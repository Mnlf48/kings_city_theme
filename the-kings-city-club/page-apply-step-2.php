<?php
/**
 * Template Name: Apply Step 2 (Needs Discovery)
 */

// Block indexing for this secure page
add_action('wp_head', function() {
    echo '<meta name="robots" content="noindex, nofollow">' . "\n";
});

// Read token from POST (form submission) or GET (initial page load)
$token = isset($_POST['secure_token']) ? sanitize_text_field($_POST['secure_token']) : (isset($_GET['token']) ? sanitize_text_field($_GET['token']) : '');
$client_email = isset($_GET['client_email']) ? sanitize_email($_GET['client_email']) : ''; // Kept for legacy compatibility if needed
$is_valid_link = false;
$already_submitted = false;
$form_submitted = false;
$error_message = '';
$service_type = '';

$post_id = 0;

if (!empty($token)) {
    // Find the existing CRM ticket using the secure token
    $existing_ticket = get_posts(array(
        'post_type'      => 'kc_application',
        'posts_per_page' => 1,
        'meta_query'     => array(
            array(
                'key'   => 'kc_secure_token',
                'value' => $token,
            ),
        ),
    ));

    if (!empty($existing_ticket)) {
        $post_id = $existing_ticket[0]->ID;
        $current_status = get_post_meta($post_id, 'kc_status', true);
        
        if ($current_status === 'Step 2 - Waiting for Client Details') {
            $is_valid_link = true;
            $service_type = get_post_meta($post_id, 'kc_service', true);
        } elseif (in_array($current_status, array('Step 2 - Submitted', 'Step 3 - Discovery Call', 'Step 3 - Submitted', 'Complete'))) {
            $already_submitted = true;
        }
    }
}

