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
<?php
$about_hero_btn_text = get_field('proposed_about_hero_btn_text') ?: 'Read Our Story';
$about_hero_btn_url  = get_field('proposed_about_hero_btn_url')  ?: '#our-story';
?>
<a class="btn" href="<?php echo esc_url($about_hero_btn_url); ?>"><?php echo esc_html($about_hero_btn_text); ?></a>
</div>
</div>
<!-- slider on right -->
<div class="split__media hero__slider" id="hero-slider" style="position: relative; aspect-ratio: 4/3; overflow: hidden; border-radius: var(--radius-card);">
<!-- slide 1 -->
<img alt="About Kings City 1" class="hero__slide is-active" src="<?php echo kc_img('image_4', 'page-about-img/kings-img30.webp'); ?>" style="position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; opacity: 1; transition: opacity 1s ease-in-out;"/>
<!-- slide 2 -->
<img alt="About Kings City 2" class="hero__slide" src="<?php echo kc_img('image_5', 'page-about-img/kings_img05.webp'); ?>" style="position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; opacity: 0; transition: opacity 1s ease-in-out;"/>
<!-- slide 3 -->
<img alt="About Kings City 3" class="hero__slide" src="<?php echo kc_img('image_6', 'page-about-img/kings_img06.webp'); ?>" style="position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; opacity: 0; transition: opacity 1s ease-in-out;"/>
</div>
</div>
</div>
</section>
<!-- our story / mission -->
<section class="section content-panel section--story" id="our-story" style="position: relative; overflow: hidden;">
  <!-- Background Floating Icons (Pink-Optimized Mix) -->
  <!-- 1 -->
  <!-- 2 -->
  <!-- 3 -->
    <!-- 4 -->
  <!-- 5 -->
  <div class="container grid-12" style="position: relative; z-index: 2;">
