<?php
/**
 * Template Name: Apply Step 2 (Needs Discovery)
 */

// Block indexing for this secure page
add_action('wp_head', function() {
    echo '<meta name="robots" content="noindex, nofollow">' . "\n";
});

$token = isset($_GET['token']) ? sanitize_text_field($_GET['token']) : '';
$client_email = isset($_GET['client_email']) ? sanitize_email($_GET['client_email']) : '';
$is_valid_link = !empty($token);
$form_submitted = false;
$error_message = '';

// Handle Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['step2_submit'])) {
    
    // Security: Check Nonce
    if (!isset($_POST['step2_nonce']) || !wp_verify_nonce($_POST['step2_nonce'], 'step2_submission')) {
        $error_message = 'Security check failed. Please refresh the page and try again.';
    } 
    // Security: Honeypot trap (If filled out, it's a bot)
    elseif (!empty($_POST['website_url_trap'])) {
        $form_submitted = true; // Silently fail for bots
    } 
    else {
        // Sanitize and collect data
        $departments = isset($_POST['departments']) ? array_map('sanitize_text_field', $_POST['departments']) : [];
        $roles = isset($_POST['roles']) ? array_map('sanitize_text_field', $_POST['roles']) : [];
        $staff_count = sanitize_text_field($_POST['staff_count']);
        $employment_type = sanitize_text_field($_POST['employment_type']);
        $expat_manager = sanitize_text_field($_POST['expat_manager']);
        $kpi_notes = sanitize_textarea_field($_POST['kpi_notes']);
        $role_details = sanitize_textarea_field($_POST['role_details']);
        $comm_methods = isset($_POST['comm_methods']) ? array_map('sanitize_text_field', $_POST['comm_methods']) : [];
        $report_to = sanitize_text_field($_POST['report_to']);
        $start_date = sanitize_text_field($_POST['start_date']);
        $additional_notes = sanitize_textarea_field($_POST['additional_notes']);
        $min_quals = isset($_POST['min_quals']) ? sanitize_textarea_field($_POST['min_quals']) : '';
        $job_descriptions = isset($_POST['job_descriptions']) ? sanitize_textarea_field($_POST['job_descriptions']) : '';
        $posted_email = isset($_POST['client_email']) ? sanitize_email($_POST['client_email']) : 'Client';

        // Handle File Uploads securely
        $attachments = [];
        $temp_dir = WP_CONTENT_DIR . '/uploads/kc_temp_docs/';
        if (!file_exists($temp_dir)) {
            wp_mkdir_p($temp_dir);
            file_put_contents($temp_dir . '.htaccess', "deny from all"); // Security
        }

        if (!empty($_FILES['client_files']['name'][0])) {
            $file_count = count($_FILES['client_files']['name']);
            for ($i = 0; $i < $file_count; $i++) {
                if ($_FILES['client_files']['error'][$i] === UPLOAD_ERR_OK) {
                    $original_name = sanitize_file_name($_FILES['client_files']['name'][$i]);
                    $temp_file = $temp_dir . uniqid() . '_' . $original_name;
                    if (move_uploaded_file($_FILES['client_files']['tmp_name'][$i], $temp_file)) {
                        $attachments[] = $temp_file;
                    }
                }
            }
        }

        // Format Email
        $to = 'lospedros479@gmail.com';
        $subject = 'New Needs Discovery Submission (Step 2)';
        
        $body = "<h2>New Step 2 Requirements</h2>";
        
        // Managed Staff Leasing Details
        if(!empty($departments)) $body .= "<p><strong>Staff Leasing Departments:</strong> " . implode(', ', $departments) . "</p>";
        if(!empty($staff_count)) $body .= "<p><strong>Staff per Department:</strong> $staff_count</p>";
        if(!empty($employment_type)) $body .= "<p><strong>Employment Type:</strong> $employment_type</p>";
        if(!empty($expat_manager)) $body .= "<p><strong>Expat Manager On-Site:</strong> $expat_manager</p>";
        if(!empty($min_quals)) $body .= "<p><strong>Minimum Qualifications:</strong><br/>" . nl2br($min_quals) . "</p>";
        if(!empty($kpi_notes)) $body .= "<p><strong>KPIs/Reporting:</strong><br/>" . nl2br($kpi_notes) . "</p>";
        
        // Offshoring Staffing Details
        if(!empty($roles)) $body .= "<hr><p><strong>Team Builder Roles:</strong> " . implode(', ', $roles) . "</p>";
        if(!empty($role_details)) $body .= "<p><strong>Role Details & Headcount:</strong><br/>" . nl2br($role_details) . "</p>";
        if(!empty($job_descriptions)) $body .= "<p><strong>Job Descriptions / Details:</strong><br/>" . nl2br($job_descriptions) . "</p>";
        if(!empty($comm_methods)) $body .= "<p><strong>Communication Methods:</strong> " . implode(', ', $comm_methods) . "</p>";
        if(!empty($report_to)) $body .= "<p><strong>Reports To:</strong> $report_to</p>";
        
        // Shared Details
        $body .= "<hr><p><strong>Start Date:</strong> $start_date</p>";
        if(!empty($additional_notes)) $body .= "<p><strong>Additional Notes:</strong><br/>" . nl2br($additional_notes) . "</p>";
        if(count($attachments) > 0) $body .= "<p><strong>Attached Files:</strong> " . count($attachments) . " file(s) attached to this email.</p>";

        // Admin Step 3 Reply Link
        $step3_url = home_url('/step-3-booking/?token=approved');
        $step3_body = "Hi there,\n\nWe have reviewed your requirements and prepared your custom proposal! Please book a Discovery Call so we can walk you through it.\n\nBook your call here: $step3_url\n\nBest,\nKings City Team";
        $step3_mailto = "mailto:$posted_email?subject=" . rawurlencode("Your Kings City Proposal is Ready") . "&body=" . rawurlencode($step3_body);

        $body .= "<hr><p><strong>Submitted By:</strong> $posted_email</p>";
        $body .= '<p style="margin-top: 20px;"><a href="' . esc_attr($step3_mailto) . '" style="display: inline-block; padding: 10px 20px; background-color: #BD451F; color: #ffffff; text-decoration: none; border-radius: 5px; font-weight: bold;">Approve & Send Step 3 Link</a></p>';

        $headers = array('Content-Type: text/html; charset=UTF-8');

        // Send Email
        wp_mail($to, $subject, $body, $headers, $attachments);
        
        // Clean up temp files immediately after sending to protect privacy
        foreach ($attachments as $file) {
            if (file_exists($file)) {
                unlink($file);
            }
        }
        
        $form_submitted = true;
    }
}

