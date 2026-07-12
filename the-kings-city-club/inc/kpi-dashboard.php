<?php
if (!defined('ABSPATH')) exit;

function kc_register_kpi_dashboard() {
    add_menu_page(
        'KPI Dashboard',
        'KPI Dashboard',
        'manage_options',
        'kc-kpi-dashboard',
        'kc_render_kpi_dashboard',
        'dashicons-chart-bar',
        28 // Position below Bookings
    );
}
add_action('admin_menu', 'kc_register_kpi_dashboard');

function kc_parse_revenue_val($val) {
    // Strip everything except numbers and decimals
    $clean = preg_replace('/[^0-9.]/', '', $val);
    return floatval($clean);
}

// Handle CSV Export
function kc_export_kpi_csv() {
    if (!current_user_can('manage_options')) wp_die('Unauthorized');

    $selected_month = '';
    if (isset($_GET['kpi_month'])) {
        $selected_month = sanitize_text_field($_GET['kpi_month']);
    } else {
        $selected_month = date('Y-m');
    }

    $date_query = array();
    $display_period = "All Time";
    if (!empty($selected_month)) {
        $year = substr($selected_month, 0, 4);
        $month = substr($selected_month, 5, 2);
        $date_query = array(
            array(
                'year'  => $year,
                'month' => $month,
            )
        );
        $display_period = date('F Y', strtotime($selected_month . '-01'));
    }

    // Bookings — completed only (revenue + space breakdown)
    $bookings_args = array(
        'post_type'      => 'kc_booking',
        'posts_per_page' => -1,
        'fields'         => 'ids',
        'meta_query'     => array(
            array('key' => 'kc_status', 'value' => 'Completed')
        )
    );
    if (!empty($date_query)) {
        $bookings_args['date_query'] = $date_query;
    }
    $bookings_query = new WP_Query($bookings_args);

    $total_bookings_revenue = 0;
    $revenue_by_space       = array();
    foreach ($bookings_query->posts as $post_id) {
        $price = kc_parse_revenue_val(get_post_meta($post_id, 'kc_price', true));
        $space = get_post_meta($post_id, 'kc_space_type', true) ?: 'Unknown';
        $total_bookings_revenue += $price;
        $revenue_by_space[$space] = ($revenue_by_space[$space] ?? 0) + $price;
    }
    arsort($revenue_by_space);

    // Bookings — all requests (for conversion rate)
    $bookings_all_args = array('post_type' => 'kc_booking', 'posts_per_page' => -1, 'fields' => 'ids');
    if (!empty($date_query)) {
        $bookings_all_args['date_query'] = $date_query;
    }
    $bookings_all_count  = (new WP_Query($bookings_all_args))->found_posts;
    $bookings_conversion = $bookings_all_count > 0
        ? round(($bookings_query->found_posts / $bookings_all_count) * 100, 1)
        : 0;

    // Quotes — closed only (revenue)
    $quotes_args = array(
        'post_type'      => 'kg_quote_lead',
        'posts_per_page' => -1,
        'fields'         => 'ids',
        'meta_query'     => array(
            array('key' => 'lead_status', 'value' => 'Closed')
        )
    );
    if (!empty($date_query)) {
        $quotes_args['date_query'] = $date_query;
    }
    $quotes_query = new WP_Query($quotes_args);

    $total_quotes_revenue = 0;
    foreach ($quotes_query->posts as $post_id) {
        $total_quotes_revenue += kc_parse_revenue_val(get_post_meta($post_id, 'total_est', true));
    }

    // Quotes — all requests (for conversion rate)
    $quotes_all_args = array('post_type' => 'kg_quote_lead', 'posts_per_page' => -1, 'fields' => 'ids');
    if (!empty($date_query)) {
        $quotes_all_args['date_query'] = $date_query;
    }
    $quotes_all_count  = (new WP_Query($quotes_all_args))->found_posts;
    $quotes_conversion = $quotes_all_count > 0
        ? round(($quotes_query->found_posts / $quotes_all_count) * 100, 1)
        : 0;

    $filename = 'Kings_City_KPI_' . $selected_month . '.csv';

    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Pragma: no-cache');
    header('Expires: 0');

    $output = fopen('php://output', 'w');

    // --- Section 1: Bookings Summary ---
    fputcsv($output, array('Reporting Period', 'Metric', 'Value'));
    fputcsv($output, array($display_period, 'Total Booking Requests',        $bookings_all_count));
    fputcsv($output, array($display_period, 'Completed & Paid Bookings',     $bookings_query->found_posts));
    fputcsv($output, array($display_period, 'Bookings Conversion Rate (%)',  $bookings_conversion . '%'));
    fputcsv($output, array($display_period, 'Total Bookings Revenue (Php)',  number_format($total_bookings_revenue, 2)));

    // --- Section 2: Quotes Summary ---
    fputcsv($output, array('', '', ''));
    fputcsv($output, array($display_period, 'Total Quote Requests',                   $quotes_all_count));
    fputcsv($output, array($display_period, 'Successful Quotes (Closed)',             $quotes_query->found_posts));
    fputcsv($output, array($display_period, 'Quotes Conversion Rate (%)',             $quotes_conversion . '%'));
    fputcsv($output, array($display_period, 'Est. Recurring Revenue / mo (Php)',      number_format($total_quotes_revenue, 2)));

    // --- Section 3: Revenue Breakdown by Space ---
    fputcsv($output, array('', '', ''));
    fputcsv($output, array('Space', 'Revenue (Php)', '% of Total'));
    foreach ($revenue_by_space as $space => $rev) {
        $pct = $total_bookings_revenue > 0 ? round(($rev / $total_bookings_revenue) * 100, 1) : 0;
        fputcsv($output, array($space, number_format($rev, 2), $pct . '%'));
    }
    if (empty($revenue_by_space)) {
        fputcsv($output, array('No completed bookings for this period', '', ''));
    }

    fclose($output);
    exit;
}
add_action('admin_post_kc_export_kpi_csv', 'kc_export_kpi_csv');