// Handle Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['step2_submit']) && $is_valid_link) {
    
    // Security: Check Nonce
    if (!isset($_POST['step2_nonce']) || !wp_verify_nonce($_POST['step2_nonce'], 'step2_submission')) {
        $error_message = 'Security check failed. Please refresh the page and try again.';
    } 
    // Security: Honeypot trap (If filled out, it's a bot)
    elseif (!empty($_POST['website_url_trap'])) {
        $form_submitted = true; // Silently fail for bots
    } 
    else {
        // Sanitize and collect data (Array handling for checkboxes)
        $departments = isset($_POST['departments']) ? array_map('sanitize_text_field', $_POST['departments']) : [];
        $staff_count = isset($_POST['staff_count']) ? sanitize_text_field($_POST['staff_count']) : '';
        $employment_type = isset($_POST['employment_type']) ? sanitize_text_field($_POST['employment_type']) : '';
        $expat_manager = isset($_POST['expat_manager']) ? sanitize_text_field($_POST['expat_manager']) : '';
        $min_quals = isset($_POST['min_quals']) ? sanitize_textarea_field($_POST['min_quals']) : '';
        $kpi_notes = isset($_POST['kpi_notes']) ? sanitize_textarea_field($_POST['kpi_notes']) : '';

        $step2_roles = isset($_POST['roles']) ? array_map('sanitize_text_field', $_POST['roles']) : [];
        $role_details = isset($_POST['role_details']) ? sanitize_textarea_field($_POST['role_details']) : '';
        $job_descriptions = isset($_POST['job_descriptions']) ? sanitize_textarea_field($_POST['job_descriptions']) : '';
        $comm_methods = isset($_POST['comm_methods']) ? array_map('sanitize_text_field', $_POST['comm_methods']) : [];
        $report_to = isset($_POST['report_to']) ? sanitize_text_field($_POST['report_to']) : '';

        $start_date = isset($_POST['start_date']) ? sanitize_text_field($_POST['start_date']) : '';
        $additional_notes = isset($_POST['additional_notes']) ? sanitize_textarea_field($_POST['additional_notes']) : '';

        // Handle File Uploads securely
        if (!empty($_FILES['client_files']['name'][0])) {
            $uploaded_files = array();
            
            $upload_dir_info = wp_upload_dir();
            $temp_dir_path = $upload_dir_info['basedir'] . '/kc_client_uploads/';
            $temp_dir_url = $upload_dir_info['baseurl'] . '/kc_client_uploads/';
            
            if (!file_exists($temp_dir_path)) {
                wp_mkdir_p($temp_dir_path);
                // Prevent directory listing but allow direct file access
                file_put_contents($temp_dir_path . '.htaccess', "Options -Indexes\n");
            }
            
            $file_count = count($_FILES['client_files']['name']);
            for ($i = 0; $i < $file_count; $i++) {
                if ($_FILES['client_files']['error'][$i] === UPLOAD_ERR_OK) {
                    $original_name = sanitize_file_name($_FILES['client_files']['name'][$i]);
                    $file_ext = strtolower(pathinfo($original_name, PATHINFO_EXTENSION));
                    
                    // Restrict to PDF only as per request
                    if ($file_ext === 'pdf') {
                        $unique_filename = uniqid() . '_' . $original_name;
                        $temp_file = $temp_dir_path . $unique_filename;
                        if (move_uploaded_file($_FILES['client_files']['tmp_name'][$i], $temp_file)) {
                            // Save the public URL to the CRM so admin can click it
                            $file_url = $temp_dir_url . $unique_filename;
                            $uploaded_files[] = $file_url;
                        }
                    }
                }
            }
            if (!empty($uploaded_files)) {
                $existing_files = get_post_meta($post_id, 'kc_uploaded_files', true);
                $all_files = $existing_files ? $existing_files . "\n" . implode("\n", $uploaded_files) : implode("\n", $uploaded_files);
                update_post_meta($post_id, 'kc_uploaded_files', $all_files);
            }
        }

        // Update the ticket with Step 2 data
        if (strpos($service_type, 'Managed Staff Leasing') !== false || strpos($service_type, 'Both') !== false) {
            update_post_meta($post_id, 'kc_departments', implode(', ', $departments));
            update_post_meta($post_id, 'kc_staff_count', $staff_count);
            update_post_meta($post_id, 'kc_employment_type', $employment_type);
            update_post_meta($post_id, 'kc_expat_manager', $expat_manager);
            update_post_meta($post_id, 'kc_min_quals', $min_quals);
            update_post_meta($post_id, 'kc_kpi_notes', $kpi_notes);
        }

        if (strpos($service_type, 'Staffing') !== false || strpos($service_type, 'Both') !== false) {
            update_post_meta($post_id, 'kc_step2_roles', implode(', ', $step2_roles));
            update_post_meta($post_id, 'kc_role_details', $role_details);
            update_post_meta($post_id, 'kc_job_descriptions', $job_descriptions);
            update_post_meta($post_id, 'kc_comm_methods', implode(', ', $comm_methods));
            update_post_meta($post_id, 'kc_report_to', $report_to);
        }

        update_post_meta($post_id, 'kc_start_date', $start_date);
        update_post_meta($post_id, 'kc_additional_notes', $additional_notes);

        // Update status
        update_post_meta($post_id, 'kc_status', 'Step 2 - Submitted');
        
        $form_submitted = true;
    }
}

get_header();

// Provide fallback if there is no service_type fetched
$is_notsure = strpos($service_type, 'Not Sure') !== false;
$show_leasing = strpos($service_type, 'Managed Staff Leasing') !== false || strpos($service_type, 'Both') !== false;
$show_staffing = strpos($service_type, 'Staffing') !== false || strpos($service_type, 'Both') !== false;
$show_both = strpos($service_type, 'Both') !== false;
?>

