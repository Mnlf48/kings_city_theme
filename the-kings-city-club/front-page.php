<?php
get_header();
?>



<main id="main-content" class="front-page-main">
<!-- hero section -->
<section class="hero premium-hero front-page-hero" id="hero-section">
<div class="container grid-12">
<div class="col-12 split">
<!-- slider on left -->
<div class="split__media hero__slider front-page-hero-slider" id="hero-slider" style="position: relative; overflow: hidden; border-radius: var(--radius-card);">
<!-- slide 1 -->
<img alt="Kings City Banner" class="hero__slide is-active" src="<?php echo kc_img('hero_section_img_1', 'front-page-img/kings-img31.webp'); ?>" style="position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; opacity: 1; transition: opacity 1s ease-in-out;"/>
<!-- slide 2 -->
<img alt="Kings Place" class="hero__slide" src="<?php echo kc_img('hero_section_img_2', 'front-page-img/kings_img02.webp'); ?>" style="position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; opacity: 0; transition: opacity 1s ease-in-out;"/>
<!-- slide 3 -->
<img alt="Kings Bag" class="hero__slide" src="<?php echo kc_img('hero_section_img_3', 'front-page-img/kings_img01.webp'); ?>" style="position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; opacity: 0; transition: opacity 1s ease-in-out;"/>
</div>
<!-- text on right -->
<div class="split__content animate-fadeInUp hero__content--index">
<span class="text-overline hero__overline"><?php $h = get_field('hero_section_txt_6'); if ($h) { $w = explode(' ', trim($h)); echo (count($w) === 3) ? $w[0] . '&nbsp;' . $w[1] . ' ' . $w[2] : $h; } ?></span>
<h1 class="hero__title hero__title--inner hero__welcome" style="margin-bottom: 0;"><?php $h = get_field('hero_section_txt_welcome'); if ($h) { $w = explode(' ', trim($h)); echo (count($w) === 3) ? $w[0] . '&nbsp;' . $w[1] . ' ' . $w[2] : $h; } ?></h1>
<h1 class="hero__title hero__title--inner"><?php $h = get_field('hero_section_txt_4'); if ($h) { $w = explode(' ', trim($h)); echo (count($w) === 3) ? $w[0] . '&nbsp;' . $w[1] . ' ' . $w[2] : $h; } ?></h1>
<p class="hero__subtitle"><?php $h = get_field('hero_section_txt_5'); if ($h) { $w = explode(' ', trim($h)); echo (count($w) === 3) ? $w[0] . '&nbsp;' . $w[1] . ' ' . $w[2] : $h; } ?></p>
<div class="hero__actions hero__actions--index" style="display: block; margin-top: 40px; height: 54px; overflow: hidden;">
<a class="btn" href="<?php echo esc_url( home_url( '/apply/' ) ); ?>">
<?php 
  // Strip ALL tags to prevent WP from injecting <p> inside the button
  echo trim(strip_tags(get_field('hero_section_txt_7'))); 
