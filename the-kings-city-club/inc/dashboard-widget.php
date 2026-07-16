<?php
if (!defined('ABSPATH')) exit;

function kc_add_dashboard_widgets() {
    wp_add_dashboard_widget(
        'kc_bookings_dashboard_widget',
        'Kings City Operations Dashboard',
        'kc_render_bookings_dashboard_widget'
    );

    remove_meta_box('dashboard_primary',    'dashboard', 'side');  // WordPress Events and News
    remove_meta_box('dashboard_quick_press', 'dashboard', 'side'); // Quick Draft
    remove_meta_box('dashboard_right_now',  'dashboard', 'normal'); // At a Glance
}
add_action('wp_dashboard_setup', 'kc_add_dashboard_widgets');

function kc_render_bookings_dashboard_widget() {
    $today = date('Y-m-d');

    // --- 1. Queries ---

    // Total Active Members — must be Active status AND expiry date not yet passed
    $members_query = new WP_Query(array(
        'post_type' => 'kc_booking',
        'fields' => 'ids',
        'posts_per_page' => -1,
        'meta_query' => array(
            'relation' => 'AND',
            array(
                'key'   => 'kc_membership_status',
                'value' => 'Active'
            ),
            array(
                'key'     => 'kc_membership_expiry',
                'value'   => $today,
                'compare' => '>='
            )
        )
    ));
    $active_members_count = $members_query->found_posts;

    // Pipeline Counts
    $counts = array(
        'Pending'   => 0,
        'Contacted' => 0,
        'Active'    => 0,
        'Completed' => 0,
        'Rejected'  => 0,
        'Cancelled' => 0,
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
    // A slot is used today if either:
    // 1. The booking's start date is exactly today (for daily/hourly spaces)
    // 2. The booking has an active membership and today is within the active period
    $todays_bookings = new WP_Query(array(
        'post_type' => 'kc_booking',
        'posts_per_page' => -1,
        'fields' => 'ids',
        'meta_query' => array(
            'relation' => 'OR',
            array(
                'relation' => 'AND',
                array('key' => 'kc_start_date', 'value' => $today),
                array('key' => 'kc_status', 'value' => array('Pending', 'Contacted', 'Active', 'Completed'), 'compare' => 'IN')
            ),
            array(
                'relation' => 'AND',
                array('key' => 'kc_membership_status', 'value' => 'Active'),
                array('key' => 'kc_start_date', 'value' => $today, 'compare' => '<='),
                array('key' => 'kc_membership_expiry', 'value' => $today, 'compare' => '>=')
            )
        )
    ));

    // Build slots_used, capacities, and display labels dynamically from kc_space CPT
    $all_spaces_posts = get_posts([
        'post_type'      => 'kc_space',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'orderby'        => 'menu_order',
        'order'          => 'ASC',
    ]);

    $slots_used   = [];
    $capacities   = [];
    $space_labels = [];

    foreach ($all_spaces_posts as $sp) {
        $bk_key = get_field('kc_space_booking_key', $sp->ID);
        $active  = get_field('kc_space_is_active', $sp->ID);
        if (!$bk_key || !$active) continue;
        $slots_used[$bk_key]   = 0;
        $capacities[$bk_key]   = (int) get_field('kc_space_capacity', $sp->ID); // 0 = unlimited
        $space_labels[$bk_key] = get_field('kc_space_heading', $sp->ID) ?: $sp->post_title;
    }

    foreach ($todays_bookings->posts as $post_id) {
        $space = get_post_meta($post_id, 'kc_space_type', true);
        if (isset($slots_used[$space])) {
            $slots_used[$space]++;
        }
    }

    $total_used_today = array_sum($slots_used);
    // Open slots = sum of (cap - used) for capped spaces only; unlimited spaces don't subtract
    $total_available_today = 0;
    foreach ($capacities as $bk_key => $max_cap) {
        if ($max_cap > 0) {
            $total_available_today += max(0, $max_cap - $slots_used[$bk_key]);
        }
    }

    // Bookings by Pass Type per Space (Completed bookings only)
    global $wpdb;
    $pass_types = ['Day Pass', 'Weekly Pass', 'Monthly Pass', 'Annual Pass'];

    $pass_rows = $wpdb->get_results("
        SELECT
            pm_space.meta_value  AS space_type,
            pm_dur.meta_value    AS duration,
            COUNT(*)             AS total
        FROM {$wpdb->posts} p
        INNER JOIN {$wpdb->postmeta} pm_space ON pm_space.post_id = p.ID AND pm_space.meta_key = 'kc_space_type'
        INNER JOIN {$wpdb->postmeta} pm_dur   ON pm_dur.post_id   = p.ID AND pm_dur.meta_key   = 'kc_duration'
        INNER JOIN {$wpdb->postmeta} pm_stat  ON pm_stat.post_id  = p.ID AND pm_stat.meta_key  = 'kc_status' AND pm_stat.meta_value IN ('Active', 'Completed')
        WHERE p.post_type = 'kc_booking' AND p.post_status = 'publish'
        GROUP BY pm_space.meta_value, pm_dur.meta_value
        ORDER BY pm_space.meta_value ASC
    ", ARRAY_A);

    // Pivot into [space][duration] = count
    $pass_matrix = [];
    foreach ($pass_rows as $r) {
        $pass_matrix[ $r['space_type'] ][ $r['duration'] ] = (int) $r['total'];
    }

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
        .kc-dash-wrapper { font-family: 'Outfit', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; }
        
        .kc-dash-headcount-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 20px; }
        .kc-dash-box { padding: 15px; border-radius: 4px; color: white; display: flex; flex-direction: column; justify-content: center; }
        .kc-dash-box .label { font-size: 10px; font-weight: bold; text-transform: uppercase; letter-spacing: 0.5px; opacity: 0.9; margin-bottom: 5px; }
        .kc-dash-box .number { font-size: 32px; font-weight: 800; line-height: 1; }
        
        .kc-dash-box.blue { background-color: #BD451F; color: #FFF9EF; } /* Terracotta */
        .kc-dash-box.green { background-color: #AC201A; color: #FFF9EF; } /* Deep Red */
        .kc-dash-box.yellow { background-color: #FBCB77; color: #2B2B2B; } /* Yellow */
        .kc-dash-box.white { background-color: #FFF9EF; color: #BD451F; border: 1px solid rgba(189,69,31,0.2); } /* Ivory */
        .kc-dash-box.white .label { color: #BD451F; opacity: 0.8; }

        .kc-dash-section-title { font-size: 11px; font-weight: bold; text-transform: uppercase; letter-spacing: 0.5px; color: #AC201A; margin-top: 20px; margin-bottom: 10px; border-bottom: 1px solid rgba(189,69,31,0.2); padding-bottom: 5px; }

        .kc-dash-progress-row { display: flex; align-items: center; margin-bottom: 8px; font-size: 11px; }
        .kc-dash-progress-label { width: 140px; color: #2B2B2B; font-weight: 500; }
        .kc-dash-progress-bar-container { flex-grow: 1; background-color: #FFF9EF; height: 6px; border-radius: 3px; margin: 0 10px; overflow: hidden; border: 1px solid rgba(189,69,31,0.1); }
        .kc-dash-progress-bar { height: 100%; background-color: #BD451F; border-radius: 3px; }
        .kc-dash-progress-value { width: 30px; text-align: right; color: #BD451F; font-weight: bold; }

        .kc-dash-pipeline-bar { height: 8px; border-radius: 4px; margin: 0 10px; flex-grow: 1; }
        .kc-dash-pipeline-row .kc-dash-progress-bar-container { background-color: #FFF9EF; height: 8px; border: 1px solid rgba(189,69,31,0.1); }
        
        .kc-dash-pipeline-pending   { background-color: #FBCB77; }
        .kc-dash-pipeline-contacted { background-color: #BD451F; }
        .kc-dash-pipeline-active    { background-color: #22c55e; }
        .kc-dash-pipeline-completed { background-color: #AC201A; }
        .kc-dash-pipeline-rejected  { background-color: #2B2B2B; }

        .kc-dash-table { width: 100%; border-collapse: collapse; font-size: 11px; margin-bottom: 10px; }
        .kc-dash-table th, .kc-dash-table td { padding: 8px 4px; border-bottom: 1px solid rgba(189,69,31,0.1); text-align: left; }
        .kc-dash-table th { color: #AC201A; font-weight: 600; text-transform: uppercase; font-size: 10px; }
        .kc-dash-table tr:last-child td { border-bottom: none; }
        .kc-dash-table a { color: #BD451F; font-weight: bold; text-decoration: none; }
        .kc-dash-table a:hover { color: #AC201A; }
        
        .kc-pass-table { width: 100%; border-collapse: collapse; font-size: 11px; margin-bottom: 10px; }
        .kc-pass-table th { color: #AC201A; font-weight: 600; text-transform: uppercase; font-size: 10px; padding: 6px 6px; border-bottom: 2px solid rgba(189,69,31,0.2); text-align: center; }
        .kc-pass-table th:first-child { text-align: left; }
        .kc-pass-table td { padding: 6px 6px; border-bottom: 1px solid rgba(189,69,31,0.08); text-align: center; font-weight: 700; color: #0f172a; }
        .kc-pass-table td:first-child { text-align: left; font-weight: 500; color: #2B2B2B; }
        .kc-pass-table tr:last-child td { border-bottom: none; }
        .kc-pass-table .kc-pass-zero { color: #cbd5e1; font-weight: 400; }
        .kc-pass-table .kc-pass-total-row td { background: rgba(189,69,31,0.05); font-weight: 700; color: #AC201A; border-top: 2px solid rgba(189,69,31,0.2); }

        .kc-dash-actions { display: flex; justify-content: space-between; gap: 10px; margin-top: 15px; }
        .kc-dash-actions a { flex: 1; text-align: center; font-weight: bold; border-radius: 4px; }
        .kc-dash-actions .button-primary { background-color: #AC201A !important; border-color: #8c1713 !important; color: #FFF9EF !important; }
        .kc-dash-actions .button-secondary { background-color: #FFF9EF !important; border-color: #BD451F !important; color: #BD451F !important; }
        .kc-dash-actions .button-secondary:hover { background-color: #FFBFBF !important; color: #AC201A !important; }
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
                <div class="number"><?php echo esc_html($counts['Active'] + $counts['Completed']); ?></div>
                <div class="label">Active & Completed</div>
            </div>
            <div class="kc-dash-box yellow">
                <div class="number"><?php echo esc_html($counts['Pending']); ?></div>
                <div class="label">Pending Action</div>
            </div>
        </div>

        <div class="kc-dash-section-title">ACTIVE SLOTS USED TODAY (<?php echo esc_html($total_used_today); ?> TOTAL)</div>
        
        <?php foreach ($capacities as $bk_key => $max_cap):
            $used    = $slots_used[$bk_key];
            $unlimited = ($max_cap === 0);
            $percent   = (!$unlimited && $max_cap > 0) ? min(100, ($used / $max_cap) * 100) : 0;
            $cap_label = $unlimited ? '∞' : esc_html($max_cap);
        ?>
        <div class="kc-dash-progress-row">
            <div class="kc-dash-progress-label"><?php echo esc_html($space_labels[$bk_key] ?? $bk_key); ?></div>
            <div class="kc-dash-progress-bar-container">
                <div class="kc-dash-progress-bar" style="width: <?php echo esc_attr($percent); ?>%;"></div>
            </div>
            <div class="kc-dash-progress-value"><?php echo esc_html($used); ?><?php if ($unlimited): ?><span style="color:#aaa; font-size:10px;">/∞</span><?php endif; ?></div>
        </div>
        <?php endforeach; ?>

        <div class="kc-dash-section-title">BOOKINGS PIPELINE (<?php echo esc_html($total_pipeline); ?> TOTAL)</div>

        <?php 
        $pipeline_stages = array(
            'Pending'   => 'kc-dash-pipeline-pending',
            'Contacted' => 'kc-dash-pipeline-contacted',
            'Active'    => 'kc-dash-pipeline-active',
            'Completed' => 'kc-dash-pipeline-completed',
            'Rejected'  => 'kc-dash-pipeline-rejected',
        );
        foreach ($pipeline_stages as $stage => $css_class): 
            $stage_count = $counts[$stage];
            $stage_percent = ($total_pipeline > 0) ? ($stage_count / $total_pipeline) * 100 : 0;
        ?>
        <div class="kc-dash-progress-row kc-dash-pipeline-row">
            <div class="kc-dash-progress-label" style="width:100px; font-weight: bold; color:<?php 
                if($stage=='Pending')   echo '#D97706';
                elseif($stage=='Contacted') echo '#BD451F';
                elseif($stage=='Active')    echo '#065f46';
                elseif($stage=='Completed') echo '#AC201A';
                elseif($stage=='Rejected')  echo '#2B2B2B';
            ?>;"><?php echo esc_html($stage); ?></div>
            <div class="kc-dash-progress-bar-container">
                <div class="kc-dash-progress-bar <?php echo esc_attr($css_class); ?>" style="width: <?php echo esc_attr($stage_percent); ?>%;"></div>
            </div>
            <div class="kc-dash-progress-value"><?php echo esc_html($stage_count); ?></div>
        </div>
        <?php endforeach; ?>


        <div class="kc-dash-section-title">BOOKINGS BY PASS TYPE (COMPLETED)</div>
        <?php if (!empty($pass_matrix)):
            $col_totals = array_fill_keys($pass_types, 0);
        ?>
        <table class="kc-pass-table">
            <thead>
                <tr>
                    <th>Space</th>
                    <?php foreach ($pass_types as $pt): ?>
                    <th><?php echo esc_html(str_replace(' Pass', '', $pt)); ?></th>
                    <?php endforeach; ?>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($pass_matrix as $space => $dur_counts):
                $row_total = 0;
            ?>
            <tr>
                <td><?php echo esc_html($space_labels[$space] ?? $space); ?></td>
                <?php foreach ($pass_types as $pt):
                    $val = $dur_counts[$pt] ?? 0;
                    $row_total += $val;
                    $col_totals[$pt] += $val;
                ?>
                <td class="<?php echo $val === 0 ? 'kc-pass-zero' : ''; ?>"><?php echo $val ?: '—'; ?></td>
                <?php endforeach; ?>
                <td><?php echo esc_html($row_total); ?></td>
            </tr>
            <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr class="kc-pass-total-row">
                    <td>Total</td>
                    <?php
                    $grand_total = 0;
                    foreach ($pass_types as $pt):
                        $grand_total += $col_totals[$pt];
                    ?>
                    <td><?php echo esc_html($col_totals[$pt]); ?></td>
                    <?php endforeach; ?>
                    <td><?php echo esc_html($grand_total); ?></td>
                </tr>
            </tfoot>
        </table>
        <?php else: ?>
        <p style="color:#94a3b8; font-size:12px;">No completed bookings yet.</p>
        <?php endif; ?>

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
