<?php
if (!defined('ABSPATH')) exit;

function kc_render_bookings_page() {
    $action = isset($_GET['action']) ? sanitize_text_field($_GET['action']) : '';
    $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

    echo '<div class="wrap kc-crm-wrap">';
    
    // Notice banner
    if (isset($_GET['message'])) {
        if ($_GET['message'] === 'success') {
            echo '<div class="notice notice-success is-dismissible"><p>Action completed successfully.</p></div>';
        } elseif ($_GET['message'] === 'error') {
            echo '<div class="notice notice-error is-dismissible"><p>An error occurred. Please try again.</p></div>';
        }
    }

    if ($action === 'view' && $id) {
        kc_render_bookings_detail_view($id);
    } else {
        kc_render_bookings_list_view();
    }

    echo '</div>';
}

function kc_render_bookings_list_view() {
    $filter = isset($_GET['filter']) ? sanitize_text_field($_GET['filter']) : 'all';
    
    $args = array(
        'post_type'      => 'kc_booking',
        'post_status'    => 'publish',
        'posts_per_page' => -1,
    );

    $posts = get_posts($args);
    $filtered_posts = array();

    foreach ($posts as $post) {
        $status = get_post_meta($post->ID, 'kc_status', true);
        
        if ($filter === 'pending' && $status !== 'Pending Payment') continue;
        if ($filter === 'confirmed' && $status !== 'Paid / Claimed') continue;
        if ($filter === 'cancelled' && $status !== 'Expired / Cancelled') continue;
        
        $filtered_posts[] = $post;
    }

    $base_url = admin_url('admin.php?page=kc-crm-bookings');
    
    ?>
    <h1 class="wp-heading-inline">Space Bookings</h1>
    <hr class="wp-header-end">

    <ul class="subsubsub">
        <li class="all"><a href="<?php echo esc_url($base_url); ?>" class="<?php echo $filter === 'all' ? 'current' : ''; ?>">All</a> |</li>
        <li class="pending"><a href="<?php echo esc_url(add_query_arg('filter', 'pending', $base_url)); ?>" class="<?php echo $filter === 'pending' ? 'current' : ''; ?>">Pending Payment</a> |</li>
        <li class="confirmed"><a href="<?php echo esc_url(add_query_arg('filter', 'confirmed', $base_url)); ?>" class="<?php echo $filter === 'confirmed' ? 'current' : ''; ?>">Confirmed</a> |</li>
        <li class="cancelled"><a href="<?php echo esc_url(add_query_arg('filter', 'cancelled', $base_url)); ?>" class="<?php echo $filter === 'cancelled' ? 'current' : ''; ?>">Cancelled</a></li>
    </ul>

    <table class="wp-list-table widefat fixed striped">
        <thead>
            <tr>
                <th style="width: 50px;">#</th>
                <th>Client Name</th>
                <th>Space Type</th>
                <th>Date & Time</th>
                <th>Est. Price</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($filtered_posts)) : ?>
                <?php foreach ($filtered_posts as $post) : 
                    $space_type = get_post_meta($post->ID, 'kc_space_type', true);
                    $start_date = get_post_meta($post->ID, 'kc_start_date', true);
                    $arrival_time = get_post_meta($post->ID, 'kc_arrival_time', true);
                    $price = get_post_meta($post->ID, 'kc_price', true);
                    $status = get_post_meta($post->ID, 'kc_status', true);
                    $view_url = add_query_arg(array('action' => 'view', 'id' => $post->ID), $base_url);
                ?>
                <tr>
                    <td><?php echo esc_html($post->ID); ?></td>
                    <td><strong><a href="<?php echo esc_url($view_url); ?>"><?php echo esc_html($post->post_title); ?></a></strong></td>
                    <td><?php echo esc_html($space_type); ?></td>
                    <td><?php echo esc_html($start_date . ' at ' . $arrival_time); ?></td>
                    <td>Php <?php echo esc_html($price); ?></td>
                    <td>
                        <?php 
                        if (function_exists('kc_render_status_badge')) {
                            kc_render_status_badge($status);
                        } else {
                            echo esc_html($status); 
                        }
                        ?>
                    </td>
                    <td><a href="<?php echo esc_url($view_url); ?>" class="button button-small">View &rarr;</a></td>
                </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr><td colspan="7">No bookings found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
    <?php
}

