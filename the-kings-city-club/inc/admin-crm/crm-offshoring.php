<?php
if (!defined('ABSPATH')) exit;

function kc_render_offshoring_page() {
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
        kc_render_offshoring_detail_view($id);
    } else {
        kc_render_offshoring_list_view();
    }

    echo '</div>';
}

function kc_render_offshoring_list_view() {
    $filter = isset($_GET['filter']) ? sanitize_text_field($_GET['filter']) : 'all';
    
    $args = array(
        'post_type'      => 'kc_application',
        'post_status'    => 'publish',
        'posts_per_page' => -1,
        'meta_query'     => array(
            array(
                'key'     => 'kc_service',
                'value'   => 'Offshoring',
                'compare' => 'LIKE'
            )
        )
    );

    $posts = get_posts($args);
    $filtered_posts = array();

    foreach ($posts as $post) {
        $status = get_post_meta($post->ID, 'kc_status', true);
        
        if ($filter === 'pending' && $status !== 'Step 1 - Pending Approval') continue;
        if ($filter === 'in_progress' && !in_array($status, array('Step 2 - Waiting for Client Details', 'Step 2 - Submitted', 'Step 3 - Discovery Call', 'Step 3 - Submitted'))) continue;
        if ($filter === 'complete' && $status !== 'Complete') continue;
        if ($filter === 'rejected' && $status !== 'Rejected' && $status !== 'Cancelled') continue;
        
        $filtered_posts[] = $post;
    }

    $base_url = admin_url('admin.php?page=kc-crm-offshoring');
    
    ?>
    <h1 class="wp-heading-inline">Offshoring Applications</h1>
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

function kc_render_offshoring_detail_view($post_id) {
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
    $past_step2 = in_array($status, array('Step 3 - Discovery Call', 'Step 3 - Submitted', 'Complete'));
    
    ?>
    <p><a href="<?php echo esc_url(admin_url('admin.php?page=kc-crm-offshoring')); ?>">&larr; Back to Offshoring</a></p>
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

            <!-- STEP 2 -->
            <?php if ($past_step1 && $status !== 'Rejected' && $status !== 'Cancelled') : ?>
            <div style="<?php echo esc_attr($card_style); ?>">
                <h2 style="<?php echo esc_attr($heading_style); ?>">Step 2 &mdash; Client Requirements</h2>
                
                <?php if (strpos($service, 'Not Sure') !== false) : ?>
                    <div style="background: #eff6ff; border: 1px solid #bfdbfe; color: #1e3a8a; padding: 1rem; border-radius: 6px;">
                        <strong>Note:</strong> Client selected "Not Sure" — proceeding directly to Discovery Call.
                    </div>
                <?php else: ?>
                    
                    <?php if (strpos($service, 'Managed Staff Leasing') !== false || strpos($service, 'Both') !== false) : ?>
                        <?php if (strpos($service, 'Both') !== false) echo '<h3 style="margin-top:0;">Managed Staff Leasing Details</h3>'; ?>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                            <?php 
                            $leasing_fields = array(
                                'Departments' => 'kc_departments',
                                'Staff per Department' => 'kc_staff_count',
                                'Employment Type' => 'kc_employment_type',
                                'Expat Manager On-Site' => 'kc_expat_manager',
                            );
                            foreach ($leasing_fields as $label => $key) {
                                echo '<div><span style="' . esc_attr($label_style) . '">' . esc_html($label) . '</span><div style="' . esc_attr($value_style) . '">' . nl2br(esc_html(get_post_meta($post_id, $key, true))) . '</div></div>';
                            }
                            ?>
                        </div>
                        <div>
                            <span style="<?php echo esc_attr($label_style); ?>">Minimum Qualifications</span>
                            <div style="<?php echo esc_attr($value_style); ?>"><?php echo nl2br(esc_html(get_post_meta($post_id, 'kc_min_quals', true))); ?></div>
                            <span style="<?php echo esc_attr($label_style); ?>">KPIs / Reporting</span>
                            <div style="<?php echo esc_attr($value_style); ?>"><?php echo nl2br(esc_html(get_post_meta($post_id, 'kc_kpi_notes', true))); ?></div>
                        </div>
                    <?php endif; ?>

                    <?php if (strpos($service, 'Both') !== false) echo '<hr style="margin: 2rem 0; border: 0; border-top: 1px solid #e5e7eb;">'; ?>

                    <?php if (strpos($service, 'Staffing') !== false || strpos($service, 'Both') !== false) : ?>
                        <?php if (strpos($service, 'Both') !== false) echo '<h3 style="margin-top:0;">Staffing Details</h3>'; ?>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                            <?php 
                            $staffing_fields = array(
                                'Team Builder Roles' => 'kc_step2_roles',
                                'Communication Methods' => 'kc_comm_methods',
                                'Reports To' => 'kc_report_to',
                            );
                            foreach ($staffing_fields as $label => $key) {
                                echo '<div><span style="' . esc_attr($label_style) . '">' . esc_html($label) . '</span><div style="' . esc_attr($value_style) . '">' . nl2br(esc_html(get_post_meta($post_id, $key, true))) . '</div></div>';
                            }
                            ?>
                        </div>
                        <div>
                            <span style="<?php echo esc_attr($label_style); ?>">Role Details & Headcount</span>
                            <div style="<?php echo esc_attr($value_style); ?>"><?php echo nl2br(esc_html(get_post_meta($post_id, 'kc_role_details', true))); ?></div>
                            <span style="<?php echo esc_attr($label_style); ?>">Job Descriptions</span>
                            <div style="<?php echo esc_attr($value_style); ?>"><?php echo nl2br(esc_html(get_post_meta($post_id, 'kc_job_descriptions', true))); ?></div>
                        </div>
                    <?php endif; ?>

                    <h3 style="margin-top: 1.5rem; border-top: 1px solid #e5e7eb; padding-top: 1rem;">Shared Details</h3>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                        <div>
                            <span style="<?php echo esc_attr($label_style); ?>">Preferred Start Date</span>
                            <div style="<?php echo esc_attr($value_style); ?>"><?php echo esc_html(get_post_meta($post_id, 'kc_start_date', true)); ?></div>
                        </div>
                        <div>
                            <span style="<?php echo esc_attr($label_style); ?>">Uploaded Files</span>
                            <div style="<?php echo esc_attr($value_style); ?>">
                                <?php 
                                $files = get_post_meta($post_id, 'kc_uploaded_files', true);
                                if ($files) {
                                    $file_urls = explode("\n", $files);
                                    foreach ($file_urls as $url) {
                                        if (trim($url)) {
                                            echo '<a href="' . esc_url(trim($url)) . '" target="_blank">View File</a><br>';
                                        }
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div>
                        <span style="<?php echo esc_attr($label_style); ?>">Additional Notes</span>
                        <div style="<?php echo esc_attr($value_style); ?>"><?php echo nl2br(esc_html(get_post_meta($post_id, 'kc_additional_notes', true))); ?></div>
                    </div>
                <?php endif; ?>
            </div>
            <?php endif; ?>

            <!-- STEP 3 -->
            <?php if ($past_step2 && $status !== 'Rejected' && $status !== 'Cancelled') : ?>
            <div style="<?php echo esc_attr($card_style); ?>">
                <h2 style="<?php echo esc_attr($heading_style); ?>">Step 3 &mdash; Discovery Call</h2>
                <?php if (in_array($status, array('Step 3 - Submitted', 'Complete'))) : ?>
                    <div style="background: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46; padding: 1rem; border-radius: 6px;">
                        <strong>&#10003; Client has booked a discovery call via Calendly.</strong>
                    </div>
                <?php else : ?>
                    <div style="background: #fffbeb; border: 1px solid #fde68a; color: #92400e; padding: 1rem; border-radius: 6px;">
                        <em>Waiting for client to book their discovery call...</em>
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

                <?php elseif ($status === 'Step 2 - Submitted') : ?>
                    <form method="POST" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" style="margin-bottom: 1rem;">
                        <input type="hidden" name="action" value="kc_approve_step2">
                        <input type="hidden" name="post_id" value="<?php echo esc_attr($post_id); ?>">
                        <?php wp_nonce_field('kc_crm_action_' . $post_id, 'kc_nonce'); ?>
                        <button type="submit" class="button button-primary" style="width: 100%; background: #15803d; border-color: #15803d; text-align: center;">&check; Approve Step 2</button>
                    </form>
                    <form method="POST" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" onsubmit="return confirm('Are you sure you want to reject this application?');">
                        <input type="hidden" name="action" value="kc_reject_step2">
                        <input type="hidden" name="post_id" value="<?php echo esc_attr($post_id); ?>">
                        <?php wp_nonce_field('kc_crm_action_' . $post_id, 'kc_nonce'); ?>
                        <div style="margin-bottom: 0.5rem;">
                            <label style="display:block; font-size:0.85rem; font-weight:600; margin-bottom:0.25rem;">Reason for rejection (will be emailed to client)</label>
                            <textarea name="reason" rows="3" style="width:100%;"></textarea>
                        </div>
                        <button type="submit" class="button button-secondary" style="width: 100%; color: #b91c1c; border-color: #fca5a5; text-align: center;">&cross; Reject</button>
                    </form>

                <?php elseif ($status === 'Step 3 - Submitted') : ?>
                    <form method="POST" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" style="margin-bottom: 1rem;">
                        <input type="hidden" name="action" value="kc_mark_complete">
                        <input type="hidden" name="post_id" value="<?php echo esc_attr($post_id); ?>">
                        <?php wp_nonce_field('kc_crm_action_' . $post_id, 'kc_nonce'); ?>
                        <button type="submit" class="button button-primary" style="width: 100%; background: #15803d; border-color: #15803d; text-align: center;">&check; Mark as Complete</button>
                    </form>
                
                <?php elseif ($status === 'Complete') : ?>
                    <p style="text-align: center; color: #15803d; font-weight: bold;">Application process is fully complete.</p>
                
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
