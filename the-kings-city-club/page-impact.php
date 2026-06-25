<?php
/* Template Name: Impact */
get_header();
?>

<style>
    /* Impact Page Specific Styles — Modeled after The Commons */
    
    /* Legacy section helpers — now superseded by .content-panel alternating rhythm */
    .bg-ivory-section {
      background-color: var(--color-bg-ivory) !important;
    }

    /* REFINED HERO: Centralized and pulled slightly upward */
    .impact-hero {
      padding: calc(var(--space-xl) + 80px) 0 var(--space-xl);
      text-align: center;
    }
    .impact-hero__content {
      max-width: 900px;
      margin: 0 auto;
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: var(--space-md);
    }
    .impact-hero__title {
      font-size: clamp(2.5rem, 5vw, 4.5rem);
      line-height: 1.05;
      margin-bottom: 0.5rem;
      color: var(--color-primary);
      font-family: var(--font-heading);
      letter-spacing: -0.01em;
    }
    .impact-hero__subtitle {
      font-size: 1.125rem;
      color: var(--color-text-muted);
      line-height: 1.7;
      max-width: 650px;
    }

    /* Initiatives Section */
    .section_about-impact-initiatives {
      padding: 100px 0 !important;
    }
    .initiatives-grid-commons {
      display: grid;
      grid-template-columns: repeat(9, 1fr);
      gap: var(--space-md);
      align-items: start;
    }
    .grid-header-initiatives {
      grid-column: span 9;
      margin-bottom: var(--space-sm);
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 0.25rem;
    }
    .grid-header-initiatives h5 {
      font-family: var(--font-heading);
      font-size: 1.1rem;
      color: var(--color-primary);
      text-transform: uppercase;
      letter-spacing: 0.1em;
      margin: 0;
    }
    .impact-section-logo {
      width: 28px;
      height: 28px;
      color: var(--color-accent-red);
    }

    .icon-plus-box {
      grid-column: span 1;
      text-align: center;
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 0.75rem;
    }
    .icon-plus-box svg {
      width: 24px;
      height: 24px;
      color: var(--color-accent-red);
      transition: transform 0.3s ease;
    }
    .icon-plus-box:hover svg {
      transform: translateY(-3px);
    }
    .icon-plus-box p {
      font-size: 0.65rem;
      color: var(--color-text-muted);
      font-weight: 600;
      line-height: 1.2;
      text-transform: uppercase;
      letter-spacing: 0.05em;
    }

    @media (max-width: 1280px) {
      .initiatives-grid-commons { grid-template-columns: repeat(5, 1fr); }
      .grid-header-initiatives { grid-column: span 5; }
    }
    @media (max-width: 1024px) {
      .initiatives-grid-commons {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 2.5rem;
      }
      .grid-header-initiatives {
        width: 100%;
        margin-bottom: 1rem;
      }
      .icon-plus-box {
        width: calc(33.33% - 2.5rem);
        min-width: 140px;
      }
    }
    @media (max-width: 767px) {
      .initiatives-grid-commons {
        gap: 1.5rem;
      }
      .icon-plus-box {
        width: calc(33.33% - 1.5rem);
        min-width: 90px;
      }
    }

    /* Standard Background Image Section Style */
    .section--impact-bg {
      position: relative;
      padding: var(--space-3xl) 0;
      overflow: hidden;
      min-height: 600px;
      display: flex;
      align-items: center;
    }
    .section--impact-bg__media {
      position: absolute;
      inset: 0;
      z-index: 0;
      background-color: var(--color-border-light);
      display: flex;
      align-items: center;
    }
    .section--impact-bg .container {
      position: relative;
      z-index: 1;
    }

    @media (max-width: 1023px) {
      .section--impact-bg .impact-card {
        margin: 0 auto;
      }
    }


    /* Large CDA Placeholder Card */
    .cda-card-large {
      background-color: var(--color-border-light);
      border-radius: var(--radius-card);
      display: flex;
      align-items: center;
      justify-content: center;
      width: 100%;
      max-width: 660px;
      aspect-ratio: 660 / 630;
      padding: clamp(2rem, 5vw, 4rem); 
      position: relative;
    }
    .cda-badge-system {
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 1.5rem;
      text-align: center;
    }
    .cda-badge-label {
      font-size: 0.85rem;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.3em;
      color: var(--color-primary);
    }
    .cda-main-logo {
      width: 180px;
      height: 180px;
      color: var(--color-primary);
    }

    /* Partners Section 3x3 Redesign */
    .partners-section-2-col {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: var(--space-3xl);
      align-items: center;
    }
    @media (max-width: 991px) {
      .partners-section-2-col {
        grid-template-columns: 1fr;
        text-align: center;
      }
    }

    .brand-logos-3x3 {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: var(--space-xl);
      align-items: center;
    }
    .brand-logo-item-3x3 {
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 1rem;
    }
    .brand-logo-item-3x3 img {
      max-width: 100%;
      height: auto;
      max-height: 50px;
      object-fit: contain;
      filter: grayscale(1) opacity(0.6);
      transition: all 0.4s ease;
    }
    .brand-logo-item-3x3 img:hover {
      filter: grayscale(0) opacity(1);
      transform: scale(1.1);
    }

    /* FULL-BLEED SUSTAINABILITY SECTION (No Container) */
    .section_about-impact-conscious {
      display: grid;
      grid-template-columns: 1fr 1fr;
      align-items: center;
      min-height: 700px;
      width: 100%;
      padding: 0; /* No vertical padding to allow full-bleed feel */
      overflow: hidden;
    }
    .impact-conscious__visual {
      background-color: var(--color-bg-white);
      height: 100%;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: var(--space-3xl);
    }
    .impact-conscious__content {
      padding: var(--space-3xl);
      max-width: 600px;
    }
    @media (max-width: 991px) {
      .section_about-impact-conscious {
        grid-template-columns: 1fr;
      }
      .impact-conscious__visual {
        order: 1;
        min-height: 300px;
        padding: var(--space-xl);
      }
      .impact-conscious__content {
        order: 2;
        padding: var(--space-xl);
        text-align: center;
        margin: 0 auto;
      }
    }
    @media (max-width: 767px) {
      .impact-conscious__visual {
        min-height: auto;
        padding: var(--space-md) var(--space-md) 0 var(--space-md);
      }
      .impact-conscious__visual img {
        width: 100%;
        max-width: 350px !important;
      }
      .impact-conscious__content {
        padding: var(--space-md) var(--space-md) var(--space-lg) var(--space-md);
      }
    }

    /* Base Section Style for Standard Cards */
    .impact-section {
      padding: var(--space-3xl) 0;
    }
  </style>

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
</div>
<!-- slider on right -->
<div class="split__media hero__slider" id="hero-slider" style="position: relative; aspect-ratio: 4/3; overflow: hidden; border-radius: var(--radius-card);">
<!-- slide 1 -->
<img alt="Impact 1" class="hero__slide is-active" src="<?php $img = get_field('image_4'); echo ($img && is_array($img) && isset($img['url'])) ? esc_url($img['url']) : (is_numeric($img) ? wp_get_attachment_image_url($img, 'full') : get_template_directory_uri() . '/assets/img/placeholder.jpg'); ?>" style="position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; opacity: 1; transition: opacity 1s ease-in-out;"/>
<!-- slide 2 -->
<img alt="Impact 2" class="hero__slide" src="<?php $img = get_field('image_5'); echo ($img && is_array($img) && isset($img['url'])) ? esc_url($img['url']) : (is_numeric($img) ? wp_get_attachment_image_url($img, 'full') : get_template_directory_uri() . '/assets/img/placeholder.jpg'); ?>" style="position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; opacity: 0; transition: opacity 1s ease-in-out;"/>
<!-- slide 3 -->
<img alt="Impact 3" class="hero__slide" src="<?php $img = get_field('image_6'); echo ($img && is_array($img) && isset($img['url'])) ? esc_url($img['url']) : (is_numeric($img) ? wp_get_attachment_image_url($img, 'full') : get_template_directory_uri() . '/assets/img/placeholder.jpg'); ?>" style="position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; opacity: 0; transition: opacity 1s ease-in-out;"/>
</div>
</div>
</div>
</section>
<!-- initiatives section -->
<section class="section content-panel section_about-impact-initiatives" style="position: relative; overflow: hidden;">
  <!-- Background Floating Icons -->
  <div class="floating-bg-icon anim-float-fast" style="top: 10%; left: 8%; color: var(--color-primary);">
    <svg viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" /></svg>
  </div>
  <div class="floating-bg-icon anim-pulse" style="top: 25%; right: 10%; color: var(--color-accent-gold);">
    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
  </div>
    <div class="floating-bg-icon anim-float-fast" style="bottom: 10%; right: 15%; color: var(--color-primary);">
    <svg viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" /></svg>
  </div>
  <div class="floating-bg-icon anim-pulse" style="bottom: 15%; left: 25%; color: var(--color-accent-gold);">
    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
  </div>
