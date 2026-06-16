<?php
/* Template Name: Our Brands */
get_header();
?>

<main id="main-content">
<!-- hero section -->
<section class="hero premium-hero">
<div class="container grid-12">
<div class="col-12 split split--media-right">
<!-- text content on left -->
<div class="split__content animate-fadeInUp hero__content--index">
<span class="text-overline hero__overline"><?php echo get_field('overline_3'); ?></span>
<h1 class="hero__title hero__title--inner"><?php $h = get_field('h1_1'); if ($h) { $w = explode(' ', trim($h)); echo (count($w) === 3) ? $w[0] . '&nbsp;' . $w[1] . ' ' . $w[2] : $h; } ?></h1>
<p class="hero__subtitle"><?php echo get_field('p_2'); ?></p>
<div class="hero__actions hero__actions--index">
<a class="btn" href="#group-companies">
                Discover Our Brands
              </a>
</div>
</div>
<!-- slider on right -->
<div class="split__media hero__slider" id="hero-slider" style="position: relative; aspect-ratio: 4/3; overflow: hidden; border-radius: var(--radius-card);">
<img alt="Kings City Our Brands 1" class="hero__slide is-active" src="<?php $img = get_field('image_4'); echo ($img && is_array($img) && isset($img['url'])) ? esc_url($img['url']) : (is_numeric($img) ? wp_get_attachment_image_url($img, 'full') : get_template_directory_uri() . '/assets/img/placeholder.jpg'); ?>" style="position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; opacity: 1; transition: opacity 1s ease-in-out;"/>
<img alt="Kings City Our Brands 2" class="hero__slide" src="<?php $img = get_field('image_5'); echo ($img && is_array($img) && isset($img['url'])) ? esc_url($img['url']) : (is_numeric($img) ? wp_get_attachment_image_url($img, 'full') : get_template_directory_uri() . '/assets/img/placeholder.jpg'); ?>" style="position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; opacity: 0; transition: opacity 1s ease-in-out;"/>
<img alt="Kings City Our Brands 3" class="hero__slide" src="<?php $img = get_field('image_6'); echo ($img && is_array($img) && isset($img['url'])) ? esc_url($img['url']) : (is_numeric($img) ? wp_get_attachment_image_url($img, 'full') : get_template_directory_uri() . '/assets/img/placeholder.jpg'); ?>" style="position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; opacity: 0; transition: opacity 1s ease-in-out;"/>
</div>
</div>
</div>
</section>
<!-- intro / mission statement -->
<section class="section content-panel section--intro" style="position: relative; overflow: hidden;">
<!-- Background Confetti -->
<div style="position: absolute; pointer-events: none; z-index: 0; top: 10%; left: 5%; color: var(--color-bg-ivory); animation: floatJournal 5s infinite ease-in-out;">
  <svg width="45" height="45" viewBox="0 0 24 24" fill="currentColor" opacity="0.6"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
</div>
<div style="position: absolute; pointer-events: none; z-index: 0; bottom: 10%; right: 5%; color: var(--color-accent-gold); animation: floatJournal 6s infinite ease-in-out reverse;">
  <svg width="40" height="40" viewBox="0 0 24 24" fill="currentColor" opacity="0.5"><path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z"/></svg>
</div>
<div style="position: absolute; pointer-events: none; z-index: 0; top: 40%; right: 2%; color: var(--color-accent-red); animation: floatJournal 4.5s infinite ease-in-out;">
  <svg width="30" height="30" viewBox="0 0 24 24" fill="currentColor" opacity="0.2"><circle cx="12" cy="12" r="10"/></svg>
</div>
<div style="position: absolute; pointer-events: none; z-index: 0; bottom: 15%; left: 8%; color: var(--color-bg-ivory); animation: floatJournal 5.5s infinite ease-in-out;">
  <svg width="35" height="35" viewBox="0 0 24 24" fill="currentColor" opacity="0.4"><path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z"/></svg>
</div>
<div style="position: absolute; pointer-events: none; z-index: 0; top: 15%; right: 20%; color: var(--color-accent-gold); animation: floatJournal 6.5s infinite ease-in-out;">
  <svg width="32" height="32" viewBox="0 0 24 24" fill="currentColor" opacity="0.5"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
</div>