?>
</a>
</div>
</div>
</div>
</div>
</section>
<!-- spaces section -->
<section class="section content-panel" style="position: relative; overflow: hidden;">
<!-- Background floating confetti -->
<style>
@keyframes floatSpace { 0% { transform: translateY(0px) rotate(-5deg); } 50% { transform: translateY(-12px) rotate(5deg); } 100% { transform: translateY(0px) rotate(-5deg); } }
.space-bg-icon { position: absolute; pointer-events: none; z-index: 0; }
</style>
<!-- 1. Ivory Sparkle -->
<!-- 2. Deep Red Heart -->
<!-- 3. Muted Gold Circle -->
<!-- 4. Ivory Star -->
<!-- 5. Soft Blush Sparkle -->
<div class="container" style="position: relative; z-index: 1;">
<div class="section__header text-center mx-auto" style="max-width: 800px; margin-bottom: var(--space-xl);">
<span class="text-overline" style="display: block; margin-bottom: var(--space-sm);"><?php echo get_field('section_txt_22'); ?></span>
<h2 style="color: #BD451F; margin-bottom: var(--space-sm);"><?php echo get_field('section_txt_12'); ?></h2>
<p class="text-lead"><?php echo get_field('section_txt_17'); ?></p>
</div>
<div class="spaces-grid stagger-children">
<!-- space card 1 -->
<article class="space-card card-glass animate-fadeInUp">
<div class="space-card__img-wrap">
<img alt="Coworking Space" class="space-card__img" src="<?php echo kc_img('section_img_8', 'front-page-img/kings-img45.webp'); ?>" loading="lazy"/>
</div>
<div class="space-card__body">
<h3 class="space-card__title"><?php echo get_field('section_txt_13'); ?></h3>
<p class="space-card__desc"><?php echo get_field('section_txt_18'); ?></p>
</div>
<div class="space-card__footer">
<a class="btn btn--small" href="<?php echo esc_url( home_url( '/spaces/' ) ); ?>">Learn More</a>
<div class="space-card__capacity" style="display:flex; align-items:center; gap:0.5rem; font-weight:600; color:var(--color-primary);">
<div class="bg-ivory" style=" color: var(--color-accent-gold); width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; box-shadow: 0 4px 8px rgba(0,0,0,0.05);">
<svg fill="none" height="16" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" viewbox="0 0 24 24" width="16">
<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
<circle cx="9" cy="7" r="4"></circle>
<path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
<path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
</svg>
</div>
<span><?php echo get_field('section_txt_23'); ?></span>
</div>
</div>
</article>
<!-- space card 2 -->
<article class="space-card card-glass animate-fadeInUp" style="animation-delay: 0.1s;">
<div class="space-card__img-wrap">
<img alt="Private Office Space" class="space-card__img" src="<?php echo kc_img('section_img_9', 'front-page-img/kings-img48.webp'); ?>" loading="lazy"/>
</div>
<div class="space-card__body">
<h3 class="space-card__title"><?php echo get_field('section_txt_14'); ?></h3>
<p class="space-card__desc"><?php echo get_field('section_txt_19'); ?></p>
</div>
<div class="space-card__footer">
<a class="btn btn--small" href="<?php echo esc_url( home_url( '/spaces/' ) ); ?>">Learn More</a>
<div class="space-card__capacity" style="display:flex; align-items:center; gap:0.5rem; font-weight:600; color:var(--color-primary);">
<div class="bg-ivory" style=" color: var(--color-accent-gold); width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; box-shadow: 0 4px 8px rgba(0,0,0,0.05);">
<svg fill="none" height="16" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" viewbox="0 0 24 24" width="16">
<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
<circle cx="9" cy="7" r="4"></circle>
<path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
<path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
</svg>
</div>
<span><?php echo get_field('section_txt_24'); ?></span>
</div>
</div>
</article>
<!-- space card 3 -->
<article class="space-card card-glass animate-fadeInUp" style="animation-delay: 0.2s;">
<div class="space-card__img-wrap">
<img alt="Enterprise" class="space-card__img" src="<?php echo kc_img('section_img_10', 'front-page-img/kings-img26.webp'); ?>" loading="lazy"/>
</div>
<div class="space-card__body">
<h3 class="space-card__title"><?php echo get_field('section_txt_15'); ?></h3>
<p class="space-card__desc"><?php echo get_field('section_txt_20'); ?></p>
</div>
<div class="space-card__footer">
<a class="btn btn--small" href="<?php echo esc_url( home_url( '/spaces/' ) ); ?>">Learn More</a>
<div class="space-card__capacity" style="display:flex; align-items:center; gap:0.5rem; font-weight:600; color:var(--color-primary);">
<div class="bg-ivory" style=" color: var(--color-accent-gold); width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; box-shadow: 0 4px 8px rgba(0,0,0,0.05);">
<svg fill="none" height="16" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" viewbox="0 0 24 24" width="16">
<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
<circle cx="9" cy="7" r="4"></circle>
<path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
<path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
</svg>
</div>
<span><?php echo get_field('section_txt_25'); ?></span>
</div>
</div>
</article>
<!-- space card 4 -->
<article class="space-card card-glass animate-fadeInUp" style="animation-delay: 0.3s;">
<div class="space-card__img-wrap">
<img alt="On-Demand" class="space-card__img" src="<?php echo kc_img('section_img_11', 'front-page-img/kings-img32.webp'); ?>" loading="lazy"/>
</div>
<div class="space-card__body">
<h3 class="space-card__title"><?php echo get_field('section_txt_16'); ?></h3>
<p class="space-card__desc"><?php echo get_field('section_txt_21'); ?></p>
</div>
<div class="space-card__footer">
<a class="btn btn--small" href="<?php echo esc_url( home_url( '/spaces/' ) ); ?>">Learn More</a>
<div class="space-card__capacity" style="display:flex; align-items:center; gap:0.5rem; font-weight:600; color:var(--color-primary);">
<div class="bg-ivory" style=" color: var(--color-accent-gold); width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; box-shadow: 0 4px 8px rgba(0,0,0,0.05);">
<svg fill="none" height="16" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" viewbox="0 0 24 24" width="16">
<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
<circle cx="9" cy="7" r="4"></circle>
<path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
<path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
</svg>
</div>
<span><?php echo get_field('section_txt_26'); ?></span>
</div>
</div>
</article>
<!-- space card 5 -->
<article class="space-card card-glass animate-fadeInUp" style="animation-delay: 0.4s;">
<div class="space-card__img-wrap">
<img alt="Virtual Office" class="space-card__img" src="<?php echo kc_img('section_img_100', 'front-page-img/kings-img74.webp'); ?>" loading="lazy"/>
</div>
<div class="space-card__body">
<h3 class="space-card__title"><?php echo get_field('section_txt_101'); ?></h3>
<p class="space-card__desc"><?php echo get_field('section_txt_102'); ?></p>
</div>
<div class="space-card__footer">
<a class="btn btn--small" href="<?php echo esc_url( home_url( '/spaces/' ) ); ?>">Learn More</a>
<div class="space-card__capacity" style="display:flex; align-items:center; gap:0.5rem; font-weight:600; color:var(--color-primary);">
<div class="bg-ivory" style=" color: var(--color-accent-gold); width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; box-shadow: 0 4px 8px rgba(0,0,0,0.05);">
<svg fill="none" height="16" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" viewbox="0 0 24 24" width="16">
<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
<circle cx="9" cy="7" r="4"></circle>
<path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
<path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
</svg>
</div>
<span><?php echo get_field('section_txt_103'); ?></span>
</div>
</div>
</article>
<!-- space card 6 -->
<article class="space-card card-glass animate-fadeInUp" style="animation-delay: 0.5s;">
<div class="space-card__img-wrap">
<img alt="Meeting Rooms" class="space-card__img" src="<?php echo kc_img('section_img_104', 'front-page-img/kings-img73.webp'); ?>" loading="lazy"/>
</div>
<div class="space-card__body">
<h3 class="space-card__title"><?php echo get_field('section_txt_105'); ?></h3>
<p class="space-card__desc"><?php echo get_field('section_txt_106'); ?></p>
</div>
<div class="space-card__footer">
<a class="btn btn--small" href="<?php echo esc_url( home_url( '/spaces/' ) ); ?>">Learn More</a>
<div class="space-card__capacity" style="display:flex; align-items:center; gap:0.5rem; font-weight:600; color:var(--color-primary);">
<div class="bg-ivory" style=" color: var(--color-accent-gold); width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; box-shadow: 0 4px 8px rgba(0,0,0,0.05);">
<svg fill="none" height="16" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" viewbox="0 0 24 24" width="16">
<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
<circle cx="9" cy="7" r="4"></circle>
<path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
<path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
</svg>
</div>
<span><?php echo get_field('section_txt_107'); ?></span>
</div>
</div>
</article>
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
<!-- offshoring section -->
<section class="section content-panel section--offshoring bg-terracotta" style="position: relative; overflow: hidden;">
<!-- Background floating confetti -->
<style>
@keyframes floatOffshore { 0% { transform: translateY(0px) rotate(-5deg); } 50% { transform: translateY(-12px) rotate(5deg); } 100% { transform: translateY(0px) rotate(-5deg); } }
.offshore-bg-icon { position: absolute; pointer-events: none; z-index: 0; }
</style>
<!-- 1. Ivory Sparkle -->
<!-- 2. Soft Blush Heart -->
<!-- 3. Red Sparkle -->
<!-- 4. Ivory Heart -->
<!-- 5. Soft Blush Sparkle -->
<div class="container grid-12" style="position: relative; z-index: 1;">
<div class="col-12 split" style="align-items: center;">
<div class="split__content">
<span class="text-overline" style="color: var(--color-bg-ivory); opacity: 0.8;"><?php echo get_field('section_txt_35'); ?></span>
<h2 style="color: var(--color-bg-ivory); margin-bottom: var(--space-md);"><?php echo get_field('section_txt_33'); ?></h2>
<p class="text-lead" style="color: var(--color-bg-ivory); opacity: 0.9;"><?php echo get_field('section_txt_34'); ?></p>
<ul class="perks-list perks-list--offshoring" style="margin-bottom: var(--space-lg); color: var(--color-bg-ivory);">
<li>
<div class="perk-bubble" style="box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
<svg fill="none" height="22" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" viewbox="0 0 24 24" width="22">
<polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 12 2"></polygon>
</svg>
</div>
<span style="font-size: 0.95rem; font-weight: 600;">Local Dedicated Talent</span>
</li>
<li>
<div class="perk-bubble" style="box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
<svg fill="none" height="22" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" viewbox="0 0 24 24" width="22">
<rect x="4" y="2" width="16" height="20" rx="2" ry="2"></rect>
<path d="M9 22v-4h6v4"></path>
<path d="M8 6h.01"></path>
<path d="M16 6h.01"></path>
<path d="M12 6h.01"></path>
<path d="M12 10h.01"></path>
<path d="M12 14h.01"></path>
<path d="M16 10h.01"></path>
<path d="M16 14h.01"></path>
<path d="M8 10h.01"></path>
<path d="M8 14h.01"></path>
</svg>
</div>
<span style="font-size: 0.95rem; font-weight: 600;">Fully Maintained Facilities</span>
</li>
<li>
<div class="perk-bubble" style="box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
<svg fill="none" height="22" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" viewbox="0 0 24 24" width="22">
<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
<circle cx="9" cy="7" r="4"></circle>
<path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
<path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
</svg>
</div>
<span style="font-size: 0.95rem; font-weight: 600;">Professional HR Framework</span>
</li>
</ul>
<div style="margin-top: var(--space-md);">
<a class="btn" href="<?php echo esc_url( home_url( '/apply/' ) ); ?>">
<?php echo trim(strip_tags(get_field('section_txt_36'))); ?>
</a>
</div>
</div>
<div class="split__media">
<img alt="Offshoring Power - A professional team working in a modern office" src="<?php echo kc_img('section_img_32', 'front-page-img/kings-img37.webp'); ?>" loading="lazy"/>
</div>
</div>
</div>


          <!-- 1. Star -->
          <div class="floating-bg-icon anim-float-fast" style="top: 10%; right: 8%; color: var(--color-bg-ivory);"><svg viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" /></svg></div>
          <!-- 2. Heart -->
          <div class="floating-bg-icon anim-pulse" style="bottom: 15%; left: 8%; color: var(--color-secondary);"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg></div>
          <!-- 3. Star -->
          <div class="floating-bg-icon anim-float-fast" style="top: 25%; right: 40%; color: var(--color-accent-red);"><svg viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" /></svg></div>
          <!-- 4. Heart -->
          <div class="floating-bg-icon anim-pulse" style="bottom: 10%; right: 10%; color: var(--color-bg-ivory);"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg></div>
          <!-- 5. Star -->
          <div class="floating-bg-icon anim-float-fast" style="top: 15%; left: 12%; color: var(--color-secondary);"><svg viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" /></svg></div>
          <!-- 6. Heart -->
          <div class="floating-bg-icon anim-pulse" style="top: 45%; left: 25%; color: var(--color-accent-red);"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg></div>

