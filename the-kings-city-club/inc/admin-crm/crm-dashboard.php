<?php
if (!defined('ABSPATH')) exit;

function kc_get_dashboard_stats() {
    $stats = array(
        'offshoring' => array('pending' => 0, 'in_progress' => 0, 'complete' => 0),
        'spaces'     => array('pending' => 0, 'in_progress' => 0, 'complete' => 0),
        'bookings'   => array('pending' => 0, 'confirmed' => 0, 'cancelled' => 0),
        'quotes'     => array('pending' => 0, 'contacted' => 0, 'closed' => 0, 'revenue_php' => 0)
    );

    // Offshoring & Spaces Stats
    $applications = get_posts(array(
        'post_type'      => 'kc_application',
        'post_status'    => 'publish',
        'posts_per_page' => -1,
    ));

    foreach ($applications as $app) {
        $service = get_post_meta($app->ID, 'kc_service', true);
        $status  = get_post_meta($app->ID, 'kc_status', true);

        if (strpos($service, 'Offshoring') !== false) {
            if ($status === 'Step 1 - Pending Approval') {
                $stats['offshoring']['pending']++;
            } elseif (in_array($status, array('Step 2 - Waiting for Client Details', 'Step 2 - Submitted', 'Step 3 - Discovery Call', 'Step 3 - Submitted'))) {
                $stats['offshoring']['in_progress']++;
            } elseif ($status === 'Complete') {
                $stats['offshoring']['complete']++;
            }
        } elseif (strpos($service, 'Spaces') !== false || strpos($service, 'Membership') !== false) {
            if ($status === 'Step 1 - Pending Approval') {
                $stats['spaces']['pending']++;
            } elseif (in_array($status, array('Step 2 - Waiting for Tour Booking', 'Step 2 - Tour Submitted'))) {
                $stats['spaces']['in_progress']++;
            } elseif ($status === 'Complete - Tour Scheduled') {
                $stats['spaces']['complete']++;
            }
        }
    }

    // Bookings Stats
    $bookings = get_posts(array(
        'post_type'      => 'kc_booking',
        'post_status'    => 'publish',
        'posts_per_page' => -1,
    ));

    foreach ($bookings as $booking) {
        $status = get_post_meta($booking->ID, 'kc_status', true);
        if ($status === 'Pending Payment') {
            $stats['bookings']['pending']++;
        } elseif ($status === 'Paid / Claimed') {
            $stats['bookings']['confirmed']++;
        } elseif ($status === 'Expired / Cancelled') {
            $stats['bookings']['cancelled']++;
        }
    }

    // Quote Requests Stats
    $quotes = get_posts(array(
        'post_type'      => 'kg_quote_lead',
        'post_status'    => 'publish',
        'posts_per_page' => -1,
    ));

    foreach ($quotes as $quote) {
        $status = get_post_meta($quote->ID, 'lead_status', true);
        if (!$status) $status = 'Pending';
        
        if ($status === 'Pending') {
            $stats['quotes']['pending']++;
        } elseif ($status === 'Contacted') {
            $stats['quotes']['contacted']++;
        } elseif ($status === 'Closed') {
            $stats['quotes']['closed']++;
            
            // Calculate revenue in PHP
            $currency = get_post_meta($quote->ID, 'currency_used', true);
            $est_str = get_post_meta($quote->ID, 'total_est', true);
            $val = (float) preg_replace('/[^0-9.]/', '', $est_str);
            
            if ($currency === 'USD') {
                $val = $val / 0.017; // Convert back to PHP using the rate from page-apply
            } elseif ($currency === 'AUD') {
                $val = $val / 0.026;
            }
            
            $stats['quotes']['revenue_php'] += $val;
        }
    }

    return $stats;
}

function kc_get_recent_activity() {
    $recent = get_posts(array(
        'post_type'      => array('kc_application', 'kc_booking'),
        'post_status'    => 'publish',
        'posts_per_page' => 10,
        'orderby'        => 'date',
        'order'          => 'DESC',
    ));
    return $recent;
}

