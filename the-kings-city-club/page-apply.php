<?php
/* Template Name: Apply Now */

$form_submitted = false;
$error_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['apply_submit'])) {
    if (!isset($_POST['apply_nonce']) || !wp_verify_nonce($_POST['apply_nonce'], 'apply_submission')) {
        $error_message = 'Security check failed. Please refresh and try again.';
    } elseif (!empty($_POST['website_url_trap'])) {
        $form_submitted = true; // Bot trap
    } else {
        $app_type = sanitize_text_field($_POST['application_type']); // "space" or "offshoring"
        $to = 'lospedros479@gmail.com';
        $headers = array('Content-Type: text/html; charset=UTF-8');
        
        $body = "<h2>New Lead Application</h2>";
        $body .= "<p><strong>Application Type:</strong> " . ucfirst($app_type) . "</p><hr>";

        if ($app_type === 'space') {
            $fname = sanitize_text_field($_POST['sp_first_name']);
            $lname = sanitize_text_field($_POST['sp_last_name']);
            $email = sanitize_email($_POST['sp_email']);
            $body .= "<p><strong>Name:</strong> $fname $lname</p>";
            $body .= "<p><strong>Email:</strong> $email</p>";
            $body .= "<p><strong>Phone:</strong> " . sanitize_text_field($_POST['sp_phone']) . "</p>";
            $body .= "<p><strong>Company:</strong> " . sanitize_text_field($_POST['sp_company']) . "</p>";
            $body .= "<p><strong>Country:</strong> " . sanitize_text_field($_POST['sp_country']) . "</p>";
            $body .= "<p><strong>Space Type:</strong> " . sanitize_text_field($_POST['space_type']) . "</p>";
            $body .= "<p><strong>Message:</strong><br/>" . nl2br(sanitize_textarea_field($_POST['sp_message'])) . "</p>";
            $subject = "New Space Membership Application";
            $service = "spaces";
        } else {
            $fname = sanitize_text_field($_POST['off_first_name']);
            $lname = sanitize_text_field($_POST['off_last_name']);
            $email = sanitize_email($_POST['off_email']);
            $service_chosen = sanitize_text_field($_POST['off_service']);
            $body .= "<p><strong>Name:</strong> $fname $lname</p>";
            $body .= "<p><strong>Email:</strong> $email</p>";
            $body .= "<p><strong>Phone:</strong> " . sanitize_text_field($_POST['off_phone']) . "</p>";
            $body .= "<p><strong>Company:</strong> " . sanitize_text_field($_POST['off_company']) . "</p>";
            $body .= "<p><strong>Country:</strong> " . sanitize_text_field($_POST['off_country']) . "</p>";
            $body .= "<p><strong>Website:</strong> " . sanitize_text_field($_POST['off_website']) . "</p>";
            $body .= "<p><strong>Service Interested In:</strong> $service_chosen</p>";
            $body .= "<p><strong>Team Size:</strong> " . sanitize_text_field($_POST['off_team_size']) . "</p>";
            
            $roles = isset($_POST['off_roles']) ? array_map('sanitize_text_field', $_POST['off_roles']) : [];
            if(!empty($roles)) {
                $body .= "<p><strong>Roles Needed:</strong> " . implode(', ', $roles) . "</p>";
            }
            
            $body .= "<p><strong>Timeline:</strong> " . sanitize_text_field($_POST['off_timeline']) . "</p>";
            $body .= "<p><strong>Message:</strong><br/>" . nl2br(sanitize_textarea_field($_POST['off_message'])) . "</p>";
            $subject = "New Staffing/Offshoring Application";
            
            if ($service_chosen === 'Managed Staff Leasing') {
                $service = 'leasing';
            } elseif ($service_chosen === 'Offshoring Staffing') {
                $service = 'offshoring';
            } elseif ($service_chosen === 'Both') {
                $service = 'both';
            } else {
                $service = 'notsure';
            }
        }

        // Action Buttons
        $reject_body = "Hi $fname,\n\nThank you for your interest in Kings City. Unfortunately, we are unable to accommodate your request at this time.\n\nBest,\nKings City Team";
        $reject_mailto = "mailto:$email?subject=" . rawurlencode("Update on your Kings City Application") . "&body=" . rawurlencode($reject_body);

        $body .= "<br><hr><br>";
        $body .= "<table style='width:100%'><tr>";

        if ($app_type === 'space') {
            $tour_url = home_url('/apply-spaces-tour/?token=approved&client_email=' . urlencode($email));
            $tour_body = "Hi $fname,\n\nThank you for applying for a Kings City Club Spaces Membership! We would love to invite you to the club for a personal tour so you can see the space and we can discuss your needs.\n\nPlease book a time for your tour here: \n$tour_url\n\nBest,\nKings City Team";
            $tour_mailto = "mailto:$email?subject=" . rawurlencode("You are invited for a Kings City Club Tour!") . "&body=" . rawurlencode($tour_body);
            
            $body .= "<td><a href='$tour_mailto' style='display:inline-block;padding:12px 20px;background:#10b981;color:#fff;text-decoration:none;border-radius:5px;font-weight:bold;'>🟩 Invite for Space Tour</a></td>";
            $body .= "<td><a href='$reject_mailto' style='display:inline-block;padding:12px 20px;background:#ef4444;color:#fff;text-decoration:none;border-radius:5px;font-weight:bold;'>🟥 Reject Application</a></td>";
        } else {
            // Offshoring
            $approve_url = home_url('/step-2-discovery/?token=approved&service=' . urlencode($service) . '&client_email=' . urlencode($email));
            $approve_body = "Hi $fname,\n\nThank you for applying. We have reviewed your initial requirements and would love to proceed. Please finish providing your discovery requirements here: \n$approve_url\n\nBest,\nKings City Team";
            $approve_mailto = "mailto:$email?subject=" . rawurlencode("Kings City Step 2 Discovery Form") . "&body=" . rawurlencode($approve_body);
            
            $discovery_body = "Hi $fname,\n\nThank you for applying! I'd love to jump on a quick call to understand your needs better and see how we can help. What time works best for you this week?\n\nBest,\nKings City Team";
            $discovery_mailto = "mailto:$email?subject=" . rawurlencode("Let's Schedule a Discovery Call") . "&body=" . rawurlencode($discovery_body);

            $body .= "<td><a href='$approve_mailto' style='display:inline-block;padding:12px 20px;background:#10b981;color:#fff;text-decoration:none;border-radius:5px;font-weight:bold;'>🟩 Approve & Send Step 2</a></td>";
            $body .= "<td><a href='$discovery_mailto' style='display:inline-block;padding:12px 20px;background:#3b82f6;color:#fff;text-decoration:none;border-radius:5px;font-weight:bold;'>🟦 Request Discovery Call</a></td>";
            $body .= "<td><a href='$reject_mailto' style='display:inline-block;padding:12px 20px;background:#ef4444;color:#fff;text-decoration:none;border-radius:5px;font-weight:bold;'>🟥 Reject Application</a></td>";
        }

        $body .= "</tr></table>";

        wp_mail($to, $subject, $body, $headers);
        $form_submitted = true;
    }
}
get_header();
?>

