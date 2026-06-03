<?php
/* Template Name: Apply Now */
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
    
    /* Team Builder Styles */
    .tb-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: var(--space-md);
      padding-bottom: var(--space-sm);
      border-bottom: 1px solid var(--color-border-light);
    }
    .tb-empty-state {
      text-align: center;
      padding: var(--space-2xl) var(--space-md);
      background: rgba(255,255,255,0.5);
      border-radius: var(--radius-card-sm);
      border: 1px dashed rgba(189, 69, 31, 0.3);
      margin-bottom: var(--space-md);
    }
    .tb-roles-headers {
      display: flex;
      font-size: 0.75rem;
      font-weight: 700;
      letter-spacing: 0.1em;
      text-transform: uppercase;
      color: var(--color-text-muted);
      margin-bottom: var(--space-sm);
      padding: 0 0.5rem;
    }
    .tbr-item {
      display: flex;
      align-items: center;
      padding: 1rem;
      background: #fff;
      border: 1px solid var(--color-border-light);
      border-radius: var(--radius-sm);
      margin-bottom: 0.5rem;
      gap: 1rem;
    }
    .tbr-name {
      flex: 1.8;
      display: flex;
      align-items: center;
      gap: 0.75rem;
    }
    .tbr-level {
      flex: 1.2;
    }
    .tbr-count {
      flex: 1;
      display: flex;
      justify-content: center;
    }
    .tbr-price {
      flex: 1.2;
      text-align: right;
      font-weight: 700;
      color: var(--color-primary);
    }
    .tbr-remove {
      width: 30px;
      text-align: right;
    }
    .btn-rem {
      background: none;
      border: none;
      color: #999;
      font-size: 1.25rem;
      cursor: pointer;
      padding: 0;
    }
    .btn-rem:hover {
      color: #ff4444;
    }
    .level-sel {
      width: 100%;
      padding: 0.5rem;
      border: 1px solid var(--color-border-light);
      border-radius: 4px;
      font-size: 0.875rem;
      background: #fafafa;
    }
    .tbr-count-ctl {
      display: inline-flex;
      align-items: center;
      border: 1px solid var(--color-border-light);
      border-radius: 4px;
      overflow: hidden;
    }
    .tbr-count-ctl button {
      background: #fafafa;
      border: none;
      padding: 0.25rem 0.5rem;
      cursor: pointer;
      font-weight: bold;
      color: var(--color-primary);
    }
    .tbr-count-ctl input {
      width: 30px;
      text-align: center;
      border: none;
      border-left: 1px solid var(--color-border-light);
      border-right: 1px solid var(--color-border-light);
      background: #fff;
      font-size: 0.875rem;
      padding: 0.25rem 0;
    }
    .tb-summary {
      background: var(--color-primary);
      color: #fff;
      padding: 1.5rem;
      border-radius: var(--radius-sm);
      margin-bottom: var(--space-md);
      margin-top: var(--space-lg);
    }
    .tb-summary-row {
      display: flex;
      justify-content: space-between;
      margin-bottom: 0.5rem;
      font-size: 0.875rem;
      color: rgba(255,255,255,0.8);
    }
    .tb-summary-row strong {
      color: #fff;
      font-size: 1rem;
    }
    .tb-summary-savings {
      display: flex;
      align-items: center;
      gap: 0.5rem;
      background: rgba(159, 211, 175, 0.2);
      color: #9fd3af;
      padding: 0.75rem;
      border-radius: 4px;
      margin: 1rem 0;
      font-weight: 600;
      font-size: 0.875rem;
    }
    .tb-summary-total {
      display: flex;
      justify-content: space-between;
      align-items: center;
      border-top: 1px solid rgba(255,255,255,0.1);
      padding-top: 1rem;
      margin-top: 1rem;
    }
    .tb-modal {
      position: fixed;
      inset: 0;
      background: rgba(43, 43, 43, 0.85);
      z-index: 2000; /* Ensure it covers EVERYTHING including header */
      display: flex;
      align-items: center;
      justify-content: center;
      backdrop-filter: blur(15px) grayscale(100%);
      -webkit-backdrop-filter: blur(15px) grayscale(100%);
      opacity: 0;
      visibility: hidden;
      transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
      pointer-events: none;
      padding: var(--space-md);
    }
    .tb-modal[aria-hidden="false"] {
      opacity: 1;
      visibility: visible;
      pointer-events: auto;
    }
    .tb-modal-content {
      background: var(--glass-bg-strong);
      backdrop-filter: var(--glass-blur-strong);
      -webkit-backdrop-filter: var(--glass-blur-strong);
      border: 1px solid rgba(255, 255, 255, 0.2);
      width: 100%;
      max-width: 640px;
      max-height: 80vh;
      border-radius: var(--radius-card);
      display: flex;
      flex-direction: column;
      box-shadow: 0 30px 60px rgba(0,0,0,0.5);
      transform: scale(0.9) translateY(40px);
      opacity: 0;
      transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }
    .tb-modal[aria-hidden="false"] .tb-modal-content {
      transform: scale(1) translateY(0);
      opacity: 1;
    }
    .tb-modal-header {
      padding: 1.5rem;
      border-bottom: 1px solid var(--color-border-light);
      display: flex;
      justify-content: space-between;
      align-items: center;
      background: rgba(255, 255, 255, 0.1);
    }
    .tb-modal-close {
      background: rgba(189, 69, 31, 0.1);
      border: none;
      width: 32px;
      height: 32px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.25rem;
      cursor: pointer;
      color: var(--color-primary);
      transition: all var(--transition-fast);
    }
    .tb-modal-close:hover {
      background: var(--color-primary);
      color: #fff;
      transform: rotate(90deg);
    }
    .tb-modal-body {
      padding: 1.5rem;
      overflow-y: auto;
      scrollbar-width: thin;
      scrollbar-color: var(--color-border-light) transparent;
    }
    .tb-modal-body::-webkit-scrollbar {
      width: 6px;
    }
    .tb-modal-body::-webkit-scrollbar-thumb {
      background: var(--color-border-light);
      border-radius: 10px;
    }
    .tb-cat-title {
      font-size: 0.75rem;
      font-weight: 700;
      letter-spacing: 0.1em;
      text-transform: uppercase;
      color: var(--color-text-muted);
      margin: 1.5rem 0 0.5rem 0;
    }
    .tb-cat-title:first-child {
      margin-top: 0;
    }
    .tb-role-card {
      display: flex;
      align-items: center;
      padding: 1.25rem;
      background: rgba(255, 255, 255, 0.5);
      border: 1px solid var(--color-border-light);
      border-radius: var(--radius-card-sm);
      margin-bottom: 0.75rem;
      gap: 1rem;
      transition: all var(--transition-fast);
    }
    .tb-role-card:hover {
      background: rgba(255, 255, 255, 0.9);
      transform: translateX(5px);
      border-color: var(--color-accent-red);
      box-shadow: var(--glass-shadow);
    }
    .tb-role-info {
      flex: 1;
      display: flex;
      flex-direction: column;
    }
    .tb-role-info strong {
      color: var(--color-primary);
      margin-bottom: 0.15rem;
      font-size: 1rem;
    }
    .tb-role-info span {
      font-size: 0.8rem;
      color: var(--color-text-muted);
      line-height: 1.4;
    }
    .btn-add-role {
      padding: 0.5rem 1.25rem;
      background-color: var(--color-accent-red) !important;
      color: var(--color-bg-ivory) !important;
      border: 1px solid var(--color-accent-red);
      border-radius: var(--radius-pill);
      font-weight: 600;
      font-size: 0.8125rem;
      cursor: pointer;
      transition: all 0.3s ease-in-out;
      box-shadow: 0 4px 12px rgba(172, 32, 26, 0.15);
    }
    .btn-add-role:hover {
      background-color: var(--color-btn-hover) !important;
      color: var(--color-bg-ivory) !important;
      border-color: var(--color-btn-hover) !important;
      transform: translateY(-2px);
      box-shadow: 0 6px 16px rgba(142, 21, 16, 0.25);
    }

    /* Modal Open State — Body Lock & Global Gray Out */
    body.modal-open {
      overflow: hidden;
      height: 100vh;
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
<!-- application layout -->
<section class="section content-panel" id="application">
<div class="container grid-12">
<!-- left column: form -->
<div class="col-8">
<div class="card-glass card-glass--strong" style="padding: var(--space-xl);">
<span class="text-overline"><?php echo get_field('overline_18'); ?></span>
<h2 style="margin-bottom: var(--space-lg);"><?php echo get_field('h2_8'); ?></h2>
<form id="apply-form" novalidate="">
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
<label class="form-label" for="space_type">Which space are you interested in?</label>
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
<label class="form-label" for="sp_first_name">First Name</label>
<input class="form-input" id="sp_first_name" name="sp_first_name" placeholder="First Name" required="" type="text"/>
</div>
<div class="form-group">
<label class="form-label" for="sp_last_name">Last Name</label>
<input class="form-input" id="sp_last_name" name="sp_last_name" placeholder="Last Name" required="" type="text"/>
</div>
</div>
<div class="form-row">
<div class="form-group">
<label class="form-label" for="sp_email">Email Address</label>
<input class="form-input" id="sp_email" name="sp_email" placeholder="you@company.com" required="" type="email"/>
</div>
<div class="form-group">
<label class="form-label" for="sp_phone">Phone Number</label>
<input class="form-input" id="sp_phone" name="sp_phone" placeholder="+63 XXX XXX XXXX" required="" type="tel"/>
</div>
</div>
<div class="form-row">
<div class="form-group">
<label class="form-label" for="sp_company">Company / Business Name</label>
<input class="form-input" id="sp_company" name="sp_company" placeholder="Your company name" type="text"/>
</div>
<div class="form-group">
<label class="form-label" for="sp_country">Country</label>
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
<label class="form-label" for="sp_message">Tell Us About Your Needs</label>
<textarea class="form-textarea" id="sp_message" name="sp_message" placeholder="Describe what you're looking for..." rows="5"></textarea>
</div>
<div style="display: flex; align-items: flex-start; gap: 0.75rem; margin-bottom: var(--space-lg); margin-top: var(--space-sm);">
<input id="sp_consent" name="sp_consent" required="" style="margin-top: 0.3rem; accent-color: var(--color-accent); width: 16px; height: 16px;" type="checkbox"/>
<label for="sp_consent" style="font-size: 0.85rem; color: var(--color-text-muted); cursor: pointer; line-height: 1.5;">
                    I agree to receive communications from Kings City regarding my application. I understand I can unsubscribe at any time.
                  </label>
</div>
<button class="btn btn--large" style="width: 100%; justify-content: center; padding: 1rem;" type="submit">Submit Application</button>
</div>
<!-- offshoring view -->
<div id="offshore-view-container" style="display: none;">
<!-- offshoring team builder ui -->
<div class="tb-header" style="margin-top: var(--space-md);">
<div style="display: flex; align-items: center; gap: 0.5rem;">
<svg fill="none" height="24" stroke="var(--color-primary)" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewbox="0 0 24 24" width="24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
<h3 style="margin:0; font-size: 1.25rem; color: var(--color-primary);"><?php echo get_field('h3_10'); ?></h3>
</div>
<button class="btn btn--small" id="btn-add-member" type="button">+ Add Member</button>
</div>
<div class="tb-body">
<div class="tb-empty-state" id="tb-empty">
<div style="margin-bottom: 1rem; color: var(--color-text-muted);">
<svg fill="none" height="48" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1" viewbox="0 0 24 24" width="48"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
</div>
<h4 style="margin-bottom: 0.5rem;">Build your offshore team with Kings City.</h4>
<p style="font-size: 0.875rem; color: var(--color-text-muted); margin-bottom: 1.5rem;"><?php echo get_field('p_15'); ?></p>
<button class="btn btn--outline" id="btn-get-started" type="button">Get Started</button>
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
<svg fill="none" height="18" stroke="currentColor" stroke-width="2" viewbox="0 0 24 24" width="18"><polyline points="20 6 9 17 4 12"></polyline></svg>
<span>Saving <strong id="tb-save-amount">~ Php 0</strong> vs. local hire</span>
</div>
<div class="tb-summary-total">
<span style="font-size:1.1rem;font-weight:700;">Estimated Total</span>
<span id="tb-final-total" style="font-size:1.5rem;font-weight:700; color: #fff;">Php 0</span>
</div>
</div>
</div>
<div style="padding-top: var(--space-lg); margin-top: var(--space-md); border-top: 1px dashed rgba(189, 69, 31, 0.2);">
<div class="form-row">
<div class="form-group">
<label class="form-label" for="off_first_name">First Name</label>
<input class="form-input" id="off_first_name" name="off_first_name" placeholder="First Name" type="text"/>
</div>
<div class="form-group">
<label class="form-label" for="off_last_name">Last Name</label>
<input class="form-input" id="off_last_name" name="off_last_name" placeholder="Last Name" type="text"/>
</div>
</div>
<div class="form-row">
<div class="form-group">
<label class="form-label" for="off_email">Work Email</label>
<input class="form-input" id="off_email" name="off_email" placeholder="you@company.com" type="email"/>
</div>
<div class="form-group">
<label class="form-label" for="off_phone">Phone Number</label>
<input class="form-input" id="off_phone" name="off_phone" placeholder="+63 XXX XXX XXXX" type="tel"/>
</div>
</div>
<div class="form-row">
<div class="form-group">
<label class="form-label" for="off_company">Company Name</label>
<input class="form-input" id="off_company" name="off_company" placeholder="Your company name" type="text"/>
</div>
<div class="form-group">
<label class="form-label" for="off_country">Country</label>
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
<label class="form-label" for="off_message">Additional Notes (Optional)</label>
<textarea class="form-textarea" id="off_message" name="off_message" placeholder="Any specific requirements..." rows="3"></textarea>
</div>
<div style="display: flex; align-items: flex-start; gap: 0.75rem; margin-bottom: var(--space-lg); margin-top: var(--space-sm);">
<input id="off_consent" name="off_consent" style="margin-top: 0.3rem; accent-color: var(--color-accent); width: 16px; height: 16px;" type="checkbox"/>
<label for="off_consent" style="font-size: 0.85rem; color: var(--color-text-muted); cursor: pointer; line-height: 1.5;">
                      I agree to receive communications from Kings City regarding my application. I understand I can unsubscribe at any time.
                    </label>
</div>
<button class="btn btn--large" style="width: 100%; justify-content: center; padding: 1rem;" type="submit">Request Detailed Quote</button>
</div>
</div>
</form>
</div>
</div>
<!-- right column: sidebars -->
<div class="col-4">
<!-- get in touch card -->
<div class="card-glass sidebar-card">
<h3><?php echo get_field('h3_11'); ?></h3>
<p style="font-size: 0.875rem; color: var(--color-text-muted); margin-bottom: var(--space-md);"><?php echo get_field('p_16'); ?></p>
<div class="contact-item">
<span class="contact-label">Phone</span>
<a class="contact-value" href="tel:+63----------">+63 ---- ---- ---</a>
</div>
<div class="contact-item" style="margin-top: var(--space-sm);">
<span class="contact-label">Email</span>
<a class="contact-value" href="mailto:kingscity@kingsgroup.com.ph">kingscity@kingsgroup.com.ph</a>
</div>
<div class="contact-item" style="margin-top: var(--space-sm);">
<span class="contact-label">Address</span>
<span class="contact-value" style="font-size: 0.875rem; line-height: 1.6; display: inline-block;">
                Ground Level, RCS Building,<br/>
                Doña Soledad Ave, Better Living,<br/>
                Parañaque City, Philippines
              </span>
</div>
</div>
<!-- why kings city offshoring card -->
<div class="card-glass sidebar-card" style="background: var(--color-primary); color: var(--color-text-light); border-color: transparent;">
<h3 style="color: var(--color-text-light);"><?php echo get_field('h3_12'); ?></h3>
<p style="font-size: 0.875rem; color: rgba(255,255,255,0.8); margin-bottom: var(--space-md);"><?php echo get_field('p_17'); ?></p>
<a class="btn" href="offshoring.html" style="background: rgba(255,255,255,0.15); color: #fff; width: 100%; justify-content: center; border: 1px solid rgba(255,255,255,0.2);">Learn More</a>
</div>
<!-- helpful links card -->
<div class="card-glass sidebar-card">
<h3><?php echo get_field('h3_13'); ?></h3>
<div style="margin-top: var(--space-md);">
<a class="sidebar-link" href="spaces.html">Explore Spaces <span>→</span></a>
<a class="sidebar-link" href="offshoring.html">How Offshoring Works <span>→</span></a>
<a class="sidebar-link" href="spaces.html">Book a Tour <span>→</span></a>
<a class="sidebar-link" href="#">Virtual Office Packages <span>→</span></a>
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
        }
      }

      radioSpace.addEventListener('change', updateFormUI);
      radioOffshore.addEventListener('change', updateFormUI);
      updateFormUI();
      
      const form = document.getElementById('apply-form');
      form.addEventListener('submit', (e) => {
        e.preventDefault();
        alert('Thank you for applying! Our team will contact you within 24 hours.');
        form.reset();
        selectedTeam = [];
        renderTeam();
        updateFormUI();
      });

      // 2. TEAM BUILDER LOGIC (Converted to PHP, x55 multiplier)
      const roleCatalog = [
        { cat: "Operations & Management", roles: [
          { id: 'op-head', name: "Operations Head", desc: "Strategic oversight and operational management", base: 137500 },
          { id: 'bldg-admin', name: "Building Administrator", desc: "Facility management and tenant relations", base: 66000 },
          { id: 'culinary', name: "Culinary Administrator", desc: "Food service operations and culinary management", base: 55000 }
        ]},
        { cat: "Finance & Accounting", roles: [
          { id: 'acct-head', name: "Accounting and Finance Head", desc: "Financial strategy, reporting, and team leadership", base: 121000 },
          { id: 'acct-mgr', name: "Accounting Manager", desc: "Account management and financial operations", base: 82500 },
          { id: 'acct-sup', name: "Accounting Supervisor", desc: "Supervise accounting staff and daily operations", base: 55000 }
        ]},
        { cat: "Human Resources", roles: [
          { id: 'hr-coord', name: "HR Coordinator", desc: "Employee relations, onboarding, and HR support", base: 49500 },
          { id: 'recruiter', name: "Recruitment Officer", desc: "Talent sourcing, interviewing, and hiring", base: 60500 },
          { id: 'payroll-master', name: "Payroll Master", desc: "Complex payroll processing and compliance", base: 77000 }
        ]},
        { cat: "Technology & Marketing", roles: [
          { id: 'dev', name: "Software Developer", desc: "Frontend, Backend, and Full Stack development", base: 110000 },
          { id: 'ba', name: "Business Analyst", desc: "Data analysis, process improvement, reporting", base: 88000 },
          { id: 'mktg', name: "Marketing Officer", desc: "Campaign management, branding, and communications", base: 66000 }
        ]}
      ];

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


<?php get_footer(); ?>