function kc_render_dashboard_page() {
    $stats = kc_get_dashboard_stats();
    $recent_activity = kc_get_recent_activity();

    $card_style = "background: #fff; border-radius: var(--radius-card, 8px); box-shadow: var(--shadow-md, 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06)); padding: 1.5rem; text-align: center;";
    $number_style = "font-size: 2.5rem; font-weight: bold; color: var(--color-primary, #bd451f); margin: 0 0 0.5rem 0; line-height: 1;";
    $label_style = "color: var(--color-text-muted, #6b7280); font-size: 0.9rem; font-weight: 500; text-transform: uppercase; letter-spacing: 0.05em; margin: 0;";
    $grid_style = "display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;";

    ?>
    <div class="wrap kc-crm-wrap">
        <h1 style="margin-bottom: 2rem; ">Kings City CRM Dashboard</h1>

        <div class="kc-crm-dashboard-sections" style="display: flex; flex-direction: column; gap: 3rem;">
            
            <!-- KPI / Revenue Section -->
            <section>
                <h2 style="border-bottom: 2px solid #e5e7eb; padding-bottom: 0.5rem; margin-bottom: 1.5rem;">KPI Dashboard: Team Builder Revenue</h2>
                <div style="<?php echo esc_attr($grid_style); ?>">
                    <div style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; border-radius: var(--radius-card, 8px); box-shadow: var(--shadow-md); padding: 2rem; text-align: center; grid-column: 1 / -1;">
                        <p style="font-size: 1.1rem; font-weight: 500; text-transform: uppercase; letter-spacing: 0.05em; margin: 0 0 0.5rem 0; opacity: 0.9;">Estimated Monthly Revenue (Closed Leads)</p>
                        <p style="font-size: 3.5rem; font-weight: bold; margin: 0; line-height: 1;">Php <?php echo number_format($stats['quotes']['revenue_php']); ?></p>
                    </div>
                    
                    <div style="<?php echo esc_attr($card_style); ?>">
                        <p style="<?php echo esc_attr($number_style); ?>"><?php echo esc_html($stats['quotes']['pending']); ?></p>
                        <p style="<?php echo esc_attr($label_style); ?>">Pending Quotes</p>
                    </div>
                    <div style="<?php echo esc_attr($card_style); ?>">
                        <p style="<?php echo esc_attr($number_style); ?>"><?php echo esc_html($stats['quotes']['contacted']); ?></p>
                        <p style="<?php echo esc_attr($label_style); ?>">Contacted / Negotiating</p>
                    </div>
                    <div style="<?php echo esc_attr($card_style); ?>">
                        <p style="<?php echo esc_attr($number_style); ?>; color: #10b981;"><?php echo esc_html($stats['quotes']['closed']); ?></p>
                        <p style="<?php echo esc_attr($label_style); ?>">Closed (Won)</p>
                    </div>
                </div>
            </section>
            
            <!-- Offshoring Section -->
            <section>
                <h2 style="border-bottom: 2px solid #e5e7eb; padding-bottom: 0.5rem; margin-bottom: 1.5rem;">Offshoring Applications</h2>
                <div style="<?php echo esc_attr($grid_style); ?>">
                    <div style="<?php echo esc_attr($card_style); ?>">
                        <p style="<?php echo esc_attr($number_style); ?>"><?php echo esc_html($stats['offshoring']['pending']); ?></p>
                        <p style="<?php echo esc_attr($label_style); ?>">Pending Approval</p>
                    </div>
                    <div style="<?php echo esc_attr($card_style); ?>">
                        <p style="<?php echo esc_attr($number_style); ?>"><?php echo esc_html($stats['offshoring']['in_progress']); ?></p>
                        <p style="<?php echo esc_attr($label_style); ?>">In Progress</p>
                    </div>
                    <div style="<?php echo esc_attr($card_style); ?>">
                        <p style="<?php echo esc_attr($number_style); ?>"><?php echo esc_html($stats['offshoring']['complete']); ?></p>
                        <p style="<?php echo esc_attr($label_style); ?>">Completed</p>
                    </div>
                </div>
            </section>

            <!-- Spaces Membership Section -->
            <section>
                <h2 style="border-bottom: 2px solid #e5e7eb; padding-bottom: 0.5rem; margin-bottom: 1.5rem;">Spaces Membership</h2>
                <div style="<?php echo esc_attr($grid_style); ?>">
                    <div style="<?php echo esc_attr($card_style); ?>">
                        <p style="<?php echo esc_attr($number_style); ?>"><?php echo esc_html($stats['spaces']['pending']); ?></p>
                        <p style="<?php echo esc_attr($label_style); ?>">Pending Approval</p>
                    </div>
                    <div style="<?php echo esc_attr($card_style); ?>">
                        <p style="<?php echo esc_attr($number_style); ?>"><?php echo esc_html($stats['spaces']['in_progress']); ?></p>
                        <p style="<?php echo esc_attr($label_style); ?>">In Progress</p>
                    </div>
                    <div style="<?php echo esc_attr($card_style); ?>">
                        <p style="<?php echo esc_attr($number_style); ?>"><?php echo esc_html($stats['spaces']['complete']); ?></p>
                        <p style="<?php echo esc_attr($label_style); ?>">Completed</p>
                    </div>
                </div>
            </section>

            <!-- Book a Space Section -->
            <section>
                <h2 style="border-bottom: 2px solid #e5e7eb; padding-bottom: 0.5rem; margin-bottom: 1.5rem;">Space Bookings</h2>
                <div style="<?php echo esc_attr($grid_style); ?>">
                    <div style="<?php echo esc_attr($card_style); ?>">
                        <p style="<?php echo esc_attr($number_style); ?>"><?php echo esc_html($stats['bookings']['pending']); ?></p>
                        <p style="<?php echo esc_attr($label_style); ?>">Pending Payment</p>
                    </div>
                    <div style="<?php echo esc_attr($card_style); ?>">
                        <p style="<?php echo esc_attr($number_style); ?>"><?php echo esc_html($stats['bookings']['confirmed']); ?></p>
                        <p style="<?php echo esc_attr($label_style); ?>">Confirmed</p>
                    </div>
                    <div style="<?php echo esc_attr($card_style); ?>">
                        <p style="<?php echo esc_attr($number_style); ?>"><?php echo esc_html($stats['bookings']['cancelled']); ?></p>
                        <p style="<?php echo esc_attr($label_style); ?>">Cancelled/Expired</p>
                    </div>
                </div>
            </section>

            <!-- Recent Activity Section -->
            <section>
                <h2 style="border-bottom: 2px solid #e5e7eb; padding-bottom: 0.5rem; margin-bottom: 1.5rem;">Recent Activity</h2>
                <div style="background: #fff; border-radius: var(--radius-card, 8px); box-shadow: var(--shadow-sm, 0 1px 2px 0 rgba(0, 0, 0, 0.05)); overflow: hidden;">
                    <table class="wp-list-table widefat fixed striped" style="border: none; border-radius: 0; box-shadow: none;">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Track</th>
                                <th>Status</th>
                                <th>Date Submitted</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($recent_activity) : ?>
                                <?php foreach ($recent_activity as $item) : 
                                    $is_booking = ($item->post_type === 'kc_booking');
                                    $status = get_post_meta($item->ID, 'kc_status', true);
                                    
                                    if ($is_booking) {
                                        $track = 'Space Booking';
                                        $url = admin_url('admin.php?page=kc-crm-bookings&action=view&id=' . $item->ID);
                                    } else {
                                        $service = get_post_meta($item->ID, 'kc_service', true);
                                        if (strpos($service, 'Offshoring') !== false) {
                                            $track = 'Offshoring';
                                            $url = admin_url('admin.php?page=kc-crm-offshoring&action=view&id=' . $item->ID);
                                        } else {
                                            $track = 'Spaces Membership';
                                            $url = admin_url('admin.php?page=kc-crm-spaces&action=view&id=' . $item->ID);
                                        }
                                    }
                                    ?>
                                    <tr>
                                        <td><strong><a href="<?php echo esc_url($url); ?>"><?php echo esc_html($item->post_title); ?></a></strong></td>
                                        <td><?php echo esc_html($track); ?></td>
                                        <td>
                                            <?php 
                                            // Fallback if the badge function from phase 11 cleanup isn't ready or included here directly
                                            if (function_exists('kc_render_status_badge')) {
                                                kc_render_status_badge($status);
                                            } else {
                                                echo esc_html($status); 
                                            }
                                            ?>
                                        </td>
                                        <td><?php echo get_the_date('M j, Y g:i a', $item->ID); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="4">No recent activity found.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </section>

        </div>
    </div>
    <?php
}