function kc_render_bookings_detail_view($post_id) {
    $post = get_post($post_id);
    if (!$post || $post->post_type !== 'kc_booking') {
        echo '<p>Booking not found.</p>';
        return;
    }

    $status = get_post_meta($post_id, 'kc_status', true);

    $card_style = "background: #fff; border-radius: var(--radius-card, 8px); box-shadow: var(--shadow-sm, 0 1px 2px 0 rgba(0, 0, 0, 0.05)); padding: 1.5rem; margin-bottom: 1.5rem;";
    $heading_style = "font-size: 1.25rem; border-bottom: 2px solid #e5e7eb; padding-bottom: 0.5rem; margin-bottom: 1rem; margin-top: 0;";
    $label_style = "font-weight: 600; color: #374151; display: block; margin-bottom: 0.25rem;";
    $value_style = "color: #111827; margin-bottom: 1rem; background: #f9fafb; padding: 0.5rem; border-radius: 4px; border: 1px solid #e5e7eb; min-height: 1.5rem;";
    
    ?>
    <p><a href="<?php echo esc_url(admin_url('admin.php?page=kc-crm-bookings')); ?>">&larr; Back to Bookings</a></p>
    <h1 class="wp-heading-inline">Booking: <?php echo esc_html($post->post_title); ?></h1>
    <hr class="wp-header-end">

    <div style="display: flex; gap: 2rem; flex-wrap: wrap;">
        <!-- LEFT COLUMN (70%) -->
        <div style="flex: 1 1 65%; min-width: 300px;">
            
            <div style="<?php echo esc_attr($card_style); ?>">
                <h2 style="<?php echo esc_attr($heading_style); ?>">Booking Details</h2>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <?php 
                    $booking_fields = array(
                        'First Name' => 'kc_first_name',
                        'Last Name'  => 'kc_last_name',
                        'Email'      => 'kc_email',
                        'Phone'      => 'kc_phone',
                        'Space Type' => 'kc_space_type',
                        'Pass/Duration' => 'kc_duration',
                        'Start Date' => 'kc_start_date',
                        'Arrival Time' => 'kc_arrival_time',
                        'Number of Participants' => 'kc_participants',
                    );
                    foreach ($booking_fields as $label => $key) {
                        echo '<div>';
                        echo '<span style="' . esc_attr($label_style) . '">' . esc_html($label) . '</span>';
                        echo '<div style="' . esc_attr($value_style) . '">' . nl2br(esc_html(get_post_meta($post_id, $key, true))) . '</div>';
                        echo '</div>';
                    }
                    ?>
                    <div>
                        <span style="<?php echo esc_attr($label_style); ?>">Estimated Price</span>
                        <div style="<?php echo esc_attr($value_style); ?> font-weight: bold; color: #bd451f;">Php <?php echo esc_html(get_post_meta($post_id, 'kc_price', true)); ?></div>
                    </div>
                </div>
                <div style="margin-top: 1rem;">
                    <span style="<?php echo esc_attr($label_style); ?>">Special Requests</span>
                    <div style="<?php echo esc_attr($value_style); ?>"><?php echo nl2br(esc_html(get_post_meta($post_id, 'kc_special', true))); ?></div>
                </div>
            </div>

        </div>

        <!-- RIGHT COLUMN (30%) -->
        <div style="flex: 0 1 30%; min-width: 250px;">
            <div style="<?php echo esc_attr($card_style); ?> position: sticky; top: 40px;">
                <h2 style="<?php echo esc_attr($heading_style); ?>">Status & Actions</h2>
                <div style="margin-bottom: 1.5rem; text-align: center;">
                    <?php 
                    if (function_exists('kc_render_status_badge')) {
                        kc_render_status_badge($status);
                    } else {
                        echo '<strong>' . esc_html($status) . '</strong>';
                    }
                    ?>
                </div>
                <hr style="border: 0; border-top: 1px solid #e5e7eb; margin-bottom: 1.5rem;">

                <?php 
                // Determine actions based on status
                if ($status === 'Pending Payment') : 
                ?>
                    <form method="POST" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" style="margin-bottom: 1rem;">
                        <input type="hidden" name="action" value="kc_confirm_booking">
                        <input type="hidden" name="post_id" value="<?php echo esc_attr($post_id); ?>">
                        <?php wp_nonce_field('kc_crm_action_' . $post_id, 'kc_nonce'); ?>
                        <button type="submit" class="button button-primary" style="width: 100%; background: #15803d; border-color: #15803d; text-align: center;">&check; Mark as Paid / Claimed</button>
                    </form>
                    <form method="POST" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" onsubmit="return confirm('Are you sure you want to cancel this booking?');">
                        <input type="hidden" name="action" value="kc_cancel_booking">
                        <input type="hidden" name="post_id" value="<?php echo esc_attr($post_id); ?>">
                        <?php wp_nonce_field('kc_crm_action_' . $post_id, 'kc_nonce'); ?>
                        <button type="submit" class="button button-secondary" style="width: 100%; color: #b91c1c; border-color: #fca5a5; text-align: center;">&cross; Cancel Booking</button>
                    </form>

                <?php elseif ($status === 'Paid / Claimed') : ?>
                    <p style="text-align: center; color: #15803d; font-weight: bold;">Booking is confirmed and paid.</p>
                
                <?php elseif ($status === 'Expired / Cancelled') : ?>
                    <p style="text-align: center; color: #b91c1c; font-weight: bold;">Booking has been cancelled.</p>
                
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php
}