</section>
<!-- membership perks section -->
<section class="section content-panel section--pass bg-blush" style="position: relative; overflow: hidden;">
<!-- Background floating icons -->
<!-- 1. Red Sparkle -->
<!-- 2. Terracotta Heart -->
<!-- 3. Ivory Sparkle -->
<!-- 4. Red Heart -->
<!-- 5. Terracotta Sparkle -->
<!-- /Background floating icons -->
<div class="container grid-12" style="position: relative; z-index: 1;">
<div class="col-12 split">
<div class="split__media">
<img alt="One Pass. All Access. - Membership Perks" src="<?php echo kc_img('section_img_37', 'front-page-img/kings_img07.webp'); ?>" loading="lazy"/>
</div>
<div class="split__content" style="margin-top: 0;">
<span class="text-overline" style="display: block; margin-bottom: var(--space-sm);"><?php echo get_field('section_txt_40'); ?></span>
<h2 style="color: #BD451F; margin-bottom: var(--space-md);"><?php echo get_field('section_txt_38'); ?></h2>
<p style="margin-bottom: var(--space-lg);"><?php echo get_field('section_txt_39'); ?></p>
<ul class="perks-list perks-list--membership">
<li>
<div class="perk-bubble">
<svg fill="none" height="22" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" viewbox="0 0 24 24" width="22">
<path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
<polyline points="9 22 9 12 15 12 15 22"></polyline>
</svg>
</div>
<span style="font-size: 0.95rem; font-weight: 600;"><?php echo get_field('section_txt_41'); ?></span>
</li>
<li>
<div class="perk-bubble">
<svg fill="none" height="22" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" viewbox="0 0 24 24" width="22">
<rect height="18" rx="2" ry="2" width="18" x="3" y="3"></rect>
<line x1="3" x2="21" y1="9" y2="9"></line>
<line x1="9" x2="9" y1="21" y2="9"></line>
</svg>
</div>
<span style="font-size: 0.95rem; font-weight: 600;"><?php echo get_field('section_txt_42'); ?></span>
</li>
<li>
<div class="perk-bubble">
<svg fill="none" height="22" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" viewbox="0 0 24 24" width="22">
<polygon points="23 7 16 12 23 17 23 7"></polygon>
<rect height="14" rx="2" ry="2" width="15" x="1" y="5"></rect>
</svg>
</div>
<span style="font-size: 0.95rem; font-weight: 600;"><?php echo get_field('section_txt_43'); ?></span>
</li>
<li>
<div class="perk-bubble">
<svg fill="none" height="22" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" viewbox="0 0 24 24" width="22">
<path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path>
<line x1="7" x2="7.01" y1="7" y2="7"></line>
</svg>
</div>
<span style="font-size: 0.95rem; font-weight: 600;"><?php echo get_field('section_txt_44'); ?></span>
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
<span style="font-size: 0.95rem; font-weight: 600;"><?php echo get_field('section_txt_45'); ?></span>
</li>
</ul>
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
<section class="section content-panel section--gallery gallery-theme-terracotta" style="position: relative; padding: var(--space-lg) 0 var(--space-2xl) 0; overflow: hidden;">
<!-- Background Confetti -->
<!-- 1. Ivory Sparkle -->
<!-- 2. Soft Blush Heart -->
<!-- 3. Red Sparkle -->
<!-- 4. Ivory Heart -->
<!-- 5. Soft Blush Sparkle -->
<!-- Heading -->
<div class="container" style="position: relative; z-index: 2;">
  <div style="text-align: center; margin-bottom: var(--space-xl);">
    <h2 style="color: var(--color-bg-ivory); margin-bottom: 0; font-size: clamp(2rem, 4vw, 3rem); font-weight: 700;"><?php $heading = get_field('section_txt_gallery_heading'); echo $heading ? $heading : 'Virtual Tour'; ?></h2>
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



          <!-- 1. Star -->
          <div class="floating-bg-icon anim-float-fast" style="top: 10%; right: 8%; color: var(--color-bg-ivory);"><svg viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" /></svg></div>
          <!-- 2. Heart -->
          <div class="floating-bg-icon anim-pulse" style="bottom: 15%; left: 8%; color: var(--color-secondary);"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg></div>
          <!-- 3. Star -->
          <div class="floating-bg-icon anim-float-fast" style="top: 25%; right: 40%; color: var(--color-accent-red);"><svg viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" /></svg></div>
          <!-- 4. Heart -->
          <div class="floating-bg-icon anim-pulse" style="bottom: 10%; right: 10%; color: var(--color-bg-ivory);"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg></div>
          <!-- 5. Star -->
          <div class="floating-bg-icon anim-float-fast" style="top: 15%; left: 12%; color: var(--color-secondary);"><svg viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" /></svg></div>
          <!-- 6. Heart -->
          <div class="floating-bg-icon anim-pulse" style="top: 45%; left: 25%; color: var(--color-accent-red);"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg></div>