<div class="container grid-12" style="position: relative; z-index: 2;">
<div class="col-12 split" style="align-items: center;">
<div class="split__media">
<img alt="Kings City Growth" src="<?php $img = get_field('image_11'); echo ($img && is_array($img) && isset($img['url'])) ? esc_url($img['url']) : (is_numeric($img) ? wp_get_attachment_image_url($img, 'full') : get_template_directory_uri() . '/assets/img/placeholder.jpg'); ?>" style="width: 100%; height: 100%; object-fit: cover; aspect-ratio: 4/3; border-radius: var(--radius-card);"/>
</div>
<div class="split__content">
<span class="text-overline" style="margin-bottom: var(--space-sm); display: flex; align-items: center; gap: 8px;">
  <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="color: var(--color-primary);"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>
  <?php echo get_field('overline_10'); ?>
</span>
<h2 style="color: var(--color-primary); margin-bottom: var(--space-md);"><?php echo get_field('h2_8'); ?></h2>
<p style="font-size: 1.125rem; color: var(--color-text-muted); line-height: 1.8; margin-bottom: 0;"><?php echo get_field('p_9'); ?></p>
</div>
</div>
</div>
</section>
<!-- top logo banner -->
<section class="logo-banner content-panel" style="position: relative; overflow: hidden; background-color: var(--color-bg-ivory); padding: 4rem 0;">
<!-- Background Confetti for Ivory Section -->
<div style="position: absolute; pointer-events: none; z-index: 0; top: 15%; left: 8%; color: var(--color-bg-pink); animation: floatJournal 5s infinite ease-in-out;">
  <svg width="45" height="45" viewBox="0 0 24 24" fill="currentColor" opacity="0.6"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
</div>
<div style="position: absolute; pointer-events: none; z-index: 0; bottom: 15%; right: 10%; color: var(--color-accent-gold); animation: floatJournal 6s infinite ease-in-out reverse;">
  <svg width="35" height="35" viewBox="0 0 24 24" fill="currentColor" opacity="0.5"><circle cx="12" cy="12" r="10"/></svg>
</div>
<div style="position: absolute; pointer-events: none; z-index: 0; top: 45%; right: 25%; color: var(--color-primary); animation: floatJournal 4.5s infinite ease-in-out;">
  <svg width="30" height="30" viewBox="0 0 24 24" fill="currentColor" opacity="0.4"><path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z"/></svg>
</div>
<div style="position: absolute; pointer-events: none; z-index: 0; bottom: 20%; left: 20%; color: var(--color-bg-pink); animation: floatJournal 5.5s infinite ease-in-out;">
  <svg width="40" height="40" viewBox="0 0 24 24" fill="currentColor" opacity="0.7"><path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z"/></svg>
</div>
<div style="position: absolute; pointer-events: none; z-index: 0; top: 20%; right: 5%; color: var(--color-accent-gold); animation: floatJournal 6.5s infinite ease-in-out;">
  <svg width="38" height="38" viewBox="0 0 24 24" fill="currentColor" opacity="0.4"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
</div>