<main id="primary" class="site-main" style="padding: 6rem 1rem; background: var(--color-background); min-height: 80vh;">
    <div class="step2-container" style="max-width: 800px; width: 100%; background: #fff; padding: 3rem; border-radius: var(--radius-lg); box-shadow: var(--shadow-md); margin: 0 auto;">
        
        <?php if ($already_submitted && !$form_submitted) : ?>
            
            <div class="step2-success" style="text-align: center; padding: 4rem 2rem;">
                <i class="fa-solid fa-circle-check" style="font-size: 4rem; color: #10b981; margin-bottom: 1.5rem;"></i>
                <h2 style="margin-bottom: 1rem; color: var(--color-primary);">Already Submitted</h2>
                <p style="color: var(--color-text-muted); font-size: 1.125rem; margin-bottom: 3rem;">You have already successfully submitted your Step 2 requirements.</p>
            </div>

        <?php elseif (!$is_valid_link && !$form_submitted) : ?>
            
            <div class="step2-error" style="text-align: center; padding: 3rem 0;">
                <i class="fa-solid fa-lock" style="font-size: 3rem; color: var(--color-text-muted); margin-bottom: 1rem;"></i>
                <h2>Secure Link Required</h2>
                <p style="color: var(--color-text-muted); margin-bottom: 2rem;">It looks like this link is invalid or your application is not in the correct status.</p>
                <a href="<?php echo esc_url(home_url('/apply')); ?>" class="kc-btn kc-btn-primary">Return to Apply Page</a>
            </div>

        <?php elseif ($is_notsure) : ?>

            <div class="step2-success" style="text-align: center; padding: 4rem 2rem;">
                <i class="fa-solid fa-calendar-check" style="font-size: 4rem; color: #10b981; margin-bottom: 1.5rem;"></i>
                <h2 style="margin-bottom: 1rem; color: var(--color-primary);">Your application has been approved.</h2>
                <p style="color: var(--color-text-muted); font-size: 1.125rem; margin-bottom: 3rem;">Please check your email for your Step 3 discovery call booking link.</p>
            </div>

        <?php elseif ($form_submitted) : ?>

            <div class="step2-success" style="text-align: center; padding: 4rem 2rem;">
                <i class="fa-solid fa-circle-check" style="font-size: 4rem; color: #10b981; margin-bottom: 1.5rem;"></i>
                <h2 style="margin-bottom: 1rem; color: var(--color-primary);">Requirements Submitted!</h2>
                <p style="color: var(--color-text-muted); font-size: 1.125rem; margin-bottom: 3rem;">Your Step 2 details have been submitted. Our team will review and be in touch shortly.</p>
            </div>

        <?php else : ?>
            
            <div class="step2-header" style="text-align: center; margin-bottom: 2.5rem;">
                <span style="display: block; font-size: 0.875rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; color: var(--color-primary); margin-bottom: 0.5rem; text-align: center;">Step 2 of 3</span>
                <h1 style="margin-bottom: 0.5rem; text-align: center;">Needs Discovery</h1>
                <p style="color: var(--color-text-muted); text-align: center;">Please provide the detailed requirements for your team so we can prepare an accurate proposal.</p>
            </div>

            <?php if (!empty($error_message)) : ?>
                <div style="background: #fee2e2; color: #b91c1c; padding: 1rem; border-radius: var(--radius-md); margin-bottom: 2rem;">
                    <?php echo esc_html($error_message); ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="" class="kc-native-form" enctype="multipart/form-data" style="text-align: left;">
                <?php wp_nonce_field('step2_submission', 'step2_nonce'); ?>
                <!-- Honeypot -->
                <input type="text" name="website_url_trap" style="display:none !important;" tabindex="-1" autocomplete="off">
                <input type="hidden" name="client_email" value="<?php echo esc_attr($client_email); ?>">
                <input type="hidden" name="secure_token" value="<?php echo esc_attr($token); ?>">

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
                    <input type="file" name="client_files[]" multiple accept=".pdf" style="width: 100%; padding: 0.75rem; border: 1px solid #ccc; border-radius: var(--radius-md); background: #fff;">
                    <small style="color: var(--color-text-muted);">You can select multiple files. (PDF files only)</small>
                </div>

                <div class="kc-form-group" style="margin-bottom: 1.5rem;">
                    <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Minimum Qualifications</label>
                    <textarea name="min_quals" rows="3" style="width: 100%; padding: 0.75rem; border: 1px solid #ccc; border-radius: var(--radius-md);" placeholder="e.g., 5+ years experience, CPA required, etc."></textarea>
                </div>
                <?php endif; ?>

                <!-- OFFSHORING STAFFING FIELDS -->
                <?php if ($show_staffing) : ?>
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
                    <input type="file" name="client_files[]" multiple accept=".pdf" style="width: 100%; padding: 0.75rem; border: 1px solid #ccc; border-radius: var(--radius-md); background: #fff;">
                    <small style="color: var(--color-text-muted);">Select multiple files to upload existing JD documents or reference resumes. (PDF files only)</small>
                </div>

                <div class="kc-form-row" style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                    <div class="kc-form-group">
                        <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Preferred communication method</label>
                        <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
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
                <?php if ($show_leasing || $show_staffing) : ?>
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
                <?php endif; ?>
            </form>
        <?php endif; ?>

    </div>
</main>

<?php get_footer(); ?>