<style>
    /* Form Styles */
    .form-group {
      margin-bottom: var(--space-md);
      display: flex;
      flex-direction: column;
    }
    .form-row {
      display: grid;
      grid-template-columns: 1fr;
      gap: var(--space-md);
    }
    @media (min-width: 768px) {
      .form-row { grid-template-columns: 1fr 1fr; }
    }
    .form-label {
      font-size: 0.875rem;
      font-weight: 600;
      color: var(--color-primary);
      margin-bottom: var(--space-xs);
    }
    .form-input, .form-select, .form-textarea {
      width: 100%;
      padding: 0.875rem 1rem;
      border: 1px solid rgba(189, 69, 31, 0.2);
      border-radius: var(--radius-sm, 8px);
      background: rgba(255, 255, 255, 0.6);
      color: var(--color-text);
      font-family: var(--font-body);
      font-size: 1rem;
      transition: border-color var(--transition-fast), background var(--transition-fast), box-shadow var(--transition-fast);
    }
    .form-input:focus, .form-select:focus, .form-textarea:focus {
      outline: none;
      border-color: var(--color-accent-red);
      background: #FFFFFF;
      box-shadow: 0 0 0 3px rgba(255, 191, 191, 0.2);
    }
    
    /* Radio Toggle */
    .type-toggle-group {
      display: flex;
      flex-wrap: wrap;
      gap: var(--space-sm);
      margin-bottom: var(--space-lg);
    }
    .type-toggle-label {
      flex: 1;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 0.5rem;
      padding: 1rem;
      border: 2px solid var(--color-border-light);
      border-radius: var(--radius-card-sm);
      cursor: pointer;
      font-weight: 600;
      transition: all var(--transition-base);
      background: rgba(255, 255, 255, 0.4);
    }
    .type-toggle-label:hover {
      background: rgba(255, 255, 255, 0.8);
    }
    .type-toggle-label.is-active {
      border-color: var(--color-accent-red);
      background: rgba(255, 191, 191, 0.15);
      color: var(--color-accent-red);
    }
    .type-toggle-input {
      accent-color: var(--color-accent-red);
    }
    
    /* Sidebar Styles */
    .sidebar-card {
      padding: var(--space-lg);
      margin-bottom: var(--space-md);
    }
    .sidebar-card h3 {
      font-size: 1.25rem;
      margin-bottom: var(--space-sm);
    }
    .contact-item {
      margin-bottom: var(--space-sm);
    }
    .contact-label {
      display: block;
      font-size: 0.75rem;
      font-weight: 700;
      letter-spacing: 0.1em;
      text-transform: uppercase;
      color: var(--color-text-muted);
      margin-bottom: 0.25rem;
    }
    .contact-value {
      color: var(--color-text);
      font-weight: 500;
    }
    .sidebar-link {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 0.75rem 0;
      border-bottom: 1px solid var(--color-border-light);
      color: var(--color-primary);
      font-weight: 600;
      transition: color var(--transition-fast);
    }
    .sidebar-link:last-child {
      border-bottom: none;
    }
    .sidebar-link:hover {
      color: var(--color-accent-red);
    }
    
  </style>

<main id="main-content">
<!-- hero section -->
<section class="hero premium-hero">
<div class="container grid-12">
<div class="col-12 split split--media-right">
<!-- text on left -->
<div class="split__content animate-fadeInUp hero__content--index">
<span class="text-overline hero__overline"><?php echo get_field('overline_3'); ?></span>
<h1 class="hero__title hero__title--inner"><?php echo get_field('h1_1'); ?></h1>
<p class="hero__subtitle"><?php echo get_field('p_2'); ?></p>
</div>
<!-- media on right -->
<div class="split__media hero__slider" id="hero-slider" style="position: relative; aspect-ratio: 4/3; overflow: hidden; border-radius: var(--radius-card);">
<img alt="Kings City Access" class="hero__slide is-active" src="<?php $img = get_field('image_4'); echo ($img && is_array($img) && isset($img['url'])) ? esc_url($img['url']) : (is_numeric($img) ? wp_get_attachment_image_url($img, 'full') : get_template_directory_uri() . '/assets/img/placeholder.jpg'); ?>" style="position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; opacity: 1; transition: opacity 1s ease-in-out;"/>
<img alt="Kings City Membership 1" class="hero__slide" src="<?php $img = get_field('image_5'); echo ($img && is_array($img) && isset($img['url'])) ? esc_url($img['url']) : (is_numeric($img) ? wp_get_attachment_image_url($img, 'full') : get_template_directory_uri() . '/assets/img/placeholder.jpg'); ?>" style="position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; opacity: 0; transition: opacity 1s ease-in-out;"/>
<img alt="Kings City Membership 2" class="hero__slide" src="<?php $img = get_field('image_6'); echo ($img && is_array($img) && isset($img['url'])) ? esc_url($img['url']) : (is_numeric($img) ? wp_get_attachment_image_url($img, 'full') : get_template_directory_uri() . '/assets/img/placeholder.jpg'); ?>" style="position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; opacity: 0; transition: opacity 1s ease-in-out;"/>
</div>
</div>
</div>
</section>