<div class="container" style="position: relative; z-index: 2;">
<div class="logo-banner__grid">
<div class="logo-banner__item">
<img alt="Kings City" src="<?php $img = get_field('image_13'); echo ($img && is_array($img) && isset($img['url'])) ? esc_url($img['url']) : (is_numeric($img) ? wp_get_attachment_image_url($img, 'full') : get_template_directory_uri() . '/assets/img/placeholder.jpg'); ?>"/>
</div>
<div class="logo-banner__item">
<img alt="Kings Manpower" src="<?php $img = get_field('image_14'); echo ($img && is_array($img) && isset($img['url'])) ? esc_url($img['url']) : (is_numeric($img) ? wp_get_attachment_image_url($img, 'full') : get_template_directory_uri() . '/assets/img/placeholder.jpg'); ?>"/>
</div>
<div class="logo-banner__item">
<img alt="The Social Manila Bakehouse" src="<?php $img = get_field('image_15'); echo ($img && is_array($img) && isset($img['url'])) ? esc_url($img['url']) : (is_numeric($img) ? wp_get_attachment_image_url($img, 'full') : get_template_directory_uri() . '/assets/img/placeholder.jpg'); ?>"/>
</div>
<div class="logo-banner__item">
<img alt="Home Culinary" src="<?php $img = get_field('image_16'); echo ($img && is_array($img) && isset($img['url'])) ? esc_url($img['url']) : (is_numeric($img) ? wp_get_attachment_image_url($img, 'full') : get_template_directory_uri() . '/assets/img/placeholder.jpg'); ?>"/>
</div>
<div class="logo-banner__item">
<img alt="RPS Migration" src="<?php $img = get_field('image_17'); echo ($img && is_array($img) && isset($img['url'])) ? esc_url($img['url']) : (is_numeric($img) ? wp_get_attachment_image_url($img, 'full') : get_template_directory_uri() . '/assets/img/placeholder.jpg'); ?>"/>
</div>
</div>
</div>
</section>
<!-- group of companies interactive list -->
<section class="section content-panel" id="group-companies">
<div class="container">
<!-- Title -->
<div style="margin-bottom: var(--space-md); text-align: center;">
<span class="text-overline"><?php echo get_field('overline_30'); ?></span>
<h2 style="color: var(--color-primary); margin-bottom: 0;"><?php echo get_field('h2_19'); ?></h2>
</div>
<!-- Split Pane Wrapper (Centered horizontally and vertically) -->
<div class="grid-12" style="align-items: start; max-width: 1200px; margin: 0 auto;">
<!-- Left Column: Interactive List (Wider) -->
<div class="col-7">
<ul class="brand-list" id="brand-list">
<li class="brand-list__item is-active" data-target="brand-kingscity" tabindex="0">
<div class="brand-list__info">
<span class="brand-list__title">The Social Manila</span>
<span class="brand-list__badge" style="background: rgba(189, 69, 31, 0.1); color: var(--color-primary);">LIFESTYLE</span>
</div>
<div class="brand-list__icon">
<svg fill="none" height="24" stroke="currentColor" stroke-width="1.5" viewbox="0 0 24 24" width="24"><polyline points="9 18 15 12 9 6"></polyline></svg>
</div>
</li>
<li class="brand-list__item" data-target="brand-manpower" tabindex="0">
<div class="brand-list__info">
<span class="brand-list__title">Kings Manpower</span>
<span class="brand-list__badge" style="background: rgba(251, 203, 119, 0.1); color: var(--color-accent);">OFFSHORING</span>
</div>
<div class="brand-list__icon">
<svg fill="none" height="24" stroke="currentColor" stroke-width="1.5" viewbox="0 0 24 24" width="24"><polyline points="9 18 15 12 9 6"></polyline></svg>
</div>
</li>
<li class="brand-list__item" data-target="brand-bakehouse" tabindex="0">
<div class="brand-list__info">
<span class="brand-list__title">The Social Manila</span>
<span class="brand-list__badge" style="background: rgba(189, 69, 31, 0.1); color: var(--color-primary);">BAKESHOP</span>
</div>
<div class="brand-list__icon">
<svg fill="none" height="24" stroke="currentColor" stroke-width="1.5" viewbox="0 0 24 24" width="24"><polyline points="9 18 15 12 9 6"></polyline></svg>
</div>
</li>
<li class="brand-list__item" data-target="brand-homeculinary" tabindex="0">
<div class="brand-list__info">
<span class="brand-list__title">Home Culinary</span>
<span class="brand-list__badge" style="background: rgba(189, 69, 31, 0.1); color: var(--color-primary);">CULINARY SCHOOL</span>
</div>
<div class="brand-list__icon">
<svg fill="none" height="24" stroke="currentColor" stroke-width="1.5" viewbox="0 0 24 24" width="24"><polyline points="9 18 15 12 9 6"></polyline></svg>
</div>
</li>
<li class="brand-list__item" data-target="brand-rps" tabindex="0">
<div class="brand-list__info">
<span class="brand-list__title">RPS Migration</span>
<span class="brand-list__badge" style="background: rgba(251, 203, 119, 0.1); color: var(--color-accent);">MIGRATION</span>
</div>
<div class="brand-list__icon">
<svg fill="none" height="24" stroke="currentColor" stroke-width="1.5" viewbox="0 0 24 24" width="24"><polyline points="9 18 15 12 9 6"></polyline></svg>
</div>
</li>
</ul>
</div>
<!-- Right Column: Details Pane -->
<div class="col-5 brand-details-container" style="padding-left: var(--space-xl); padding-top: 1.25rem;">
<div class="brand-detail is-active" id="brand-kingscity">
<h3 style="color: var(--color-primary); margin-bottom: var(--space-md); text-transform: uppercase; letter-spacing: 0.05em;"><?php echo get_field('h3_20'); ?></h3>
<p style="color: var(--color-text-muted); font-size: 1rem; line-height: 1.6; margin-bottom: var(--space-lg);"><?php echo get_field('p_25'); ?></p>
<a class="btn btn--outline" href="https://kingscity.com.ph/" rel="noopener noreferrer" style="padding: 0.75rem 2rem;" target="_blank">Learn More</a>
</div>
<div class="brand-detail" id="brand-manpower">
<h3 style="color: var(--color-primary); margin-bottom: var(--space-md); text-transform: uppercase; letter-spacing: 0.05em;"><?php echo get_field('h3_21'); ?></h3>
<p style="color: var(--color-text-muted); font-size: 1rem; line-height: 1.6; margin-bottom: var(--space-lg);"><?php echo get_field('p_26'); ?></p>
<a class="btn btn--outline" href="https://kings-group-ph.netlify.app/" rel="noopener noreferrer" style="padding: 0.75rem 2rem;" target="_blank">Learn More</a>
</div>
<div class="brand-detail" id="brand-bakehouse">
<h3 style="color: var(--color-primary); margin-bottom: var(--space-md); text-transform: uppercase; letter-spacing: 0.05em;"><?php echo get_field('h3_22'); ?></h3>
<p style="color: var(--color-text-muted); font-size: 1rem; line-height: 1.6; margin-bottom: var(--space-lg);"><?php echo get_field('p_27'); ?></p>
<a class="btn btn--outline" href="https://socialmanilabakeshop.netlify.app/?fbclid=IwY2xjawR3um5leHRuA2FlbQIxMABicmlkETF0N1VLUnQ2Ylp0a3ZVSEZQc3J0YwZhcHBfaWQQMjIyMDM5MTc4ODIwMDg5MgABHq67pr7XXxo8nhR7GuE3k3l9kxwUsFrbKAB3xKN-59K9ZE2IJefpdhY5x97d_aem_YWdncwDQSlsaL4fMOQXRGuKfyOXL&amp;brid=YWdncwGD5GWCmPLegsp9eyuuRT5q" rel="noopener noreferrer" style="padding: 0.75rem 2rem;" target="_blank">Learn More</a>
</div>
<div class="brand-detail" id="brand-homeculinary">
<h3 style="color: var(--color-primary); margin-bottom: var(--space-md); text-transform: uppercase; letter-spacing: 0.05em;"><?php echo get_field('h3_23'); ?></h3>
<p style="color: var(--color-text-muted); font-size: 1rem; line-height: 1.6; margin-bottom: var(--space-lg);"><?php echo get_field('p_28'); ?></p>
<a class="btn btn--outline" href="https://homeculinaryschool.com/" rel="noopener noreferrer" style="padding: 0.75rem 2rem;" target="_blank">Learn More</a>
</div>
<div class="brand-detail" id="brand-rps">
<h3 style="color: var(--color-primary); margin-bottom: var(--space-md); text-transform: uppercase; letter-spacing: 0.05em;"><?php echo get_field('h3_24'); ?></h3>
<p style="color: var(--color-text-muted); font-size: 1rem; line-height: 1.6; margin-bottom: var(--space-lg);"><?php echo get_field('p_29'); ?></p>
<a class="btn btn--outline" href="https://rpsmigration.com.au/" rel="noopener noreferrer" style="padding: 0.75rem 2rem;" target="_blank">Learn More</a>
</div>
</div>
</div> <!-- End split pane wrapper -->
</div>
</section>
<!-- membership perks section -->
<section class="section content-panel section--pass" style="position: relative; overflow: hidden;">
<!-- Background floating icons (Ivory optimized) -->
<style>
@keyframes floatSoft { 0% { transform: translateY(0px) rotate(0deg); } 50% { transform: translateY(-10px) rotate(5deg); } 100% { transform: translateY(0px) rotate(0deg); } }
@keyframes pulseSoft { 0% { transform: scale(1); opacity: 0.3; } 50% { transform: scale(1.1); opacity: 0.6; } 100% { transform: scale(1); opacity: 0.3; } }
.pass-bg-icon { position: absolute; pointer-events: none; z-index: 0; }
</style>
<div class="pass-bg-icon" style="top: 10%; left: 5%; color: var(--color-secondary); opacity: 0.8; animation: pulseSoft 4s infinite ease-in-out;">
<svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
<polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
</svg>
</div>
<div class="pass-bg-icon" style="top: 15%; right: 8%; color: var(--color-accent-red); opacity: 0.2; animation: floatSoft 5s infinite ease-in-out;">
<svg width="30" height="30" viewBox="0 0 24 24" fill="currentColor">
<circle cx="12" cy="12" r="10"></circle>
</svg>
</div>
<div class="pass-bg-icon" style="bottom: 15%; left: 8%; color: var(--color-accent-gold); opacity: 0.5; animation: floatSoft 6s infinite ease-in-out;">
<svg width="50" height="50" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
<path d="M4 12c2 0 2-4 4-4s2 4 4 4 2-4 4-4 2 4 4 4"></path>
</svg>
</div>
<div class="pass-bg-icon" style="bottom: 10%; right: 5%; color: var(--color-primary); opacity: 0.2; animation: pulseSoft 5.5s infinite ease-in-out;">
<svg width="40" height="40" viewBox="0 0 24 24" fill="currentColor">
<path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
</svg>
</div>
<!-- /Background floating icons -->
<div class="container grid-12" style="position: relative; z-index: 1;">
<div class="col-12 split">
<div class="split__content">
<span class="text-overline" style="display: block; margin-bottom: var(--space-sm);"><?php echo get_field('overline_34'); ?></span>
<h2 style="color: var(--color-primary); margin-bottom: var(--space-md);"><?php echo get_field('h2_32'); ?></h2>
<p style="color: var(--color-text-muted); margin-bottom: var(--space-lg);"><?php echo get_field('p_33'); ?></p>
<ul style="display:flex; flex-direction:column; gap:1.25rem; color: var(--color-text-muted); list-style: none; padding: 0; text-align: left;">
<li style="display:flex; align-items:center; gap:1rem;">
<div style="background-color: var(--color-secondary); color: var(--color-accent-red); width: 44px; height: 44px; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
<svg fill="none" height="22" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" viewbox="0 0 24 24" width="22">
<path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
<polyline points="9 22 9 12 15 12 15 22"></polyline>
</svg>
</div>
<span style="font-size: 0.95rem; font-weight: 600;">A dedicated home location 24/7 access</span>
</li>
<li style="display:flex; align-items:center; gap:1rem;">
<div style="background-color: var(--color-secondary); color: var(--color-accent-gold); width: 44px; height: 44px; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
<svg fill="none" height="22" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" viewbox="0 0 24 24" width="22">
<rect height="18" rx="2" ry="2" width="18" x="3" y="3"></rect>
<line x1="3" x2="21" y1="9" y2="9"></line>
<line x1="9" x2="9" y1="21" y2="9"></line>
</svg>
</div>
<span style="font-size: 0.95rem; font-weight: 600;">Meeting, conference, training and workshop rooms</span>
</li>
<li style="display:flex; align-items:center; gap:1rem;">
<div style="background-color: var(--color-secondary); color: var(--color-primary); width: 44px; height: 44px; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
<svg fill="none" height="22" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" viewbox="0 0 24 24" width="22">
<polygon points="23 7 16 12 23 17 23 7"></polygon>
<rect height="14" rx="2" ry="2" width="15" x="1" y="5"></rect>
</svg>
</div>
<span style="font-size: 0.95rem; font-weight: 600;">Event spaces, podcast studios, and photography studios</span>
</li>
<li style="display:flex; align-items:center; gap:1rem;">
<div style="background-color: var(--color-secondary); color: var(--color-accent-red); width: 44px; height: 44px; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
<svg fill="none" height="22" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" viewbox="0 0 24 24" width="22">
<path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path>
<line x1="7" x2="7.01" y1="7" y2="7"></line>
</svg>
</div>
<span style="font-size: 0.95rem; font-weight: 600;">Premium Gym access &amp; Kings Club wellness program</span>
</li>
<li style="display:flex; align-items:center; gap:1rem;">
<div style="background-color: var(--color-secondary); color: var(--color-accent-gold); width: 44px; height: 44px; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
<svg fill="none" height="22" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" viewbox="0 0 24 24" width="22">
<path d="M18 8h1a4 4 0 0 1 0 8h-1"></path>
<path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"></path>
<line x1="6" x2="6" y1="1" y2="4"></line>
<line x1="10" x2="10" y1="1" y2="4"></line>
<line x1="14" x2="14" y1="1" y2="4"></line>
</svg>
</div>
<span style="font-size: 0.95rem; font-weight: 600;">Exclusive discounts at our in-house coffee shops</span>
</li>
</ul>
</div>
<div class="split__media">
<!-- placeholder: a membership card on a desk or coffee shop setting -->
<img alt="Kings City Membership Access" src="<?php $img = get_field('image_35'); echo ($img && is_array($img) && isset($img['url'])) ? esc_url($img['url']) : (is_numeric($img) ? wp_get_attachment_image_url($img, 'full') : get_template_directory_uri() . '/assets/img/placeholder.jpg'); ?>" style="width: 100%; height: 100%; object-fit: cover; aspect-ratio: 4/3; border-radius: var(--radius-card);"/>
</div>
</div>
</div>
</section>
<!-- locations gallery carousel -->
<section class="section content-panel section--gallery gallery-theme-pink" style="position: relative; padding: var(--space-lg) 0 var(--space-2xl) 0; overflow: hidden;">
<!-- Background Confetti -->
<div class="gallery-bg-icon" style="top: 10%; right: 15%; color: var(--color-bg-ivory); animation: floatJournal 4.5s infinite ease-in-out;">
  <svg width="45" height="45" viewBox="0 0 24 24" fill="currentColor" opacity="0.3"><path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z"/></svg>