</section>
<!-- trust bar -->
<!-- what defines us -->
<!-- get social with us -->
<section class="section content-panel section--social bg-blush" style="position: relative; overflow: hidden;">
<!-- Floating Background "Social Stickers" -->
<style>
@keyframes floatSocial { 0% { transform: translateY(0px) rotate(-5deg); } 50% { transform: translateY(-12px) rotate(5deg); } 100% { transform: translateY(0px) rotate(-5deg); } }
@keyframes pulseSocial { 0% { transform: scale(1); opacity: 0.2; } 50% { transform: scale(1.1); opacity: 0.4; } 100% { transform: scale(1); opacity: 0.2; } }
.social-bg-icon { position: absolute; pointer-events: none; z-index: 0; }
</style>

<!-- 1. Deep Red Heart (Top Right) -->

<!-- 1. Red Sparkle -->
<!-- 2. Ivory Heart -->
<!-- 3. Terracotta Sparkle -->
<!-- 4. Red Heart -->
<!-- 5. Ivory Sparkle -->
<div class="container grid-12" style="position: relative; z-index: 1;">
<!-- top row: heading + description -->
<div class="col-12 split" style="align-items: center;">
<div class="split__content">
<span class="text-overline" style="display: block; margin-bottom: var(--space-sm);"><?php echo get_field('section_txt_67'); ?></span>
<h2 style="color: #BD451F; margin-bottom: var(--space-md);"><?php echo get_field('section_txt_59'); ?></h2>
<p style="font-size: 0.95rem; line-height: 1.7; max-width: 480px; margin-bottom: var(--space-lg);"><?php echo get_field('section_txt_60'); ?></p>