<!-- pricing section -->
<section class="section" id="pricing-section">
  <div class="container grid-12">
    <!-- Subsection 1: Team Builder Pricing -->
    <div class="col-6" style="grid-column: span 12;">
      <div class="card-glass card-glass--strong" style="padding: var(--space-xl); height: 100%;">
        <span class="text-overline"><?php echo get_field('pricing_tb_overline') ?: 'Team Builder Pricing'; ?></span>
        <h2 style="margin-bottom: var(--space-lg);"><?php echo get_field('pricing_tb_heading') ?: 'Estimate Your Team'; ?></h2>
        
        <div class="tb-header" style="margin-top: var(--space-md);">
          <div style="display: flex; align-items: center; gap: 0.5rem;">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="var(--color-primary)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
            <h3 style="margin:0; font-size: 1.25rem; color: var(--color-primary);"><?php echo get_field('pricing_tb_subheading') ?: 'Your Team Selection'; ?></h3>
          </div>
          <button type="button" class="btn btn--small" id="btn-add-member">+ Add Member</button>
        </div>
        
        <div class="tb-body">
          <div class="tb-empty-state" id="tb-empty">
            <div style="margin-bottom: 1rem; color: var(--color-text-muted);">
              <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
            </div>
            <h4 style="margin-bottom: 0.5rem;"><?php echo get_field('pricing_tb_body_title') ?: 'Build your offshore team with Kings City.'; ?></h4>
            <p style="font-size: 0.875rem; color: var(--color-text-muted); margin-bottom: 1.5rem;"><?php echo get_field('pricing_tb_body_desc') ?: 'Select roles below and instantly see a transparent monthly estimate.'; ?></p>
            <button type="button" class="btn btn--outline" id="btn-get-started">Get Started</button>
          </div>

          <div class="tb-roles-container" id="tb-roles-list" style="display:none;">
            <div class="tb-roles-headers">
              <div style="flex:1.8">Role Function</div>
              <div style="flex:1.2">Experience Level</div>
              <div style="flex:1;text-align:center;">Headcount</div>
              <div style="flex:1.2;text-align:right;">Est. Monthly</div>
              <div style="width:30px"></div>
            </div>
            <div id="tb-roles-inner"></div>
          </div>

          <div class="tb-summary" id="tb-summary" style="display:none;">
            <div class="tb-summary-row">
              <span>Team Size:</span>
              <strong id="tb-total-size">0</strong>
            </div>
            <div class="tb-summary-row">
              <span>Est. Monthly Base:</span>
              <strong id="tb-total-base">Php 0</strong>
            </div>
            <div class="tb-summary-savings" id="tb-savings" style="display:none;">
              <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg>
              <span>Saving <strong id="tb-save-amount">~ Php 0</strong> vs. local hire</span>
            </div>
            <div class="tb-summary-total">
              <span style="font-size:1.1rem;font-weight:700;">Estimated Total</span>
              <span style="font-size:1.5rem;font-weight:700; color: #fff;" id="tb-final-total">Php 0</span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Subsection 2: Staff Leasing Pricing -->
    <div class="col-6" style="grid-column: span 12;">
      <div class="card-glass card-glass--strong" style="padding: var(--space-xl); height: 100%;">
        <span class="text-overline"><?php echo get_field('pricing_sl_overline') ?: 'Staff Leasing Pricing'; ?></span>
        <h2 style="margin-bottom: var(--space-lg);"><?php echo get_field('pricing_sl_heading') ?: 'Monthly Rates'; ?></h2>
        <div class="tb-leasing-scroll-container">
          <?php 
          $departments = get_terms(array(
              'taxonomy' => 'sl_department',
              'hide_empty' => false,
          ));
          if(!empty($departments) && !is_wp_error($departments)): 
              foreach($departments as $dept): ?>
            
            <h3 class="tb-dept-title"><?php echo esc_html($dept->name); ?></h3>
            
            <div class="tb-roles-container">
              <div class="tb-roles-headers" style="display: flex; margin-bottom: var(--space-sm); padding: 0 0.5rem; font-size: 0.75rem; font-weight: 700; letter-spacing: 0.1em; text-transform: uppercase; color: var(--color-text-muted);">
                <div style="flex:1.2">Tier Name</div>
                <div style="flex:1">Headcount Range</div>
                <div style="flex:1.2;text-align:right;">Est. Monthly Rate</div>
              </div>
              <div>
                <?php 
                $tier_query = new WP_Query(array(
                    'post_type' => 'sl_tier',
                    'posts_per_page' => -1,
                    'post_status' => 'publish',
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'sl_department',
                            'field' => 'term_id',
                            'terms' => $dept->term_id,
                        )
                    )
                ));
                if($tier_query->have_posts()): while($tier_query->have_posts()): $tier_query->the_post(); 
                ?>
                <div class="tbr-item" style="padding: 1rem; margin-bottom: 0.5rem; background: #fff; border: 1px solid var(--color-border-light); border-radius: var(--radius-sm); display: flex; align-items: center; gap: 1rem;">
                  <div style="flex:1.2; font-weight: 600; color: var(--color-primary);">
                    <?php the_title(); ?>
                  </div>
                  <div style="flex:1; font-size: 0.875rem; color: var(--color-text-muted);">
                    <?php echo esc_html(get_field('headcount_range')); ?>
                  </div>
                  <div style="flex:1.2; text-align: right; font-weight: 700; color: var(--color-primary);">
                    <?php echo esc_html(get_field('monthly_rate')); ?>
                  </div>
                </div>
                <?php endwhile; wp_reset_postdata(); endif; ?>
              </div>
            </div>
          
          <?php endforeach; else: ?>
            <!-- Fallback if no departments are added -->
            <div class="tb-roles-container">
              <div class="tb-roles-headers" style="display: flex; margin-bottom: var(--space-sm); padding: 0 0.5rem; font-size: 0.75rem; font-weight: 700; letter-spacing: 0.1em; text-transform: uppercase; color: var(--color-text-muted);">
                <div style="flex:1.2">Tier Name</div>
                <div style="flex:1">Headcount Range</div>
                <div style="flex:1.2;text-align:right;">Est. Monthly Rate</div>
              </div>
              <div>
                <div class="tbr-item" style="padding: 1rem; margin-bottom: 0.5rem; background: #fff; border: 1px solid var(--color-border-light); border-radius: var(--radius-sm); display: flex; align-items: center; gap: 1rem;">
                  <div style="flex:1.2; font-weight: 600; color: var(--color-primary);">Starter Tier</div>
                  <div style="flex:1; font-size: 0.875rem; color: var(--color-text-muted);">1-5 Staff</div>
                  <div style="flex:1.2; text-align: right; font-weight: 700; color: var(--color-primary);">Php 00,000 / mo</div>
                </div>
                <div class="tbr-item" style="padding: 1rem; margin-bottom: 0.5rem; background: #fff; border: 1px solid var(--color-border-light); border-radius: var(--radius-sm); display: flex; align-items: center; gap: 1rem;">
                  <div style="flex:1.2; font-weight: 600; color: var(--color-primary);">Growth Tier</div>
                  <div style="flex:1; font-size: 0.875rem; color: var(--color-text-muted);">6-15 Staff</div>
                  <div style="flex:1.2; text-align: right; font-weight: 700; color: var(--color-primary);">Php 00,000 / mo</div>
                </div>
              </div>
            </div>
          <?php endif; ?>
        </div>

      </div>
    </div>
  </div>
