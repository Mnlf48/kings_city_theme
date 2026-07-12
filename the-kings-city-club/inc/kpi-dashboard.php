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
    global $wpdb;
    if (!current_user_can('manage_options')) wp_die('Unauthorized');

    $selected_month = isset($_GET['kpi_month']) ? sanitize_text_field($_GET['kpi_month']) : date('Y-m');

    $date_query     = array();
    $display_period = 'All Time';
    if (!empty($selected_month)) {
        $year  = substr($selected_month, 0, 4);
        $month = substr($selected_month, 5, 2);
        $date_query     = array(array('year' => $year, 'month' => $month));
        $display_period = date('F Y', strtotime($selected_month . '-01'));
    }

    // --- Bookings: single pass over all records ---
    $booking_statuses   = array('Pending', 'Contacted', 'Completed', 'Rejected', 'Cancelled');
    $bookings_by_status = array_fill_keys($booking_statuses, 0);

    $b_all_args = array('post_type' => 'kc_booking', 'posts_per_page' => -1, 'fields' => 'ids');
    if (!empty($date_query)) $b_all_args['date_query'] = $date_query;
    $b_all_query        = new WP_Query($b_all_args);
    $bookings_all_count = $b_all_query->found_posts;

    $total_bookings_revenue = 0;
    $revenue_by_space       = array();
    $total_bookings_won     = 0;

    foreach ($b_all_query->posts as $post_id) {
        $status = get_post_meta($post_id, 'kc_status', true) ?: 'Pending';
        if (isset($bookings_by_status[$status])) $bookings_by_status[$status]++;
        if ($status === 'Completed') {
            $price = kc_parse_revenue_val(get_post_meta($post_id, 'kc_price', true));
            $space = get_post_meta($post_id, 'kc_space_type', true) ?: 'Unknown';
            $total_bookings_revenue += $price;
            $revenue_by_space[$space] = ($revenue_by_space[$space] ?? 0) + $price;
            $total_bookings_won++;
        }
    }
    arsort($revenue_by_space);
    $bookings_conversion    = $bookings_all_count > 0 ? round(($total_bookings_won / $bookings_all_count) * 100, 1) : 0;
    $bookings_pending_action = $bookings_by_status['Pending'] + $bookings_by_status['Contacted'];

    // --- Quotes: single pass over all records ---
    $quote_statuses   = array('Pending', 'Contacted', 'Closed', 'Rejected');
    $quotes_by_status = array_fill_keys($quote_statuses, 0);

    $q_all_args = array('post_type' => 'kg_quote_lead', 'posts_per_page' => -1, 'fields' => 'ids');
    if (!empty($date_query)) $q_all_args['date_query'] = $date_query;
    $q_all_query      = new WP_Query($q_all_args);
    $quotes_all_count = $q_all_query->found_posts;

    $total_quotes_revenue = 0;
    $total_quotes_won     = 0;

    foreach ($q_all_query->posts as $post_id) {
        $status = get_post_meta($post_id, 'lead_status', true) ?: 'Pending';
        if (isset($quotes_by_status[$status])) $quotes_by_status[$status]++;
        if ($status === 'Closed') {
            $total_quotes_revenue += kc_parse_revenue_val(get_post_meta($post_id, 'total_est', true));
            $total_quotes_won++;
        }
    }
    $quotes_conversion    = $quotes_all_count > 0 ? round(($total_quotes_won / $quotes_all_count) * 100, 1) : 0;
    $quotes_pending_action = $quotes_by_status['Pending'] + $quotes_by_status['Contacted'];

    // --- Mailing list (always all-time) ---
    $ml_table   = $wpdb->prefix . 'kc_mailing_list';
    $ml_total   = (int) $wpdb->get_var("SELECT COUNT(*) FROM {$ml_table}");
    $ml_active  = (int) $wpdb->get_var("SELECT COUNT(*) FROM {$ml_table} WHERE status = 'active'");
    $ml_pending = (int) $wpdb->get_var("SELECT COUNT(*) FROM {$ml_table} WHERE status = 'pending'");
    $ml_unsub   = (int) $wpdb->get_var("SELECT COUNT(*) FROM {$ml_table} WHERE status = 'unsubscribed'");

    // --- Summary values ---
    $combined_revenue   = $total_bookings_revenue + $total_quotes_revenue;
    $total_needs_action = $bookings_pending_action + $quotes_pending_action;
    $blended_conversion = ($bookings_all_count + $quotes_all_count) > 0
        ? round((($total_bookings_won + $total_quotes_won) / ($bookings_all_count + $quotes_all_count)) * 100, 1)
        : 0;

    // --- Output ---
    $filename = 'Kings_City_KPI_' . $selected_month . '.csv';
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Pragma: no-cache');
    header('Expires: 0');

    $out = fopen('php://output', 'w');

    // Section 0: Summary
    fputcsv($out, array('=== SUMMARY ===', '', ''));
    fputcsv($out, array('Reporting Period', 'Metric', 'Value'));
    fputcsv($out, array($display_period, 'Combined Revenue — Bookings + Quotes (Php)', number_format($combined_revenue, 2)));
    fputcsv($out, array($display_period, 'Overall Blended Conversion Rate',            $blended_conversion . '%'));
    fputcsv($out, array($display_period, 'Needs Action — Pending + Contacted Items',   $total_needs_action));

    // Section 1: Bookings
    fputcsv($out, array('', '', ''));
    fputcsv($out, array('=== BOOKINGS (SPACES) ===', '', ''));
    fputcsv($out, array($display_period, 'Total Booking Requests',       $bookings_all_count));
    fputcsv($out, array($display_period, 'Completed & Paid',             $total_bookings_won));
    fputcsv($out, array($display_period, 'Conversion Rate',              $bookings_conversion . '%'));
    fputcsv($out, array($display_period, 'Total Bookings Revenue (Php)', number_format($total_bookings_revenue, 2)));
    fputcsv($out, array('', '', ''));
    fputcsv($out, array('--- Pipeline Breakdown ---', '', ''));
    foreach ($bookings_by_status as $status => $count) {
        fputcsv($out, array($display_period, 'Bookings — ' . $status, $count));
    }

    // Section 1b: Individual Booking Records
    fputcsv($out, array('', '', '', '', '', '', '', '', '', '', ''));
    fputcsv($out, array('--- Booking Records ---', '', '', '', '', '', '', '', '', '', ''));
    fputcsv($out, array('Client Name', 'Email', 'Phone', 'Space', 'Start Date', 'Duration', 'Price (Php)', 'Status', 'Membership Status', 'Membership Expiry', 'Admin Note'));
    $bk_rec_query = new WP_Query(array('post_type' => 'kc_booking', 'posts_per_page' => -1, 'orderby' => 'date', 'order' => 'DESC', 'fields' => 'ids'));
    if (!empty($bk_rec_query->posts)) {
        foreach ($bk_rec_query->posts as $pid) {
            $bk_name = trim(get_post_meta($pid, 'kc_first_name', true) . ' ' . get_post_meta($pid, 'kc_last_name', true));
            fputcsv($out, array(
                $bk_name,
                get_post_meta($pid, 'kc_email',             true),
                get_post_meta($pid, 'kc_phone',             true),
                get_post_meta($pid, 'kc_space_type',        true),
                get_post_meta($pid, 'kc_start_date',        true),
                get_post_meta($pid, 'kc_duration',          true),
                get_post_meta($pid, 'kc_price',             true),
                get_post_meta($pid, 'kc_status',            true) ?: 'Pending',
                get_post_meta($pid, 'kc_membership_status', true) ?: '—',
                get_post_meta($pid, 'kc_membership_expiry', true) ?: '—',
                get_post_meta($pid, 'kc_admin_note',        true) ?: '—',
            ));
        }
    } else {
        fputcsv($out, array('No booking records found.', '', '', '', '', '', '', '', '', '', ''));
    }

    // Section 2: Quotes
    fputcsv($out, array('', '', ''));
    fputcsv($out, array('=== QUOTE LEADS (TEAM BUILDER) ===', '', ''));
    fputcsv($out, array($display_period, 'Total Quote Requests',              $quotes_all_count));
    fputcsv($out, array($display_period, 'Successful Quotes (Closed)',        $total_quotes_won));
    fputcsv($out, array($display_period, 'Conversion Rate',                   $quotes_conversion . '%'));
    fputcsv($out, array($display_period, 'Est. Recurring Revenue / mo (Php)', number_format($total_quotes_revenue, 2)));
    fputcsv($out, array('', '', ''));
    fputcsv($out, array('--- Pipeline Breakdown ---', '', ''));
    foreach ($quotes_by_status as $status => $count) {
        fputcsv($out, array($display_period, 'Quotes — ' . $status, $count));
    }

    // Section 2b: Individual Quote Request Records
    fputcsv($out, array('', '', '', '', '', '', '', '', ''));
    fputcsv($out, array('--- Quote Request Records ---', '', '', '', '', '', '', '', ''));
    fputcsv($out, array('Client Name', 'Email', 'Phone', 'Address', 'Date Submitted', 'Status', 'Currency', 'Est. Total', 'Team Breakdown'));
    $qt_rec_query = new WP_Query(array('post_type' => 'kg_quote_lead', 'posts_per_page' => -1, 'orderby' => 'date', 'order' => 'DESC', 'fields' => 'ids'));
    if (!empty($qt_rec_query->posts)) {
        foreach ($qt_rec_query->posts as $qid) {
            $qt_fn   = get_post_meta($qid, 'first_name',   true);
            $qt_mn   = get_post_meta($qid, 'middle_name',  true);
            $qt_ln   = get_post_meta($qid, 'last_name',    true);
            $qt_name = trim($qt_fn . ($qt_mn ? ' ' . $qt_mn : '') . ' ' . $qt_ln);
            // Collapse team into a readable single-cell string
            $qt_team_raw = get_post_meta($qid, 'team_json', true);
            $qt_team     = $qt_team_raw ? json_decode($qt_team_raw, true) : array();
            $qt_team_str = '—';
            if (is_array($qt_team) && !empty($qt_team)) {
                $parts = array();
                foreach ($qt_team as $m) {
                    $role  = $m['title']     ?? $m['role'] ?? 'Unknown';
                    $level = $m['level']     ?? '';
                    $count = $m['headcount'] ?? $m['count'] ?? 1;
                    $rate  = $m['monthly']   ?? $m['rate']  ?? '';
                    $part  = $role . ($level ? ' — ' . $level : '') . ' x' . $count;
                    if ($rate) $part .= ' (' . $rate . '/mo)';
                    $parts[] = $part;
                }
                $qt_team_str = implode(' | ', $parts);
            }
            fputcsv($out, array(
                $qt_name,
                get_post_meta($qid, 'email',        true),
                get_post_meta($qid, 'phone',        true),
                get_post_meta($qid, 'address',      true),
                get_the_date('Y-m-d', $qid),
                get_post_meta($qid, 'lead_status',  true) ?: 'Pending',
                get_post_meta($qid, 'currency_used',true) ?: 'PHP',
                get_post_meta($qid, 'total_est',    true),
                $qt_team_str,
            ));
        }
    } else {
        fputcsv($out, array('No quote request records found.', '', '', '', '', '', '', '', ''));
    }

    // Section 3: Revenue by Space
    fputcsv($out, array('', '', ''));
    fputcsv($out, array('=== REVENUE BREAKDOWN BY SPACE ===', '', ''));
    fputcsv($out, array('Space', 'Revenue (Php)', '% of Total Bookings Revenue'));
    if (empty($revenue_by_space)) {
        fputcsv($out, array('No completed bookings for this period', '', ''));
    } else {
        foreach ($revenue_by_space as $space => $rev) {
            $pct = $total_bookings_revenue > 0 ? round(($rev / $total_bookings_revenue) * 100, 1) : 0;
            fputcsv($out, array($space, number_format($rev, 2), $pct . '%'));
        }
    }

    // Section 4: Members (all-time — not date filtered)
    $mem_args = array('post_type' => 'kc_booking', 'posts_per_page' => -1, 'fields' => 'ids');
    $mem_all  = (new WP_Query($mem_args))->posts;
    $mem_active = $mem_expired = $mem_expiring = $mem_none = 0;
    $seen_emails_csv = array();
    $today_csv = date('Y-m-d');
    $in30_csv  = date('Y-m-d', strtotime('+30 days'));
    foreach ($mem_all as $pid) {
        $email  = get_post_meta($pid, 'kc_email', true);
        if ($email && in_array($email, $seen_emails_csv, true)) continue;
        if ($email) $seen_emails_csv[] = $email;
        $ms  = get_post_meta($pid, 'kc_membership_status', true);
        $exp = get_post_meta($pid, 'kc_membership_expiry', true);
        if ($ms === 'Active') {
            $mem_active++;
            if ($exp && $exp >= $today_csv && $exp <= $in30_csv) $mem_expiring++;
        } elseif ($ms === 'Expired') {
            $mem_expired++;
        } else {
            $mem_none++;
        }
    }

    fputcsv($out, array('', '', ''));
    fputcsv($out, array('=== MEMBERS (ALL-TIME) ===', '', ''));
    fputcsv($out, array('All Time', 'Active Members',          $mem_active));
    fputcsv($out, array('All Time', 'Expiring Within 30 Days', $mem_expiring));
    fputcsv($out, array('All Time', 'Expired Members',         $mem_expired));
    fputcsv($out, array('All Time', 'No Membership (N/A)',     $mem_none));

    // Section 5: Mailing List
    fputcsv($out, array('', '', ''));
    fputcsv($out, array('=== MAILING LIST (ALL-TIME) ===', '', ''));
    fputcsv($out, array('All Time', 'Total Subscribers',      $ml_total));
    fputcsv($out, array('All Time', 'Active Subscribers',     $ml_active));
    fputcsv($out, array('All Time', 'Pending Subscribers',    $ml_pending));
    fputcsv($out, array('All Time', 'Unsubscribed',           $ml_unsub));

    // Section 5b: Individual Mailing List Records
    fputcsv($out, array('', '', ''));
    fputcsv($out, array('--- Mailing List Records ---', '', ''));
    fputcsv($out, array('Email', 'Status', 'Subscribed At'));
    $ml_records = $wpdb->get_results(
        "SELECT email, status, subscribed_at FROM {$ml_table} ORDER BY id DESC",
        ARRAY_A
    );
    if (!empty($ml_records)) {
        foreach ($ml_records as $row) {
            fputcsv($out, array(
                $row['email'],
                ucfirst($row['status']),
                $row['subscribed_at'],
            ));
        }
    } else {
        fputcsv($out, array('No subscribers found.', '', ''));
    }

    fclose($out);
    exit;
}
add_action('admin_post_kc_export_kpi_csv', 'kc_export_kpi_csv');