<div class="container" style="position: relative; z-index: 2;">
<div class="initiatives-grid-commons">
<div class="grid-header-initiatives">
<svg class="impact-section-logo" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewbox="0 0 24 24">
<circle cx="12" cy="12" r="10"></circle>
<path d="M12 8l4 4-4 4M8 12h7"></path>
</svg>
<h5>Our Initiatives</h5>
</div>
<div class="icon-plus-box"><svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewbox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg><p><?php echo get_field('p_8'); ?></p></div>
<div class="icon-plus-box"><svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewbox="0 0 24 24"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"></path></svg><p><?php echo get_field('p_9'); ?></p></div>
<div class="icon-plus-box"><svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewbox="0 0 24 24"><polyline points="23 4 23 10 17 10"></polyline><polyline points="1 20 1 14 7 14"></polyline><path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path></svg><p><?php echo get_field('p_10'); ?></p></div>
<div class="icon-plus-box"><svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewbox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg><p><?php echo get_field('p_11'); ?></p></div>
<div class="icon-plus-box"><svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewbox="0 0 24 24"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" x2="12" y1="22.08" y2="12"></line></svg><p><?php echo get_field('p_12'); ?></p></div>
<div class="icon-plus-box"><svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewbox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5z"></path><path d="M2 17l10 5 10-5"></path><path d="M2 12l10 5 10-5"></path></svg><p><?php echo get_field('p_13'); ?></p></div>
<div class="icon-plus-box"><svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewbox="0 0 24 24"><path d="M18 8h1a4 4 0 0 1 0 8h-1"></path><path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"></path><line x1="6" x2="6" y1="1" y2="4"></line><line x1="10" x2="10" y1="1" y2="4"></line><line x1="14" x2="14" y1="1" y2="4"></line></svg><p><?php echo get_field('p_14'); ?></p></div>
<div class="icon-plus-box"><svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewbox="0 0 24 24"><circle cx="5.5" cy="17.5" r="3.5"></circle><circle cx="18.5" cy="17.5" r="3.5"></circle><polyline points="15 6 10 6 10 17.5"></polyline><line x1="15" x2="18.5" y1="6" y2="14"></line><line x1="10" x2="15" y1="11" y2="11"></line></svg><p><?php echo get_field('p_15'); ?></p></div>
<div class="icon-plus-box"><svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewbox="0 0 24 24"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path></svg><p><?php echo get_field('p_16'); ?></p></div>
</div>
</div>
</section>
<!-- great place to work section -->
<section class="section content-panel section--impact-bg">
<div class="section--impact-bg__media">
<img alt="Great Place to Work Background" src="<?php $img = get_field('image_22'); echo ($img && is_array($img) && isset($img['url'])) ? esc_url($img['url']) : (is_numeric($img) ? wp_get_attachment_image_url($img, 'full') : get_template_directory_uri() . '/assets/img/placeholder.jpg'); ?>" style="position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; z-index: 0;"/>
</div>
<div class="container">
<div class="impact-card animate-fadeInLeft" style="background-color: var(--color-bg-ivory); box-shadow: var(--glass-shadow-lg); backdrop-filter: blur(10px); border-radius: var(--radius-card);">
<span class="text-overline"><?php echo get_field('overline_21'); ?></span>
<h2 style="margin-top: 1rem;"><?php echo get_field('h2_18'); ?></h2>
<p><?php echo get_field('p_19'); ?></p>
<p><?php echo get_field('p_20'); ?></p>
<div style="display: flex; align-items: center; gap: var(--space-md); margin-top: var(--space-lg);">
<img alt="Certified" src="<?php echo get_template_directory_uri(); ?>/assets/svg/impact-certified.svg" style="width: 64px; height: 64px;"/>
<span style="font-size: 0.9rem; font-weight: 600; color: var(--color-primary);">Verified Global Standards</span>
</div>
</div>
</div>
</section>
<!-- local empowerment section -->
<section class="section content-panel section--cda" style="position: relative; overflow: hidden;">
  <!-- Background Floating Icons -->
  <div class="floating-bg-icon anim-float-fast" style="top: 10%; left: 8%; color: var(--color-primary);">
    <svg viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" /></svg>
  </div>
  <div class="floating-bg-icon anim-pulse" style="top: 25%; right: 10%; color: var(--color-accent-gold);">
    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
  </div>
    <div class="floating-bg-icon anim-float-fast" style="bottom: 10%; right: 15%; color: var(--color-primary);">
    <svg viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" /></svg>
  </div>
  <div class="floating-bg-icon anim-pulse" style="bottom: 15%; left: 25%; color: var(--color-accent-gold);">
    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
  </div>
