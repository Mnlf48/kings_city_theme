<?php
/* Template Name: About */
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
<h1 class="hero__title hero__title--inner" style="width: 100%;">
<?php 
$h1_val = get_field('h1_1');
if (!$h1_val) $h1_val = 'The Kings City Club';

if (stripos($h1_val, 'the kings city club') !== false) {
    echo '<span style="display: block;">' . trim(str_ireplace('City Club', '', $h1_val)) . '</span>';
    echo '<span style="display: block;">CITY CLUB</span>';
} else {
    $w = explode(' ', trim($h1_val)); 
    echo (count($w) === 3) ? $w[0] . '&nbsp;' . $w[1] . ' ' . $w[2] : $h1_val;
}
?>
</h1>
<p class="hero__subtitle"><?php echo get_field('p_2'); ?></p>
<div class="hero__actions hero__actions--index">
<a class="btn" href="#our-story">
                Read Our Story
              </a>
</div>
</div>
<!-- slider on right -->
<div class="split__media hero__slider" id="hero-slider" style="position: relative; aspect-ratio: 4/3; overflow: hidden; border-radius: var(--radius-card);">
<!-- slide 1 -->
<img alt="About Kings City 1" class="hero__slide is-active" src="<?php $img = get_field('image_4'); echo ($img && is_array($img) && isset($img['url'])) ? esc_url($img['url']) : (is_numeric($img) ? wp_get_attachment_image_url($img, 'full') : get_template_directory_uri() . '/assets/img/placeholder.jpg'); ?>" style="position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; opacity: 1; transition: opacity 1s ease-in-out;"/>
<!-- slide 2 -->
<img alt="About Kings City 2" class="hero__slide" src="<?php $img = get_field('image_5'); echo ($img && is_array($img) && isset($img['url'])) ? esc_url($img['url']) : (is_numeric($img) ? wp_get_attachment_image_url($img, 'full') : get_template_directory_uri() . '/assets/img/placeholder.jpg'); ?>" style="position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; opacity: 0; transition: opacity 1s ease-in-out;"/>
<!-- slide 3 -->
<img alt="About Kings City 3" class="hero__slide" src="<?php $img = get_field('image_6'); echo ($img && is_array($img) && isset($img['url'])) ? esc_url($img['url']) : (is_numeric($img) ? wp_get_attachment_image_url($img, 'full') : get_template_directory_uri() . '/assets/img/placeholder.jpg'); ?>" style="position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; opacity: 0; transition: opacity 1s ease-in-out;"/>
</div>
</div>
</div>
</section>
<!-- our story / mission -->
<section class="section content-panel section--story" id="our-story">
<div class="container grid-12">
<div class="col-12 split" style="align-items: center;">
<div class="split__media">
<img alt="Kings City Bag" src="<?php $img = get_field('image_12'); echo ($img && is_array($img) && isset($img['url'])) ? esc_url($img['url']) : (is_numeric($img) ? wp_get_attachment_image_url($img, 'full') : get_template_directory_uri() . '/assets/img/placeholder.jpg'); ?>" style="width: 100%; height: 100%; object-fit: cover; aspect-ratio: 4/3; border-radius: var(--radius-card);"/>
</div>
<div class="split__content">
<span class="text-overline"><?php echo get_field('overline_11'); ?></span>
<h2 style="font-family: var(--font-heading); font-weight: 400; color: var(--color-primary); margin-bottom: var(--space-lg); line-height: 1.2;"><?php echo get_field('h2_8'); ?></h2>
<p style="font-size: 1.125rem; color: var(--color-text-muted); line-height: 1.8; margin-bottom: var(--space-md);"><?php echo get_field('p_9'); ?></p>
<p style="font-size: 1.125rem; color: var(--color-text-muted); line-height: 1.8; margin-bottom: 0;"><?php echo get_field('p_10'); ?></p>
</div>
</div>
</div>
</section>
<!-- mission and vision -->
<section class="section content-panel" id="mission-vision">
<div class="container grid-12">
<div class="col-12 split">
<!-- mission card -->
<div class="split__content card-glass mv-card" style="background-color: var(--color-secondary);">
<svg class="mv-card__icon" width="32" height="32" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
<span class="text-overline"><?php echo get_field('overline_mv_mission'); ?></span>
<h2 class="mv-card__title"><?php echo get_field('h3_mv_mission'); ?></h2>
<p class="mv-card__text"><?php echo get_field('p_mv_mission'); ?></p>
</div>
<!-- vision card -->
<div class="split__content card-glass card-glass--strong section--brown mv-card">
<svg class="mv-card__icon" width="32" height="32" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><circle cx="12" cy="12" r="6"></circle><circle cx="12" cy="12" r="2"></circle></svg>
<span class="text-overline"><?php echo get_field('overline_mv_vision'); ?></span>
<h2 class="mv-card__title"><?php echo get_field('h3_mv_vision'); ?></h2>
<p class="mv-card__text"><?php echo get_field('p_mv_vision'); ?></p>
</div>
</div>
</div>
</section>
<!-- philippines map section -->
<section class="section content-panel section--map">
<div class="container grid-12">
<div class="col-12 split">
<div class="split__content animate-fadeInUp">
<span class="text-overline"><?php echo get_field('overline_17'); ?></span>
<h2 style="font-family: var(--font-heading); font-weight: 400; color: var(--color-primary); margin-bottom: var(--space-md);"><?php echo get_field('h2_14'); ?></h2>
<p style="color: var(--color-text-muted); line-height: 1.7; margin-bottom: var(--space-md);"><?php echo get_field('p_15'); ?></p>
<p style="color: var(--color-text-muted); line-height: 1.7; margin-bottom: 0;"><?php echo get_field('p_16'); ?></p>
</div>
<div class="split__media text-center">
<img alt="Philippine Map" src="<?php $img = get_field('image_18'); echo ($img && is_array($img) && isset($img['url'])) ? esc_url($img['url']) : (is_numeric($img) ? wp_get_attachment_image_url($img, 'full') : get_template_directory_uri() . '/assets/img/placeholder.jpg'); ?>" style="max-width: 100%; height: auto; max-height: 400px; object-fit: contain; filter: drop-shadow(0 10px 20px rgba(0,0,0,0.05));"/>
</div>
</div>
</div>
</section>
<!-- core values grid -->
<section class="core-values-section content-panel">
<div class="core-values-container">
<div class="text-center" style="margin-bottom: var(--space-2xl);">
<span class="text-overline"><?php echo get_field('overline_29'); ?></span>
<h2 style="font-family: var(--font-heading); font-weight: 400; color: var(--color-primary);"><?php echo get_field('h2_20'); ?></h2>
</div>
<div class="core-values-grid">
<div class="core-value-card">
<span class="core-value-number">01.</span>
<h3><?php echo get_field('h3_21'); ?></h3>
<p><?php echo get_field('p_25'); ?></p>
</div>
<div class="core-value-card">
<span class="core-value-number">02.</span>
<h3><?php echo get_field('h3_22'); ?></h3>
<p><?php echo get_field('p_26'); ?></p>
</div>
<div class="core-value-card">
<span class="core-value-number">03.</span>
<h3><?php echo get_field('h3_23'); ?></h3>
<p><?php echo get_field('p_27'); ?></p>
</div>
<div class="core-value-card">
<span class="core-value-number">04.</span>
<h3><?php echo get_field('h3_24'); ?></h3>
<p><?php echo get_field('p_28'); ?></p>
</div>
</div>
</div>
</section>
<!-- timeline / how we got here -->
<section class="section content-panel" style="padding: var(--space-lg) 0;">
<div class="container" style="max-width: 800px;">
<div class="text-center" style="margin-bottom: var(--space-xl);">
<span class="text-overline"><?php echo get_field('overline_50'); ?></span>
<h2 style="font-family: var(--font-heading); font-weight: 400; color: var(--color-primary);"><?php echo get_field('h2_31'); ?></h2>
</div>
<div class="snake-timeline">
<!-- row 1 -->
<div class="snake-row">
<!-- -->
<div class="snake-item">
<div class="snake-dot"></div>
<div class="snake-content">
<span class="snake-year">1999</span>
<h3 class="snake-title"><?php echo get_field('h3_32'); ?></h3>
<p class="snake-desc"><?php echo get_field('p_41'); ?></p>
</div>
</div>
<!-- -->
<div class="snake-item">
<div class="snake-dot"></div>
<div class="snake-content">
<span class="snake-year">2005</span>
<h3 class="snake-title"><?php echo get_field('h3_33'); ?></h3>
<p class="snake-desc"><?php echo get_field('p_42'); ?></p>
</div>
</div>
<!-- -->
<div class="snake-item">
<div class="snake-dot"></div>
<div class="snake-content">
<span class="snake-year">2009</span>
<h3 class="snake-title"><?php echo get_field('h3_34'); ?></h3>
<p class="snake-desc"><?php echo get_field('p_43'); ?></p>
</div>
</div>
</div>
<!-- row 2 -->
<div class="snake-row">
<!-- -->
<div class="snake-item">
<div class="snake-dot"></div>
<div class="snake-content">
<span class="snake-year">2011</span>
<h3 class="snake-title"><?php echo get_field('h3_35'); ?></h3>
<p class="snake-desc"><?php echo get_field('p_44'); ?></p>
</div>
</div>
<!-- -->
<div class="snake-item">
<div class="snake-dot"></div>
<div class="snake-content">
<span class="snake-year">2016</span>
<h3 class="snake-title"><?php echo get_field('h3_36'); ?></h3>
<p class="snake-desc"><?php echo get_field('p_45'); ?></p>
</div>
</div>
<!-- -->
<div class="snake-item">
<div class="snake-dot"></div>
<div class="snake-content">
<span class="snake-year">2017</span>
<h3 class="snake-title"><?php echo get_field('h3_37'); ?></h3>
<p class="snake-desc"><?php echo get_field('p_46'); ?></p>
</div>
</div>
</div>
<!-- row 3 -->
<div class="snake-row">
<!-- -->
<div class="snake-item">
<div class="snake-dot"></div>
<div class="snake-content">
<span class="snake-year">2019</span>
<h3 class="snake-title"><?php echo get_field('h3_38'); ?></h3>
<p class="snake-desc"><?php echo get_field('p_47'); ?></p>
</div>
</div>
<!-- -->
<div class="snake-item">
<div class="snake-dot"></div>
<div class="snake-content">
<span class="snake-year">2020</span>
<h3 class="snake-title"><?php echo get_field('h3_39'); ?></h3>
<p class="snake-desc"><?php echo get_field('p_48'); ?></p>
</div>
</div>
<!-- -->
<div class="snake-item">
<div class="snake-dot"></div>
<div class="snake-content">
<span class="snake-year">2025</span>
<h3 class="snake-title"><?php echo get_field('h3_40'); ?></h3>
<p class="snake-desc"><?php echo get_field('p_49'); ?></p>
</div>
</div>
</div>
</div>
</div>
</section>
<!-- membership perks section -->
<section class="section content-panel section--pass bg-ivory" style="position: relative; overflow: hidden;">
<!-- Background floating icons (Ivory optimized) -->
 
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
<div class="split__media">
<img alt="One Pass. All Access. - Membership Perks" src="<?php $img = get_field('about_pass_image'); echo ($img && is_array($img) && isset($img['url'])) ? esc_url($img['url']) : (is_numeric($img) ? wp_get_attachment_image_url($img, 'full') : get_template_directory_uri() . '/assets/img/placeholder.jpg'); ?>"/>
</div>
<div class="split__content">
<span class="text-overline" style="display: block; margin-bottom: var(--space-sm);"><?php echo get_field('about_pass_overline'); ?></span>
<h2 style="margin-bottom: var(--space-md);"><?php echo get_field('about_pass_heading'); ?></h2>
<p style="margin-bottom: var(--space-lg);"><?php echo get_field('about_pass_subtext'); ?></p>
<ul class="perks-list">
<li>
<div class="perk-bubble">
<svg fill="none" height="22" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" viewbox="0 0 24 24" width="22">
<path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
<polyline points="9 22 9 12 15 12 15 22"></polyline>
</svg>
</div>
<span style="font-size: 0.95rem; font-weight: 600;"><?php echo get_field('about_pass_perk_1'); ?></span>
</li>
<li>
<div class="perk-bubble">
<svg fill="none" height="22" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" viewbox="0 0 24 24" width="22">
<rect height="18" rx="2" ry="2" width="18" x="3" y="3"></rect>
<line x1="3" x2="21" y1="9" y2="9"></line>
<line x1="9" x2="9" y1="21" y2="9"></line>
</svg>
</div>
<span style="font-size: 0.95rem; font-weight: 600;"><?php echo get_field('about_pass_perk_2'); ?></span>
</li>
<li>
<div class="perk-bubble">
<svg fill="none" height="22" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" viewbox="0 0 24 24" width="22">
<polygon points="23 7 16 12 23 17 23 7"></polygon>
<rect height="14" rx="2" ry="2" width="15" x="1" y="5"></rect>
</svg>
</div>
<span style="font-size: 0.95rem; font-weight: 600;"><?php echo get_field('about_pass_perk_3'); ?></span>
</li>
<li>
<div class="perk-bubble">
<svg fill="none" height="22" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" viewbox="0 0 24 24" width="22">
<path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path>
<line x1="7" x2="7.01" y1="7" y2="7"></line>
</svg>
</div>
<span style="font-size: 0.95rem; font-weight: 600;"><?php echo get_field('about_pass_perk_4'); ?></span>
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
<span style="font-size: 0.95rem; font-weight: 600;"><?php echo get_field('about_pass_perk_5'); ?></span>
</li>
</ul>
</div>
</div>
</div>
</section>
<!-- community section -->
<section class="section content-panel section--community" id="community">
<div class="container grid-12">
<div class="col-12 split">
<div class="split__content">
<span class="text-overline"><?php echo get_field('overline_community'); ?></span>
<h2 style="font-family: var(--font-heading); font-weight: 400; color: var(--color-primary); margin-bottom: var(--space-lg); line-height: 1.2;"><?php echo get_field('h2_community'); ?></h2>
<p style="font-size: 1.125rem; color: var(--color-text-muted); line-height: 1.8; margin-bottom: var(--space-md);"><?php echo get_field('p_community_1'); ?></p>
<p style="font-size: 1.125rem; color: var(--color-text-muted); line-height: 1.8; margin-bottom: 0;"><?php echo get_field('p_community_2'); ?></p>
</div>
<div class="split__media">
<img alt="Community Image" src="<?php $img = get_field('community_image'); echo ($img && is_array($img) && isset($img['url'])) ? esc_url($img['url']) : (is_numeric($img) ? wp_get_attachment_image_url($img, 'full') : get_template_directory_uri() . '/assets/img/placeholder.jpg'); ?>" style="width: 100%; height: 100%; object-fit: cover; aspect-ratio: 4/3; border-radius: var(--radius-card);"/>
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

