<?php
/* Template Name: Apply Now */

$form_submitted = false;
$error_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['quote_submit'])) {
    if (!isset($_POST['quote_nonce']) || !wp_verify_nonce($_POST['quote_nonce'], 'quote_submission')) {
        $error_message = 'Security check failed. Please try again.';
    } elseif (!empty($_POST['website_url_trap'])) {
        $error_message = 'Spam detected.';
    } else {
        $fname = sanitize_text_field($_POST['first_name']);
        $mname = sanitize_text_field($_POST['middle_name']);
        $lname = sanitize_text_field($_POST['last_name']);
        $email = sanitize_email($_POST['email']);
        $phone = sanitize_text_field($_POST['phone']);
        $address = sanitize_textarea_field($_POST['address']);
        $team_json = stripslashes($_POST['team_json']);
        
        $team_data = json_decode($team_json, true);
        
        $to = 'kingscity@kingsgroup.com.ph';
        $subject = 'New Quote Request from ' . $fname . ' ' . $lname;
        
        $message = "You have received a new quote request.\n\n";
        $message .= "Name: $fname $mname $lname\n";
        $message .= "Email: $email\n";
        $message .= "Phone: $phone\n";
        $message .= "Address:\n$address\n\n";
        
        $message .= "--- TEAM BUILDER SELECTION ---\n";
        if (!empty($team_data) && is_array($team_data)) {
            $message .= "Currency: " . esc_html($_POST['currency_used']) . "\n";
            $message .= "Total Estimated Monthly Base: " . esc_html($_POST['total_est']) . "\n\n";
            foreach ($team_data as $role) {
                $message .= "- " . $role['title'] . " (" . $role['level'] . ")\n";
                $message .= "  Headcount: " . $role['headcount'] . "\n";
                $message .= "  Est. Monthly: " . $role['monthly'] . "\n\n";
            }
        } else {
            $message .= "No team roles selected.\n";
        }
        
        // Check for recent submissions from the same email
        $recent_leads = get_posts(array(
            'post_type'      => 'kg_quote_lead',
            'meta_key'       => 'email',
            'meta_value'     => $email,
            'date_query'     => array(
                array(
                    'after' => '7 days ago'
                )
            ),
            'posts_per_page' => 1
        ));

        if (!empty($recent_leads)) {
            $error_message = 'We have already received a recent quote request from this email. Please allow up to 7 days before submitting another, or contact us directly.';
        } else {
            $post_id = wp_insert_post(array(
                'post_title'   => $fname . ' ' . $lname . ' - ' . esc_html($_POST['total_est']),
                'post_type'    => 'kg_quote_lead',
                'post_status'  => 'publish'
            ));

        if (!is_wp_error($post_id)) {
            update_post_meta($post_id, 'first_name', $fname);
            update_post_meta($post_id, 'middle_name', $mname);
            update_post_meta($post_id, 'last_name', $lname);
            update_post_meta($post_id, 'email', $email);
            update_post_meta($post_id, 'phone', $phone);
            update_post_meta($post_id, 'address', $address);
            update_post_meta($post_id, 'team_json', $team_json);
            update_post_meta($post_id, 'currency_used', sanitize_text_field($_POST['currency_used']));
            update_post_meta($post_id, 'total_est', sanitize_text_field($_POST['total_est']));
            update_post_meta($post_id, 'lead_status', 'Pending');
            
            // Also send notification email
            $headers = array('Reply-To: ' . $email);
            wp_mail($to, $subject, $message, $headers);
            // Set 7-day cookie
            setcookie('kc_quote_submitted', '1', time() + (7 * 24 * 60 * 60), "/");
            
            $form_submitted = true;
        }
        }
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
<h1 class="hero__title hero__title--inner"><?php $h = get_field('h1_1'); if ($h) { $w = explode(' ', trim($h)); echo (count($w) === 3) ? $w[0] . '&nbsp;' . $w[1] . ' ' . $w[2] : $h; } ?></h1>
<p class="hero__subtitle"><?php echo get_field('p_2'); ?></p>
</div>
<!-- media on right -->
<div class="split__media hero__slider" id="hero-slider" style="position: relative; aspect-ratio: 4/3; overflow: hidden; border-radius: var(--radius-card);">
<img alt="Kings City Access" class="hero__slide is-active" src="<?php echo kc_img('image_4', 'page-apply-img/kings-img29.webp'); ?>" style="position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; opacity: 1; transition: opacity 1s ease-in-out;"/>
<img alt="Kings City Membership 1" class="hero__slide" src="<?php echo kc_img('image_5', 'kings_img07-3-scaled.webp'); ?>" style="position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; opacity: 0; transition: opacity 1s ease-in-out;"/>
<img alt="Kings City Membership 2" class="hero__slide" src="<?php echo kc_img('image_6', 'kings-img30-1-scaled.webp'); ?>" style="position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; opacity: 0; transition: opacity 1s ease-in-out;"/>
</div>
</div>
</div>
</section>

<!-- pricing section -->
<section class="section" id="pricing-section" style="position: relative; overflow: hidden;">
  <!-- Background Floating Icons -->
  
          <!-- 1. Star -->
          <!-- 2. Heart -->
          <!-- 3. Star -->
          <!-- 4. Heart -->
          <!-- 5. Star -->
          <div class="container grid-12" style="position: relative; z-index: 2;">
    <!-- Subsection 1: Team Builder Pricing -->
    <div class="col-10" style="grid-column: 2 / span 10;">
      <form id="quote-form" method="POST" action="#pricing-section" novalidate>
        <input type="hidden" name="quote_submit" value="1">
        <input type="text" name="website_url_trap" style="display:none !important;" tabindex="-1" autocomplete="off">
        <?php wp_nonce_field('quote_submission', 'quote_nonce'); ?>
        <input type="hidden" id="team_json" name="team_json" value="">
        <input type="hidden" id="currency_used" name="currency_used" value="">
        <input type="hidden" id="total_est" name="total_est" value="">
        
        <div class="card-glass card-glass--strong" style="background: var(--glass-bg-dark); padding: var(--space-xl); height: 100%;">
          <?php if (isset($_COOKIE['kc_quote_submitted'])): ?>
              <div style="text-align:center; padding: 4rem 2rem;">
                  <i class="fa-solid fa-clock" style="font-size: 4rem; color: var(--color-bg-ivory); margin-bottom: 1.5rem;"></i>
                  <h2 style="margin-bottom:1rem; color: var(--color-bg-ivory);">Quote Request Under Review</h2>
                  <p style="color:var(--color-bg-ivory); font-size: 1.125rem;">You recently requested a quote. Our team is currently reviewing your requirements and will be in touch shortly.</p>
              </div>
          <?php elseif ($form_submitted): ?>
              <div style="text-align:center; padding: 4rem 2rem;">
                  <i class="fa-solid fa-check-circle" style="font-size: 4rem; color: #10b981; margin-bottom: 1.5rem;"></i>
                  <h2 style="margin-bottom:1rem; color: var(--color-bg-ivory);">Quote Request Received!</h2>
                  <p style="color:var(--color-bg-ivory); font-size: 1.125rem;">Thank you for your interest. Our team will review your requirements and get back to you shortly.</p>
              </div>
          <?php else: ?>
          
          <?php if (!empty($error_message)): ?>
              <div style="background:#fee2e2;color:#b91c1c;padding:1rem;margin-bottom:1.5rem;border-radius:8px;"><?php echo esc_html($error_message); ?></div>
          <?php endif; ?>
        <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 1rem; margin-bottom: var(--space-lg);">
          <div>
            <span class="text-overline" style="color: var(--color-bg-ivory);"><?php echo get_field('pricing_tb_overline') ?: 'Team Builder Pricing'; ?></span>
            <h2 style="margin: 0; color: var(--color-bg-ivory);"><?php echo get_field('pricing_tb_heading') ?: 'Estimate Your Team'; ?></h2>
          </div>
          <div class="currency-toggle" style="display: flex; background: var(--color-bg-ivory); border-radius: var(--radius-pill); padding: 4px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); border: 1px solid var(--color-border-light);">
            <?php 
            $default_currencies = array(
                array('code' => 'AUD', 'rate' => 0.026),
                array('code' => 'USD', 'rate' => 0.017),
                array('code' => 'PHP', 'rate' => 1)
            );
            $saved_currencies = get_option('kc_tb_currencies', $default_currencies);
            // Fallback if empty array is saved
            if (empty($saved_currencies)) { $saved_currencies = $default_currencies; }
            $first = true;
            foreach ($saved_currencies as $curr):
                $code = esc_attr($curr['code']);
                $activeClass = $first ? ' is-active' : '';
                $bgStyle = $first ? 'background: var(--color-secondary); color: var(--color-primary);' : 'background: transparent; color: var(--color-primary);';
            ?>
            <button type="button" class="curr-btn<?php echo $activeClass; ?>" data-curr="<?php echo $code; ?>" style="padding: 0.25rem 1rem; border-radius: var(--radius-pill); font-size: 0.8rem; font-weight: 700; <?php echo $bgStyle; ?> border: none; cursor: pointer; transition: all 0.3s ease;"><?php echo $code; ?></button>
            <?php 
                $first = false;
            endforeach; 
            ?>
          </div>
        </div>
        
        <div class="tb-header" style="margin-top: var(--space-md);">
          <div style="display: flex; align-items: center; gap: 0.5rem;">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="var(--color-bg-ivory)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
            <h3 style="margin:0; color: var(--color-bg-ivory);"><?php echo get_field('pricing_tb_subheading') ?: 'Your Team Selection'; ?></h3>
          </div>
          <button type="button" class="btn btn--small" id="btn-add-member" style="background: var(--color-secondary) !important; color: var(--color-primary) !important; border-color: var(--color-primary) !important;">+ Add Member</button>
        </div>
        
        <div class="tb-body" style="background-color: #FBCB77; padding: var(--space-md); border-radius: var(--radius-card);">
          <div class="tb-empty-state" id="tb-empty">
            <div style="margin-bottom: 1rem; color: var(--color-primary); display: flex; justify-content: center; align-items: center;">
              <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
            </div>
            <h4 style="margin-bottom: 0.5rem; color: var(--color-primary);"><?php echo get_field('pricing_tb_body_title') ?: 'Build your offshore team with Kings City.'; ?></h4>
            <p style="font-size: 0.875rem; color: var(--color-primary); margin-bottom: 1.5rem;"><?php echo get_field('pricing_tb_body_desc') ?: 'Select roles below and instantly see a transparent monthly estimate.'; ?></p>
            <button type="button" class="btn btn--outline" id="btn-get-started" style="background: var(--color-secondary) !important; color: var(--color-primary) !important; border-color: var(--color-primary) !important;">Get Started</button>
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
              <span style="font-size:1.5rem;font-weight:700; color: var(--color-primary);" id="tb-final-total">Php 0</span>
            </div>

            <!-- NEW LEAD CAPTURE FIELDS -->
            <div style="margin-top: 2rem; padding-top: 2rem; border-top: 1px dashed var(--color-border);">
              <h4 style="margin-bottom: 1.5rem; color: var(--color-primary);">Request Your Detailed Quote</h4>
              
              <div class="form-row">
                  <div class="form-group">
                      <input class="form-input" name="first_name" placeholder="First Name" required="" type="text"/>
                  </div>
                  <div class="form-group">
                      <input class="form-input" name="middle_name" placeholder="Middle Name (Optional)" type="text"/>
                  </div>
              </div>
              <div class="form-row">
                  <div class="form-group">
                      <input class="form-input" name="last_name" placeholder="Last Name" required="" type="text"/>
                  </div>
                  <div class="form-group">
                      <input class="form-input" name="email" placeholder="Your Work Email" required="" type="email"/>
                  </div>
              </div>
              <div class="form-row">
                  <div class="form-group">
                      <input class="form-input" name="phone" placeholder="Phone Number" required="" type="tel"/>
                  </div>
                  <div class="form-group">
                      <input class="form-input" name="address" placeholder="Address" required="" type="text"/>
                  </div>
              </div>
              
              <button class="btn btn--large" style="width: 100%; justify-content: center; margin-top: 1rem; background-color: var(--color-accent-red); color: white;" type="submit">REQUEST DETAILED QUOTE</button>
            </div>
            <!-- END LEAD CAPTURE FIELDS -->
            
          </div>
        </div>
        <?php endif; ?>
      </div>
      </form>
    </div>
  </div>


          <!-- 1. Star -->
          <div class="floating-bg-icon anim-float-fast" style="top: 10%; right: 8%; color: var(--color-primary);"><svg viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" /></svg></div>
          <!-- 2. Heart -->
          <div class="floating-bg-icon anim-pulse" style="bottom: 15%; left: 8%; color: var(--color-accent-red);"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg></div>
          <!-- 3. Star -->
          <div class="floating-bg-icon anim-float-fast" style="top: 25%; right: 40%; color: var(--color-secondary);"><svg viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" /></svg></div>
          <!-- 4. Heart -->
          <div class="floating-bg-icon anim-pulse" style="bottom: 10%; right: 10%; color: var(--color-primary);"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg></div>
          <!-- 5. Star -->
          <div class="floating-bg-icon anim-float-fast" style="top: 15%; left: 12%; color: var(--color-accent-red);"><svg viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" /></svg></div>
          <!-- 6. Heart -->
          <div class="floating-bg-icon anim-pulse" style="top: 45%; left: 25%; color: var(--color-secondary);"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg></div>

</section>
</main>
<script>
    document.addEventListener('DOMContentLoaded', () => {


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
              $terms = get_the_terms(get_the_ID(), 'tb_role_category');
              $cat = ($terms && !is_wp_error($terms)) ? $terms[0]->name : 'Uncategorized';
              
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
      <?php 
      $saved_currencies = get_option('kc_tb_currencies', array(
          array('code' => 'AUD', 'rate' => 0.026),
          array('code' => 'USD', 'rate' => 0.017),
          array('code' => 'PHP', 'rate' => 1)
      ));
      if (empty($saved_currencies)) {
          $saved_currencies = array(
              array('code' => 'AUD', 'rate' => 0.026),
              array('code' => 'USD', 'rate' => 0.017),
              array('code' => 'PHP', 'rate' => 1)
          );
      }
      $rates_map = array();
      foreach ($saved_currencies as $c) {
          $rates_map[$c['code']] = (float)$c['rate'];
      }
      $default_curr = $saved_currencies[0]['code'];
      ?>
      const currencyRates = <?php echo json_encode($rates_map); ?>;
      let currentCurr = '<?php echo esc_js($default_curr); ?>'; // Default currency


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

      function formatCurrency(numPhp) {
        let rate = currencyRates[currentCurr] || 1;
        let converted = Math.round(numPhp * rate);
        
        let prefix = currentCurr + " ";
        if (currentCurr === "AUD") prefix = "A$ ";
        if (currentCurr === "USD") prefix = "$ ";
        if (currentCurr === "PHP") prefix = "Php ";
        if (currentCurr === "GBP") prefix = "£ ";
        if (currentCurr === "EUR") prefix = "€ ";

        return prefix + converted.toLocaleString('en-US');
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
          emptyState.style.display = 'flex';
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
                ${formatCurrency(price)}<span style="color:var(--color-text-muted);font-weight:500;font-size:0.75rem;">/mo</span>
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
        tbTotalBase.textContent = formatCurrency(baseTotal);
        tbFinalTotal.textContent = formatCurrency(baseTotal);

        if(size > 0) {
          let localCost = baseTotal * 2.5; // Estimated 2.5x local cost
          let savings = localCost - baseTotal;
          tbSaveAmount.textContent = '~ ' + formatCurrency(savings);
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
      // Currency Toggle Logic
      const currBtns = document.querySelectorAll('.curr-btn');
      currBtns.forEach(btn => {
        btn.addEventListener('click', (e) => {
          // Remove active state
          currBtns.forEach(b => {
            b.classList.remove('is-active');
            b.style.background = 'transparent';
            b.style.color = 'var(--color-primary)';
          });
          // Set active state
          const clicked = e.target;
          clicked.classList.add('is-active');
          clicked.style.background = 'var(--color-secondary)';
          clicked.style.color = 'var(--color-primary)';
          
          currentCurr = clicked.dataset.curr;
          
          // Force UI to re-render with new currency
          renderTeam(); // recalculate entire team list and total
        });
      });


      renderCatalog();

      // Populate hidden fields before submit
      const quoteForm = document.getElementById('quote-form');
      if (quoteForm) {
        quoteForm.addEventListener('submit', function(e) {
          if (selectedTeam.length === 0) {
            e.preventDefault();
            alert("Please add at least one role to your team before requesting a quote.");
            return;
          }
          
          let teamListForSubmit = selectedTeam.map(t => {
            let levelLabel = 'Junior';
            if (t.level == 1.3) levelLabel = 'Mid';
            if (t.level == 1.7) levelLabel = 'Senior';
            return {
              title: t.name,
              level: levelLabel,
              headcount: t.count,
              monthly: formatCurrency((t.base * t.level) * t.count)
            };
          });
          
          document.getElementById('team_json').value = JSON.stringify(teamListForSubmit);
          document.getElementById('currency_used').value = currentCurr;
          document.getElementById('total_est').value = document.getElementById('tb-final-total').innerText;
        });
      }
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
        <h3 style="margin:0;"><?php echo get_field('pricing_tb_modal_title') ?: 'Select a Role'; ?></h3>
        <button type="button" class="tb-modal-close" id="tb-modal-close" aria-label="Close">&times;</button>
      </div>
      <div class="tb-modal-body" id="tb-modal-roles">
        <!-- roles injected via js -->
      </div>
    </div>
  </div>

<?php get_footer(); ?>

