<?php
if (!defined('ABSPATH')) exit;
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
<span class="text-overline hero__overline"><?php echo esc_html(get_field('overline_3')); ?></span>
<h1 class="hero__title hero__title--inner"><?php $h = esc_html(get_field('h1_1')); if ($h) { $w = explode(' ', trim($h)); echo (count($w) === 3) ? $w[0] . '&nbsp;' . $w[1] . ' ' . $w[2] : $h; } ?></h1>
<p class="hero__subtitle"><?php echo esc_html(get_field('p_2')); ?></p>
<div class="hero__actions hero__actions--index">
<a class="btn" href="#group-companies">
  <?php echo esc_html(get_field('proposed_our_brands_hero_btn_text') ?: 'Discover Our Brands'); ?>
</a>
</div>
</div>
<!-- slider on right -->
<div class="split__media hero__slider" id="hero-slider" style="position: relative; aspect-ratio: 4/3; overflow: hidden; border-radius: var(--radius-card);">
<img alt="Kings City Our Brands 1" class="hero__slide is-active" src="<?php echo kc_img('image_4', 'front-page-img/kings_img02.webp'); ?>" style="position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; opacity: 1; transition: opacity 1s ease-in-out;"/>
<img alt="Kings City Our Brands 2" class="hero__slide" src="<?php echo kc_img('image_5', 'page-our-brands-img/kings-img42.webp'); ?>" style="position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; opacity: 0; transition: opacity 1s ease-in-out;"/>
<img alt="Kings City Our Brands 3" class="hero__slide" src="<?php echo kc_img('image_6', 'page-about-img/kings-img30.webp'); ?>" style="position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; opacity: 0; transition: opacity 1s ease-in-out;"/>
</div>
</div>
</div>
</section>
<!-- intro / mission statement -->
<section class="section content-panel section--intro" style="position: relative; overflow: hidden;">
<!-- Background Confetti -->

          <!-- 1. Star -->
          <!-- 2. Heart -->
          <!-- 3. Star -->
          <!-- 4. Heart -->
          <!-- 5. Star -->
          <div class="container grid-12" style="position: relative; z-index: 2;">
<div class="col-12 split" style="align-items: center;">
<div class="split__media">
<img alt="Kings City Growth" src="<?php echo kc_img('image_11', 'page-our-brands-img/kings-img19.webp'); ?>" style="width: 100%; height: 100%; object-fit: cover; aspect-ratio: 4/3; border-radius: var(--radius-card);"/>
</div>
<div class="split__content">
<span class="text-overline" style="margin-bottom: var(--space-sm); display: flex; align-items: center; gap: 8px;">
  <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="color: var(--color-primary);"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>
  <?php echo esc_html(get_field('overline_10')); ?>
</span>
<h2 style="color: var(--color-primary); margin-bottom: var(--space-md);"><?php echo esc_html(get_field('h2_8')); ?></h2>
<p style="font-size: 1.125rem; color: var(--color-text-muted); line-height: 1.8; margin-bottom: 0;"><?php echo esc_html(get_field('p_9')); ?></p>
</div>
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
<!-- top logo banner -->
<section class="logo-banner content-panel bg-ivory" style="position: relative; overflow: hidden;  padding: 4rem 0;">


<div class="container" style="position: relative; z-index: 2;">
<div class="logo-banner__grid">
<div class="logo-banner__item">
<img alt="Kings City" src="<?php echo kc_img('image_13', 'page-our-brands-img/kings-img84.png'); ?>"/>
</div>
<div class="logo-banner__item">
<img alt="Kings Manpower" src="<?php echo kc_img('image_14', 'page-our-brands-img/kings-img60.png'); ?>"/>
</div>
<div class="logo-banner__item">
<img alt="The Social Manila Bakehouse" src="<?php echo kc_img('image_15', 'page-our-brands-img/kings-img61.png'); ?>"/>
</div>
<div class="logo-banner__item">
<img alt="Home Culinary" src="<?php echo kc_img('image_16', 'page-our-brands-img/kings-img62.png'); ?>"/>
</div>

</div>
</div>
</section>
<!-- group of companies interactive list -->
<section class="section content-panel" id="group-companies" style="position: relative; overflow: hidden;">

<!-- Background Floating Icons -->

          <!-- 1. Star -->
          <!-- 2. Heart -->
          <!-- 3. Star -->
          <!-- 4. Heart -->
          <!-- 5. Star -->
          <div class="container" style="position: relative; z-index: 2;">