</div>
<div class="gallery-bg-icon" style="bottom: 15%; left: 10%; color: #BD451F; animation: floatJournal 6s infinite ease-in-out reverse;">
  <svg width="55" height="55" viewBox="0 0 24 24" fill="currentColor" opacity="0.2"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
</div>
<div class="gallery-bg-icon" style="top: 50%; left: 3%; color: var(--color-accent-gold); animation: floatJournal 5.5s infinite ease-in-out;">
  <svg width="30" height="30" viewBox="0 0 24 24" fill="currentColor" opacity="0.4"><circle cx="12" cy="12" r="10"/></svg>
</div>

<!-- Heading -->
<div class="container" style="position: relative; z-index: 2;">
  <div style="text-align: center; margin-bottom: var(--space-xl);">
    <h2 class="gallery-heading" style="margin-bottom: 0; font-size: clamp(2rem, 4vw, 3rem); font-weight: 700;"><?php $heading = get_field('section_txt_gallery_heading'); echo $heading ? $heading : 'Virtual Tour'; ?></h2>
  </div>
</div>

<button aria-label="Previous image" class="gallery-nav gallery-nav--prev" onclick="scrollGallery(-1)">
<svg fill="none" height="20" stroke="currentColor" stroke-width="2" viewbox="0 0 24 24" width="20">
<polyline points="15 18 9 12 15 6"></polyline>
</svg>
</button>
<div class="gallery-carousel" id="gallery-carousel">
<!-- original set -->
<div class="gallery-card">
<img alt="Kings Club Makati" src="<?php $img = get_field('image_37'); echo ($img && is_array($img) && isset($img['url'])) ? esc_url($img['url']) : (is_numeric($img) ? wp_get_attachment_image_url($img, 'full') : get_template_directory_uri() . '/assets/img/placeholder.jpg'); ?>" style="width:100%; height:100%; object-fit:cover;"/>
</div>
<div class="gallery-card">
<img alt="Kings Club BGC" src="<?php $img = get_field('image_38'); echo ($img && is_array($img) && isset($img['url'])) ? esc_url($img['url']) : (is_numeric($img) ? wp_get_attachment_image_url($img, 'full') : get_template_directory_uri() . '/assets/img/placeholder.jpg'); ?>" style="width:100%; height:100%; object-fit:cover;"/>
</div>
<div class="gallery-card">
<img alt="Kings Club Ortigas" src="<?php $img = get_field('image_39'); echo ($img && is_array($img) && isset($img['url'])) ? esc_url($img['url']) : (is_numeric($img) ? wp_get_attachment_image_url($img, 'full') : get_template_directory_uri() . '/assets/img/placeholder.jpg'); ?>" style="width:100%; height:100%; object-fit:cover;"/>
</div>
<div class="gallery-card">
<img alt="Kings Club Alabang" src="<?php $img = get_field('image_40'); echo ($img && is_array($img) && isset($img['url'])) ? esc_url($img['url']) : (is_numeric($img) ? wp_get_attachment_image_url($img, 'full') : get_template_directory_uri() . '/assets/img/placeholder.jpg'); ?>" style="width:100%; height:100%; object-fit:cover;"/>
</div>
<div class="gallery-card">
<img alt="Kings Club Quezon City" src="<?php $img = get_field('image_41'); echo ($img && is_array($img) && isset($img['url'])) ? esc_url($img['url']) : (is_numeric($img) ? wp_get_attachment_image_url($img, 'full') : get_template_directory_uri() . '/assets/img/placeholder.jpg'); ?>" style="width:100%; height:100%; object-fit:cover;"/>
</div>
<div class="gallery-card">
<img alt="Kings Club Pasay" src="<?php $img = get_field('image_42'); echo ($img && is_array($img) && isset($img['url'])) ? esc_url($img['url']) : (is_numeric($img) ? wp_get_attachment_image_url($img, 'full') : get_template_directory_uri() . '/assets/img/placeholder.jpg'); ?>" style="width:100%; height:100%; object-fit:cover;"/>
</div>
<!-- duplicated set for infinite loop -->
<div class="gallery-card">
<img alt="Kings Club Makati" src="<?php $img = get_field('image_43'); echo ($img && is_array($img) && isset($img['url'])) ? esc_url($img['url']) : (is_numeric($img) ? wp_get_attachment_image_url($img, 'full') : get_template_directory_uri() . '/assets/img/placeholder.jpg'); ?>" style="width:100%; height:100%; object-fit:cover;"/>
</div>
<div class="gallery-card">
<img alt="Kings Club BGC" src="<?php $img = get_field('image_44'); echo ($img && is_array($img) && isset($img['url'])) ? esc_url($img['url']) : (is_numeric($img) ? wp_get_attachment_image_url($img, 'full') : get_template_directory_uri() . '/assets/img/placeholder.jpg'); ?>" style="width:100%; height:100%; object-fit:cover;"/>
</div>
<div class="gallery-card">
<img alt="Kings Club Ortigas" src="<?php $img = get_field('image_45'); echo ($img && is_array($img) && isset($img['url'])) ? esc_url($img['url']) : (is_numeric($img) ? wp_get_attachment_image_url($img, 'full') : get_template_directory_uri() . '/assets/img/placeholder.jpg'); ?>" style="width:100%; height:100%; object-fit:cover;"/>
</div>
<div class="gallery-card">
<img alt="Kings Club Alabang" src="<?php $img = get_field('image_46'); echo ($img && is_array($img) && isset($img['url'])) ? esc_url($img['url']) : (is_numeric($img) ? wp_get_attachment_image_url($img, 'full') : get_template_directory_uri() . '/assets/img/placeholder.jpg'); ?>" style="width:100%; height:100%; object-fit:cover;"/>
</div>
<div class="gallery-card">
<img alt="Kings Club Quezon City" src="<?php $img = get_field('image_47'); echo ($img && is_array($img) && isset($img['url'])) ? esc_url($img['url']) : (is_numeric($img) ? wp_get_attachment_image_url($img, 'full') : get_template_directory_uri() . '/assets/img/placeholder.jpg'); ?>" style="width:100%; height:100%; object-fit:cover;"/>
</div>
<div class="gallery-card">
<img alt="Kings Club Pasay" src="<?php $img = get_field('image_48'); echo ($img && is_array($img) && isset($img['url'])) ? esc_url($img['url']) : (is_numeric($img) ? wp_get_attachment_image_url($img, 'full') : get_template_directory_uri() . '/assets/img/placeholder.jpg'); ?>" style="width:100%; height:100%; object-fit:cover;"/>
</div>
</div>
<button aria-label="Next image" class="gallery-nav gallery-nav--next" onclick="scrollGallery(1)">
<svg fill="none" height="20" stroke="currentColor" stroke-width="2" viewbox="0 0 24 24" width="20">
<polyline points="9 18 15 12 9 6"></polyline>
</svg>
</button>
<script>
        // Gallery Auto-Scroll & Manual Controls with Seamless Loop
        const gallery = document.getElementById('gallery-carousel');
        let autoScrollInterval;

        function getScrollAmount() {
          const card = gallery.querySelector('.gallery-card');
          return card ? card.clientWidth + parseInt(getComputedStyle(gallery).gap || 0) : 320;
        }

        function scrollGallery(direction) {
          if (!gallery) return;
          const scrollAmount = getScrollAmount();
          gallery.style.scrollBehavior = 'smooth';
          gallery.scrollBy({ left: scrollAmount * direction });
          resetAutoScroll();
        }

        function startAutoScroll() {
          if (!gallery) return;
          autoScrollInterval = setInterval(() => {
            const scrollAmount = getScrollAmount();
            
            // If scrolled halfway through the duplicated content, instantly reset to start
            if (gallery.scrollLeft >= gallery.scrollWidth / 2) {
              gallery.style.scrollBehavior = 'auto'; // Instant jump
              gallery.scrollLeft = 0;
              
              // Force reflow then smooth scroll to next item
              void gallery.offsetWidth; 
              gallery.style.scrollBehavior = 'smooth';
              gallery.scrollBy({ left: scrollAmount });
            } else {
              gallery.style.scrollBehavior = 'smooth';
              gallery.scrollBy({ left: scrollAmount });
            }
          }, 3500);
        }

        function resetAutoScroll() {
          clearInterval(autoScrollInterval);
          startAutoScroll();
        }

        if (gallery) {
          gallery.addEventListener('mouseenter', () => clearInterval(autoScrollInterval));
          gallery.addEventListener('mouseleave', startAutoScroll);
          
          gallery.addEventListener('touchstart', () => clearInterval(autoScrollInterval));
          gallery.addEventListener('touchend', startAutoScroll);

          startAutoScroll();
        }
      </script>
