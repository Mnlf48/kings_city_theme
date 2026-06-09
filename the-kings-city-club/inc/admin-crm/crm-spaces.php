<?php
if (!defined('ABSPATH')) exit;

function kc_render_spaces_page() {
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
        kc_render_spaces_detail_view($id);
    } else {
        kc_render_spaces_list_view();
    }

    echo '</div>';
}

function kc_render_spaces_list_view() {
    $filter = isset($_GET['filter']) ? sanitize_text_field($_GET['filter']) : 'all';
    
    $args = array(
        'post_type'      => 'kc_application',
        'post_status'    => 'publish',
        'posts_per_page' => -1,
        'meta_query'     => array(
            'relation' => 'OR',
            array(
                'key'     => 'kc_service',
                'value'   => 'Spaces',
                'compare' => 'LIKE'
            ),
            array(
                'key'     => 'kc_service',
                'value'   => 'Membership',
                'compare' => 'LIKE'
            )
        )
    );

    $posts = get_posts($args);
    $filtered_posts = array();

    foreach ($posts as $post) {
        $status = get_post_meta($post->ID, 'kc_status', true);
        
        if ($filter === 'pending' && $status !== 'Step 1 - Pending Approval') continue;
        if ($filter === 'in_progress' && !in_array($status, array('Step 2 - Waiting for Tour Booking', 'Step 2 - Tour Submitted'))) continue;
        if ($filter === 'complete' && $status !== 'Complete - Tour Scheduled') continue;
        if ($filter === 'rejected' && $status !== 'Rejected' && $status !== 'Cancelled') continue;
        
        $filtered_posts[] = $post;
    }

    $base_url = admin_url('admin.php?page=kc-crm-spaces');
    
    ?>
    <h1 class="wp-heading-inline">Spaces Membership Applications</h1>
    <hr class="wp-header-end">

    <ul class="subsubsub">
        <li class="all"><a href="<?php echo esc_url($base_url); ?>" class="<?php echo $filter === 'all' ? 'current' : ''; ?>">All</a> |</li>
        <li class="pending"><a href="<?php echo esc_url(add_query_arg('filter', 'pending', $base_url)); ?>" class="<?php echo $filter === 'pending' ? 'current' : ''; ?>">Pending</a> |</li>
        <li class="in_progress"><a href="<?php echo esc_url(add_query_arg('filter', 'in_progress', $base_url)); ?>" class="<?php echo $filter === 'in_progress' ? 'current' : ''; ?>">In Progress</a> |</li>
        <li class="complete"><a href="<?php echo esc_url(add_query_arg('filter', 'complete', $base_url)); ?>" class="<?php echo $filter === 'complete' ? 'current' : ''; ?>">Complete</a> |</li>
        <li class="rejected"><a href="<?php echo esc_url(add_query_arg('filter', 'rejected', $base_url)); ?>" class="<?php echo $filter === 'rejected' ? 'current' : ''; ?>">Rejected</a></li>
    </ul>

    <table class="wp-list-table widefat fixed striped">
        <thead>
            <tr>
                <th style="width: 50px;">#</th>
                <th>Client Name</th>
                <th>Service</th>
                <th>Status</th>
                <th>Date Submitted</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($filtered_posts)) : ?>
                <?php foreach ($filtered_posts as $post) : 
                    $service = get_post_meta($post->ID, 'kc_service', true);
                    $status = get_post_meta($post->ID, 'kc_status', true);
                    $view_url = add_query_arg(array('action' => 'view', 'id' => $post->ID), $base_url);
                ?>
                <tr>
                    <td><?php echo esc_html($post->ID); ?></td>
                    <td><strong><a href="<?php echo esc_url($view_url); ?>"><?php echo esc_html($post->post_title); ?></a></strong></td>
                    <td><?php echo esc_html($service); ?></td>
                    <td>
                        <?php 
                        if (function_exists('kc_render_status_badge')) {
                            kc_render_status_badge($status);
                        } else {
                            echo esc_html($status); 
                        }
                        ?>
                    </td>
                    <td><?php echo get_the_date('M j, Y', $post->ID); ?></td>
                    <td><a href="<?php echo esc_url($view_url); ?>" class="button button-small">View &rarr;</a></td>
                </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr><td colspan="6">No applications found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
    <?php
}