</section>
<!-- application layout -->
<section class="section content-panel" id="application">
<div class="container grid-12">
<!-- left column: form -->
<div class="col-8">
<div class="card-glass card-glass--strong" style="padding: var(--space-xl);">

<?php if ($form_submitted): ?>
    <div style="text-align:center; padding: 4rem 2rem;">
        <i class="fa-solid fa-check-circle" style="font-size: 4rem; color: #10b981; margin-bottom: 1.5rem;"></i>
        <h2 style="margin-bottom:1rem; color: var(--color-primary);">Application Received!</h2>
        <p style="color:var(--color-text-muted); font-size: 1.125rem;">Thank you for your interest in Kings City. Our team is currently reviewing your details and will send you an email shortly with the next steps.</p>
    </div>
<?php else: ?>
    <span class="text-overline"><?php echo get_field('overline_18'); ?></span>
    <h2 style="margin-bottom: var(--space-lg);"><?php echo get_field('h2_8'); ?></h2>

    <?php if (!empty($error_message)): ?>
        <div style="background:#fee2e2;color:#b91c1c;padding:1rem;margin-bottom:1.5rem;border-radius:8px;"><?php echo esc_html($error_message); ?></div>
    <?php endif; ?>

<form id="apply-form" method="POST" action="#application" novalidate="">
<input type="hidden" name="apply_submit" value="1">
<input type="text" name="website_url_trap" style="display:none !important;" tabindex="-1" autocomplete="off">
<?php wp_nonce_field('apply_submission', 'apply_nonce'); ?>
<!-- application type toggle -->
<div class="form-group">
<p style="font-size: 0.85rem; font-weight: 700; letter-spacing: 0.1em; text-transform: uppercase; color: var(--color-primary); margin-bottom: var(--space-xs);"><?php echo get_field('p_14'); ?></p>
<div class="type-toggle-group">
<label class="type-toggle-label is-active" id="lbl-space">
<input checked="" class="type-toggle-input" name="application_type" type="radio" value="space"/> 
                    Spaces Membership
                  </label>
<label class="type-toggle-label" id="lbl-offshore">
<input class="type-toggle-input" name="application_type" type="radio" value="offshoring"/> 
                    Offshoring / Staffing
                  </label>
</div>
</div>
<!-- spaces view -->
<div id="space-view-container">
<div class="tb-header" style="margin-top: var(--space-md);">
<div style="display: flex; align-items: center; gap: 0.5rem;">
<svg fill="none" height="24" stroke="var(--color-primary)" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewbox="0 0 24 24" width="24"><rect height="7" width="7" x="3" y="3"></rect><rect height="7" width="7" x="14" y="3"></rect><rect height="7" width="7" x="14" y="14"></rect><rect height="7" width="7" x="3" y="14"></rect></svg>
<h3 style="margin:0; font-size: 1.25rem; color: var(--color-primary);"><?php echo get_field('h3_9'); ?></h3>
</div>
</div>
<div class="form-group" style="margin-top: var(--space-md);">
<label class="form-label" for="space_type"><?php echo get_field('sp_label_space_type') ?: 'Which space are you interested in?'; ?></label>
<select class="form-select" id="space_type" name="space_type">
<option value="coworking">Co-Working</option>
<option value="meeting">Meeting Rooms</option>
<option value="events">Events Place</option>
<option value="office">Office Leasing</option>
<option value="virtual">Virtual Assistant / Virtual Office</option>
</select>
</div>
<div class="form-row">
<div class="form-group">
<label class="form-label" for="sp_first_name"><?php echo get_field('sp_label_first_name') ?: 'First Name'; ?></label>
<input class="form-input" id="sp_first_name" name="sp_first_name" placeholder="First Name" required="" type="text"/>
</div>
<div class="form-group">
<label class="form-label" for="sp_last_name"><?php echo get_field('sp_label_last_name') ?: 'Last Name'; ?></label>
<input class="form-input" id="sp_last_name" name="sp_last_name" placeholder="Last Name" required="" type="text"/>
</div>
</div>
<div class="form-row">
<div class="form-group">
<label class="form-label" for="sp_email"><?php echo get_field('sp_label_email') ?: 'Email Address'; ?></label>
<input class="form-input" id="sp_email" name="sp_email" placeholder="you@company.com" required="" type="email"/>
</div>
<div class="form-group">
<label class="form-label" for="sp_phone"><?php echo get_field('sp_label_phone') ?: 'Phone Number'; ?></label>
<input class="form-input" id="sp_phone" name="sp_phone" placeholder="+63 XXX XXX XXXX" required="" type="tel"/>
</div>
</div>
<div class="form-row">
<div class="form-group">
<label class="form-label" for="sp_company"><?php echo get_field('sp_label_company') ?: 'Company / Business Name'; ?></label>
<input class="form-input" id="sp_company" name="sp_company" placeholder="Your company name" type="text"/>
</div>
<div class="form-group">
<label class="form-label" for="sp_country"><?php echo get_field('sp_label_country') ?: 'Country'; ?></label>
<select class="form-select" id="sp_country" name="sp_country">
<option value="ph">Philippines</option>
<option value="au">Australia</option>
<option value="nz">New Zealand</option>
<option value="us">United States</option>
<option value="uk">United Kingdom</option>
<option value="other">Other</option>
</select>
</div>
</div>
<div class="form-group">
<label class="form-label" for="sp_message"><?php echo get_field('sp_label_needs') ?: 'Tell Us About Your Needs'; ?></label>
<textarea class="form-textarea" id="sp_message" name="sp_message" placeholder="Describe what you're looking for..." rows="5"></textarea>
</div>
<div style="display: flex; align-items: flex-start; gap: 0.75rem; margin-bottom: var(--space-lg); margin-top: var(--space-sm);">
<input id="sp_consent" name="sp_consent" required="" style="margin-top: 0.3rem; accent-color: var(--color-accent); width: 16px; height: 16px;" type="checkbox"/>
<label for="sp_consent" style="font-size: 0.85rem; color: var(--color-text-muted); cursor: pointer; line-height: 1.5;">
                    <?php echo get_field('sp_label_consent') ?: 'I agree to receive communications from Kings City regarding my application. I understand I can unsubscribe at any time.'; ?>
                  </label>