</section>
</main>
<script>
        // Gallery Auto-Scroll & Manual Controls with Seamless Loop
        const gallery = document.getElementById('gallery-carousel');
        let autoScrollInterval;

        function getScrollAmount() {
          const card = gallery.querySelector('.gallery-card');
          return card ? card.clientWidth + parseInt(getComputedStyle(gallery).gap || 0) : 320;
        }

        function scrollGallery(direction) {
          if (!gallery) return;
          const scrollAmount = getScrollAmount();
          gallery.style.scrollBehavior = 'smooth';
          gallery.scrollBy({ left: scrollAmount * direction });
          resetAutoScroll();
        }

        function startAutoScroll() {
          if (!gallery) return;
          autoScrollInterval = setInterval(() => {
            const scrollAmount = getScrollAmount();
            
            // If scrolled halfway through the duplicated content, instantly reset to start
            if (gallery.scrollLeft >= gallery.scrollWidth / 2) {
              gallery.style.scrollBehavior = 'auto'; // Instant jump
              gallery.scrollLeft = 0;
              
              // Force reflow then smooth scroll to next item
              void gallery.offsetWidth; 
              gallery.style.scrollBehavior = 'smooth';
              gallery.scrollBy({ left: scrollAmount });
            } else {
              gallery.style.scrollBehavior = 'smooth';
              gallery.scrollBy({ left: scrollAmount });
            }
          }, 3500);
        }

        function resetAutoScroll() {
          clearInterval(autoScrollInterval);
          startAutoScroll();
        }

        if (gallery) {
          gallery.addEventListener('mouseenter', () => clearInterval(autoScrollInterval));
          gallery.addEventListener('mouseleave', startAutoScroll);
          
          gallery.addEventListener('touchstart', () => clearInterval(autoScrollInterval));
          gallery.addEventListener('touchend', startAutoScroll);

          startAutoScroll();
        }
      </script>