<div class="container grid-12" style="position: relative; z-index: 2;">
<div class="col-12 split">
<div class="split__content animate-fadeInLeft">
<span class="text-overline"><?php echo get_field('overline_27'); ?></span>
<h2 style="margin-top: 1rem; margin-bottom: var(--space-md);"><?php echo get_field('h2_24'); ?></h2>
<p style="font-size: 1.125rem; color: var(--color-text-muted); line-height: 1.8;"><?php echo get_field('p_25'); ?></p>
<p style="color: var(--color-text-muted); line-height: 1.8;"><?php echo get_field('p_26'); ?></p>
</div>
<div class="split__media animate-fadeInRight">
<div class="cda-card-large" style="overflow: hidden; position: relative;">
<!-- Background Image -->
<img alt="CDA Registered Cooperative" src="<?php $img = get_field('image_28'); echo ($img && is_array($img) && isset($img['url'])) ? esc_url($img['url']) : (is_numeric($img) ? wp_get_attachment_image_url($img, 'full') : get_template_directory_uri() . '/assets/img/placeholder.jpg'); ?>" style="position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; z-index: 0;"/>
<!-- Original text and badge -->
<div class="cda-badge-system" style="position: relative; z-index: 2;">
<span class="cda-badge-label">Certified</span>
<svg class="cda-main-logo" fill="none" viewbox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
<path d="M50 5 L85 25 V75 L50 95 L15 75 V25 L50 5Z" stroke="currentColor" stroke-width="2.5"></path>
<text fill="currentColor" font-family="Butler" font-size="26" font-weight="900" text-anchor="middle" x="50" y="58">CDA</text>
<circle cx="50" cy="50" r="44" stroke="currentColor" stroke-dasharray="6 6" stroke-width="1.5"></circle>
</svg>
<span class="cda-badge-label">Cooperative</span>
</div>
</div>
</div>
</div>
</div>
</section>
<!-- environmentally conscious section -->
<section class="section content-panel section_about-impact-conscious" style="position: relative; overflow: hidden;">
  <!-- Background Floating Icons -->
  <div class="floating-bg-icon anim-float-fast" style="top: 10%; left: 8%; color: var(--color-primary);">
    <svg viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" /></svg>
  </div>
  <div class="floating-bg-icon anim-pulse" style="top: 25%; right: 10%; color: var(--color-accent-gold);">
    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
  </div>
    <div class="floating-bg-icon anim-float-fast" style="bottom: 10%; right: 15%; color: var(--color-primary);">
    <svg viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" /></svg>
  </div>
  <div class="floating-bg-icon anim-pulse" style="bottom: 15%; left: 25%; color: var(--color-accent-gold);">
    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
  </div>