<!-- Title -->
<div style="margin-bottom: var(--space-md); text-align: center;">
<span class="text-overline"><?php echo esc_html(get_field('overline_30')); ?></span>
<h2 style="color: var(--color-primary); margin-bottom: 0;"><?php echo esc_html(get_field('h2_19')); ?></h2>
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
<span class="brand-list__title">The Social Manila</span>
<span class="brand-list__badge" style="background: rgba(251, 203, 119, 0.1); color: var(--color-accent);">BAKESHOP</span>
</div>
<div class="brand-list__icon">
<svg fill="none" height="24" stroke="currentColor" stroke-width="1.5" viewbox="0 0 24 24" width="24"><polyline points="9 18 15 12 9 6"></polyline></svg>
</div>
</li>
<li class="brand-list__item" data-target="brand-bakehouse" tabindex="0">
<div class="brand-list__info">
<span class="brand-list__title">Kings Manpower</span>
<span class="brand-list__badge" style="background: rgba(189, 69, 31, 0.1); color: var(--color-primary);">OFFSHORING</span>
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

</ul>
</div>
<!-- Right Column: Details Pane -->
<div class="col-5 brand-details-container" style="padding-left: var(--space-xl); padding-top: 1.25rem;">
<div class="brand-detail is-active" id="brand-kingscity">
<h3 style="color: var(--color-primary); margin-bottom: var(--space-md); text-transform: uppercase; letter-spacing: 0.05em;"><?php echo esc_html(get_field('h3_20')); ?></h3>
<p style="color: var(--color-text-muted); font-size: 1rem; line-height: 1.6; margin-bottom: var(--space-lg);"><?php echo esc_html(get_field('p_25')); ?></p>
<a class="btn btn--outline" href="<?php echo esc_url(get_field('proposed_brand_1_url') ?: 'https://kingscity.com.ph/'); ?>" rel="noopener noreferrer" style="padding: 0.75rem 2rem;" target="_blank">Learn More</a>
</div>
<div class="brand-detail" id="brand-manpower">
<h3 style="color: var(--color-primary); margin-bottom: var(--space-md); text-transform: uppercase; letter-spacing: 0.05em;"><?php echo esc_html(get_field('h3_21')); ?></h3>
<p style="color: var(--color-text-muted); font-size: 1rem; line-height: 1.6; margin-bottom: var(--space-lg);"><?php echo esc_html(get_field('p_26')); ?></p>
<a class="btn btn--outline" href="<?php echo esc_url(get_field('proposed_brand_2_url') ?: 'https://thesocialmanilabakehouse.com/'); ?>" rel="noopener noreferrer" style="padding: 0.75rem 2rem;" target="_blank">Learn More</a>
</div>
<div class="brand-detail" id="brand-bakehouse">
<h3 style="color: var(--color-primary); margin-bottom: var(--space-md); text-transform: uppercase; letter-spacing: 0.05em;"><?php echo esc_html(get_field('h3_22')); ?></h3>
<p style="color: var(--color-text-muted); font-size: 1rem; line-height: 1.6; margin-bottom: var(--space-lg);"><?php echo esc_html(get_field('p_27')); ?></p>
<a class="btn btn--outline" href="<?php echo esc_url(get_field('proposed_brand_3_url') ?: 'https://kings-group-ph.netlify.app/'); ?>" rel="noopener noreferrer" style="padding: 0.75rem 2rem;" target="_blank">Learn More</a>
</div>
<div class="brand-detail" id="brand-homeculinary">
<h3 style="color: var(--color-primary); margin-bottom: var(--space-md); text-transform: uppercase; letter-spacing: 0.05em;"><?php echo esc_html(get_field('h3_23')); ?></h3>
<p style="color: var(--color-text-muted); font-size: 1rem; line-height: 1.6; margin-bottom: var(--space-lg);"><?php echo esc_html(get_field('p_28')); ?></p>
<a class="btn btn--outline" href="<?php echo esc_url(get_field('proposed_brand_4_url') ?: 'https://homeculinaryschool.com/'); ?>" rel="noopener noreferrer" style="padding: 0.75rem 2rem;" target="_blank">Learn More</a>
</div>