<div class="col-12 split" style="align-items: center;">
<div class="split__media">
<img alt="Kings City Bag" src="<?php echo kc_img('image_12', 'page-about-img/kings_img08.webp'); ?>" style="width: 100%; height: 100%; object-fit: cover; aspect-ratio: 4/3; border-radius: var(--radius-card);"/>
</div>
<div class="split__content">
<span class="text-overline"><?php echo get_field('overline_11'); ?></span>
<h2 style="font-family: var(--font-heading); font-weight: 400; color: var(--color-primary); margin-bottom: var(--space-lg); line-height: 1.2;"><?php echo get_field('h2_8'); ?></h2>
<p style="font-size: 1.125rem; color: var(--color-text-muted); line-height: 1.8; margin-bottom: var(--space-md);"><?php echo get_field('p_9'); ?></p>
<p style="font-size: 1.125rem; color: var(--color-text-muted); line-height: 1.8; margin-bottom: 0;"><?php echo get_field('p_10'); ?></p>
</div>
</div>
</div>


          <!-- 1. Star -->
          <!-- 2. Heart -->
          <!-- 3. Star -->
          <!-- 4. Heart -->
          <!-- 5. Star -->
          

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
<!-- mission and vision -->
<section class="section content-panel" id="mission-vision" style="position: relative; overflow: hidden;">

  <!-- Background Floating Icons (Ivory Optimized Mix) -->
  <div class="container grid-12" style="position: relative; z-index: 2;">
    <div class="col-12 split cycle-hover-border">
      <!-- mission card -->
      <div class="split__content card-glass mv-card" style="background-color: var(--color-secondary);">
        <div class="universal-icon-wrapper" style="margin-bottom: var(--space-md);">
          <!-- Intricate Mission Compass Icon -->
          <svg fill="none" height="32" stroke="var(--color-bg-ivory)" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24" width="32"><path fill="var(--color-primary)" fill-opacity="0.3" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10c1.38 0 2.5-1.12 2.5-2.5 0-.53-.21-1.04-.59-1.41-.37-.38-.59-.88-.59-1.41 0-1.1.9-2 2-2h1.67c2.65 0 4.83-2.18 4.83-4.83C21.83 6.31 17.43 2 12 2z"></path><circle cx="12" cy="12" r="3" fill="var(--color-accent-gold)" stroke="none"></circle><path d="M12 2v6" stroke="var(--color-accent-gold)"></path><path d="M12 22v-6" stroke="var(--color-accent-gold)"></path><path d="M2 12h6" stroke="var(--color-accent-gold)"></path><path d="M22 12h-6" stroke="var(--color-accent-gold)"></path></svg>
        </div>
        <span class="text-overline"><?php echo get_field('overline_mv_mission'); ?></span>
        <h2 class="mv-card__title"><?php echo get_field('h3_mv_mission'); ?></h2>
        <p class="mv-card__text"><?php echo get_field('p_mv_mission'); ?></p>
      </div>
      <!-- vision card -->
      <div class="split__content card-glass card-glass--strong section--brown mv-card">
        <div class="universal-icon-wrapper" style="margin-bottom: var(--space-md);">
          <!-- Intricate Vision Diamond Icon -->
          <svg fill="none" height="32" stroke="var(--color-bg-ivory)" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24" width="32"><path fill="var(--color-secondary)" fill-opacity="0.8" d="M2 12l10-10 10 10-10 10Z"></path><path fill="var(--color-accent-gold)" d="M12 8l3 4-3 4-3-4Z" stroke="none"></path><circle cx="12" cy="12" r="1.5" fill="var(--color-bg-ivory)" stroke="none"></circle></svg>
        </div>
        <span class="text-overline"><?php echo get_field('overline_mv_vision'); ?></span>
        <h2 class="mv-card__title"><?php echo get_field('h3_mv_vision'); ?></h2>
        <p class="mv-card__text"><?php echo get_field('p_mv_vision'); ?></p>
      </div>
    </div>
  </div>


          <!-- 1. Star -->
          <!-- 2. Heart -->
          <!-- 3. Star -->
          <!-- 4. Heart -->
          <!-- 5. Star -->
          

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
<!-- philippines map section -->
<section class="section content-panel section--map" style="position: relative; overflow: hidden;">
  <!-- Background Floating Icons (Pink-Optimized Mix) -->
  <!-- 1 -->
  <!-- 2 -->
  <!-- 3 -->
    <!-- 4 -->
  <!-- 5 -->
  <div class="container grid-12" style="position: relative; z-index: 2;">