get_header();
?>

<main id="primary" class="site-main" style="padding: 6rem 1rem; background: var(--color-background); min-height: 80vh;">
    <div class="step2-container" style="max-width: 800px; width: 100%; background: #fff; padding: 3rem; border-radius: var(--radius-lg); box-shadow: var(--shadow-md); margin: 0 auto;">
        
        <?php if (!$is_valid_link) : ?>
            
            <div class="step2-error" style="text-align: center; padding: 3rem 0;">
                <i class="fa-solid fa-lock" style="font-size: 3rem; color: var(--color-text-muted); margin-bottom: 1rem;"></i>
                <h2>Secure Link Required</h2>
                <p style="color: var(--color-text-muted); margin-bottom: 2rem;">It looks like this link is missing a secure token or has expired.</p>
                <a href="<?php echo esc_url(home_url('/apply')); ?>" class="kc-btn kc-btn-primary">Return to Apply Page</a>
            </div>

        <?php elseif ($form_submitted) : ?>

            <div class="step2-success" style="text-align: center; padding: 4rem 2rem;">
                <i class="fa-solid fa-circle-check" style="font-size: 4rem; color: #10b981; margin-bottom: 1.5rem;"></i>
                <h2 style="margin-bottom: 1rem; color: var(--color-primary);">Requirements Submitted!</h2>
                <p style="color: var(--color-text-muted); font-size: 1.125rem; margin-bottom: 3rem;">Thank you for submitting your detailed requirements. Our team is already preparing your custom proposal and will send you an email shortly to book your discovery call.</p>
                
                <div style="display: inline-flex; align-items: center; justify-content: center; gap: 0.75rem; background: #fff9ef; padding: 0.75rem 1.5rem; border-radius: 50px; border: 1px solid rgba(189, 69, 31, 0.1); color: var(--color-primary); font-size: 0.875rem; font-weight: 600;">
                    <i class="fa-solid fa-spinner fa-spin"></i>
                    <span>Redirecting back to the application page...</span>
                </div>
                
                <script>
                    setTimeout(function() {
                        window.location.href = "<?php echo esc_url(home_url('/apply/')); ?>";
                    }, 4000);
                </script>
            </div>

        <?php else : ?>
            
            <div class="step2-header" style="text-align: center; margin-bottom: 2.5rem;">
                <span style="font-size: 0.875rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; color: var(--color-primary);">Step 2 of 3</span>
                <h1 style="margin-bottom: 0.5rem;">Needs Discovery</h1>
                <p style="color: var(--color-text-muted);">Please provide the detailed requirements for your team so we can prepare an accurate proposal.</p>
            </div>

            <?php if (!empty($error_message)) : ?>
                <div style="background: #fee2e2; color: #b91c1c; padding: 1rem; border-radius: var(--radius-md); margin-bottom: 2rem;">
                    <?php echo esc_html($error_message); ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="" class="kc-native-form" enctype="multipart/form-data" style="text-align: center;">
                <?php wp_nonce_field('step2_submission', 'step2_nonce'); ?>
                <!-- Honeypot -->
                <input type="text" name="website_url_trap" style="display:none !important;" tabindex="-1" autocomplete="off">
                <input type="hidden" name="client_email" value="<?php echo esc_attr($client_email); ?>">

                <?php 
                // Determine which sections to show based on the ?service= url parameter
                $service_param = isset($_GET['service']) ? sanitize_text_field($_GET['service']) : 'both';
                
                $is_notsure = ($service_param === 'notsure');
                $show_leasing = ($service_param === 'leasing' || $service_param === 'both');
                $show_offshoring = ($service_param === 'offshoring' || $service_param === 'both');
                ?>

                <?php if ($is_notsure) : ?>
                    <div style="text-align: center; padding: 2rem;">
                        <h3 style="margin-bottom: 1rem;">Let's find the best fit!</h3>
                        <p style="color: var(--color-text-muted); margin-bottom: 2rem;">Please book a quick discovery call below so we can understand your unique needs.</p>
                        <!-- Calendly inline widget begin -->
                        <div class="calendly-inline-widget" data-url="https://calendly.com/lospedros479/30min" style="min-width:320px;height:700px;"></div>
                        <script type="text/javascript" src="https://assets.calendly.com/assets/external/widget.js" async></script>
                        <!-- Calendly inline widget end -->
                        <!-- IMPORTANT: Replace "https://calendly.com/calendly-demo" above with your actual Calendly link -->
                        
                        <div style="margin-top: 3rem; text-align: left; background: #fff9ef; padding: 1.5rem; border-radius: 8px; border: 1px solid rgba(189, 69, 31, 0.1);">
                            <div class="kc-form-group" style="margin-bottom: 1rem;">
                                <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: var(--color-primary);">Have any existing documents or JDs?</label>
                                <input type="file" name="client_files[]" multiple style="width: 100%; padding: 0.75rem; border: 1px solid #ccc; border-radius: var(--radius-md); background: #fff;">
                                <small style="color: var(--color-text-muted); display: block; margin-top: 0.5rem;">Upload them here so we can review them before our call. (PDF, Word, etc.)</small>
                            </div>
                            <div class="kc-form-submit">
                                <button type="submit" name="step2_submit" class="kc-btn kc-btn-primary" style="width: 100%; padding: 0.75rem; font-size: 1rem;">Submit Documents (Optional)</button>
                            </div>
                        </div>
                    </div>
                <?php else : ?>

                <!-- MANAGED STAFF LEASING FIELDS -->
                <?php if ($show_leasing) : ?>
                <div class="kc-form-group" style="margin-bottom: 1.5rem;">
                    <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">What departments do you want to set up?</label>
                    <div class="kc-checkbox-group">
                        <?php 
                        $depts = get_terms(array('taxonomy' => 'sl_department', 'hide_empty' => false));
                        if (!is_wp_error($depts) && !empty($depts)) {
                            foreach($depts as $dept) {
                                echo '<label style="display: block; margin-bottom: 0.25rem;"><input type="checkbox" name="departments[]" value="' . esc_attr($dept->name) . '"> ' . esc_html($dept->name) . '</label>';
                            }
                        } else {
                            echo '<p>No departments available.</p>';
                        }
                        ?>
                    </div>
                </div>

                <div class="kc-form-group" style="margin-bottom: 1.5rem;">
                    <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Number of staff per department</label>
                    <input type="number" name="staff_count" min="1" style="width: 100%; padding: 0.75rem; border: 1px solid #ccc; border-radius: var(--radius-md);" placeholder="e.g. 5">
                </div>

                <div class="kc-form-row" style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                    <div class="kc-form-group">
                        <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Employment type</label>
                        <label style="display: block; margin-bottom: 0.25rem;"><input type="radio" name="employment_type" value="Full Time"> Full Time</label>
                        <label style="display: block; margin-bottom: 0.25rem;"><input type="radio" name="employment_type" value="Part Time"> Part Time</label>
                        <label style="display: block; margin-bottom: 0.25rem;"><input type="radio" name="employment_type" value="Mixed"> Mixed</label>
                    </div>
                    <div class="kc-form-group">
                        <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Do you want an expat manager on-site?</label>
                        <label style="display: block; margin-bottom: 0.25rem;"><input type="radio" name="expat_manager" value="Yes"> Yes</label>
                        <label style="display: block; margin-bottom: 0.25rem;"><input type="radio" name="expat_manager" value="No"> No</label>
                        <label style="display: block; margin-bottom: 0.25rem;"><input type="radio" name="expat_manager" value="Not Sure"> Not Sure</label>
                    </div>
                </div>
                <div class="kc-form-group" style="margin-bottom: 1.5rem;">
                    <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Upload Ideal Candidate Profiles or Org Charts (Optional)</label>
                    <input type="file" name="client_files[]" multiple style="width: 100%; padding: 0.75rem; border: 1px solid #ccc; border-radius: var(--radius-md); background: #fff;">
                    <small style="color: var(--color-text-muted);">You can select multiple files. (PDF, Word, Images)</small>
                </div>

                <div class="kc-form-group" style="margin-bottom: 1.5rem;">
                    <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Minimum Qualifications</label>
                    <textarea name="min_quals" rows="3" style="width: 100%; padding: 0.75rem; border: 1px solid #ccc; border-radius: var(--radius-md);" placeholder="e.g., 5+ years experience, CPA required, etc."></textarea>
                </div>
                <?php endif; ?>

                <!-- OFFSHORING STAFFING FIELDS -->
                <?php if ($show_offshoring) : ?>
                <div class="kc-form-group" style="margin-bottom: 1.5rem;">
                    <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Which Team Builder Roles do you need?</label>
                    <div class="kc-checkbox-group">
                        <?php 
                        $roles = get_posts(array('post_type' => 'tb_role', 'posts_per_page' => -1, 'post_status' => 'publish'));
                        if (!empty($roles)) {
                            foreach($roles as $role) {
                                echo '<label style="display: block; margin-bottom: 0.25rem;"><input type="checkbox" name="roles[]" value="' . esc_attr($role->post_title) . '"> ' . esc_html($role->post_title) . '</label>';
                            }
                        } else {
                            echo '<p>No roles available.</p>';
                        }
                        ?>
                    </div>
                </div>

                <div class="kc-form-group" style="margin-bottom: 1.5rem;">
                    <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Role Details & Headcount</label>
                    <textarea name="role_details" rows="3" style="width: 100%; padding: 0.75rem; border: 1px solid #ccc; border-radius: var(--radius-md);" placeholder="Please specify the experience level (Junior/Mid/Senior) and headcount for each role."></textarea>
                </div>

                <div class="kc-form-group" style="margin-bottom: 1.5rem;">
                    <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Job description per role</label>
                    <textarea name="job_descriptions" rows="3" style="width: 100%; padding: 0.75rem; border: 1px solid #ccc; border-radius: var(--radius-md);" placeholder="Provide a brief job description or requirements for each role."></textarea>
                </div>

                <div class="kc-form-group" style="margin-bottom: 1.5rem;">
                    <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Upload Job Descriptions or Example CVs (Optional)</label>
                    <input type="file" name="client_files[]" multiple style="width: 100%; padding: 0.75rem; border: 1px solid #ccc; border-radius: var(--radius-md); background: #fff;">
                    <small style="color: var(--color-text-muted);">Select multiple files to upload existing JD documents or reference resumes. (PDF, Word, etc.)</small>
                </div>

                <div class="kc-form-row" style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                    <div class="kc-form-group">
                        <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Preferred communication method</label>
                        <div style="display: flex; gap: 1rem; flex-wrap: wrap; justify-content: center;">
                            <label><input type="checkbox" name="comm_methods[]" value="Zoom"> Zoom</label>
                            <label><input type="checkbox" name="comm_methods[]" value="Skype"> Skype</label>
                            <label><input type="checkbox" name="comm_methods[]" value="Email"> Email</label>
                            <label><input type="checkbox" name="comm_methods[]" value="Phone"> Phone</label>
                            <label><input type="checkbox" name="comm_methods[]" value="On-site"> On-site</label>
                        </div>
                    </div>
                    <div class="kc-form-group">
                        <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Who will they report to?</label>
                        <input type="text" name="report_to" placeholder="Name / Job Title" style="width: 100%; padding: 0.75rem; border: 1px solid #ccc; border-radius: var(--radius-md);">
                    </div>
                </div>
                <?php endif; ?>

                <!-- SHARED FIELDS -->
                <div class="kc-form-group" style="margin-bottom: 1.5rem;">
                    <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Preferred start date</label>
                    <input type="date" name="start_date" style="width: 100%; padding: 0.75rem; border: 1px solid #ccc; border-radius: var(--radius-md);">
                </div>

                <?php if ($show_leasing) : ?>
                <div class="kc-form-group" style="margin-bottom: 1.5rem;">
                    <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">KPI and reporting preferences</label>
                    <textarea name="kpi_notes" rows="3" style="width: 100%; padding: 0.75rem; border: 1px solid #ccc; border-radius: var(--radius-md);" placeholder="Any specific KPI reporting requirements?"></textarea>
                </div>
                <?php endif; ?>

                <div class="kc-form-group" style="margin-bottom: 1.5rem;">
                    <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Additional notes</label>
                    <textarea name="additional_notes" rows="3" style="width: 100%; padding: 0.75rem; border: 1px solid #ccc; border-radius: var(--radius-md);" placeholder="Anything else we should know?"></textarea>
                </div>

                <div class="kc-form-submit" style="margin-top: 2rem;">
                    <button type="submit" name="step2_submit" class="kc-btn kc-btn-primary" style="width: 100%; padding: 1rem; font-size: 1.125rem;">Submit Requirements</button>
                </div>
                <?php endif; // Closes: if ($is_notsure) else block (line 131) ?>
            </form>
        <?php endif; // Closes: if (!$is_valid_link) else block (line 96) ?>

    </div>
</main>

<?php
get_footer();