</div>
<button class="btn btn--large" style="width: 100%; justify-content: center; padding: 1rem;" type="submit"><?php echo get_field('sp_btn_submit') ?: 'Submit Application'; ?></button>
</div>
<!-- offshoring view -->
<div id="offshore-view-container" style="display: none;">
<div class="form-row">
<div class="form-group">
<label class="form-label" for="off_first_name"><?php echo get_field('off_label_first_name') ?: 'First Name'; ?></label>
<input class="form-input" id="off_first_name" name="off_first_name" type="text"/>
</div>
<div class="form-group">
<label class="form-label" for="off_last_name"><?php echo get_field('off_label_last_name') ?: 'Last Name'; ?></label>
<input class="form-input" id="off_last_name" name="off_last_name" type="text"/>
</div>
</div>
<div class="form-row">
<div class="form-group">
<label class="form-label" for="off_email"><?php echo get_field('off_label_email') ?: 'Email Address'; ?></label>
<input class="form-input" id="off_email" name="off_email" placeholder="you@company.com" type="email"/>
</div>
<div class="form-group">
<label class="form-label" for="off_phone"><?php echo get_field('off_label_phone') ?: 'Phone Number'; ?></label>
<input class="form-input" id="off_phone" name="off_phone" placeholder="+63 XXX XXX XXXX" type="tel"/>
</div>
</div>
<div class="form-row">
<div class="form-group">
<label class="form-label" for="off_company"><?php echo get_field('off_label_company') ?: 'Company Name'; ?></label>
<input class="form-input" id="off_company" name="off_company" type="text"/>
</div>
<div class="form-group">
<label class="form-label" for="off_country"><?php echo get_field('off_label_country') ?: 'Country'; ?></label>
<select class="form-select" id="off_country" name="off_country">
<option value="ph">Philippines</option>
<option value="au">Australia</option>
<option value="nz">New Zealand</option>
<option value="us">United States</option>
<option value="uk">United Kingdom</option>
<option value="other">Other</option>
</select>
</div>
</div>
<div class="form-group">
<label class="form-label" for="off_website"><?php echo get_field('off_label_website') ?: 'Company Website (Optional)'; ?></label>
<input class="form-input" id="off_website" name="off_website" placeholder="https://yourcompany.com" type="text"/>
</div>
<div class="form-label" style="margin-top: var(--space-lg); border-bottom: 1px solid rgba(189, 69, 31, 0.2); padding-bottom: 0.5rem; margin-bottom: var(--space-md);">
Tell Us About Your Needs
</div>
<div class="form-group">
<label class="form-label" for="off_service"><?php echo get_field('off_label_service') ?: 'Which service are you interested in?'; ?></label>
<select class="form-select" id="off_service" name="off_service">
<option value="Managed Staff Leasing">Managed Staff Leasing</option>
<option value="Offshoring Staffing">Offshoring Staffing</option>
<option value="Both">Both</option>
<option value="Not Sure">Not Sure</option>
</select>
</div>
<div class="form-group" id="wrap_team_size">
<label class="form-label" for="off_team_size"><?php echo get_field('off_label_team_size') ?: 'How many staff are you looking to hire?'; ?></label>
<select class="form-select" id="off_team_size" name="off_team_size">
<option value="1-5">1–5</option>
<option value="6-15">6–15</option>
<option value="16-30">16–30</option>
<option value="30+">30+</option>
</select>
</div>
<div class="form-group" id="wrap_roles">
<label class="form-label" for="off_roles"><?php echo get_field('off_label_roles') ?: 'What type of roles are you looking for?'; ?></label>
<div id="off_roles" style="display: flex; flex-direction: column; gap: 0.5rem;">
<label style="display: flex; align-items: center; gap: 0.5rem;"><input type="checkbox" name="off_roles[]" value="Finance &amp; Accounting"> Finance &amp; Accounting</label>
<label style="display: flex; align-items: center; gap: 0.5rem;"><input type="checkbox" name="off_roles[]" value="HR"> HR</label>
<label style="display: flex; align-items: center; gap: 0.5rem;"><input type="checkbox" name="off_roles[]" value="IT &amp; Development"> IT &amp; Development</label>
<label style="display: flex; align-items: center; gap: 0.5rem;"><input type="checkbox" name="off_roles[]" value="Marketing"> Marketing</label>
<label style="display: flex; align-items: center; gap: 0.5rem;"><input type="checkbox" name="off_roles[]" value="Operations"> Operations</label>
<label style="display: flex; align-items: center; gap: 0.5rem;"><input type="checkbox" name="off_roles[]" value="Other"> Other</label>
</div>
</div>
<div class="form-group">
<label class="form-label" for="off_timeline"><?php echo get_field('off_label_timeline') ?: 'When are you looking to start?'; ?></label>
<select class="form-select" id="off_timeline" name="off_timeline">
<option value="ASAP">ASAP</option>
<option value="Within 1 month">Within 1 month</option>
<option value="1-3 months">1–3 months</option>
<option value="Just exploring">Just exploring</option>
</select>
</div>
<div class="form-group">
<label class="form-label" for="off_source"><?php echo get_field('off_label_source') ?: 'How did you hear about us?'; ?></label>
<select class="form-select" id="off_source" name="off_source">
<option value="Google">Google</option>
<option value="Referral">Referral</option>
<option value="Social Media">Social Media</option>
<option value="Other">Other</option>
</select>
</div>
<div class="form-group">
<label class="form-label" id="label_off_message" for="off_message"><?php echo get_field('off_label_notes') ?: 'Briefly describe your goals'; ?></label>
<textarea class="form-textarea" id="off_message" name="off_message" placeholder="Anything else you'd like us to know?" rows="3"></textarea>
</div>
<div style="display: flex; align-items: flex-start; gap: 0.75rem; margin-bottom: var(--space-lg); margin-top: var(--space-sm);">
<input id="off_consent" name="off_consent" style="margin-top: 0.3rem; accent-color: var(--color-accent); width: 16px; height: 16px;" type="checkbox"/>
<label for="off_consent" style="font-size: 0.85rem; color: var(--color-text-muted); cursor: pointer; line-height: 1.5;">
                      <?php echo get_field('off_label_consent') ?: 'I agree to receive communications from Kings City regarding my application. I understand I can unsubscribe at any time.'; ?>
                    </label>