</div>
</div> <!-- End split pane wrapper -->
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
<!-- membership perks section -->
<section class="section content-panel section--pass bg-ivory" style="position: relative; overflow: hidden;">
<!-- Background floating icons (Ivory optimized) -->
 
<!-- /Background floating icons -->

          <!-- 1. Star -->
          <!-- 2. Heart -->
          <!-- 3. Star -->
          <!-- 4. Heart -->
          <!-- 5. Star -->
          <div class="container grid-12" style="position: relative; z-index: 1;">
<div class="col-12 split">
<div class="split__content">
<span class="text-overline" style="display: block; margin-bottom: var(--space-sm);"><?php echo esc_html(get_field('overline_34')); ?></span>
<h2 style="color: var(--color-primary); margin-bottom: var(--space-md);"><?php echo esc_html(get_field('h2_32')); ?></h2>
<p style="color: var(--color-text-muted); margin-bottom: var(--space-lg);"><?php echo esc_html(get_field('p_33')); ?></p>
<ul class="perks-list" style="color: var(--color-text-muted);">
<li>
<div class="perk-bubble">
<svg fill="none" height="22" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" viewbox="0 0 24 24" width="22">
<path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
<polyline points="9 22 9 12 15 12 15 22"></polyline>
</svg>
</div>
<span style="font-size: 0.95rem; font-weight: 600;"><?php echo esc_html(get_field('perk_1') ?: 'A dedicated home location 24/7 access'); ?></span>
</li>
<li>
<div class="perk-bubble">
<svg fill="none" height="22" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" viewbox="0 0 24 24" width="22">
<rect height="18" rx="2" ry="2" width="18" x="3" y="3"></rect>
<line x1="3" x2="21" y1="9" y2="9"></line>
<line x1="9" x2="9" y1="21" y2="9"></line>
</svg>
</div>
<span style="font-size: 0.95rem; font-weight: 600;"><?php echo esc_html(get_field('perk_2') ?: 'Meeting, conference, training and workshop rooms'); ?></span>
</li>
<li>
<div class="perk-bubble">
<svg fill="none" height="22" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" viewbox="0 0 24 24" width="22">
<polygon points="23 7 16 12 23 17 23 7"></polygon>
<rect height="14" rx="2" ry="2" width="15" x="1" y="5"></rect>
</svg>
</div>
<span style="font-size: 0.95rem; font-weight: 600;"><?php echo esc_html(get_field('perk_3') ?: 'Event spaces, podcast studios, and photography studios'); ?></span>
</li>
<li>
<div class="perk-bubble">
<svg fill="none" height="22" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" viewbox="0 0 24 24" width="22">
<path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path>
<line x1="7" x2="7.01" y1="7" y2="7"></line>
</svg>
</div>
<span style="font-size: 0.95rem; font-weight: 600;"><?php echo esc_html(get_field('perk_4') ?: 'Premium Gym access &amp; Kings Club wellness program'); ?></span>
</li>
<li>
<div class="perk-bubble">
<svg fill="none" height="22" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" viewbox="0 0 24 24" width="22">
<path d="M18 8h1a4 4 0 0 1 0 8h-1"></path>
<path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"></path>
<line x1="6" x2="6" y1="1" y2="4"></line>
<line x1="10" x2="10" y1="1" y2="4"></line>
<line x1="14" x2="14" y1="1" y2="4"></line>
</svg>
</div>
<span style="font-size: 0.95rem; font-weight: 600;"><?php echo esc_html(get_field('perk_5') ?: 'Exclusive discounts at our in-house coffee shops'); ?></span>
</li>
</ul>
</div>
<div class="split__media">
<!-- placeholder: a membership card on a desk or coffee shop setting -->
<img alt="Kings City Membership Access" src="<?php echo kc_img('image_35', 'page-our-brands-img/kings_img07.webp'); ?>" style="width: 100%; height: 100%; object-fit: cover; aspect-ratio: 4/3; border-radius: var(--radius-card);"/>
</div>
</div>
</div>


          <!-- 1. Star -->
          <div class="floating-bg-icon anim-float-fast" style="top: 10%; right: 8%; color: var(--color-primary);"><svg viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" /></svg></div>
          <!-- 2. Heart -->
          <div class="floating-bg-icon anim-pulse" style="bottom: 15%; left: 8%; color: var(--color-accent-red);"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg></div>
          <!-- 3. Star -->
          <div class="floating-bg-icon anim-float-fast" style="top: 25%; right: 40%; color: var(--color-bg-ivory);"><svg viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" /></svg></div>
          <!-- 4. Heart -->
          <div class="floating-bg-icon anim-pulse" style="bottom: 10%; right: 10%; color: var(--color-primary);"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg></div>
          <!-- 5. Star -->
          <div class="floating-bg-icon anim-float-fast" style="top: 15%; left: 12%; color: var(--color-accent-red);"><svg viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" /></svg></div>
          <!-- 6. Heart -->
          <div class="floating-bg-icon anim-pulse" style="top: 45%; left: 25%; color: var(--color-bg-ivory);"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg></div>