<div class="col-12 split">
<div class="split__content animate-fadeInUp">
<span class="text-overline"><?php echo get_field('overline_17'); ?></span>
<h2 style="font-family: var(--font-heading); font-weight: 400; color: var(--color-primary); margin-bottom: var(--space-md);"><?php echo get_field('h2_14'); ?></h2>
<p style="color: var(--color-text-muted); line-height: 1.7; margin-bottom: var(--space-md);"><?php echo get_field('p_15'); ?></p>
<p style="color: var(--color-text-muted); line-height: 1.7; margin-bottom: 0;"><?php echo get_field('p_16'); ?></p>
</div>
<div class="split__media text-center">
<img alt="Philippine Map" src="<?php echo kc_img('image_18', 'page-about-img/kings-img58.png'); ?>" style="max-width: 100%; height: auto; max-height: 400px; object-fit: contain; filter: drop-shadow(0 10px 20px rgba(0,0,0,0.05));"/>
</div>
</div>
</div>


          <!-- 1. Star -->
          <!-- 2. Heart -->
          <!-- 3. Star -->
          <!-- 4. Heart -->
          <!-- 5. Star -->
          

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
<!-- core values grid -->
<section class="core-values-section content-panel bg-ivory" style="position: relative; overflow: hidden; padding: var(--space-3xl) 0;">

  <!-- Background Floating Icons (Ivory Optimized Mix) -->
  <div class="core-values-container" style="position: relative; z-index: 2;">
    <div class="text-center" style="margin-bottom: var(--space-2xl);">
      <span class="text-overline"><?php echo get_field('overline_29'); ?></span>
      <h2 style="font-family: var(--font-heading); font-weight: 400; color: var(--color-primary);"><?php echo get_field('h2_20'); ?></h2>
    </div>
    <div class="universal-glass-grid cycle-card-bg">
      <!-- card 1 -->
      <div class="card-glass text-center compact-mobile" style="display: flex; flex-direction: column; align-items: center; padding: var(--space-xl) var(--space-lg);">
        <div class="universal-icon-wrapper" style="margin-bottom: var(--space-md);">
          <!-- Glowing Heart (Value 1) -->
          <svg fill="none" height="32" stroke="var(--color-primary)" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24" width="32"><path fill="var(--color-accent-red)" fill-opacity="0.3" d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path><circle cx="15.5" cy="8.5" r="1.5" fill="var(--color-accent-gold)" stroke="none"></circle></svg>
        </div>
        <span class="text-overline" style="margin-bottom: 0.5rem; color: var(--color-secondary);">01.</span>
        <h3 style="margin-top: 0; font-size: 1.5rem;"><?php echo get_field('h3_21'); ?></h3>
        <p style="color: var(--color-text-muted); font-size: 1rem;"><?php echo get_field('p_25'); ?></p>
      </div>
      <!-- card 2 -->
      <div class="card-glass text-center compact-mobile" style="display: flex; flex-direction: column; align-items: center; padding: var(--space-xl) var(--space-lg);">
        <div class="universal-icon-wrapper" style="margin-bottom: var(--space-md);">
          <!-- Sparkling Crown (Value 2) -->
          <svg fill="none" height="32" stroke="var(--color-primary)" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24" width="32"><path fill="var(--color-secondary)" fill-opacity="0.3" d="M2 20h20"></path><path fill="var(--color-accent-gold)" fill-opacity="0.3" d="M4 20L5 8l4 4 3-6 3 6 4-4 1 12H4z"></path><circle cx="12" cy="4" r="1.5" fill="var(--color-accent-gold)" stroke="none"></circle><circle cx="5" cy="5" r="1" fill="var(--color-primary)" stroke="none"></circle><circle cx="19" cy="5" r="1" fill="var(--color-primary)" stroke="none"></circle></svg>
        </div>
        <span class="text-overline" style="margin-bottom: 0.5rem; color: var(--color-secondary);">02.</span>
        <h3 style="margin-top: 0; font-size: 1.5rem;"><?php echo get_field('h3_22'); ?></h3>
        <p style="color: var(--color-text-muted); font-size: 1rem;"><?php echo get_field('p_26'); ?></p>
      </div>
      <!-- card 3 -->
      <div class="card-glass text-center compact-mobile" style="display: flex; flex-direction: column; align-items: center; padding: var(--space-xl) var(--space-lg);">
        <div class="universal-icon-wrapper" style="margin-bottom: var(--space-md);">
          <!-- Blooming Flower (Value 3) -->
          <svg fill="none" height="32" stroke="var(--color-primary)" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24" width="32"><path fill="var(--color-bg-pink)" d="M12 22v-6"></path><path fill="var(--color-primary)" fill-opacity="0.2" d="M12 16a4 4 0 0 0-4-4 4 4 0 0 0-4 4c0 2 1.5 3 4 3s4-1 4-3z"></path><path fill="var(--color-accent-gold)" fill-opacity="0.2" d="M12 16a4 4 0 0 1 4-4 4 4 0 0 1 4 4c0 2-1.5 3-4 3s-4-1-4-3z"></path><path fill="var(--color-secondary)" fill-opacity="0.4" d="M12 16a4 4 0 0 1-4-4 4 4 0 0 1 4-4c0-2 1.5-3 4-3s4 1 4 3a4 4 0 0 1-4 4z"></path></svg>
        </div>
        <span class="text-overline" style="margin-bottom: 0.5rem; color: var(--color-secondary);">03.</span>
        <h3 style="margin-top: 0; font-size: 1.5rem;"><?php echo get_field('h3_23'); ?></h3>
        <p style="color: var(--color-text-muted); font-size: 1rem;"><?php echo get_field('p_27'); ?></p>
      </div>
      <!-- card 4 -->
      <div class="card-glass text-center compact-mobile" style="display: flex; flex-direction: column; align-items: center; padding: var(--space-xl) var(--space-lg);">
        <div class="universal-icon-wrapper" style="margin-bottom: var(--space-md);">
          <!-- Crystal Diamond (Value 4) -->
          <svg fill="none" height="32" stroke="var(--color-primary)" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24" width="32"><path fill="var(--color-secondary)" fill-opacity="0.3" d="M2 12l10-10 10 10-10 10Z"></path><path fill="var(--color-accent-gold)" d="M12 8l3 4-3 4-3-4Z" stroke="none"></path><circle cx="12" cy="12" r="1.5" fill="var(--color-primary)" stroke="none"></circle></svg>
        </div>
        <span class="text-overline" style="margin-bottom: 0.5rem; color: var(--color-secondary);">04.</span>
        <h3 style="margin-top: 0; font-size: 1.5rem;"><?php echo get_field('h3_24'); ?></h3>
        <p style="color: var(--color-text-muted); font-size: 1rem;"><?php echo get_field('p_28'); ?></p>
      </div>
    </div>
  </div>


          <!-- 1. Star -->
          <!-- 2. Heart -->
          <!-- 3. Star -->
          <!-- 4. Heart -->
          <!-- 5. Star -->
          

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
<!-- timeline / how we got here -->
<section class="section content-panel" style="padding: var(--space-3xl) 0; position: relative; overflow: hidden;">

  <!-- Background Floating Icons -->
  <div class="container" style="max-width: 800px; position: relative; z-index: 2;">
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
<span class="snake-year"><?php echo esc_html(get_field('proposed_timeline_year_1') ?: '1999'); ?></span>
<h3 class="snake-title"><?php echo get_field('h3_32'); ?></h3>
<p class="snake-desc"><?php echo get_field('p_41'); ?></p>
</div>
</div>
<!-- -->
<div class="snake-item">
<div class="snake-dot"></div>
<div class="snake-content">
<span class="snake-year"><?php echo esc_html(get_field('proposed_timeline_year_2') ?: '2005'); ?></span>
<h3 class="snake-title"><?php echo get_field('h3_33'); ?></h3>
<p class="snake-desc"><?php echo get_field('p_42'); ?></p>
</div>
</div>
<!-- -->
<div class="snake-item">
<div class="snake-dot"></div>
<div class="snake-content">
<span class="snake-year"><?php echo esc_html(get_field('proposed_timeline_year_3') ?: '2009'); ?></span>
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
<span class="snake-year"><?php echo esc_html(get_field('proposed_timeline_year_4') ?: '2011'); ?></span>
<h3 class="snake-title"><?php echo get_field('h3_35'); ?></h3>
<p class="snake-desc"><?php echo get_field('p_44'); ?></p>
</div>
</div>
<!-- -->
<div class="snake-item">
<div class="snake-dot"></div>
<div class="snake-content">
<span class="snake-year"><?php echo esc_html(get_field('proposed_timeline_year_5') ?: '2016'); ?></span>
<h3 class="snake-title"><?php echo get_field('h3_36'); ?></h3>
<p class="snake-desc"><?php echo get_field('p_45'); ?></p>
</div>
</div>
<!-- -->
<div class="snake-item">
<div class="snake-dot"></div>
<div class="snake-content">
<span class="snake-year"><?php echo esc_html(get_field('proposed_timeline_year_6') ?: '2017'); ?></span>
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
<span class="snake-year"><?php echo esc_html(get_field('proposed_timeline_year_7') ?: '2019'); ?></span>
<h3 class="snake-title"><?php echo get_field('h3_38'); ?></h3>
<p class="snake-desc"><?php echo get_field('p_47'); ?></p>
</div>
</div>
<!-- -->
<div class="snake-item">
<div class="snake-dot"></div>
<div class="snake-content">
<span class="snake-year"><?php echo esc_html(get_field('proposed_timeline_year_8') ?: '2020'); ?></span>
<h3 class="snake-title"><?php echo get_field('h3_39'); ?></h3>
<p class="snake-desc"><?php echo get_field('p_48'); ?></p>
</div>
</div>
<!-- -->
<div class="snake-item">
<div class="snake-dot"></div>
<div class="snake-content">
<span class="snake-year"><?php echo esc_html(get_field('proposed_timeline_year_9') ?: '2025'); ?></span>
<h3 class="snake-title"><?php echo get_field('h3_40'); ?></h3>
<p class="snake-desc"><?php echo get_field('p_49'); ?></p>
</div>
</div>
</div>
<!-- row 4 (2026 centered finale) -->
<div class="snake-row snake-row--centered-finale">
<!-- empty spacer for right (row-reverse places first item on right) -->
<div class="snake-item" style="visibility: hidden;"></div>
<!-- 10th item (sits in the middle) -->
<div class="snake-item">
<div class="snake-dot"></div>
<div class="snake-content">
<span class="snake-year"><?php echo esc_html(get_field('proposed_timeline_year_10') ?: '2026'); ?></span>
<h3 class="snake-title"><?php echo get_field('h3_41') ?: 'Social Manila Lifestyle'; ?></h3>
<p class="snake-desc"><?php echo get_field('p_50'); ?></p>
</div>
</div>
<!-- empty spacer for left -->
<div class="snake-item" style="visibility: hidden;"></div>
</div>
</div>
</div>


          <!-- 1. Star -->
          <!-- 2. Heart -->
          <!-- 3. Star -->
          <!-- 4. Heart -->
          <!-- 5. Star -->
          

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
<div class="container grid-12" style="position: relative; z-index: 1;">
<div class="col-12 split">
<div class="split__media">
<img alt="One Pass. All Access. - Membership Perks" src="<?php echo kc_img('about_pass_image', 'page-about-img/kings_img07.webp'); ?>"/>
</div>
<div class="split__content">
<span class="text-overline" style="display: block; margin-bottom: var(--space-sm);"><?php echo get_field('about_pass_overline'); ?></span>
<h2 style="margin-bottom: var(--space-md);"><?php echo get_field('about_pass_heading'); ?></h2>
<p style="margin-bottom: var(--space-lg);"><?php echo get_field('about_pass_subtext'); ?></p>
<ul class="perks-list perks-list--brands-about">
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


          <!-- 1. Star -->
          <!-- 2. Heart -->
          <!-- 3. Star -->
          <!-- 4. Heart -->
          <!-- 5. Star -->
          

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
<!-- community section -->
<section class="section content-panel section--community" id="community" style="position: relative; overflow: hidden;">
  <!-- Background Floating Icons (Pink-Optimized Mix) -->
  <!-- 1 -->
  <!-- 2 -->
  <!-- 3 -->
  
<div class="container grid-12" style="position: relative; z-index: 2;">
<div class="col-12 split">
<div class="split__content">
<span class="text-overline"><?php echo get_field('overline_community'); ?></span>
<h2 style="font-family: var(--font-heading); font-weight: 400; color: var(--color-primary); margin-bottom: var(--space-lg); line-height: 1.2;"><?php echo get_field('h2_community'); ?></h2>
<p style="font-size: 1.125rem; color: var(--color-text-muted); line-height: 1.8; margin-bottom: var(--space-md);"><?php echo get_field('p_community_1'); ?></p>
<p style="font-size: 1.125rem; color: var(--color-text-muted); line-height: 1.8; margin-bottom: 0;"><?php echo get_field('p_community_2'); ?></p>
</div>
<div class="split__media">
<img alt="Community Image" src="<?php echo kc_img('community_image', 'page-about-img/kings-img55.webp'); ?>" style="width: 100%; height: 100%; object-fit: cover; aspect-ratio: 4/3; border-radius: var(--radius-card);"/>
</div>
</div>
</div>


          <!-- 1. Star -->
          <!-- 2. Heart -->
          <!-- 3. Star -->
          <!-- 4. Heart -->
          <!-- 5. Star -->
          

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