function kc_render_spaces_detail_view($post_id) {
    $post = get_post($post_id);
    if (!$post || $post->post_type !== 'kc_application') {
        echo '<p>Application not found.</p>';
        return;
    }

    $status = get_post_meta($post_id, 'kc_status', true);
    $service = get_post_meta($post_id, 'kc_service', true);

    $card_style = "background: #fff; border-radius: var(--radius-card, 8px); box-shadow: var(--shadow-sm, 0 1px 2px 0 rgba(0, 0, 0, 0.05)); padding: 1.5rem; margin-bottom: 1.5rem;";
    $heading_style = "font-size: 1.25rem; border-bottom: 2px solid #e5e7eb; padding-bottom: 0.5rem; margin-bottom: 1rem; margin-top: 0;";
    $label_style = "font-weight: 600; color: #374151; display: block; margin-bottom: 0.25rem;";
    $value_style = "color: #111827; margin-bottom: 1rem; background: #f9fafb; padding: 0.5rem; border-radius: 4px; border: 1px solid #e5e7eb; min-height: 1.5rem;";
    
    // Status Logic
    $past_step1 = !in_array($status, array('Step 1 - Pending Approval'));
    
    ?>
    <p><a href="<?php echo esc_url(admin_url('admin.php?page=kc-crm-spaces')); ?>">&larr; Back to Spaces Membership</a></p>
    <h1 class="wp-heading-inline">Application: <?php echo esc_html($post->post_title); ?></h1>
    <hr class="wp-header-end">

    <div style="display: flex; gap: 2rem; flex-wrap: wrap;">
        <!-- LEFT COLUMN (70%) -->
        <div style="flex: 1 1 65%; min-width: 300px;">
            
            <!-- STEP 1 -->
            <div style="<?php echo esc_attr($card_style); ?>">
                <h2 style="<?php echo esc_attr($heading_style); ?>">Step 1 &mdash; Initial Application</h2>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <?php 
                    $step1_fields = array(
                        'First Name' => 'kc_first_name',
                        'Last Name'  => 'kc_last_name',
                        'Email'      => 'kc_email',
                        'Phone'      => 'kc_phone',
                        'Service'    => 'kc_service',
                        'Company'    => 'kc_company',
                        'Country'    => 'kc_country',
                        'Website'    => 'kc_website',
                        'Team Size'  => 'kc_team_size',
                        'Roles Needed' => 'kc_roles',
                        'Timeline'   => 'kc_timeline',
                    );
                    foreach ($step1_fields as $label => $key) {
                        echo '<div>';
                        echo '<span style="' . esc_attr($label_style) . '">' . esc_html($label) . '</span>';
                        echo '<div style="' . esc_attr($value_style) . '">' . nl2br(esc_html(get_post_meta($post_id, $key, true))) . '</div>';
                        echo '</div>';
                    }
                    ?>
                </div>
                <div style="margin-top: 1rem;">
                    <span style="<?php echo esc_attr($label_style); ?>">Message</span>
                    <div style="<?php echo esc_attr($value_style); ?>"><?php echo nl2br(esc_html(get_post_meta($post_id, 'kc_message', true))); ?></div>
                </div>
            </div>

            <!-- STEP 2: Tour Booking -->
            <?php if ($past_step1 && $status !== 'Rejected' && $status !== 'Cancelled') : ?>
            <div style="<?php echo esc_attr($card_style); ?>">
                <h2 style="<?php echo esc_attr($heading_style); ?>">Step 2 &mdash; Tour Booking</h2>
                <?php if (in_array($status, array('Step 2 - Tour Submitted', 'Complete - Tour Scheduled'))) : ?>
                    <div style="background: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46; padding: 1rem; border-radius: 6px;">
                        <strong>&#10003; Client has booked a tour via Calendly.</strong>
                    </div>
                <?php else : ?>
                    <div style="background: #fffbeb; border: 1px solid #fde68a; color: #92400e; padding: 1rem; border-radius: 6px;">
                        <em>Waiting for client to book their tour...</em>
                    </div>
                <?php endif; ?>
            </div>
            <?php endif; ?>

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
                if ($status === 'Step 1 - Pending Approval') : 
                ?>
                    <form method="POST" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" style="margin-bottom: 1rem;">
                        <input type="hidden" name="action" value="kc_approve_step1">
                        <input type="hidden" name="post_id" value="<?php echo esc_attr($post_id); ?>">
                        <?php wp_nonce_field('kc_crm_action_' . $post_id, 'kc_nonce'); ?>
                        <button type="submit" class="button button-primary" style="width: 100%; background: #15803d; border-color: #15803d; text-align: center;">&check; Approve Step 1</button>
                    </form>
                    <form method="POST" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" onsubmit="return confirm('Are you sure you want to reject this application?');">
                        <input type="hidden" name="action" value="kc_reject_step1">
                        <input type="hidden" name="post_id" value="<?php echo esc_attr($post_id); ?>">
                        <?php wp_nonce_field('kc_crm_action_' . $post_id, 'kc_nonce'); ?>
                        <div style="margin-bottom: 0.5rem;">
                            <label style="display:block; font-size:0.85rem; font-weight:600; margin-bottom:0.25rem;">Reason for rejection (will be emailed to client)</label>
                            <textarea name="reason" rows="3" style="width:100%;"></textarea>
                        </div>
                        <button type="submit" class="button button-secondary" style="width: 100%; color: #b91c1c; border-color: #fca5a5; text-align: center;">&cross; Reject</button>
                    </form>

                <?php elseif ($status === 'Step 2 - Tour Submitted') : ?>
                    <form method="POST" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" style="margin-bottom: 1rem;">
                        <input type="hidden" name="action" value="kc_mark_complete">
                        <input type="hidden" name="post_id" value="<?php echo esc_attr($post_id); ?>">
                        <?php wp_nonce_field('kc_crm_action_' . $post_id, 'kc_nonce'); ?>
                        <button type="submit" class="button button-primary" style="width: 100%; background: #15803d; border-color: #15803d; text-align: center;">&check; Mark as Complete</button>
                    </form>
                
                <?php elseif ($status === 'Complete - Tour Scheduled') : ?>
                    <p style="text-align: center; color: #15803d; font-weight: bold;">Tour has been scheduled.</p>
                
                <?php elseif ($status === 'Rejected' || $status === 'Cancelled') : ?>
                    <p style="text-align: center; color: #b91c1c; font-weight: bold;">Application is <?php echo esc_html(strtolower($status)); ?>.</p>
                
                <?php else : ?>
                    <p style="text-align: center; color: #6b7280; font-size: 0.9rem;">Waiting for client action to proceed.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php
}