</section>
<!-- locations gallery carousel -->
<section class="section content-panel section--gallery gallery-theme-pink" style="position: relative; padding: var(--space-lg) 0 var(--space-2xl) 0; overflow: hidden;">
<!-- Background Confetti -->
<!-- Heading -->

          <!-- 1. Star -->
          <!-- 2. Heart -->
          <!-- 3. Star -->
          <!-- 4. Heart -->
          <!-- 5. Star -->
          <div class="container" style="position: relative; z-index: 2;">
  <div style="text-align: center; margin-bottom: var(--space-xl);">
    <h2 class="gallery-heading" style="margin-bottom: 0; font-size: clamp(2rem, 4vw, 3rem); font-weight: 700;"><?php echo esc_html(get_field('section_txt_gallery_heading') ?: 'Virtual Tour'); ?></h2>
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
<img alt="Kings Club Makati" src="<?php echo kc_img('section_img_46', 'front-page-img/kings-img53.webp'); ?>" style="width:100%; height:100%; object-fit:cover;" loading="lazy"/>
</div>
<div class="gallery-card">
<img alt="Kings Club BGC" src="<?php echo kc_img('section_img_47', 'front-page-img/kings-img16.webp'); ?>" style="width:100%; height:100%; object-fit:cover;" loading="lazy"/>
</div>
<div class="gallery-card">
<img alt="Kings Club Ortigas" src="<?php echo kc_img('section_img_48', 'front-page-img/kings-img17.webp'); ?>" style="width:100%; height:100%; object-fit:cover;" loading="lazy"/>
</div>
<div class="gallery-card">
<img alt="Kings Club Alabang" src="<?php echo kc_img('section_img_49', 'front-page-img/kings_img06.webp'); ?>" style="width:100%; height:100%; object-fit:cover;" loading="lazy"/>
</div>
<div class="gallery-card">
<img alt="Kings Club Quezon City" src="<?php echo kc_img('section_img_50', 'front-page-img/kings-img40.webp'); ?>" style="width:100%; height:100%; object-fit:cover;" loading="lazy"/>
</div>

<!-- duplicated set for infinite loop -->
<div class="gallery-card">
<img alt="Kings Club Makati" src="<?php echo kc_img('section_img_52', 'front-page-img/kings-img37.webp'); ?>" style="width:100%; height:100%; object-fit:cover;" loading="lazy"/>
</div>
<div class="gallery-card">
<img alt="Kings Club BGC" src="<?php echo kc_img('section_img_53', 'front-page-img/kings-img20.webp'); ?>" style="width:100%; height:100%; object-fit:cover;" loading="lazy"/>
</div>
<div class="gallery-card">
<img alt="Kings Club Ortigas" src="<?php echo kc_img('section_img_54', 'front-page-img/kings_img06.webp'); ?>" style="width:100%; height:100%; object-fit:cover;" loading="lazy"/>
</div>
<div class="gallery-card">
<img alt="Kings Club Alabang" src="<?php echo kc_img('section_img_55', 'front-page-img/kings-img53.webp'); ?>" style="width:100%; height:100%; object-fit:cover;" loading="lazy"/>
</div>
<div class="gallery-card">
<img alt="Kings Club Quezon City" src="<?php echo kc_img('section_img_56', 'front-page-img/kings-img47.webp'); ?>" style="width:100%; height:100%; object-fit:cover;" loading="lazy"/>
</div>
</div>
<button aria-label="Next image" class="gallery-nav gallery-nav--next" onclick="scrollGallery(1)">
<svg fill="none" height="20" stroke="currentColor" stroke-width="2" viewbox="0 0 24 24" width="20">
<polyline points="9 18 15 12 9 6"></polyline>
</svg>
</button>

</section>
</main>
<script>
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