function kc_render_kpi_dashboard() {
    global $wpdb;

    $selected_month = isset($_GET['kpi_month']) ? sanitize_text_field($_GET['kpi_month']) : date('Y-m');

    $date_query     = array();
    $display_period = 'All Time';
    if (!empty($selected_month)) {
        $year  = substr($selected_month, 0, 4);
        $month = substr($selected_month, 5, 2);
        $date_query     = array(array('year' => $year, 'month' => $month));
        $display_period = date('F Y', strtotime($selected_month . '-01'));
    }

    // --- Bookings: all statuses for pipeline breakdown ---
    $booking_statuses = array('Pending', 'Contacted', 'Completed', 'Rejected', 'Cancelled');
    $bookings_by_status = array_fill_keys($booking_statuses, 0);

    $bookings_all_args = array('post_type' => 'kc_booking', 'posts_per_page' => -1, 'fields' => 'ids');
    if (!empty($date_query)) $bookings_all_args['date_query'] = $date_query;
    $bookings_all_query = new WP_Query($bookings_all_args);
    $bookings_all_count = $bookings_all_query->found_posts;

    $total_bookings_revenue = 0;
    $revenue_by_space       = array();
    $total_bookings_won     = 0;

    foreach ($bookings_all_query->posts as $post_id) {
        $status = get_post_meta($post_id, 'kc_status', true) ?: 'Pending';
        if (isset($bookings_by_status[$status])) $bookings_by_status[$status]++;
        if ($status === 'Completed') {
            $price = kc_parse_revenue_val(get_post_meta($post_id, 'kc_price', true));
            $space = get_post_meta($post_id, 'kc_space_type', true) ?: 'Unknown';
            $total_bookings_revenue += $price;
            $revenue_by_space[$space] = ($revenue_by_space[$space] ?? 0) + $price;
            $total_bookings_won++;
        }
    }
    arsort($revenue_by_space);
    $bookings_conversion = $bookings_all_count > 0 ? round(($total_bookings_won / $bookings_all_count) * 100, 1) : 0;
    $bookings_pending_action = $bookings_by_status['Pending'] + $bookings_by_status['Contacted'];

    // --- Quotes: all statuses for pipeline breakdown ---
    $quote_statuses = array('Pending', 'Contacted', 'Closed', 'Rejected');
    $quotes_by_status = array_fill_keys($quote_statuses, 0);

    $quotes_all_args = array('post_type' => 'kg_quote_lead', 'posts_per_page' => -1, 'fields' => 'ids');
    if (!empty($date_query)) $quotes_all_args['date_query'] = $date_query;
    $quotes_all_query = new WP_Query($quotes_all_args);
    $quotes_all_count = $quotes_all_query->found_posts;

    $total_quotes_revenue = 0;
    $total_quotes_won     = 0;

    foreach ($quotes_all_query->posts as $post_id) {
        $status = get_post_meta($post_id, 'lead_status', true) ?: 'Pending';
        if (isset($quotes_by_status[$status])) $quotes_by_status[$status]++;
        if ($status === 'Closed') {
            $total_quotes_revenue += kc_parse_revenue_val(get_post_meta($post_id, 'total_est', true));
            $total_quotes_won++;
        }
    }
    $quotes_conversion = $quotes_all_count > 0 ? round(($total_quotes_won / $quotes_all_count) * 100, 1) : 0;
    $quotes_pending_action = $quotes_by_status['Pending'] + $quotes_by_status['Contacted'];

    // --- Mailing list snapshot (not date-filtered — always all-time) ---
    $ml_table   = $wpdb->prefix . 'kc_mailing_list';
    $ml_total   = (int) $wpdb->get_var("SELECT COUNT(*) FROM {$ml_table}");
    $ml_active  = (int) $wpdb->get_var("SELECT COUNT(*) FROM {$ml_table} WHERE status = 'active'");
    $ml_pending = (int) $wpdb->get_var("SELECT COUNT(*) FROM {$ml_table} WHERE status = 'pending'");
    $ml_unsub   = (int) $wpdb->get_var("SELECT COUNT(*) FROM {$ml_table} WHERE status = 'unsubscribed'");

    // --- Members snapshot (not date-filtered — always all-time, deduplicated by email) ---
    $mem_all_args = array('post_type' => 'kc_booking', 'posts_per_page' => -1, 'fields' => 'ids');
    $mem_all_ids  = (new WP_Query($mem_all_args))->posts;
    $mem_active   = 0;
    $mem_expiring = 0;
    $mem_expired  = 0;
    $mem_none     = 0;
    $seen_emails  = array();
    $today        = date('Y-m-d');
    $in_30_days   = date('Y-m-d', strtotime('+30 days'));
    foreach ($mem_all_ids as $pid) {
        $email = get_post_meta($pid, 'kc_email', true);
        if ($email && in_array($email, $seen_emails, true)) continue;
        if ($email) $seen_emails[] = $email;
        $ms  = get_post_meta($pid, 'kc_membership_status', true);
        $exp = get_post_meta($pid, 'kc_membership_expiry', true);
        if ($ms === 'Active') {
            $mem_active++;
            if ($exp && $exp >= $today && $exp <= $in_30_days) $mem_expiring++;
        } elseif ($ms === 'Expired') {
            $mem_expired++;
        } else {
            $mem_none++;
        }
    }

    // --- Summary tile values ---
    $combined_revenue    = $total_bookings_revenue + $total_quotes_revenue;
    $total_pending_items = $bookings_pending_action + $quotes_pending_action;
    $blended_conversion  = ($bookings_all_count + $quotes_all_count) > 0
        ? round((($total_bookings_won + $total_quotes_won) / ($bookings_all_count + $quotes_all_count)) * 100, 1)
        : 0;

    // Pipeline status badge colours
    $status_colors = array(
        'Pending'   => array('#fef9c3', '#854d0e'),
        'Contacted' => array('#dbeafe', '#1e40af'),
        'Completed' => array('#dcfce7', '#166534'),
        'Closed'    => array('#dcfce7', '#166534'),
        'Rejected'  => array('#fee2e2', '#991b1b'),
        'Cancelled' => array('#f1f5f9', '#475569'),
    );
    ?>
    <style>
        :root {
            --kc-terracotta: #BD451F;
            --kc-deep-red:   #AC201A;
            --kc-gold:       #FBCB77;
            --kc-blush:      #FFBFBF;
            --kc-ivory:      #FFF9EF;
        }
        .kc-kpi-wrap { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif; margin: 20px; background: #f1f5f9; padding-bottom: 48px; display: flex; flex-direction: column; }

        /* Header */
        .kc-kpi-header { background: var(--kc-terracotta); color: #fff; padding: 28px 30px; border-radius: 8px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 4px 12px rgba(0,0,0,0.12); margin-bottom: 24px; order: 1; }
        .kc-kpi-header h1 { color: #fff; margin: 0; font-size: 22px; font-weight: 800; letter-spacing: .5px; }
        .kc-kpi-header p  { margin: 4px 0 0; color: var(--kc-ivory); opacity: .85; font-size: 13px; }
        .kc-kpi-controls  { display: flex; align-items: center; gap: 12px; }
        .kc-kpi-controls input[type="month"] { padding: 5px 10px; border-radius: 4px; border: none; background: rgba(255,255,255,.9); color: #333; font-weight: 700; cursor: pointer; height: 32px; }
        .kc-btn-csv { background: var(--kc-gold); color: #854d0e; border: none; font-weight: 700; padding: 6px 16px; border-radius: 4px; cursor: pointer; text-decoration: none; display: inline-block; line-height: 20px; font-size: 13px; }
        .kc-btn-csv:hover { background: #fde68a; color: #854d0e; }

        /* Summary tiles row */
        .kc-kpi-tiles { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 24px; }
        .kc-tile { background: #fff; border-radius: 8px; padding: 20px 22px; box-shadow: 0 1px 4px rgba(0,0,0,.07); border-top: 4px solid transparent; }
        .kc-tile--revenue  { border-top-color: var(--kc-deep-red); }
        .kc-tile--audience { border-top-color: var(--kc-gold); }
        .kc-tile--action   { border-top-color: #f59e0b; }
        .kc-tile--rate     { border-top-color: #10b981; }
        .kc-tile__label { font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: .5px; color: #64748b; margin-bottom: 8px; }
        .kc-tile__value { font-size: 28px; font-weight: 800; color: #1e293b; line-height: 1; }
        .kc-tile__sub   { font-size: 12px; color: #94a3b8; margin-top: 6px; }
        .kc-tile--revenue  .kc-tile__value { color: var(--kc-deep-red); }
        .kc-tile--audience .kc-tile__value { color: #b45309; }
        .kc-tile--action   .kc-tile__value { color: #d97706; }
        .kc-tile--rate     .kc-tile__value { color: #059669; }

        /* Two-col grid */
        .kc-kpi-grid  { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .kc-kpi-full  { grid-column: 1 / -1; }

        /* Cards */
        .kc-kpi-card { background: #fff; border-radius: 8px; padding: 24px; box-shadow: 0 1px 4px rgba(0,0,0,.07); }
        .kc-card-title { font-size: 13px; font-weight: 800; text-transform: uppercase; letter-spacing: .5px; padding-bottom: 10px; margin-bottom: 18px; border-bottom: 2px solid #f1f5f9; }
        .kc-card-title--bookings { color: var(--kc-deep-red);  border-bottom-color: var(--kc-blush); }
        .kc-card-title--quotes   { color: #b45309;             border-bottom-color: var(--kc-gold);  }
        .kc-card-title--funnel   { color: var(--kc-terracotta);}
        .kc-card-title--spaces   { color: var(--kc-terracotta);}
        .kc-card-title--mail     { color: #0369a1; border-bottom-color: #bae6fd; }

        /* Stat rows */
        .kc-stat-row { display: flex; justify-content: space-between; align-items: center; padding: 9px 0; border-bottom: 1px solid #f8fafc; }
        .kc-stat-row:last-child { border-bottom: none; }
        .kc-stat-label { color: #64748b; font-size: 13px; font-weight: 500; }
        .kc-stat-value { font-weight: 700; font-size: 17px; color: #1e293b; }
        .kc-stat-revenue { font-size: 30px; font-weight: 800; }
        .kc-revenue-bookings { color: var(--kc-deep-red); }
        .kc-revenue-quotes   { color: #b45309; }

        /* Pipeline status badges */
        .kc-pipeline { display: flex; flex-wrap: wrap; gap: 10px; margin-top: 16px; }
        .kc-pipeline-badge { display: flex; flex-direction: column; align-items: center; padding: 10px 16px; border-radius: 6px; min-width: 72px; }
        .kc-pipeline-badge__count { font-size: 22px; font-weight: 800; line-height: 1; }
        .kc-pipeline-badge__label { font-size: 11px; font-weight: 600; margin-top: 4px; text-transform: uppercase; letter-spacing: .3px; }

        /* Funnel bars */
        .kc-bar-wrap  { margin-bottom: 20px; }
        .kc-bar-wrap:last-child { margin-bottom: 0; }
        .kc-bar-header { display: flex; justify-content: space-between; font-size: 13px; font-weight: 600; color: #475569; margin-bottom: 6px; }
        .kc-bar-track  { background: #e2e8f0; height: 12px; border-radius: 6px; overflow: hidden; }
        .kc-bar-fill-b { background: var(--kc-deep-red); height: 100%; border-radius: 6px; transition: width .6s ease; }
        .kc-bar-fill-q { background: var(--kc-gold);     height: 100%; border-radius: 6px; transition: width .6s ease; }

        /* Space bars */
        .kc-space-row  { display: flex; align-items: center; margin-bottom: 12px; font-size: 13px; }
        .kc-space-name { width: 160px; font-weight: 600; color: #334155; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .kc-space-bar  { flex: 1; background: #f1f5f9; height: 10px; border-radius: 5px; margin: 0 14px; overflow: hidden; }
        .kc-space-bar-fill { background: var(--kc-terracotta); height: 100%; border-radius: 5px; }
        .kc-space-val  { width: 90px; text-align: right; font-weight: 700; color: #475569; }

        /* Mailing list tiles */
        .kc-ml-tiles { display: grid; grid-template-columns: repeat(4,1fr); gap: 12px; }
        .kc-ml-tile  { border-radius: 6px; padding: 16px; text-align: center; }
        .kc-ml-tile__num { font-size: 30px; font-weight: 800; line-height: 1; }
        .kc-ml-tile__lbl { font-size: 11px; text-transform: uppercase; letter-spacing: .4px; color: #64748b; margin-top: 5px; font-weight: 600; }
        .kc-ml-tile--total   { background: #e0f2fe; } .kc-ml-tile--total   .kc-ml-tile__num { color: #0369a1; }
        .kc-ml-tile--active  { background: #dcfce7; } .kc-ml-tile--active  .kc-ml-tile__num { color: #166534; }
        .kc-ml-tile--pending { background: #fef9c3; } .kc-ml-tile--pending .kc-ml-tile__num { color: #854d0e; }
        .kc-ml-tile--unsub   { background: #fee2e2; } .kc-ml-tile--unsub   .kc-ml-tile__num { color: #991b1b; }

        /* Members tiles */
        .kc-card-title--members { color: #b45309; border-bottom-color: #fde68a; }
        .kc-mem-tiles { display: grid; grid-template-columns: repeat(4,1fr); gap: 12px; }
        .kc-mem-tile  { border-radius: 6px; padding: 16px; text-align: center; }
        .kc-mem-tile__num { font-size: 30px; font-weight: 800; line-height: 1; }
        .kc-mem-tile__lbl { font-size: 11px; text-transform: uppercase; letter-spacing: .4px; color: #64748b; margin-top: 5px; font-weight: 600; }
        .kc-mem-tile--active   { background: #dcfce7; } .kc-mem-tile--active   .kc-mem-tile__num { color: #166534; }
        .kc-mem-tile--expiring { background: #fef9c3; } .kc-mem-tile--expiring .kc-mem-tile__num { color: #854d0e; }
        .kc-mem-tile--expired  { background: #fee2e2; } .kc-mem-tile--expired  .kc-mem-tile__num { color: #991b1b; }
        .kc-mem-tile--none     { background: #f1f5f9; } .kc-mem-tile--none     .kc-mem-tile__num { color: #475569; }

        .kc-section-divider { grid-column: 1/-1; border: none; border-top: 1px solid #e2e8f0; margin: 4px 0; }
    </style>

    <div class="wrap kc-kpi-wrap">

        <!-- Header -->
        <div class="kc-kpi-header">
            <div>
                <h1>Kings City KPI Dashboard</h1>
                <p>Live performance metrics — <?php echo esc_html($display_period); ?></p>
            </div>
            <div class="kc-kpi-controls">
                <form method="GET" action="admin.php" style="margin:0;display:flex;align-items:center;gap:10px;">
                    <input type="hidden" name="page" value="kc-kpi-dashboard">
                    <span style="color:var(--kc-ivory);font-size:13px;">Reporting Period:</span>
                    <input type="month" name="kpi_month" value="<?php echo esc_attr($selected_month); ?>" onchange="this.form.submit()">
                </form>
                <a href="<?php echo esc_url(admin_url('admin-post.php?action=kc_export_kpi_csv&kpi_month=' . $selected_month)); ?>" class="kc-btn-csv">&#8595; Export CSV</a>
            </div>
        </div>

        <!-- Overview Tab Panel -->
        <div id="kc-tab-overview" class="kc-tab-panel kc-tab-panel-active" style="background:transparent;border:none;box-shadow:none;padding:0;">

        <!-- Row 1: Summary Tiles -->
        <div class="kc-kpi-tiles">
            <div class="kc-tile kc-tile--revenue">
                <div class="kc-tile__label">Combined Revenue</div>
                <div class="kc-tile__value">Php <?php echo number_format($combined_revenue, 2); ?></div>
                <div class="kc-tile__sub">Bookings + Quote leads</div>
            </div>
            <div class="kc-tile kc-tile--audience">
                <div class="kc-tile__label">Active Subscribers</div>
                <div class="kc-tile__value"><?php echo esc_html($ml_active); ?></div>
                <div class="kc-tile__sub"><?php echo esc_html($ml_total); ?> total on mailing list</div>
            </div>
            <div class="kc-tile kc-tile--action">
                <div class="kc-tile__label">Needs Action</div>
                <div class="kc-tile__value"><?php echo esc_html($total_pending_items); ?></div>
                <div class="kc-tile__sub"><?php echo esc_html($bookings_pending_action); ?> bookings · <?php echo esc_html($quotes_pending_action); ?> quotes</div>
            </div>
            <div class="kc-tile kc-tile--rate">
                <div class="kc-tile__label">Overall Conversion</div>
                <div class="kc-tile__value"><?php echo esc_html($blended_conversion); ?>%</div>
                <div class="kc-tile__sub">Across bookings &amp; quotes</div>
            </div>
        </div>

        <!-- Row 2: Mailing List + Members side-by-side -->
        <div class="kc-kpi-grid" style="margin-bottom:20px;">

            <!-- Mailing List Snapshot -->
            <div class="kc-kpi-card">
                <div class="kc-card-title kc-card-title--mail">
                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:-1px;margin-right:5px;"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>Mailing List — All-Time Audience
                </div>
                <div class="kc-ml-tiles">
                    <div class="kc-ml-tile kc-ml-tile--total">
                        <div class="kc-ml-tile__num"><?php echo esc_html($ml_total); ?></div>
                        <div class="kc-ml-tile__lbl">Total</div>
                    </div>
                    <div class="kc-ml-tile kc-ml-tile--active">
                        <div class="kc-ml-tile__num"><?php echo esc_html($ml_active); ?></div>
                        <div class="kc-ml-tile__lbl">Active</div>
                    </div>
                    <div class="kc-ml-tile kc-ml-tile--pending">
                        <div class="kc-ml-tile__num"><?php echo esc_html($ml_pending); ?></div>
                        <div class="kc-ml-tile__lbl">Pending</div>
                    </div>
                    <div class="kc-ml-tile kc-ml-tile--unsub">
                        <div class="kc-ml-tile__num"><?php echo esc_html($ml_unsub); ?></div>
                        <div class="kc-ml-tile__lbl">Unsubscribed</div>
                    </div>
                </div>
            </div>

            <!-- Members Snapshot -->
            <div class="kc-kpi-card">
                <div class="kc-card-title kc-card-title--members">
                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:-1px;margin-right:5px;"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>Members — All-Time Status
                </div>
                <div class="kc-mem-tiles">
                    <div class="kc-mem-tile kc-mem-tile--active">
                        <div class="kc-mem-tile__num"><?php echo esc_html($mem_active); ?></div>
                        <div class="kc-mem-tile__lbl">Active Members</div>
                    </div>
                    <div class="kc-mem-tile kc-mem-tile--expiring">
                        <div class="kc-mem-tile__num"><?php echo esc_html($mem_expiring); ?></div>
                        <div class="kc-mem-tile__lbl">Expiring in 30 Days</div>
                    </div>
                    <div class="kc-mem-tile kc-mem-tile--expired">
                        <div class="kc-mem-tile__num"><?php echo esc_html($mem_expired); ?></div>
                        <div class="kc-mem-tile__lbl">Expired</div>
                    </div>
                    <div class="kc-mem-tile kc-mem-tile--none">
                        <div class="kc-mem-tile__num"><?php echo esc_html($mem_none); ?></div>
                        <div class="kc-mem-tile__lbl">No Membership</div>
                    </div>
                </div>
                <?php if ($mem_expiring > 0): ?>
                <p style="margin:14px 0 0; font-size:12px; color:#854d0e; background:#fef9c3; padding:8px 12px; border-radius:4px; font-weight:600;">
                    &#9888; <?php echo esc_html($mem_expiring); ?> member<?php echo $mem_expiring > 1 ? 's' : ''; ?> expiring within 30 days.
                </p>
                <?php endif; ?>
            </div>

        </div>

        <!-- Row 3+: Pipeline cards, Funnel, Revenue by Space -->
        <div class="kc-kpi-grid">

            <!-- Bookings Pipeline -->
            <div class="kc-kpi-card">
                <div class="kc-card-title kc-card-title--bookings">Bookings — Spaces</div>
                <div class="kc-stat-row">
                    <span class="kc-stat-label">Total Requests</span>
                    <span class="kc-stat-value"><?php echo esc_html($bookings_all_count); ?></span>
                </div>
                <div class="kc-stat-row">
                    <span class="kc-stat-label">Completed &amp; Paid</span>
                    <span class="kc-stat-value"><?php echo esc_html($total_bookings_won); ?></span>
                </div>
                <div class="kc-stat-row" style="margin-top:14px;padding-top:14px;border-top:2px dashed #f1f5f9;">
                    <span class="kc-stat-label">Total Revenue</span>
                    <span class="kc-stat-revenue kc-revenue-bookings">Php <?php echo number_format($total_bookings_revenue, 2); ?></span>
                </div>
                <!-- Pipeline breakdown -->
                <div class="kc-pipeline">
                    <?php foreach ($bookings_by_status as $st => $cnt):
                        $col = $status_colors[$st] ?? array('#f1f5f9','#475569'); ?>
                        <div class="kc-pipeline-badge" style="background:<?php echo esc_attr($col[0]); ?>;">
                            <span class="kc-pipeline-badge__count" style="color:<?php echo esc_attr($col[1]); ?>;"><?php echo esc_html($cnt); ?></span>
                            <span class="kc-pipeline-badge__label" style="color:<?php echo esc_attr($col[1]); ?>;"><?php echo esc_html($st); ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Quotes Pipeline -->
            <div class="kc-kpi-card">
                <div class="kc-card-title kc-card-title--quotes">Quote Leads — Team Builder</div>
                <div class="kc-stat-row">
                    <span class="kc-stat-label">Total Requests</span>
                    <span class="kc-stat-value"><?php echo esc_html($quotes_all_count); ?></span>
                </div>
                <div class="kc-stat-row">
                    <span class="kc-stat-label">Successful (Closed)</span>
                    <span class="kc-stat-value"><?php echo esc_html($total_quotes_won); ?></span>
                </div>
                <div class="kc-stat-row" style="margin-top:14px;padding-top:14px;border-top:2px dashed #f1f5f9;">
                    <span class="kc-stat-label">Est. Recurring Revenue</span>
                    <span class="kc-stat-revenue kc-revenue-quotes">Php <?php echo number_format($total_quotes_revenue, 2); ?>/mo</span>
                </div>
                <!-- Pipeline breakdown -->
                <div class="kc-pipeline">
                    <?php foreach ($quotes_by_status as $st => $cnt):
                        $col = $status_colors[$st] ?? array('#f1f5f9','#475569'); ?>
                        <div class="kc-pipeline-badge" style="background:<?php echo esc_attr($col[0]); ?>;">
                            <span class="kc-pipeline-badge__count" style="color:<?php echo esc_attr($col[1]); ?>;"><?php echo esc_html($cnt); ?></span>
                            <span class="kc-pipeline-badge__label" style="color:<?php echo esc_attr($col[1]); ?>;"><?php echo esc_html($st); ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Conversion Funnel -->
            <div class="kc-kpi-card kc-kpi-full">
                <div class="kc-card-title kc-card-title--funnel">Revenue Conversion Funnel</div>
                <div class="kc-bar-wrap">
                    <div class="kc-bar-header">
                        <span>Bookings Conversion Rate</span>
                        <span><?php echo number_format($bookings_conversion, 1); ?>%</span>
                    </div>
                    <div class="kc-bar-track"><div class="kc-bar-fill-b" style="width:<?php echo esc_attr(min($bookings_conversion,100)); ?>%;"></div></div>
                </div>
                <div class="kc-bar-wrap">
                    <div class="kc-bar-header">
                        <span>Team Builder Quotes Conversion Rate</span>
                        <span><?php echo number_format($quotes_conversion, 1); ?>%</span>
                    </div>
                    <div class="kc-bar-track"><div class="kc-bar-fill-q" style="width:<?php echo esc_attr(min($quotes_conversion,100)); ?>%;"></div></div>
                </div>
                <div class="kc-bar-wrap">
                    <div class="kc-bar-header">
                        <span>Overall Blended Conversion Rate</span>
                        <span><?php echo number_format($blended_conversion, 1); ?>%</span>
                    </div>
                    <div class="kc-bar-track"><div class="kc-bar-fill-b" style="width:<?php echo esc_attr(min($blended_conversion,100)); ?>%; background:var(--kc-terracotta);"></div></div>
                </div>
            </div>

            <!-- Revenue Breakdown by Space -->
            <div class="kc-kpi-card kc-kpi-full">
                <div class="kc-card-title kc-card-title--spaces">Bookings Revenue Breakdown by Space</div>
                <?php if (empty($revenue_by_space)): ?>
                    <p style="color:#64748b;font-style:italic;">No completed bookings yet to display revenue breakdown.</p>
                <?php else:
                    $max_rev = max($revenue_by_space);
                    foreach ($revenue_by_space as $space => $rev):
                        $pct = $max_rev > 0 ? ($rev / $max_rev) * 100 : 0;
                        $share = $total_bookings_revenue > 0 ? round(($rev / $total_bookings_revenue) * 100, 1) : 0;
                    ?>
                    <div class="kc-space-row">
                        <div class="kc-space-name" title="<?php echo esc_attr($space); ?>"><?php echo esc_html($space); ?></div>
                        <div class="kc-space-bar"><div class="kc-space-bar-fill" style="width:<?php echo esc_attr($pct); ?>%;"></div></div>
                        <div class="kc-space-val">Php <?php echo number_format($rev); ?> <span style="color:#94a3b8;font-size:11px;">(<?php echo esc_html($share); ?>%)</span></div>
                    </div>
                    <?php endforeach; endif; ?>
            </div>

        </div><!-- /.kc-kpi-grid -->
        </div><!-- /#kc-tab-overview -->

        <!-- =============================================
             RECORDS TABS
             ============================================= -->
        <div class="kc-tabs-wrap">

            <style>
                .kc-tabs-wrap { margin-top: 0; margin-bottom: 0; order: 2; }
                #kc-tab-overview { order: 3; margin-top: 20px; margin-bottom: 24px; }

                /* Tab nav */
                .kc-tab-nav { display: flex; gap: 0; border-bottom: 3px solid transparent; margin-bottom: 0; }
                .kc-tab-btn { background: #fff; border: 1px solid #e2e8f0; border-bottom: none; color: #475569; font-size: 13px; font-weight: 700; padding: 10px 24px; cursor: pointer; margin-right: 4px; border-radius: 6px 6px 0 0; text-transform: uppercase; letter-spacing: .4px; transition: background .15s, color .15s; }
                .kc-tab-btn:hover { background: #fff9ef; color: var(--kc-terracotta); }
                .kc-tab-btn.kc-tab-active { background: var(--kc-terracotta); color: #fff; border-color: var(--kc-terracotta); }
                .kc-tab-btn svg { pointer-events: none; }

                /* Tab panels */
                .kc-tab-panel { display: none; background: #fff; border: 1px solid #e2e8f0; border-top: none; border-radius: 0 0 8px 8px; padding: 24px; box-shadow: 0 2px 6px rgba(0,0,0,.05); }
                .kc-tab-panel.kc-tab-panel-active { display: block; }

                /* Filter bar */
                .kc-filter-bar { display: flex; flex-wrap: wrap; gap: 10px; align-items: flex-end; margin-bottom: 20px; background: #f8fafc; padding: 14px 16px; border-radius: 6px; border: 1px solid #e2e8f0; }
                .kc-filter-bar label { font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: .4px; color: #64748b; display: block; margin-bottom: 4px; }
                .kc-filter-bar input[type="text"] { padding: 7px 10px; border: 1px solid #d1d5db; border-radius: 4px; font-size: 13px; line-height: 1.4; color: #1e293b; background: #fff; min-width: 160px; box-sizing: border-box; }
                .kc-filter-bar select { padding: 8px 32px 8px 10px; border: 1px solid #d1d5db; border-radius: 4px; font-size: 13px; line-height: 1.4; color: #1e293b; background-color: #fff; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%2364748b' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 10px center; min-width: 160px; appearance: none; -webkit-appearance: none; -moz-appearance: none; cursor: pointer; box-sizing: border-box; vertical-align: middle; }
                .kc-filter-bar input[type="text"]:focus,
                .kc-filter-bar select:focus { border-color: var(--kc-terracotta); outline: none; }
                .kc-filter-apply { background: var(--kc-terracotta); color: #fff; border: none; padding: 8px 18px; font-size: 13px; line-height: 1.4; font-weight: 700; border-radius: 4px; cursor: pointer; }
                .kc-filter-apply:hover { background: var(--kc-deep-red); }
                .kc-filter-clear  { background: #fff; color: var(--kc-terracotta); border: 1px solid var(--kc-terracotta); padding: 8px 14px; font-size: 13px; line-height: 1.4; font-weight: 700; border-radius: 4px; cursor: pointer; }
                .kc-filter-clear:hover { background: #fff9ef; }

                /* Records table */
                .kc-records-table { width: 100%; border-collapse: collapse; font-size: 13px; }
                .kc-records-table thead tr { background: var(--kc-terracotta); }
                .kc-records-table thead th { color: #fff; font-size: 11px; text-transform: uppercase; letter-spacing: .4px; padding: 10px 12px; text-align: left; font-weight: 700; white-space: nowrap; }
                .kc-records-table tbody tr { border-bottom: 1px solid #f1f5f9; }
                .kc-records-table tbody tr:hover td { background: #fffaf7; }
                .kc-records-table tbody td { padding: 10px 12px; color: #334155; vertical-align: middle; }
                .kc-records-table tbody td.kc-num { color: #94a3b8; font-size: 11px; }
                .kc-no-results { text-align: center; color: #94a3b8; font-style: italic; padding: 24px !important; }

                /* Status badge */
                .kc-badge { display: inline-block; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: .3px; }

                /* View Details button */
                .kc-view-btn { background: #fff; border: 1px solid var(--kc-terracotta); color: var(--kc-terracotta); padding: 5px 12px; font-size: 12px; font-weight: 700; border-radius: 4px; cursor: pointer; white-space: nowrap; }
                .kc-view-btn:hover { background: var(--kc-terracotta); color: #fff; }

                /* Modal */
                .kc-kpi-modal-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,.55); z-index: 99999; align-items: center; justify-content: center; }
                .kc-kpi-modal-overlay.kc-modal-open { display: flex; }
                .kc-kpi-modal { background: #fff; border-radius: 8px; width: 560px; max-width: 96vw; max-height: 88vh; overflow-y: auto; box-shadow: 0 12px 40px rgba(0,0,0,.2); }
                .kc-modal-header { background: var(--kc-terracotta); padding: 16px 22px; display: flex; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 1; }
                .kc-modal-header h2 { margin: 0; color: #fff; font-size: 15px; font-weight: 800; }
                .kc-modal-close { background: none; border: none; color: #fff; font-size: 22px; cursor: pointer; line-height: 1; padding: 0; opacity: .85; }
                .kc-modal-close:hover { opacity: 1; }
                .kc-modal-body { padding: 22px; }
                .kc-modal-section { margin-bottom: 20px; }
                .kc-modal-section h3 { font-size: 11px; text-transform: uppercase; letter-spacing: .5px; color: var(--kc-terracotta); font-weight: 800; margin: 0 0 10px; border-bottom: 1px solid #f1f5f9; padding-bottom: 6px; }
                .kc-modal-row { display: flex; gap: 8px; padding: 6px 0; border-bottom: 1px solid #f8fafc; font-size: 13px; }
                .kc-modal-row:last-child { border-bottom: none; }
                .kc-modal-lbl { width: 160px; flex-shrink: 0; color: #64748b; font-weight: 600; }
                .kc-modal-val { color: #1e293b; font-weight: 500; word-break: break-word; }
                .kc-modal-team-table { width: 100%; border-collapse: collapse; font-size: 12px; margin-top: 6px; }
                .kc-modal-team-table th { background: var(--kc-terracotta); color: #fff; padding: 7px 10px; text-align: left; font-size: 11px; text-transform: uppercase; letter-spacing: .3px; }
                .kc-modal-team-table td { padding: 7px 10px; border-bottom: 1px solid #f1f5f9; color: #334155; }
                .kc-modal-team-table tr:nth-child(even) td { background: #fffaf7; }
            </style>

            <!-- Tab Navigation -->
            <div class="kc-tab-nav">
                <button class="kc-tab-btn kc-tab-active" data-tab="kc-tab-overview">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:-2px;margin-right:6px;"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>Overview
                </button>
                <button class="kc-tab-btn" data-tab="kc-tab-bookings">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:-2px;margin-right:6px;"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>Bookings
                </button>
                <button class="kc-tab-btn" data-tab="kc-tab-quotes">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:-2px;margin-right:6px;"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><line x1="10" y1="9" x2="8" y2="9"/></svg>Quote Requests
                </button>
                <button class="kc-tab-btn" data-tab="kc-tab-mailing">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:-2px;margin-right:6px;"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>Mailing List
                </button>
            </div>

            <!-- Tab panels -->
            <?php
            /* ---- BOOKINGS TAB DATA ---- */
            // Build space list from kc_space posts — same source as the booking form
            // value = kc_space_booking_key (what's stored on the booking), label = kc_space_heading (what admin sees in Space Add)
            $bk_spaces = array();
            $bk_space_posts = get_posts(array(
                'post_type'      => 'kc_space',
                'posts_per_page' => -1,
                'post_status'    => 'publish',
                'orderby'        => 'menu_order',
                'order'          => 'ASC',
            ));
            foreach ($bk_space_posts as $bk_sp) {
                $bk_key   = get_field('kc_space_booking_key', $bk_sp->ID);
                $bk_label = get_field('kc_space_heading', $bk_sp->ID) ?: $bk_sp->post_title;
                if ($bk_key) $bk_spaces[] = array('value' => $bk_key, 'label' => $bk_label);
            }

            $bk_q = new WP_Query(array('post_type'=>'kc_booking','posts_per_page'=>-1,'orderby'=>'date','order'=>'DESC'));
            $bk_rows = array();
            while ($bk_q->have_posts()) {
                $bk_q->the_post(); $pid = get_the_ID();
                $space  = get_post_meta($pid,'kc_space_type',true);
                $status = get_post_meta($pid,'kc_status',true) ?: 'Pending';
                $bk_rows[] = array(
                    'id'         => $pid,
                    'name'       => trim(get_post_meta($pid,'kc_first_name',true).' '.get_post_meta($pid,'kc_last_name',true)),
                    'email'      => get_post_meta($pid,'kc_email',true),
                    'phone'      => get_post_meta($pid,'kc_phone',true),
                    'space'      => $space,
                    'date'       => get_post_meta($pid,'kc_start_date',true),
                    'duration'   => get_post_meta($pid,'kc_duration',true),
                    'price'      => get_post_meta($pid,'kc_price',true),
                    'status'     => $status,
                    'mem_status' => get_post_meta($pid,'kc_membership_status',true),
                    'mem_expiry' => get_post_meta($pid,'kc_membership_expiry',true),
                    'note'       => get_post_meta($pid,'kc_admin_note',true),
                );
            }
            wp_reset_postdata();
            ?>
            <div id="kc-tab-bookings" class="kc-tab-panel">

                <div class="kc-filter-bar">
                    <div>
                        <label for="kc-bk-search">Client Name</label>
                        <input type="text" id="kc-bk-search" placeholder="Search name…" />
                    </div>
                    <div>
                        <label for="kc-bk-space">Space</label>
                        <select id="kc-bk-space">
                            <option value="">All Spaces</option>
                            <?php foreach ($bk_spaces as $sp): ?>
                            <option value="<?php echo esc_attr($sp['value']); ?>"><?php echo esc_html($sp['label']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label for="kc-bk-status">Status</label>
                        <select id="kc-bk-status">
                            <option value="">All Statuses</option>
                            <option value="Pending">Pending</option>
                            <option value="Contacted">Contacted</option>
                            <option value="Completed">Completed</option>
                            <option value="Rejected">Rejected</option>
                            <option value="Cancelled">Cancelled</option>
                        </select>
                    </div>
                    <button class="kc-filter-apply" id="kc-bk-apply">Apply Filters</button>
                    <button class="kc-filter-clear"  id="kc-bk-clear">Clear</button>
                </div>

                <div style="overflow-x:auto;">
                    <table class="kc-records-table">
                        <thead><tr>
                            <th>#</th><th>Client</th><th>Space</th><th>Date</th>
                            <th>Duration</th><th>Price</th><th>Status</th><th></th>
                        </tr></thead>
                        <tbody id="kc-bk-tbody"></tbody>
                    </table>
                </div>

                <script>
                (function() {
                    var BK = <?php echo wp_json_encode($bk_rows, JSON_HEX_TAG | JSON_HEX_AMP); ?>;
                    var BADGE = {
                        Pending:   'background:#fef9c3;color:#854d0e',
                        Contacted: 'background:#dbeafe;color:#1e40af',
                        Completed: 'background:#dcfce7;color:#166534',
                        Rejected:  'background:#fee2e2;color:#991b1b',
                        Cancelled: 'background:#f1f5f9;color:#475569'
                    };
                    function esc(v) {
                        if (v === null || v === undefined || v === '') return '—';
                        return String(v).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
                    }
                    function mrow(lbl, val) {
                        return '<div class="kc-modal-row"><span class="kc-modal-lbl">'+lbl+'</span><span class="kc-modal-val">'+esc(val)+'</span></div>';
                    }
                    function modalHtml(b) {
                        var h = '<div class="kc-modal-section"><h3>Client Info</h3>';
                        h += mrow('Full Name',b.name)+mrow('Email',b.email)+mrow('Phone',b.phone);
                        h += '</div><div class="kc-modal-section"><h3>Booking Details</h3>';
                        h += mrow('Space',b.space)+mrow('Start Date',b.date)+mrow('Duration',b.duration);
                        h += mrow('Price', b.price ? '₱ '+esc(b.price) : null)+mrow('Status',b.status);
                        h += '</div>';
                        if (b.mem_status) {
                            h += '<div class="kc-modal-section"><h3>Membership</h3>';
                            h += mrow('Status',b.mem_status);
                            if (b.mem_expiry) h += mrow('Expiry',b.mem_expiry);
                            h += '</div>';
                        }
                        if (b.note) {
                            h += '<div class="kc-modal-section"><h3>Admin Note</h3>';
                            h += '<p style="font-size:13px;color:#334155;margin:0">'+esc(b.note)+'</p></div>';
                        }
                        return h;
                    }
                    function render(list) {
                        var tbody = document.getElementById('kc-bk-tbody');
                        if (!list.length) {
                            tbody.innerHTML = '<tr><td colspan="8" class="kc-no-results">No bookings found.</td></tr>';
                            return;
                        }
                        var rows = '';
                        list.forEach(function(b, i) {
                            var bs = BADGE[b.status] || 'background:#f1f5f9;color:#475569';
                            rows += '<tr>';
                            rows += '<td class="kc-num">'+(i+1)+'</td>';
                            rows += '<td><strong>'+esc(b.name)+'</strong><div style="font-size:11px;color:#94a3b8">'+esc(b.email)+'</div></td>';
                            rows += '<td>'+esc(b.space)+'</td>';
                            rows += '<td>'+esc(b.date)+'</td>';
                            rows += '<td>'+esc(b.duration)+'</td>';
                            rows += '<td>'+(b.price ? '₱ '+esc(b.price) : '—')+'</td>';
                            rows += '<td><span class="kc-badge" style="'+bs+'">'+esc(b.status)+'</span></td>';
                            rows += '<td><button class="kc-view-btn" data-idx="'+i+'">View Details</button></td>';
                            rows += '</tr>';
                        });
                        tbody.innerHTML = rows;
                        tbody.querySelectorAll('.kc-view-btn').forEach(function(btn) {
                            var b = list[parseInt(btn.dataset.idx, 10)];
                            btn.setAttribute('data-modal-title', b.name || 'Booking Details');
                            btn.setAttribute('data-modal-body',  modalHtml(b));
                        });
                    }
                    function applyFilters() {
                        var q  = document.getElementById('kc-bk-search').value.trim().toLowerCase();
                        var sp = document.getElementById('kc-bk-space').value;
                        var st = document.getElementById('kc-bk-status').value;
                        render(BK.filter(function(b) {
                            if (q  && b.name.toLowerCase().indexOf(q) === -1) return false;
                            if (sp && b.space  !== sp) return false;
                            if (st && b.status !== st) return false;
                            return true;
                        }));
                    }
                    document.getElementById('kc-bk-apply').addEventListener('click', applyFilters);
                    document.getElementById('kc-bk-clear').addEventListener('click', function() {
                        document.getElementById('kc-bk-search').value = '';
                        document.getElementById('kc-bk-space').value  = '';
                        document.getElementById('kc-bk-status').value = '';
                        render(BK);
                    });
                    document.getElementById('kc-bk-search').addEventListener('keydown', function(ev) {
                        if (ev.key === 'Enter') applyFilters();
                    });
                    render(BK);
                })();
                </script>
            </div>
            <?php
            /* ---- QUOTES TAB DATA ---- */
            $qt_q = new WP_Query(array('post_type'=>'kg_quote_lead','posts_per_page'=>-1,'orderby'=>'date','order'=>'DESC'));
            $qt_rows = array();
            while ($qt_q->have_posts()) {
                $qt_q->the_post(); $qid = get_the_ID();
                $fn   = get_post_meta($qid,'first_name',true);
                $mn   = get_post_meta($qid,'middle_name',true);
                $ln   = get_post_meta($qid,'last_name',true);
                $name = trim($fn . ($mn?' '.$mn:'') . ' ' . $ln);
                $team_raw = get_post_meta($qid,'team_json',true);
                $team = $team_raw ? json_decode($team_raw, true) : array();
                $qt_rows[] = array(
                    'id'       => $qid,
                    'name'     => $name,
                    'email'    => get_post_meta($qid,'email',true),
                    'phone'    => get_post_meta($qid,'phone',true),
                    'address'  => get_post_meta($qid,'address',true),
                    'total'    => get_post_meta($qid,'total_est',true),
                    'currency' => get_post_meta($qid,'currency_used',true) ?: 'PHP',
                    'status'   => get_post_meta($qid,'lead_status',true) ?: 'Pending',
                    'team'     => is_array($team) ? $team : array(),
                    'created'  => get_the_date('Y-m-d'),
                );
            }
            wp_reset_postdata();
            ?>
            <div id="kc-tab-quotes" class="kc-tab-panel">

                <div class="kc-filter-bar">
                    <div>
                        <label for="kc-qt-search">Client Name</label>
                        <input type="text" id="kc-qt-search" placeholder="Search name…" />
                    </div>
                    <div>
                        <label for="kc-qt-status">Status</label>
                        <select id="kc-qt-status">
                            <option value="">All Statuses</option>
                            <option value="Pending">Pending</option>
                            <option value="Contacted">Contacted</option>
                            <option value="Closed">Closed</option>
                            <option value="Rejected">Rejected</option>
                        </select>
                    </div>
                    <button class="kc-filter-apply" id="kc-qt-apply">Apply Filters</button>
                    <button class="kc-filter-clear"  id="kc-qt-clear">Clear</button>
                </div>

                <div style="overflow-x:auto;">
                    <table class="kc-records-table">
                        <thead><tr>
                            <th>#</th><th>Client</th><th>Team Size</th>
                            <th>Est. Total</th><th>Date</th><th>Status</th><th></th>
                        </tr></thead>
                        <tbody id="kc-qt-tbody"></tbody>
                    </table>
                </div>

                <script>
                (function() {
                    var QT = <?php echo wp_json_encode($qt_rows, JSON_HEX_TAG | JSON_HEX_AMP); ?>;
                    var BADGE = {
                        Pending:   'background:#fef9c3;color:#854d0e',
                        Contacted: 'background:#dbeafe;color:#1e40af',
                        Closed:    'background:#dcfce7;color:#166534',
                        Rejected:  'background:#fee2e2;color:#991b1b'
                    };
                    function esc(v) {
                        if (v === null || v === undefined || v === '' || (Array.isArray(v) && !v.length)) return '—';
                        return String(v).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
                    }
                    function mrow(lbl, val) {
                        return '<div class="kc-modal-row"><span class="kc-modal-lbl">'+lbl+'</span><span class="kc-modal-val">'+esc(val)+'</span></div>';
                    }
                    function teamTable(team) {
                        if (!team || !team.length) return '<p style="color:#94a3b8;font-style:italic;font-size:13px">No team members added.</p>';
                        var rows = team.map(function(m) {
                            var role  = m.title     || m.role || m.name || '—';
                            var level = m.level     || '—';
                            var count = m.headcount || m.count || m.qty || 1;
                            var rate  = m.monthly   || m.rate  || '—';
                            return '<tr><td>'+esc(role)+'</td><td>'+esc(level)+'</td><td>'+esc(count)+'</td><td>'+esc(rate)+'</td></tr>';
                        }).join('');
                        return '<table class="kc-modal-team-table"><thead><tr><th>Role</th><th>Level</th><th>Headcount</th><th>Monthly Rate</th></tr></thead><tbody>'+rows+'</tbody></table>';
                    }
                    function modalHtml(q) {
                        var h = '<div class="kc-modal-section"><h3>Client Info</h3>';
                        h += mrow('Full Name',q.name)+mrow('Email',q.email)+mrow('Phone',q.phone);
                        h += mrow('Address',q.address);
                        h += '</div><div class="kc-modal-section"><h3>Quote Details</h3>';
                        h += mrow('Date Submitted',q.created)+mrow('Status',q.status);
                        h += mrow('Currency',q.currency);
                        h += mrow('Est. Total', q.total ? q.currency+' '+esc(q.total) : null);
                        h += '</div>';
                        if (q.team && q.team.length) {
                            h += '<div class="kc-modal-section"><h3>Team Breakdown ('+q.team.length+' role'+(q.team.length!==1?'s':'')+')</h3>';
                            h += teamTable(q.team);
                            h += '</div>';
                        }
                        return h;
                    }
                    function render(list) {
                        var tbody = document.getElementById('kc-qt-tbody');
                        if (!list.length) {
                            tbody.innerHTML = '<tr><td colspan="7" class="kc-no-results">No quote requests found.</td></tr>';
                            return;
                        }
                        var rows = '';
                        list.forEach(function(q, i) {
                            var bs = BADGE[q.status] || 'background:#f1f5f9;color:#475569';
                            rows += '<tr>';
                            rows += '<td class="kc-num">'+(i+1)+'</td>';
                            rows += '<td><strong>'+esc(q.name)+'</strong><div style="font-size:11px;color:#94a3b8">'+esc(q.email)+'</div></td>';
                            rows += '<td>'+(q.team&&q.team.length ? q.team.length+' role'+(q.team.length!==1?'s':'') : '—')+'</td>';
                            rows += '<td>'+(q.total ? esc(q.currency)+' '+esc(q.total) : '—')+'</td>';
                            rows += '<td>'+esc(q.created)+'</td>';
                            rows += '<td><span class="kc-badge" style="'+bs+'">'+esc(q.status)+'</span></td>';
                            rows += '<td><button class="kc-view-btn" data-idx="'+i+'">View Details</button></td>';
                            rows += '</tr>';
                        });
                        tbody.innerHTML = rows;
                        tbody.querySelectorAll('.kc-view-btn').forEach(function(btn) {
                            var q = list[parseInt(btn.dataset.idx, 10)];
                            btn.setAttribute('data-modal-title', q.name || 'Quote Details');
                            btn.setAttribute('data-modal-body',  modalHtml(q));
                        });
                    }
                    function applyFilters() {
                        var qv = document.getElementById('kc-qt-search').value.trim().toLowerCase();
                        var st = document.getElementById('kc-qt-status').value;
                        render(QT.filter(function(q) {
                            if (qv && q.name.toLowerCase().indexOf(qv) === -1) return false;
                            if (st && q.status !== st) return false;
                            return true;
                        }));
                    }
                    document.getElementById('kc-qt-apply').addEventListener('click', applyFilters);
                    document.getElementById('kc-qt-clear').addEventListener('click', function() {
                        document.getElementById('kc-qt-search').value = '';
                        document.getElementById('kc-qt-status').value = '';
                        render(QT);
                    });
                    document.getElementById('kc-qt-search').addEventListener('keydown', function(ev) {
                        if (ev.key === 'Enter') applyFilters();
                    });
                    render(QT);
                })();
                </script>
            </div>
            <?php
            /* ---- MAILING LIST TAB DATA ---- */
            global $wpdb;
            $ml_table = $wpdb->prefix . 'kc_mailing_list';
            $ml_rows  = $wpdb->get_results("SELECT id, email, status, subscribed_at FROM {$ml_table} ORDER BY id DESC", ARRAY_A);
            if (!$ml_rows) $ml_rows = array();
            ?>
            <div id="kc-tab-mailing" class="kc-tab-panel">

                <div class="kc-filter-bar">
                    <div>
                        <label for="kc-ml-search">Email</label>
                        <input type="text" id="kc-ml-search" placeholder="Search email…" />
                    </div>
                    <div>
                        <label for="kc-ml-status">Status</label>
                        <select id="kc-ml-status">
                            <option value="">All Statuses</option>
                            <option value="active">Active</option>
                            <option value="pending">Pending</option>
                            <option value="unsubscribed">Unsubscribed</option>
                        </select>
                    </div>
                    <button class="kc-filter-apply" id="kc-ml-apply">Apply Filters</button>
                    <button class="kc-filter-clear"  id="kc-ml-clear">Clear</button>
                </div>

                <div style="overflow-x:auto;">
                    <table class="kc-records-table">
                        <thead><tr>
                            <th>#</th><th>Email</th><th>Status</th><th>Subscribed</th><th></th>
                        </tr></thead>
                        <tbody id="kc-ml-tbody"></tbody>
                    </table>
                </div>

                <script>
                (function() {
                    var ML = <?php echo wp_json_encode($ml_rows, JSON_HEX_TAG | JSON_HEX_AMP); ?>;
                    var BADGE = {
                        active:       'background:#dcfce7;color:#166534',
                        pending:      'background:#fef9c3;color:#854d0e',
                        unsubscribed: 'background:#f1f5f9;color:#475569'
                    };
                    function esc(v) {
                        if (v === null || v === undefined || v === '') return '—';
                        return String(v).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
                    }
                    function mrow(lbl, val) {
                        return '<div class="kc-modal-row"><span class="kc-modal-lbl">'+lbl+'</span><span class="kc-modal-val">'+esc(val)+'</span></div>';
                    }
                    function modalHtml(m) {
                        var h = '<div class="kc-modal-section"><h3>Subscriber Info</h3>';
                        h += mrow('Email',m.email);
                        h += mrow('Status', m.status ? m.status.charAt(0).toUpperCase()+m.status.slice(1) : null);
                        h += mrow('Subscribed At', m.subscribed_at);
                        h += mrow('Record ID', '#'+m.id);
                        h += '</div>';
                        return h;
                    }
                    function render(list) {
                        var tbody = document.getElementById('kc-ml-tbody');
                        if (!list.length) {
                            tbody.innerHTML = '<tr><td colspan="5" class="kc-no-results">No subscribers found.</td></tr>';
                            return;
                        }
                        var rows = '';
                        list.forEach(function(m, i) {
                            var st  = (m.status || 'pending').toLowerCase();
                            var bs  = BADGE[st] || 'background:#f1f5f9;color:#475569';
                            var lbl = st.charAt(0).toUpperCase() + st.slice(1);
                            rows += '<tr>';
                            rows += '<td class="kc-num">'+(i+1)+'</td>';
                            rows += '<td>'+esc(m.email)+'</td>';
                            rows += '<td><span class="kc-badge" style="'+bs+'">'+lbl+'</span></td>';
                            rows += '<td>'+esc(m.subscribed_at)+'</td>';
                            rows += '<td><button class="kc-view-btn" data-idx="'+i+'">View Details</button></td>';
                            rows += '</tr>';
                        });
                        tbody.innerHTML = rows;
                        tbody.querySelectorAll('.kc-view-btn').forEach(function(btn) {
                            var m = list[parseInt(btn.dataset.idx, 10)];
                            btn.setAttribute('data-modal-title', m.email || 'Subscriber Details');
                            btn.setAttribute('data-modal-body',  modalHtml(m));
                        });
                    }
                    function applyFilters() {
                        var q  = document.getElementById('kc-ml-search').value.trim().toLowerCase();
                        var st = document.getElementById('kc-ml-status').value;
                        render(ML.filter(function(m) {
                            if (q  && m.email.toLowerCase().indexOf(q) === -1) return false;
                            if (st && (m.status||'pending').toLowerCase() !== st) return false;
                            return true;
                        }));
                    }
                    document.getElementById('kc-ml-apply').addEventListener('click', applyFilters);
                    document.getElementById('kc-ml-clear').addEventListener('click', function() {
                        document.getElementById('kc-ml-search').value  = '';
                        document.getElementById('kc-ml-status').value  = '';
                        render(ML);
                    });
                    document.getElementById('kc-ml-search').addEventListener('keydown', function(ev) {
                        if (ev.key === 'Enter') applyFilters();
                    });
                    render(ML);
                })();
                </script>
            </div>

            <!-- Shared Modal -->
            <div class="kc-kpi-modal-overlay" id="kc-kpi-modal-overlay">
                <div class="kc-kpi-modal">
                    <div class="kc-modal-header">
                        <h2 id="kc-modal-title">Details</h2>
                        <button class="kc-modal-close" id="kc-modal-close">&times;</button>
                    </div>
                    <div class="kc-modal-body" id="kc-modal-body"></div>
                </div>
            </div>

        </div><!-- /.kc-tabs-wrap -->

        <script>
        jQuery(document).ready(function($) {
            // Tab switching
            $('.kc-tab-btn').on('click', function() {
                var target = $(this).data('tab');
                $('.kc-tab-btn').removeClass('kc-tab-active');
                $('.kc-tab-panel').removeClass('kc-tab-panel-active');
                $('[data-tab="' + target + '"]').addClass('kc-tab-active');
                $('#' + target).addClass('kc-tab-panel-active');
            });

            // Modal open/close
            $(document).on('click', '.kc-view-btn', function() {
                var title = $(this).data('modal-title') || 'Details';
                var body  = $(this).data('modal-body')  || '';
                $('#kc-modal-title').text(title);
                $('#kc-modal-body').html(body);
                $('#kc-kpi-modal-overlay').addClass('kc-modal-open');
            });
            $('#kc-modal-close, #kc-kpi-modal-overlay').on('click', function(e) {
                if (e.target === this) $('#kc-kpi-modal-overlay').removeClass('kc-modal-open');
            });
            $(document).on('keydown', function(e) {
                if (e.key === 'Escape') $('#kc-kpi-modal-overlay').removeClass('kc-modal-open');
            });
        });
        </script>

    </div>
    <?php
}
