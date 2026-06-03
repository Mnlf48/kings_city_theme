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
<h1 class="hero__title hero__title--inner"><?php echo get_field('h1_1'); ?></h1>
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
<section class="section content-panel section--intro">
<div class="container grid-12">
<div class="col-12 split" style="align-items: center;">
<div class="split__media">
<img alt="Kings City Growth" src="<?php $img = get_field('image_11'); echo ($img && is_array($img) && isset($img['url'])) ? esc_url($img['url']) : (is_numeric($img) ? wp_get_attachment_image_url($img, 'full') : get_template_directory_uri() . '/assets/img/placeholder.jpg'); ?>" style="width: 100%; height: 100%; object-fit: cover; aspect-ratio: 4/3; border-radius: var(--radius-card);"/>
</div>
<div class="split__content">
<span class="text-overline" style="margin-bottom: var(--space-sm); display: block;"><?php echo get_field('overline_10'); ?></span>
<h2 style="color: var(--color-primary); margin-bottom: var(--space-md);"><?php echo get_field('h2_8'); ?></h2>
<p style="font-size: 1.125rem; color: var(--color-text-muted); line-height: 1.8; margin-bottom: 0;"><?php echo get_field('p_9'); ?></p>
</div>
</div>
</div>
</section>
<!-- top logo banner -->
<section class="logo-banner content-panel">
<div class="container">
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
<span class="brand-list__title">Kings City</span>
<span class="brand-list__badge" style="background: rgba(189, 69, 31, 0.1); color: var(--color-primary);">CO-WORKING</span>
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
<section class="section content-panel section--pass">
<div class="container grid-12">
<div class="col-12 split">
<div class="split__content">
<span class="text-overline" style="display: block; margin-bottom: var(--space-sm);"><?php echo get_field('overline_34'); ?></span>
<h2 style="color: var(--color-primary); margin-bottom: var(--space-md);"><?php echo get_field('h2_32'); ?></h2>
<p style="color: var(--color-text-muted); margin-bottom: var(--space-lg);"><?php echo get_field('p_33'); ?></p>
<ul style="display:flex; flex-direction:column; gap:1.25rem; color: var(--color-text-muted); list-style: none; padding: 0; text-align: left;">
<li style="display:flex; align-items:center; gap:1rem;">
<svg fill="none" height="24" stroke="var(--color-primary)" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewbox="0 0 24 24" width="24">
<path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
<polyline points="9 22 9 12 15 12 15 22"></polyline>
</svg>
<span style="font-size: 0.95rem;">A dedicated home location 24/7 access</span>
</li>
<li style="display:flex; align-items:center; gap:1rem;">
<svg fill="none" height="24" stroke="var(--color-primary)" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewbox="0 0 24 24" width="24">
<rect height="18" rx="2" ry="2" width="18" x="3" y="3"></rect>
<line x1="3" x2="21" y1="9" y2="9"></line>
<line x1="9" x2="9" y1="21" y2="9"></line>
</svg>
<span style="font-size: 0.95rem;">Meeting, conference, training and workshop rooms</span>
</li>
<li style="display:flex; align-items:center; gap:1rem;">
<svg fill="none" height="24" stroke="var(--color-primary)" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewbox="0 0 24 24" width="24">
<polygon points="23 7 16 12 23 17 23 7"></polygon>
<rect height="14" rx="2" ry="2" width="15" x="1" y="5"></rect>
</svg>
<span style="font-size: 0.95rem;">Event spaces, podcast studios, and photography studios</span>
</li>
<li style="display:flex; align-items:center; gap:1rem;">
<svg fill="none" height="24" stroke="var(--color-primary)" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewbox="0 0 24 24" width="24">
<path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path>
<line x1="7" x2="7.01" y1="7" y2="7"></line>
</svg>
<span style="font-size: 0.95rem;">Premium Gym access &amp; Kings Club wellness program</span>
</li>
<li style="display:flex; align-items:center; gap:1rem;">
<svg fill="none" height="24" stroke="var(--color-primary)" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewbox="0 0 24 24" width="24">
<path d="M18 8h1a4 4 0 0 1 0 8h-1"></path>
<path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"></path>
<line x1="6" x2="6" y1="1" y2="4"></line>
<line x1="10" x2="10" y1="1" y2="4"></line>
<line x1="14" x2="14" y1="1" y2="4"></line>
</svg>
<span style="font-size: 0.95rem;">Exclusive discounts at our in-house coffee shops</span>
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
<section class="section content-panel" style="position: relative;">
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