<script>
    // Hero Slider Auto-play
    const slides = document.querySelectorAll('.hero__slide');
    let currentSlide = 0;
    if (slides.length > 0) {
      setInterval(() => {
        slides[currentSlide].style.opacity = '0';
        slides[currentSlide].classList.remove('is-active');
        currentSlide = (currentSlide + 1) % slides.length;
        slides[currentSlide].style.opacity = '1';
        slides[currentSlide].classList.add('is-active');
      }, 4000);
    }

    // Brands Interactive Tabs
    const brandItems = document.querySelectorAll('.brand-list__item');
    const brandDetails = document.querySelectorAll('.brand-detail');

    function updateBrandDetail(item) {
      if (item.classList.contains('is-active')) return;

      // Remove active class from all items and details
      brandItems.forEach(el => el.classList.remove('is-active'));
      brandDetails.forEach(el => {
        el.classList.remove('is-active');
        el.style.opacity = '0';
      });

      // Add active class to hovered/clicked item
      item.classList.add('is-active');

      // Show corresponding detail
      const targetId = item.getAttribute('data-target');
      const targetDetail = document.getElementById(targetId);
      
      if (targetDetail) {
        targetDetail.classList.add('is-active');
        // Slight delay for smooth fade-in
        setTimeout(() => {
          targetDetail.style.opacity = '1';
        }, 50);
      }
    }

    brandItems.forEach(item => {
      // Click interaction
      item.addEventListener('click', () => updateBrandDetail(item));
      
      // Keyboard support
      item.addEventListener('keydown', (e) => {
        if (e.key === 'Enter' || e.key === ' ') {
          e.preventDefault();
          updateBrandDetail(item);
        }
      });
    });
  </script>


<?php get_footer(); ?>
