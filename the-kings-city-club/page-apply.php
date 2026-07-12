<?php
if (!defined('ABSPATH')) exit;
/* Template Name: Apply Now */

get_header();
?>


<main id="main-content">
<!-- hero section -->
<section class="hero premium-hero">
<div class="container grid-12">
<div class="col-12 split split--media-right">
<!-- text on left -->
<div class="split__content animate-fadeInUp hero__content--index">
<span class="text-overline hero__overline"><?php echo esc_html(get_field('overline_3')); ?></span>
<h1 class="hero__title hero__title--inner"><?php kc_split_heading(get_field('h1_1')); ?></h1>
<p class="hero__subtitle"><?php echo esc_html(get_field('p_2')); ?></p>
</div>
<!-- media on right -->
<div class="split__media hero__slider" id="hero-slider" style="position: relative; aspect-ratio: 4/3; overflow: hidden; border-radius: var(--radius-card);">
<img alt="Kings City Access" class="hero__slide is-active" src="<?php echo kc_img('image_4', 'page-apply-img/kings-img29.webp'); ?>" style="position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; opacity: 1; transition: opacity 1s ease-in-out;"/>
<img alt="Kings City Membership 1" class="hero__slide" src="<?php echo kc_img('image_5', 'page-apply-img/kings_img07.webp'); ?>" style="position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; opacity: 0; transition: opacity 1s ease-in-out;"/>
<img alt="Kings City Membership 2" class="hero__slide" src="<?php echo kc_img('image_6', 'page-apply-img/kings-img30.webp'); ?>" style="position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; opacity: 0; transition: opacity 1s ease-in-out;"/>
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
    <div class="col-10 pricing-card-wrapper">
      <form id="quote-form" method="POST" action="#pricing-section" novalidate>
        <input type="hidden" name="quote_submit" value="1">
        <input type="text" name="website_url_trap" style="display:none !important;" tabindex="-1" autocomplete="off">
        <?php wp_nonce_field('quote_submission', 'quote_nonce'); ?>
        <input type="hidden" id="team_json" name="team_json" value="">
        <input type="hidden" id="currency_used" name="currency_used" value="">
        <input type="hidden" id="total_est" name="total_est" value="">
        
        <div class="card-glass card-glass--strong" style="background: var(--glass-bg-dark); padding: var(--space-xl); height: 100%;">
          
        <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 1rem; margin-bottom: var(--space-lg);">
          <div>
            <span class="text-overline" style="color: var(--color-bg-ivory);"><?php echo esc_html(get_field('pricing_tb_overline') ?: 'Team Builder Pricing'); ?></span>
            <h2 style="margin: 0; color: var(--color-bg-ivory);"><?php echo esc_html(get_field('pricing_tb_heading') ?: 'Estimate Your Team'); ?></h2>
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
            <h3 style="margin:0; color: var(--color-bg-ivory);"><?php echo esc_html(get_field('pricing_tb_subheading') ?: 'Your Team Selection'); ?></h3>
          </div>
          <button type="button" class="btn btn--small" id="btn-add-member" style="background: var(--color-secondary) !important; color: var(--color-primary) !important; border-color: var(--color-primary) !important;">+ Add Member</button>
        </div>
        
        <div class="tb-body" style="background-color: #FBCB77; padding: var(--space-md); border-radius: var(--radius-card);">
          <div class="tb-empty-state" id="tb-empty">
            <div style="margin-bottom: 1rem; color: var(--color-primary); display: flex; justify-content: center; align-items: center;">
              <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
            </div>
            <h4 style="margin-bottom: 0.5rem; color: var(--color-primary);"><?php echo esc_html(get_field('pricing_tb_body_title') ?: 'Build your offshore team with Kings City.'); ?></h4>
            <p style="font-size: 0.875rem; color: var(--color-primary); margin-bottom: 1.5rem;"><?php echo esc_html(get_field('pricing_tb_body_desc') ?: 'Select roles below and instantly see a transparent monthly estimate.'); ?></p>
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
              <strong id="tb-total-base">PHP 0</strong>
            </div>
            <div class="tb-summary-savings" id="tb-savings" style="display:none;">
              <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg>
              <span>Saving <strong id="tb-save-amount">~ PHP 0</strong> vs. local hire</span>
            </div>
            <div class="tb-summary-total">
              <span style="font-size:1.1rem;font-weight:700;">Estimated Total</span>
              <span style="font-size:1.5rem;font-weight:700; color: var(--color-primary);" id="tb-final-total">PHP 0</span>
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


  <!-- select role modal -->
  <div class="tb-modal" id="tb-modal" aria-hidden="true">
    <div class="tb-modal-content">
      <div class="tb-modal-header">
        <h3 style="margin:0;"><?php echo esc_html(get_field('pricing_tb_modal_title') ?: 'Select a Role'); ?></h3>
        <button type="button" class="tb-modal-close" id="tb-modal-close" aria-label="Close">&times;</button>
      </div>
      <div class="tb-modal-body" id="tb-modal-roles">
        <!-- roles injected via js -->
      </div>
    </div>
  </div>


<!-- Custom Popup Modal -->
<div id="kc-quote-popup" style="display:none; position:fixed; z-index:9999; left:0; top:0; width:100%; height:100%; background:rgba(0,0,0,0.5); align-items:center; justify-content:center;">
    <div style="background:var(--color-bg-ivory); padding:2rem; border-radius:var(--radius-lg); max-width:500px; width:90%; text-align:center; box-shadow:var(--shadow-lg);">
        <i id="kc-quote-popup-icon" class="fa-solid fa-circle-exclamation" style="font-size:3rem; margin-bottom:1rem;"></i>
        <h3 id="kc-quote-popup-title" style="margin-bottom:1rem; color:var(--color-primary);">Notice</h3>
        <p id="kc-quote-popup-message" style="margin-bottom:1.5rem; font-size:1.1rem; line-height:1.5;">Message goes here</p>
        <button type="button" id="kc-quote-popup-close-btn" class="btn btn--primary" style="background-color:var(--color-accent-red); color:#fff; border:none; padding:10px 30px; border-radius:var(--radius-pill); cursor:pointer; font-weight:bold; font-size:1.1rem;">Close</button>
    </div>
</div>



<?php get_footer(); ?>