function kc_render_kpi_dashboard() {
    $selected_month = '';
    if (isset($_GET['kpi_month'])) {
        $selected_month = sanitize_text_field($_GET['kpi_month']);
    } else {
        $selected_month = date('Y-m');
    }

    $date_query = array();
    $display_period = "All Time";
    if (!empty($selected_month)) {
        $year = substr($selected_month, 0, 4);
        $month = substr($selected_month, 5, 2);
        $date_query = array(
            array(
                'year'  => $year,
                'month' => $month,
            )
        );
        $display_period = date('F Y', strtotime($selected_month . '-01'));
    }

    // --- Data Queries ---

    // 1. Bookings Revenue (Status: Completed)
    $bookings_args = array(
        'post_type' => 'kc_booking',
        'posts_per_page' => -1,
        'fields' => 'ids',
        'meta_query' => array(
            array(
                'key' => 'kc_status',
                'value' => 'Completed'
            )
        )
    );
    if (!empty($date_query)) {
        $bookings_args['date_query'] = $date_query;
    }
    $bookings_query = new WP_Query($bookings_args);

    $total_bookings_won = 0;
    $total_bookings_revenue = 0;
    $revenue_by_space = array();

    foreach ($bookings_query->posts as $post_id) {
        $price_raw = get_post_meta($post_id, 'kc_price', true);
        $price = kc_parse_revenue_val($price_raw);
        $space = get_post_meta($post_id, 'kc_space_type', true);
        
        $total_bookings_won++;
        $total_bookings_revenue += $price;

        if (!isset($revenue_by_space[$space])) {
            $revenue_by_space[$space] = 0;
        }
        $revenue_by_space[$space] += $price;
    }

    // Bookings Total Requests (for funnel)
    $bookings_all_args = array('post_type' => 'kc_booking', 'posts_per_page' => -1, 'fields' => 'ids');
    if (!empty($date_query)) {
        $bookings_all_args['date_query'] = $date_query;
    }
    $bookings_all = new WP_Query($bookings_all_args);
    $bookings_all_count = $bookings_all->found_posts;
    $bookings_conversion = ($bookings_all_count > 0) ? ($total_bookings_won / $bookings_all_count) * 100 : 0;

    // 2. Quote Leads Revenue (Status: Closed)
    $quotes_args = array(
        'post_type' => 'kg_quote_lead',
        'posts_per_page' => -1,
        'fields' => 'ids',
        'meta_query' => array(
            array(
                'key' => 'lead_status',
                'value' => 'Closed'
            )
        )
    );
    if (!empty($date_query)) {
        $quotes_args['date_query'] = $date_query;
    }
    $quotes_query = new WP_Query($quotes_args);

    $total_quotes_won = 0;
    $total_quotes_revenue = 0;

    foreach ($quotes_query->posts as $post_id) {
        $est_raw = get_post_meta($post_id, 'total_est', true);
        $est = kc_parse_revenue_val($est_raw);
        $total_quotes_won++;
        $total_quotes_revenue += $est;
    }

    // Quotes Total Requests (for funnel)
    $quotes_all_args = array('post_type' => 'kg_quote_lead', 'posts_per_page' => -1, 'fields' => 'ids');
    if (!empty($date_query)) {
        $quotes_all_args['date_query'] = $date_query;
    }
    $quotes_all = new WP_Query($quotes_all_args);
    $quotes_all_count = $quotes_all->found_posts;
    $quotes_conversion = ($quotes_all_count > 0) ? ($total_quotes_won / $quotes_all_count) * 100 : 0;


    // --- HTML/CSS Layout ---
    ?>
    <style>
        .kc-kpi-wrap { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif; margin: 20px; background-color: #f1f5f9; padding-bottom: 40px;}
        
        /* Brand Colors */
        :root {
            --kc-terracotta: #BD451F;
            --kc-deep-red: #AC201A;
            --kc-muted-gold: #FBCB77;
            --kc-blush: #FFBFBF;
            --kc-ivory: #FFF9EF;
        }

        .kc-kpi-header {
            background-color: var(--kc-terracotta);
            color: white;
            padding: 30px;
            border-radius: 8px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        .kc-kpi-header h1 { color: white; margin: 0; font-size: 24px; font-weight: bold; letter-spacing: 1px;}
        .kc-kpi-header p { margin: 5px 0 0 0; color: var(--kc-ivory); opacity: 0.9; }

        .kc-kpi-controls { display: flex; align-items: center; gap: 15px; }
        .kc-kpi-controls input[type="month"] { padding: 5px 10px; border-radius: 4px; border: none; background: rgba(255,255,255,0.9); color: #333; font-weight: bold; cursor: pointer; height: 32px;}
        .kc-kpi-controls .button-csv { background-color: var(--kc-muted-gold); color: #854d0e; border: none; font-weight: bold; padding: 6px 15px; border-radius: 4px; cursor: pointer; text-decoration: none; display: inline-block; line-height: 20px;}
        .kc-kpi-controls .button-csv:hover { background-color: #fde68a; }

        .kc-kpi-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-top: 20px; }
        
        .kc-kpi-card { background-color: white; border-radius: 8px; padding: 25px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
        .kc-kpi-card-title { font-size: 14px; font-weight: bold; color: #475569; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 2px solid #f1f5f9; padding-bottom: 10px; margin-bottom: 20px; }
        
        .kc-kpi-stat-row { display: flex; justify-content: space-between; align-items: center; padding: 10px 0; border-bottom: 1px solid #f8fafc; }
        .kc-kpi-stat-row:last-child { border-bottom: none; }
        .kc-kpi-stat-label { color: #64748b; font-weight: 500; font-size: 14px;}
        .kc-kpi-stat-value { font-weight: bold; font-size: 18px; color: #1e293b; }
        .kc-kpi-stat-revenue { font-size: 32px; font-weight: 800; }
        
        /* Accents */
        .card-bookings .kc-kpi-stat-revenue { color: var(--kc-deep-red); }
        .card-quotes .kc-kpi-stat-revenue { color: var(--kc-muted-gold); }
        .card-bookings .kc-kpi-card-title { color: var(--kc-deep-red); border-bottom-color: var(--kc-blush); }
        .card-quotes .kc-kpi-card-title { color: #b45309; border-bottom-color: var(--kc-muted-gold); } /* slightly darker text for contrast */

        /* Funnel Chart */
        .kc-funnel-bar-container { background-color: #e2e8f0; height: 12px; border-radius: 6px; margin-top: 5px; margin-bottom: 15px; overflow: hidden; }
        .kc-funnel-bar-bookings { background-color: var(--kc-deep-red); height: 100%; border-radius: 6px; }
        .kc-funnel-bar-quotes { background-color: var(--kc-muted-gold); height: 100%; border-radius: 6px; }

        /* Space Bars */
        .kc-space-bar-wrap { display: flex; align-items: center; margin-bottom: 12px; font-size: 13px; }
        .kc-space-label { width: 150px; font-weight: 500; color: #334155; }
        .kc-space-bar-bg { flex-grow: 1; background-color: #f1f5f9; height: 10px; border-radius: 5px; margin: 0 15px; overflow: hidden; }
        .kc-space-bar-fill { background-color: var(--kc-terracotta); height: 100%; border-radius: 5px; }
        .kc-space-val { width: 80px; text-align: right; font-weight: bold; color: #475569; }

    </style>

    <div class="wrap kc-kpi-wrap">
        
        <div class="kc-kpi-header">
            <div>
                <h1>Kings City Financial KPI Dashboard</h1>
                <p>Live revenue tracking and performance metrics.</p>
            </div>
            <div class="kc-kpi-controls">
                <form method="GET" action="admin.php" style="margin:0; display:flex; align-items:center; gap:10px;">
                    <input type="hidden" name="page" value="kc-kpi-dashboard">
                    <span style="color:var(--kc-ivory); font-size: 13px;">Reporting Period:</span>
                    <input type="month" name="kpi_month" value="<?php echo esc_attr($selected_month); ?>" onchange="this.form.submit()">
                </form>
                <a href="<?php echo admin_url('admin-post.php?action=kc_export_kpi_csv&kpi_month=' . $selected_month); ?>" class="button-csv">Export CSV</a>
            </div>
        </div>

        <div class="kc-kpi-grid">
            
            <!-- Bookings Card -->
            <div class="kc-kpi-card card-bookings">
                <div class="kc-kpi-card-title">Bookings Revenue (Spaces)</div>
                <div class="kc-kpi-stat-row">
                    <span class="kc-kpi-stat-label">Total Booking Requests</span>
                    <span class="kc-kpi-stat-value"><?php echo esc_html($bookings_all_count); ?></span>
                </div>
                <div class="kc-kpi-stat-row">
                    <span class="kc-kpi-stat-label">Completed & Paid Bookings</span>
                    <span class="kc-kpi-stat-value"><?php echo esc_html($total_bookings_won); ?></span>
                </div>
                <div class="kc-kpi-stat-row" style="margin-top: 15px; padding-top: 15px; border-top: 2px dashed #f1f5f9;">
                    <span class="kc-kpi-stat-label">Total Revenue</span>
                    <span class="kc-kpi-stat-revenue">Php <?php echo number_format($total_bookings_revenue, 2); ?></span>
                </div>
            </div>

            <!-- Quotes Card -->
            <div class="kc-kpi-card card-quotes">
                <div class="kc-kpi-card-title">Quote Leads Revenue (Team Builder)</div>
                <div class="kc-kpi-stat-row">
                    <span class="kc-kpi-stat-label">Total Quote Requests</span>
                    <span class="kc-kpi-stat-value"><?php echo esc_html($quotes_all_count); ?></span>
                </div>
                <div class="kc-kpi-stat-row">
                    <span class="kc-kpi-stat-label">Successful Quotes (Closed)</span>
                    <span class="kc-kpi-stat-value"><?php echo esc_html($total_quotes_won); ?></span>
                </div>
                <div class="kc-kpi-stat-row" style="margin-top: 15px; padding-top: 15px; border-top: 2px dashed #f1f5f9;">
                    <span class="kc-kpi-stat-label">Est. Recurring Revenue</span>
                    <span class="kc-kpi-stat-revenue">Php <?php echo number_format($total_quotes_revenue, 2); ?>/mo</span>
                </div>
            </div>

            <!-- Conversion Funnel -->
            <div class="kc-kpi-card" style="grid-column: 1 / -1;">
                <div class="kc-kpi-card-title" style="color: var(--kc-terracotta);">Revenue Conversion Funnel</div>
                
                <div style="margin-bottom: 25px;">
                    <div style="display:flex; justify-content:space-between; font-size:13px; font-weight:600; color:#475569;">
                        <span>Bookings Conversion Rate</span>
                        <span><?php echo number_format($bookings_conversion, 1); ?>%</span>
                    </div>
                    <div class="kc-funnel-bar-container">
                        <div class="kc-funnel-bar-bookings" style="width: <?php echo esc_attr($bookings_conversion); ?>%;"></div>
                    </div>
                </div>

                <div>
                    <div style="display:flex; justify-content:space-between; font-size:13px; font-weight:600; color:#475569;">
                        <span>Team Builder Quotes Conversion Rate</span>
                        <span><?php echo number_format($quotes_conversion, 1); ?>%</span>
                    </div>
                    <div class="kc-funnel-bar-container">
                        <div class="kc-funnel-bar-quotes" style="width: <?php echo esc_attr($quotes_conversion); ?>%;"></div>
                    </div>
                </div>
            </div>

            <!-- Revenue by Space -->
            <div class="kc-kpi-card" style="grid-column: 1 / -1;">
                <div class="kc-kpi-card-title" style="color: var(--kc-terracotta);">Bookings Revenue Breakdown by Space</div>
                
                <?php 
                if (empty($revenue_by_space)) {
                    echo "<p style='color:#64748b;'>No completed bookings yet to display revenue breakdown.</p>";
                } else {
                    // Find max for scaling the bars
                    $max_revenue = max($revenue_by_space);
                    
                    // Sort descending
                    arsort($revenue_by_space);

                    foreach ($revenue_by_space as $space => $rev) {
                        $percent = ($max_revenue > 0) ? ($rev / $max_revenue) * 100 : 0;
                        ?>
                        <div class="kc-space-bar-wrap">
                            <div class="kc-space-label"><?php echo esc_html($space); ?></div>
                            <div class="kc-space-bar-bg">
                                <div class="kc-space-bar-fill" style="width: <?php echo esc_attr($percent); ?>%;"></div>
                            </div>
                            <div class="kc-space-val">Php <?php echo number_format($rev); ?></div>
                        </div>
                        <?php
                    }
                }
                ?>
            </div>

        </div>
    </div>
    <?php
}