</div>
<button class="btn btn--large" style="width: 100%; justify-content: center; padding: 1rem;" type="submit"><?php echo get_field('off_btn_submit') ?: 'Request a Consultation'; ?></button>
</div>
</form>
<?php endif; ?>
</div>
</div>
<!-- right column: sidebars -->
<div class="col-4">
<!-- get in touch card -->
<div class="card-glass sidebar-card">
<h3><?php echo get_field('h3_contact'); ?></h3>
<p style="font-size: 0.875rem; color: var(--color-text-muted); margin-bottom: var(--space-md);"><?php echo get_field('p_16'); ?></p>
<div class="contact-item">
<span class="contact-label"><?php echo get_field('sb_contact_phone_lbl') ?: 'Phone'; ?></span>
<a class="contact-value" href="tel:+63----------"><?php echo get_field('sb_contact_phone_val') ?: '+63 ---- ---- ---'; ?></a>
</div>
<div class="contact-item" style="margin-top: var(--space-sm);">
<span class="contact-label"><?php echo get_field('sb_contact_email_lbl') ?: 'Email'; ?></span>
<a class="contact-value" href="mailto:kingscity@kingsgroup.com.ph"><?php echo get_field('sb_contact_email_val') ?: 'kingscity@kingsgroup.com.ph'; ?></a>
</div>
<div class="contact-item" style="margin-top: var(--space-sm);">
<span class="contact-label"><?php echo get_field('sb_contact_addr_lbl') ?: 'Address'; ?></span>
<span class="contact-value" style="font-size: 0.875rem; line-height: 1.6; display: inline-block;">
                Ground Level, RCS Building,<br/>
                Doña Soledad Ave, Better Living,<br/>
                Parañaque City, Philippines
              </span>