<!-- feature list -->
<ul class="perks-list perks-list--social">
<!-- feature 1: book spaces -->
<li>
<div class="perk-bubble" style="box-shadow: 0 4px 12px rgba(189, 69, 31, 0.1);">
<svg fill="none" height="22" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" viewbox="0 0 24 24" width="22">
<rect height="18" rx="2" ry="2" width="18" x="3" y="4"></rect>
<line x1="16" x2="16" y1="2" y2="6"></line>
<line x1="8" x2="8" y1="2" y2="6"></line>
<line x1="3" x2="21" y1="10" y2="10"></line>
<rect height="3" rx="0.5" width="3" x="8" y="14"></rect>
</svg>
</div>
<span style="font-size: 0.95rem; font-weight: 600;"><?php echo get_field('section_txt_61'); ?></span>
</li>

<!-- feature 2: events & notifications -->
<li>
<div class="perk-bubble" style="box-shadow: 0 4px 12px rgba(189, 69, 31, 0.1);">
<svg fill="none" height="22" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" viewbox="0 0 24 24" width="22">
<path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
<path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
</svg>
</div>
<span style="font-size: 0.95rem; font-weight: 600;"><?php echo get_field('section_txt_62'); ?></span>
</li>

<!-- feature 3: network & connect -->
<li>
<div class="perk-bubble" style="box-shadow: 0 4px 12px rgba(189, 69, 31, 0.1);">
<svg fill="none" height="22" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" viewbox="0 0 24 24" width="22">
<circle cx="12" cy="5" r="3"></circle>
<circle cx="4" cy="12" r="2.5"></circle>
<circle cx="20" cy="12" r="2.5"></circle>
<circle cx="12" cy="19" r="2.5"></circle>
<line x1="12" x2="12" y1="8" y2="16.5"></line>
<line x1="6.3" x2="9.8" y1="13" y2="17.5"></line>
<line x1="17.7" x2="14.2" y1="13" y2="17.5"></line>
</svg>
</div>
<span style="font-size: 0.95rem; font-weight: 600;"><?php echo get_field('section_txt_63'); ?></span>
</li>

