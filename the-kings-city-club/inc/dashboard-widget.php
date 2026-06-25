<?php
if (!defined('ABSPATH')) exit;

function kc_add_dashboard_widgets() {
    wp_add_dashboard_widget(
        'kc_bookings_dashboard_widget',
        'Kings City Operations Dashboard',
        'kc_render_bookings_dashboard_widget'
    );
}
add_action('wp_dashboard_setup', 'kc_add_dashboard_widgets');

function kc_render_bookings_dashboard_widget() {
    $today = date('Y-m-d');

    // --- 1. Queries ---

    // Total Active Members
    $members_query = new WP_Query(array(
        'post_type' => 'kc_booking',
        'fields' => 'ids',
        'posts_per_page' => -1,
        'meta_query' => array(
            array(
                'key' => 'kc_membership_status',
                'value' => 'Active'
            )
        )
    ));
    $active_members_count = $members_query->found_posts;

    // Pipeline Counts
    $counts = array(
        'Pending' => 0,
        'Contacted' => 0,
        'Completed' => 0,
        'Rejected' => 0,
        'Cancelled' => 0
    );

    $all_bookings = new WP_Query(array(
        'post_type' => 'kc_booking',
        'posts_per_page' => -1,
        'fields' => 'ids'
    ));
    
    foreach ($all_bookings->posts as $post_id) {
        $status = get_post_meta($post_id, 'kc_status', true);
        if (isset($counts[$status])) {
            $counts[$status]++;
        }
    }

    $total_pipeline = array_sum($counts);

    // Today's Slots Used
    $todays_bookings = new WP_Query(array(
        'post_type' => 'kc_booking',
        'posts_per_page' => -1,
        'fields' => 'ids',
        'meta_query' => array(
            'relation' => 'AND',
            array('key' => 'kc_start_date', 'value' => $today),
            array('key' => 'kc_status', 'value' => array('Pending', 'Contacted', 'Completed'), 'compare' => 'IN')
        )
    ));

    $slots_used = array(
        'Co-Working' => 0,
        'Meeting Rooms' => 0,
        'Events Place' => 0,
        'Office Leasing' => 0,
        'Virtual Office' => 0,
        'Bakehouse' => 0,
        'Manille Ceramic (Limited)' => 0,
    );

    foreach ($todays_bookings->posts as $post_id) {
        $space = get_post_meta($post_id, 'kc_space_type', true);
        if (isset($slots_used[$space])) {
            $slots_used[$space]++;
        }
    }

    // Capacities
    $capacities = array(
        'Co-Working' => get_option('kc_capacity_co_working', 50),
        'Meeting Rooms' => get_option('kc_capacity_meeting_rooms', 5),
        'Events Place' => get_option('kc_capacity_events_place', 2),
        'Office Leasing' => get_option('kc_capacity_office_leasing', 10),
        'Virtual Office' => get_option('kc_capacity_virtual_office', 100),
        'Bakehouse' => get_option('kc_capacity_bakehouse', 20),
        'Manille Ceramic (Limited)' => get_option('kc_capacity_manille_ceramic', 10),
    );

    $total_capacity = array_sum($capacities);
    $total_used_today = array_sum($slots_used);
    $total_available_today = max(0, $total_capacity - $total_used_today);

    // Recent Bookings (5)
    $recent_bookings = new WP_Query(array(
        'post_type' => 'kc_booking',
        'posts_per_page' => 5,
    ));

    // Recent Quote Leads (5)
    $recent_quotes = new WP_Query(array(
        'post_type' => 'kg_quote_lead',
        'posts_per_page' => 5,
    ));

    // --- 2. Styles ---
    ?>
    <style>
        .kc-dash-wrapper { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif; }
        
        .kc-dash-headcount-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 20px; }
        .kc-dash-box { padding: 15px; border-radius: 4px; color: white; display: flex; flex-direction: column; justify-content: center; }
        .kc-dash-box .label { font-size: 10px; font-weight: bold; text-transform: uppercase; letter-spacing: 0.5px; opacity: 0.8; margin-bottom: 5px; }
        .kc-dash-box .number { font-size: 32px; font-weight: 800; line-height: 1; }
        
        .kc-dash-box.blue { background-color: #17406B; }
        .kc-dash-box.green { background-color: #0E7754; }
        .kc-dash-box.yellow { background-color: #D97706; }
        .kc-dash-box.white { background-color: #fff; color: #17406B; border: 1px solid #e2e8f0; }
        .kc-dash-box.white .label { color: #64748b; }

        .kc-dash-section-title { font-size: 11px; font-weight: bold; text-transform: uppercase; letter-spacing: 0.5px; color: #64748b; margin-top: 20px; margin-bottom: 10px; border-bottom: 1px solid #e2e8f0; padding-bottom: 5px; }

        .kc-dash-progress-row { display: flex; align-items: center; margin-bottom: 8px; font-size: 11px; }
        .kc-dash-progress-label { width: 140px; color: #1e293b; font-weight: 500; }
        .kc-dash-progress-bar-container { flex-grow: 1; background-color: #e2e8f0; height: 6px; border-radius: 3px; margin: 0 10px; overflow: hidden; }
        .kc-dash-progress-bar { height: 100%; background-color: #17406B; border-radius: 3px; }
        .kc-dash-progress-value { width: 30px; text-align: right; color: #64748b; font-weight: bold; }

        .kc-dash-pipeline-bar { height: 8px; border-radius: 4px; margin: 0 10px; flex-grow: 1; }
        .kc-dash-pipeline-row .kc-dash-progress-bar-container { background-color: #f1f5f9; height: 8px; }
        
        .kc-dash-pipeline-pending { background-color: #f59e0b; }
        .kc-dash-pipeline-contacted { background-color: #3b82f6; }
        .kc-dash-pipeline-completed { background-color: #10b981; }
        .kc-dash-pipeline-rejected { background-color: #ef4444; }

        .kc-dash-table { width: 100%; border-collapse: collapse; font-size: 11px; margin-bottom: 10px; }
        .kc-dash-table th, .kc-dash-table td { padding: 8px 4px; border-bottom: 1px solid #f1f5f9; text-align: left; }
        .kc-dash-table th { color: #64748b; font-weight: 600; text-transform: uppercase; font-size: 10px; }
        .kc-dash-table tr:last-child td { border-bottom: none; }
        
        .kc-dash-actions { display: flex; justify-content: space-between; gap: 10px; margin-top: 15px; }
        .kc-dash-actions a { flex: 1; text-align: center; }
    </style>

    <!-- 3. HTML Structure -->
    <div class="kc-dash-wrapper">
        
        <div class="kc-dash-section-title" style="margin-top:0; border:none;">HEADCOUNT</div>
        
        <div class="kc-dash-headcount-grid">
            <div class="kc-dash-box blue">
                <div class="number"><?php echo esc_html($active_members_count); ?></div>
                <div class="label">Active Members</div>
            </div>
            <div class="kc-dash-box white">
                <div class="number"><?php echo esc_html($total_available_today); ?></div>
                <div class="label">Open Slots Today</div>
            </div>
            <div class="kc-dash-box green">
                <div class="number"><?php echo esc_html($counts['Completed']); ?></div>
                <div class="label">Completed Bookings</div>
            </div>
            <div class="kc-dash-box yellow">
                <div class="number"><?php echo esc_html($counts['Pending']); ?></div>
                <div class="label">Pending Action</div>
            </div>
        </div>

        <div class="kc-dash-section-title">ACTIVE SLOTS USED TODAY (<?php echo esc_html($total_used_today); ?> TOTAL)</div>
        
        <?php foreach ($capacities as $space_name => $max_cap): 
            $used = $slots_used[$space_name];
            $percent = ($max_cap > 0) ? ($used / $max_cap) * 100 : 0;
            if ($percent > 100) $percent = 100;
        ?>
        <div class="kc-dash-progress-row">
            <div class="kc-dash-progress-label"><?php echo esc_html($space_name); ?></div>
            <div class="kc-dash-progress-bar-container">
                <div class="kc-dash-progress-bar" style="width: <?php echo esc_attr($percent); ?>%;"></div>
            </div>
            <div class="kc-dash-progress-value"><?php echo esc_html($used); ?></div>
        </div>
        <?php endforeach; ?>

        <div class="kc-dash-section-title">BOOKINGS PIPELINE (<?php echo esc_html($total_pipeline); ?> TOTAL)</div>

        <?php 
        $pipeline_stages = array(
            'Pending' => 'kc-dash-pipeline-pending',
            'Contacted' => 'kc-dash-pipeline-contacted',
            'Completed' => 'kc-dash-pipeline-completed',
            'Rejected' => 'kc-dash-pipeline-rejected',
        );
        foreach ($pipeline_stages as $stage => $css_class): 
            $stage_count = $counts[$stage];
            $stage_percent = ($total_pipeline > 0) ? ($stage_count / $total_pipeline) * 100 : 0;
        ?>
        <div class="kc-dash-progress-row kc-dash-pipeline-row">
            <div class="kc-dash-progress-label" style="width:100px; color:<?php 
                if($stage=='Pending') echo '#d97706';
                elseif($stage=='Contacted') echo '#2563eb';
                elseif($stage=='Completed') echo '#059669';
                elseif($stage=='Rejected') echo '#dc2626';
            ?>;"><?php echo esc_html($stage); ?></div>
            <div class="kc-dash-progress-bar-container">
                <div class="kc-dash-progress-bar <?php echo esc_attr($css_class); ?>" style="width: <?php echo esc_attr($stage_percent); ?>%;"></div>
            </div>
            <div class="kc-dash-progress-value"><?php echo esc_html($stage_count); ?></div>
        </div>
        <?php endforeach; ?>


        <div class="kc-dash-section-title">RECENT BOOKINGS</div>
        <table class="kc-dash-table">
            <tr>
                <th>Client</th>
                <th>Space</th>
                <th>Date</th>
            </tr>
            <?php if ($recent_bookings->have_posts()): while ($recent_bookings->have_posts()): $recent_bookings->the_post(); 
                $space = get_post_meta(get_the_ID(), 'kc_space_type', true);
                $date = get_post_meta(get_the_ID(), 'kc_start_date', true);
            ?>
            <tr>
                <td><a href="<?php echo get_edit_post_link(); ?>"><?php the_title(); ?></a></td>
                <td><?php echo esc_html($space); ?></td>
                <td><?php echo esc_html($date); ?></td>
            </tr>
            <?php endwhile; else: ?>
            <tr><td colspan="3">No bookings found.</td></tr>
            <?php endif; wp_reset_postdata(); ?>
        </table>

        <div class="kc-dash-section-title">RECENT QUOTE LEADS</div>
        <table class="kc-dash-table">
            <tr>
                <th>Company/Client</th>
                <th>Estimated Monthly</th>
            </tr>
            <?php if ($recent_quotes->have_posts()): while ($recent_quotes->have_posts()): $recent_quotes->the_post(); 
                $company = get_post_meta(get_the_ID(), 'company_name', true);
                if (!$company) $company = get_the_title();
                $monthly = get_post_meta(get_the_ID(), 'monthly_total', true);
            ?>
            <tr>
                <td><a href="<?php echo get_edit_post_link(); ?>"><?php echo esc_html($company); ?></a></td>
                <td><?php echo esc_html($monthly); ?></td>
            </tr>
            <?php endwhile; else: ?>
            <tr><td colspan="2">No quote leads found.</td></tr>
            <?php endif; wp_reset_postdata(); ?>
        </table>

        <div class="kc-dash-actions">
            <a href="<?php echo admin_url('edit.php?post_type=kc_booking'); ?>" class="button button-primary">Manage Bookings</a>
            <a href="<?php echo admin_url('edit.php?post_type=kg_quote_lead'); ?>" class="button button-secondary">Quote Leads</a>
        </div>
    </div>
    <?php
}