</div>
</div>
<!-- why kings city offshoring card -->
<div class="card-glass sidebar-card" style="background: var(--color-primary); color: #FFF9EF; border-color: transparent;">
<h3 style="color: #FFF9EF;"><?php echo get_field('h3_why_kings'); ?></h3>
<p style="font-size: 0.875rem; color: rgba(255,255,255,0.8); margin-bottom: var(--space-md);"><?php echo get_field('p_why_kings'); ?></p>
<a class="btn" href="<?php echo get_field('sb_why_kings_btn_url') ?: 'offshoring.html'; ?>" style="background: rgba(255,255,255,0.15); color: #fff; width: 100%; justify-content: center; border: 1px solid rgba(255,255,255,0.2);"><?php echo get_field('sb_why_kings_btn') ?: 'Learn More'; ?></a>
</div>
<!-- helpful links card -->
<div class="card-glass sidebar-card">
<h3><?php echo get_field('h3_13'); ?></h3>
<div style="margin-top: var(--space-md);">
<a class="sidebar-link" href="spaces.html"><?php echo get_field('sb_link1_txt') ?: 'Explore Spaces'; ?> <span>→</span></a>
<a class="sidebar-link" href="<?php echo get_field('sb_why_kings_btn_url') ?: 'offshoring.html'; ?>"><?php echo get_field('sb_link2_txt') ?: 'How Offshoring Works'; ?> <span>→</span></a>
<a class="sidebar-link" href="spaces.html"><?php echo get_field('sb_link3_txt') ?: 'Book a Tour'; ?> <span>→</span></a>
<a class="sidebar-link" href="#"><?php echo get_field('sb_link4_txt') ?: 'Virtual Office Packages'; ?> <span>→</span></a>
</div>
</div>
</div>
</div>
</section>
</main>
<script>
    document.addEventListener('DOMContentLoaded', () => {
      // 1. Form Toggle Logic: Spaces vs Offshoring
      const radioSpace = document.querySelector('input[value="space"]');
      const radioOffshore = document.querySelector('input[value="offshoring"]');
      const spaceViewContainer = document.getElementById('space-view-container');
      const offshoreViewContainer = document.getElementById('offshore-view-container');
      
      const labelSpace = document.getElementById('lbl-space');
      const labelOffshore = document.getElementById('lbl-offshore');

      function updateFormUI() {
        if (radioSpace.checked) {
          spaceViewContainer.style.display = 'block';
          offshoreViewContainer.style.display = 'none';
          
          labelSpace.classList.add('is-active');
          labelOffshore.classList.remove('is-active');

          // Required fields toggle
          document.getElementById('sp_first_name').required = true;
          document.getElementById('sp_last_name').required = true;
          document.getElementById('sp_email').required = true;
          document.getElementById('sp_phone').required = true;
          document.getElementById('sp_consent').required = true;

          document.getElementById('off_first_name').required = false;
          document.getElementById('off_last_name').required = false;
          document.getElementById('off_email').required = false;
          document.getElementById('off_phone').required = false;
          document.getElementById('off_consent').required = false;
        } else {
          spaceViewContainer.style.display = 'none';
          offshoreViewContainer.style.display = 'block';
          
          labelOffshore.classList.add('is-active');
          labelSpace.classList.remove('is-active');

          // Required fields toggle
          document.getElementById('sp_first_name').required = false;
          document.getElementById('sp_last_name').required = false;
          document.getElementById('sp_email').required = false;
          document.getElementById('sp_phone').required = false;
          document.getElementById('sp_consent').required = false;

          document.getElementById('off_first_name').required = true;
          document.getElementById('off_last_name').required = true;
          document.getElementById('off_email').required = true;
          document.getElementById('off_phone').required = true;
          document.getElementById('off_consent').required = true;
          document.getElementById('off_service').required = true;
        }
      }

      radioSpace.addEventListener('change', updateFormUI);
      radioOffshore.addEventListener('change', updateFormUI);
      updateFormUI();

      // Dynamic Step 1 Fields based on Offshoring Service Selection
      const offServiceSelect = document.getElementById('off_service');
      const wrapTeamSize = document.getElementById('wrap_team_size');
      const wrapRoles = document.getElementById('wrap_roles');
      const labelOffMessage = document.getElementById('label_off_message');

      function updateOffshoreFields() {
        if (!offServiceSelect) return;
        const val = offServiceSelect.value;
        
        if (val === 'Managed Staff Leasing') {
          wrapTeamSize.style.display = 'block';
          wrapRoles.style.display = 'none';
          if(labelOffMessage) labelOffMessage.innerText = 'Briefly describe your goals';
        } else if (val === 'Offshoring Staffing') {
          wrapTeamSize.style.display = 'block';
          wrapRoles.style.display = 'block';
          if(labelOffMessage) labelOffMessage.innerText = 'Briefly describe your goals';
        } else if (val === 'Both') {
          wrapTeamSize.style.display = 'block';
          wrapRoles.style.display = 'block';
          if(labelOffMessage) labelOffMessage.innerText = 'Briefly describe your goals';
        } else if (val === 'Not Sure') {
          wrapTeamSize.style.display = 'none';
          wrapRoles.style.display = 'none';
          if(labelOffMessage) labelOffMessage.innerText = 'What are the biggest challenges you are trying to solve?';
        }
      }
      
      if (offServiceSelect) {
        offServiceSelect.addEventListener('change', updateOffshoreFields);
        updateOffshoreFields(); // trigger on load
      }
      
      
      // Form submission validation (HTML5) runs before submission
      // Removed e.preventDefault() so the form actually submits to PHP!

      // 2. TEAM BUILDER LOGIC (Converted to PHP, x55 multiplier)
      <?php
      $dynamic_roles = array();
      $tb_query = new WP_Query(array(
          'post_type' => 'tb_role',
          'posts_per_page' => -1,
          'post_status' => 'publish'
      ));
      if($tb_query->have_posts()) {
          while($tb_query->have_posts()) {
              $tb_query->the_post();
              $cat = get_field('category');
              if (!$cat) $cat = 'Uncategorized';
              
              if (!isset($dynamic_roles[$cat])) {
                  $dynamic_roles[$cat] = array(
                      'cat' => $cat,
                      'roles' => array()
                  );
              }
              
              $dynamic_roles[$cat]['roles'][] = array(
                  'id' => get_post_field('post_name', get_post()),
                  'name' => get_the_title(),
                  'desc' => strip_tags(get_the_content()),
                  'base' => (int) get_field('base_price')
              );
          }
          wp_reset_postdata();
      }
      
      // Convert associative array to indexed array for JS
      $roleCatalogArray = array_values($dynamic_roles);
      ?>
      const roleCatalog = <?php echo json_encode($roleCatalogArray); ?>;

      let selectedTeam = [];

      const modal = document.getElementById('tb-modal');
      const btnAddMember = document.getElementById('btn-add-member');
      const btnGetStarted = document.getElementById('btn-get-started');
      const btnCloseModal = document.getElementById('tb-modal-close');
      const modalRoles = document.getElementById('tb-modal-roles');

      const emptyState = document.getElementById('tb-empty');
      const rolesList = document.getElementById('tb-roles-list');
      const rolesInner = document.getElementById('tb-roles-inner');
      const tbSummary = document.getElementById('tb-summary');
      const tbTotalSize = document.getElementById('tb-total-size');
      const tbTotalBase = document.getElementById('tb-total-base');
      const tbFinalTotal = document.getElementById('tb-final-total');
      const tbSavingsBox = document.getElementById('tb-savings');
      const tbSaveAmount = document.getElementById('tb-save-amount');

      function formatPhp(num) {
        return 'Php ' + num.toLocaleString('en-US');
      }

      function renderCatalog() {
        let ht = '';
        roleCatalog.forEach(c => {
          ht += `<div class="tb-cat-title">${c.cat}</div>`;
          c.roles.forEach(r => {
            ht += `
              <div class="tb-role-card">
                <div style="color: var(--color-accent); margin-top: 4px;">
                  <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                </div>
                <div class="tb-role-info">
                  <strong>${r.name}</strong>
                  <span>${r.desc}</span>
                </div>
                <button type="button" class="btn-add-role" data-id="${r.id}">+ Add</button>
              </div>
            `;
          });
        });
        modalRoles.innerHTML = ht;

        modalRoles.querySelectorAll('.btn-add-role').forEach(btn => {
          btn.addEventListener('click', (e) => {
            addRoleToTeam(e.target.dataset.id);
            closeModal();
          });
        });
      }
      
      function getRoleData(id) {
        for(let c of roleCatalog) {
          let r = c.roles.find(x => x.id === id);
          if(r) return r;
        }
        return null;
      }

      function addRoleToTeam(id) {
        const d = getRoleData(id);
        if(!d) return;

        let ex = selectedTeam.find(t => t.id === id);
        if(ex) {
          ex.count++;
        } else {
          selectedTeam.push({
            id: id,
            name: d.name,
            base: d.base,
            level: 1, // 1=Junior, 1.3=Mid, 1.7=Senior
            count: 1
          });
        }
        renderTeam();
      }

      function removeRole(id) {
        selectedTeam = selectedTeam.filter(t => t.id !== id);
        renderTeam();
      }

      function renderTeam() {
        if(selectedTeam.length === 0) {
          emptyState.style.display = 'block';
          rolesList.style.display = 'none';
          tbSummary.style.display = 'none';
          updateTotals();
          return;
        }

        emptyState.style.display = 'none';
        rolesList.style.display = 'block';
        tbSummary.style.display = 'block';

        let ht = '';
        selectedTeam.forEach(t => {
          const price = t.base * t.level;
          ht += `
            <div class="tbr-item" data-id="${t.id}">
              <div class="tbr-name">
                <div style="color: var(--color-accent); margin-top: 4px;">
                  <svg viewBox="0 0 24 24" width="18" height="18" stroke="currentColor" stroke-width="2" fill="none"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                </div>
                <div style="display:flex; flex-direction:column;">
                  <strong>${t.name}</strong>
                  <span style="font-size:0.75rem; color:var(--color-text-muted);">Dedicated Offshore Talent</span>
                </div>
              </div>
              <div class="tbr-level">
                <select class="level-sel">
                  <option value="1" ${t.level == 1 ? 'selected':''}>Junior</option>
                  <option value="1.3" ${t.level == 1.3 ? 'selected':''}>Mid-Level</option>
                  <option value="1.7" ${t.level == 1.7 ? 'selected':''}>Senior</option>
                </select>
              </div>
              <div class="tbr-count">
                <div class="tbr-count-ctl">
                  <button type="button" class="count-minus">-</button>
                  <input type="text" value="${t.count}" readonly>
                  <button type="button" class="count-plus">+</button>
                </div>
              </div>
              <div class="tbr-price">
                ${formatPhp(price)}<span style="color:var(--color-text-muted);font-weight:500;font-size:0.75rem;">/mo</span>
              </div>
              <div class="tbr-remove">
                <button type="button" class="btn-rem" title="Remove">&times;</button>
              </div>
            </div>
          `;
        });
        rolesInner.innerHTML = ht;

        rolesInner.querySelectorAll('.tbr-item').forEach(item => {
          const id = item.dataset.id;
          const t = selectedTeam.find(x => x.id === id);

          item.querySelector('.btn-rem').addEventListener('click', () => removeRole(id));
          
          item.querySelector('.level-sel').addEventListener('change', (e) => {
            t.level = parseFloat(e.target.value);
            renderTeam();
          });

          item.querySelector('.count-minus').addEventListener('click', () => {
            if(t.count > 1) { t.count--; renderTeam(); }
          });
          item.querySelector('.count-plus').addEventListener('click', () => {
            t.count++; renderTeam();
          });
        });

        updateTotals();
      }

      function updateTotals() {
        let size = 0;
        let baseTotal = 0;
        
        selectedTeam.forEach(t => {
          size += t.count;
          baseTotal += (t.base * t.level) * t.count;
        });

        tbTotalSize.textContent = size;
        tbTotalBase.textContent = formatPhp(baseTotal);
        tbFinalTotal.textContent = formatPhp(baseTotal);

        if(size > 0) {
          let localCost = baseTotal * 2.5; // Estimated 2.5x local cost
          let savings = localCost - baseTotal;
          tbSaveAmount.textContent = '~ ' + formatPhp(savings);
          tbSavingsBox.style.display = 'flex';
        } else {
          tbSavingsBox.style.display = 'none';
        }
      }

      function openModal() { 
        modal.setAttribute('aria-hidden', 'false'); 
        document.body.classList.add('modal-open');
      }
      function closeModal() { 
        modal.setAttribute('aria-hidden', 'true'); 
        document.body.classList.remove('modal-open');
      }

      if(btnAddMember) btnAddMember.addEventListener('click', openModal);
      if(btnGetStarted) btnGetStarted.addEventListener('click', openModal);
      if(btnCloseModal) btnCloseModal.addEventListener('click', closeModal);
      modal.addEventListener('click', e => { if(e.target === modal) closeModal(); });

      renderCatalog();
    });

    // hero slider logic
    (function() {
      const slider = document.getElementById('hero-slider');
      if (!slider) return;
      const slides = slider.querySelectorAll('.hero__slide');
      if (slides.length < 2) return;
      let current = 0;
      setInterval(() => {
        slides[current].style.opacity = '0';
        slides[current].classList.remove('is-active');
        current = (current + 1) % slides.length;
        slides[current].style.opacity = '1';
        slides[current].classList.add('is-active');
      }, 4000);
    })();
  </script>


  <!-- select role modal -->
  <div class="tb-modal" id="tb-modal" aria-hidden="true">
    <div class="tb-modal-content">
      <div class="tb-modal-header">
        <h3 style="margin:0;font-size:1.25rem;"><?php echo get_field('pricing_tb_modal_title') ?: 'Select a Role'; ?></h3>
        <button type="button" class="tb-modal-close" id="tb-modal-close" aria-label="Close">&times;</button>
      </div>
      <div class="tb-modal-body" id="tb-modal-roles">
        <!-- roles injected via js -->
      </div>
    </div>
  </div>

<?php get_footer(); ?>