<!-- svg in the left -->
<div class="impact-conscious__visual animate-fadeInLeft" style="position: relative; z-index: 2;">
<img alt="Social Impact World Animation" src="<?php echo get_template_directory_uri(); ?>/assets/svg/impact-world.svg" style="width: 100%; max-width: 500px; height: auto;"/>
</div>
<!-- context in the right -->
<div class="impact-conscious__content animate-fadeInRight" style="position: relative; z-index: 2;">
<span class="text-overline"><?php echo get_field('overline_33'); ?></span>
<h2 style="margin-top: 1rem; margin-bottom: var(--space-md); font-family: var(--font-heading);"><?php echo get_field('h2_30'); ?></h2>
<p style="color: var(--color-text-muted); line-height: 1.8; margin-bottom: var(--space-md);"><?php echo get_field('p_31'); ?></p>
<p style="color: var(--color-text-muted); line-height: 1.8;"><?php echo get_field('p_32'); ?></p>
</div>
</section>
<!-- our partners in impact section -->
<section class="impact-section content-panel" style="position: relative; overflow: hidden;">
  <!-- Background Floating Icons -->
  <div class="floating-bg-icon anim-float-fast" style="top: 10%; left: 8%; color: var(--color-primary);">
    <svg viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" /></svg>
  </div>
  <div class="floating-bg-icon anim-pulse" style="top: 25%; right: 10%; color: var(--color-accent-gold);">
    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
  </div>
    <div class="floating-bg-icon anim-float-fast" style="bottom: 10%; right: 15%; color: var(--color-primary);">
    <svg viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" /></svg>
  </div>
  <div class="floating-bg-icon anim-pulse" style="bottom: 15%; left: 25%; color: var(--color-accent-gold);">
    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
  </div>