<!-- feature 4: interactive newsfeed -->
<li>
<div class="perk-bubble" style="box-shadow: 0 4px 12px rgba(189, 69, 31, 0.1);">
<svg fill="none" height="22" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" viewbox="0 0 24 24" width="22">
<rect height="18" rx="2" width="20" x="2" y="3"></rect>
<line x1="2" x2="22" y1="8" y2="8"></line>
<line x1="9" x2="9" y1="8" y2="21"></line>
<line x1="13" x2="19" y1="13" y2="13"></line>
<line x1="13" x2="18" y1="16.5" y2="16.5"></line>
</svg>
</div>
<span style="font-size: 0.95rem; font-weight: 600;"><?php echo get_field('section_txt_64'); ?></span>
</li>

<!-- feature 5: direct message -->
<li>
<div class="perk-bubble" style="box-shadow: 0 4px 12px rgba(189, 69, 31, 0.1);">
<svg fill="none" height="22" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" viewbox="0 0 24 24" width="22">
<line x1="22" x2="11" y1="2" y2="13"></line>
<polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
</svg>
</div>
<span style="font-size: 0.95rem; font-weight: 600;"><?php echo get_field('section_txt_65'); ?></span>
</li>

<!-- feature 6: promote business -->
<li>
<div class="perk-bubble" style="box-shadow: 0 4px 12px rgba(189, 69, 31, 0.1);">
<svg fill="none" height="22" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" viewbox="0 0 24 24" width="22">
<circle cx="12" cy="12" r="10"></circle>
<line x1="12" x2="12" y1="8" y2="12"></line>
<circle cx="12" cy="12" fill="currentColor" r="1" stroke="none"></circle>
<circle cx="8" cy="6" fill="currentColor" r="0.5" stroke="none"></circle>
<circle cx="16" cy="6" fill="currentColor" r="0.5" stroke="none"></circle>
<circle cx="18" cy="10" fill="currentColor" r="0.5" stroke="none"></circle>
</svg>
</div>
<span style="font-size: 0.95rem; font-weight: 600;"><?php echo get_field('section_txt_66'); ?></span>
</li>
</ul>
</div>
<div class="split__media">
<img alt="Get Social With Us - Kings Club Community App" src="<?php echo kc_img('section_img_58', 'front-page-img/kings-img44.webp'); ?>" loading="lazy"/>
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
<!-- impact section -->
<section class="section content-panel section--impact" style="position: relative; padding: var(--space-3xl) 0;">
<!-- impact background image -->
<img alt="Impact - Giving Back" src="<?php echo kc_img('section_img_68', 'front-page-img/kings-img20.webp'); ?>" style="position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; z-index: 0;" loading="lazy"/>
<div class="container" style="position: relative; z-index: 1;">
<div class="impact-card" style="background: var(--glass-bg-dark); backdrop-filter: var(--glass-blur); padding: clamp(2rem, 4vw, 4rem); border-radius: var(--radius-card); max-width: 650px;">
<span class="text-overline" style="display: block; margin-bottom: var(--space-sm); color: var(--color-bg-ivory);"><?php echo get_field('section_txt_72'); ?></span>
<h2 style="color: var(--color-bg-ivory); margin-bottom: var(--space-md);"><?php echo get_field('section_txt_69'); ?></h2>
<p style="color: var(--color-bg-ivory); margin-bottom: var(--space-md); line-height: 1.7;"><?php echo get_field('section_txt_70'); ?></p>
<p style="color: var(--color-bg-ivory); margin-bottom: var(--space-xl); line-height: 1.7;"><?php echo get_field('section_txt_71'); ?></p>
<div style="display: flex; align-items: center; gap: var(--space-lg); flex-wrap: wrap;">
<a class="btn" href="<?php echo esc_url( home_url( '/impact/' ) ); ?>">Learn More</a>
</div>
</div>
</div>
</section>
<!-- journal preview -->
<section class="section content-panel section--journal" style="position: relative; overflow: hidden;">
<!-- Background floating confetti -->
<style>
.journal-bg-icon { position: absolute; pointer-events: none; z-index: 0; }
</style>
<!-- 1. Terracotta Sparkle -->
<!-- 2. Soft Blush Heart -->
<!-- 3. Ivory Sparkle -->
<!-- 4. Terracotta Heart -->
<!-- 5. Soft Blush Sparkle -->
<div class="container" style="position: relative; z-index: 1;">
<div class="section__header-row" style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: var(--space-xl); flex-wrap: wrap; gap: var(--space-md);">
<div>
<span class="text-overline"><?php echo get_field('section_txt_85'); ?></span>
<h2 style="color: #BD451F; margin-bottom: 0;"><?php echo get_field('section_txt_78'); ?></h2>
</div>
<div class="journal-cta-wrap journal-cta-wrap--desktop" style="align-self: flex-end; margin-bottom: 5px;">
<a class="btn" href="<?php echo esc_url( home_url( '/news/' ) ); ?>">Read News <svg fill="none" height="16" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" style="margin-left: 8px;" viewbox="0 0 24 24" width="16">
<line x1="5" x2="19" y1="12" y2="12"></line>
<polyline points="12 5 19 12 12 19"></polyline>
</svg></a>
</div>
</div>
<div class="journal-grid">
<!-- journal card 1 -->
<article class="card-glass">
<img alt="Galentine's 2026" src="<?php echo kc_img('section_img_75', 'front-page-img/kings-img33.webp'); ?>" style="width: 100%; aspect-ratio: 16/9; object-fit: cover; border-radius: var(--radius-card) var(--radius-card) 0 0;" loading="lazy"/>
<div class="journal-card__body">
<div class="journal-card__meta bg-ivory" style="display:inline-block;  color:var(--color-primary); padding:0.25rem 0.75rem; border-radius:12px; font-size:0.75rem; font-weight:700; margin-bottom:0.75rem; box-shadow:0 4px 8px rgba(0,0,0,0.05); text-transform:uppercase;"><?php echo get_field('section_txt_87'); ?></div>
<h3 class="journal-card__title"><?php echo get_field('section_txt_79'); ?></h3>
<p class="journal-card__excerpt"><?php echo get_field('section_txt_82'); ?></p>
</div>
</article>
<!-- journal card 2 -->
<article class="card-glass">
<img alt="Triple Anniversary Celebration" src="<?php echo kc_img('section_img_76', 'front-page-img/kings-img34.webp'); ?>" style="width: 100%; aspect-ratio: 16/9; object-fit: cover; border-radius: var(--radius-card) var(--radius-card) 0 0;" loading="lazy"/>
<div class="journal-card__body">
<div class="journal-card__meta bg-ivory" style="display:inline-block;  color:var(--color-primary); padding:0.25rem 0.75rem; border-radius:12px; font-size:0.75rem; font-weight:700; margin-bottom:0.75rem; box-shadow:0 4px 8px rgba(0,0,0,0.05); text-transform:uppercase;"><?php echo get_field('section_txt_88'); ?></div>
<h3 class="journal-card__title"><?php echo get_field('section_txt_80'); ?></h3>
<p class="journal-card__excerpt"><?php echo get_field('section_txt_83'); ?></p>
</div>
</article>
<!-- journal card 3 -->
<article class="card-glass">
<img alt="Manille Céramique Pottery Studio" src="<?php echo kc_img('section_img_77', 'front-page-img/kings-img35.webp'); ?>" style="width: 100%; aspect-ratio: 16/9; object-fit: cover; border-radius: var(--radius-card) var(--radius-card) 0 0;" loading="lazy"/>
<div class="journal-card__body">
<div class="journal-card__meta bg-ivory" style="display:inline-block;  color:var(--color-primary); padding:0.25rem 0.75rem; border-radius:12px; font-size:0.75rem; font-weight:700; margin-bottom:0.75rem; box-shadow:0 4px 8px rgba(0,0,0,0.05); text-transform:uppercase;"><?php echo get_field('section_txt_89'); ?></div>
<h3 class="journal-card__title"><?php echo get_field('section_txt_81'); ?></h3>
<p class="journal-card__excerpt"><?php echo get_field('section_txt_84'); ?></p>
</div>
</article>
</div>
<!-- mobile read news cta -->
<div class="journal-cta-wrap journal-cta-wrap--mobile text-right" style="margin-top: var(--space-md);">
<a class="btn" href="<?php echo esc_url( home_url( '/news/' ) ); ?>">Read News <svg fill="none" height="16" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" style="margin-left: 8px;" viewbox="0 0 24 24" width="16">
<line x1="5" x2="19" y1="12" y2="12"></line>
<polyline points="12 5 19 12 12 19"></polyline>
</svg></a>
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
      </script><script>
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

    // SVG Line-Drawing Animation (What Defines Us)
    const definesIcons = document.querySelectorAll('.defines-icon');
    if (definesIcons.length > 0) {
      const iconObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            entry.target.classList.add('is-drawing');
            // After the initial draw completes, add looping class
            setTimeout(() => {
              entry.target.classList.add('is-looping');
            }, 2500);
          }
        });
      }, { threshold: 0.3 });

      definesIcons.forEach(icon => iconObserver.observe(icon));
    }
  </script>

<?php
get_footer();
?>