<div class="container" style="position: relative; z-index: 2;">
<div class="partners-section-2-col">
<div class="animate-fadeInLeft">
<span class="text-overline"><?php echo get_field('overline_37'); ?></span>
<h2 style="font-family: var(--font-heading); color: var(--color-primary); margin-bottom: var(--space-md);"><?php echo get_field('h2_35'); ?></h2>
<p style="color: var(--color-text-muted); line-height: 1.8; font-size: 1.05rem;"><?php echo get_field('p_36'); ?></p>
</div>
<div class="animate-fadeInRight">
<div class="brand-logos-3x3">
<div class="brand-logo-item-3x3"><img alt="Partner" src="<?php $img = get_field('image_38'); echo ($img && is_array($img) && isset($img['url'])) ? esc_url($img['url']) : (is_numeric($img) ? wp_get_attachment_image_url($img, 'full') : get_template_directory_uri() . '/assets/img/placeholder.jpg'); ?>"/></div>
<div class="brand-logo-item-3x3"><img alt="Partner" src="<?php $img = get_field('image_39'); echo ($img && is_array($img) && isset($img['url'])) ? esc_url($img['url']) : (is_numeric($img) ? wp_get_attachment_image_url($img, 'full') : get_template_directory_uri() . '/assets/img/placeholder.jpg'); ?>"/></div>
<div class="brand-logo-item-3x3"><img alt="Partner" src="<?php $img = get_field('image_40'); echo ($img && is_array($img) && isset($img['url'])) ? esc_url($img['url']) : (is_numeric($img) ? wp_get_attachment_image_url($img, 'full') : get_template_directory_uri() . '/assets/img/placeholder.jpg'); ?>"/></div>
<div class="brand-logo-item-3x3"><img alt="Partner" src="<?php $img = get_field('image_41'); echo ($img && is_array($img) && isset($img['url'])) ? esc_url($img['url']) : (is_numeric($img) ? wp_get_attachment_image_url($img, 'full') : get_template_directory_uri() . '/assets/img/placeholder.jpg'); ?>"/></div>
<div class="brand-logo-item-3x3"><img alt="Partner" src="<?php $img = get_field('image_42'); echo ($img && is_array($img) && isset($img['url'])) ? esc_url($img['url']) : (is_numeric($img) ? wp_get_attachment_image_url($img, 'full') : get_template_directory_uri() . '/assets/img/placeholder.jpg'); ?>"/></div>
<div class="brand-logo-item-3x3"><img alt="Partner" src="<?php $img = get_field('image_43'); echo ($img && is_array($img) && isset($img['url'])) ? esc_url($img['url']) : (is_numeric($img) ? wp_get_attachment_image_url($img, 'full') : get_template_directory_uri() . '/assets/img/placeholder.jpg'); ?>"/></div>
<div class="brand-logo-item-3x3"><img alt="Partner" src="<?php $img = get_field('image_44'); echo ($img && is_array($img) && isset($img['url'])) ? esc_url($img['url']) : (is_numeric($img) ? wp_get_attachment_image_url($img, 'full') : get_template_directory_uri() . '/assets/img/placeholder.jpg'); ?>"/></div>
<div class="brand-logo-item-3x3"><img alt="Partner" src="<?php $img = get_field('image_45'); echo ($img && is_array($img) && isset($img['url'])) ? esc_url($img['url']) : (is_numeric($img) ? wp_get_attachment_image_url($img, 'full') : get_template_directory_uri() . '/assets/img/placeholder.jpg'); ?>"/></div>
<div class="brand-logo-item-3x3"><img alt="Partner" src="<?php $img = get_field('image_46'); echo ($img && is_array($img) && isset($img['url'])) ? esc_url($img['url']) : (is_numeric($img) ? wp_get_attachment_image_url($img, 'full') : get_template_directory_uri() . '/assets/img/placeholder.jpg'); ?>"/></div>
</div>
</div>
</div>
</div>
</section>
</main>
<script>
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

