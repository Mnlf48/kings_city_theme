<?php
/* Template Name: News & Insights */
get_header();
?>

<main id="main-content">
<!-- hero section -->
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
<!-- media on right -->
<div class="split__media hero__slider" id="hero-slider" style="position: relative; aspect-ratio: 4/3; overflow: hidden; border-radius: var(--radius-card);">
<!-- news hero placeholder -->
<div class="hero__slide is-active" style="display: flex; align-items: center; justify-content: center; color: var(--color-text-muted); font-size: 1.2rem; font-weight: 500; text-transform: uppercase; letter-spacing: 0.05em; position: absolute; inset: 0; opacity: 1; transition: opacity 1s ease-in-out; background-color: var(--color-border-light);">
              NO IMAGE
            </div>
</div>
</div>
</div>
</section>
<!-- section 1 (blush) -->
<section class="section content-panel bg-blush" style="position: relative; overflow: hidden;">
  <!-- Background Floating Icons (Pink-Optimized Mix) -->
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
<div class="journal-grid">
<article class="card-glass">
<div style="width: 100%; aspect-ratio: 16/9; background-color: var(--color-border-light); display: flex; align-items: center; justify-content: center; color: var(--color-text-muted); font-size: 0.8rem; font-weight: 500; text-transform: uppercase; border-radius: var(--radius-card) var(--radius-card) 0 0;">
              No Image
            </div>
<div style="padding: var(--space-lg);">
<span class="text-overline" style="font-size: 0.7rem; color: var(--color-accent-red);"><?php echo get_field('overline_11'); ?></span>
<h3 style="font-family: var(--font-heading); margin-top: 0.5rem; margin-bottom: 1rem; line-height: 1.3;"><?php echo get_field('h3_5'); ?></h3>
<p style="color: var(--color-text-muted); font-size: 0.9rem; line-height: 1.6; margin-bottom: 1.5rem;"><?php echo get_field('p_8'); ?></p>
<div style="display: flex; justify-content: space-between; align-items: center;">
<span style="font-size: 0.75rem; color: var(--color-text-muted);">February 28, 2026</span>
<a class="btn btn--small" href="#" style="padding: 0.5rem 1rem; font-size: 0.8rem;">Read More</a>
</div>
</div>
</article>
<article class="card-glass">
<div style="width: 100%; aspect-ratio: 16/9; background-color: var(--color-border-light); display: flex; align-items: center; justify-content: center; color: var(--color-text-muted); font-size: 0.8rem; font-weight: 500; text-transform: uppercase; border-radius: var(--radius-card) var(--radius-card) 0 0;">
              No Image
            </div>
<div style="padding: var(--space-lg);">
<span class="text-overline" style="font-size: 0.7rem; color: var(--color-accent-red);"><?php echo get_field('overline_12'); ?></span>
<h3 style="font-family: var(--font-heading); margin-top: 0.5rem; margin-bottom: 1rem; line-height: 1.3;"><?php echo get_field('h3_6'); ?></h3>
<p style="color: var(--color-text-muted); font-size: 0.9rem; line-height: 1.6; margin-bottom: 1.5rem;"><?php echo get_field('p_9'); ?></p>
<div style="display: flex; justify-content: space-between; align-items: center;">
<span style="font-size: 0.75rem; color: var(--color-text-muted);">January 31, 2026</span>
<a class="btn btn--small" href="#" style="padding: 0.5rem 1rem; font-size: 0.8rem;">Read More</a>
</div>
</div>
</article>
<article class="card-glass">
<div style="width: 100%; aspect-ratio: 16/9; background-color: var(--color-border-light); display: flex; align-items: center; justify-content: center; color: var(--color-text-muted); font-size: 0.8rem; font-weight: 500; text-transform: uppercase; border-radius: var(--radius-card) var(--radius-card) 0 0;">
              No Image
            </div>
<div style="padding: var(--space-lg);">
<span class="text-overline" style="font-size: 0.7rem; color: var(--color-accent-red);"><?php echo get_field('overline_13'); ?></span>
<h3 style="font-family: var(--font-heading); margin-top: 0.5rem; margin-bottom: 1rem; line-height: 1.3;"><?php echo get_field('h3_7'); ?></h3>
<p style="color: var(--color-text-muted); font-size: 0.9rem; line-height: 1.6; margin-bottom: 1.5rem;"><?php echo get_field('p_10'); ?></p>
<div style="display: flex; justify-content: space-between; align-items: center;">
<span style="font-size: 0.75rem; color: var(--color-text-muted);">April 28, 2026</span>
<a class="btn btn--small" href="#" style="padding: 0.5rem 1rem; font-size: 0.8rem;">Read More</a>
</div>
</div>
</article>
</div>
</div>
</section>
<!-- section 2 (ivory) -->
<section class="section content-panel bg-ivory" style="position: relative; overflow: hidden;">
  <!-- Background Floating Icons (Ivory Optimized Mix) -->
  <div class="floating-bg-icon anim-float-fast" style="top: 10%; left: 8%; color: var(--color-accent-red);">
    <svg viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" /></svg>
  </div>
  <div class="floating-bg-icon anim-pulse" style="top: 15%; right: 10%; color: var(--color-accent-gold);">
    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
  </div>
    <div class="floating-bg-icon anim-float-fast" style="top: 55%; right: 20%; color: var(--color-primary);">
    <svg viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" /></svg>
  </div>
  <div class="floating-bg-icon anim-pulse" style="bottom: 15%; left: 10%; color: var(--color-accent-gold);">
    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
  </div>
  <div class="container" style="position: relative; z-index: 2;">
<div class="journal-grid">
<article class="card-glass">
<div style="width: 100%; aspect-ratio: 16/9; background-color: var(--color-border-light); display: flex; align-items: center; justify-content: center; color: var(--color-text-muted); font-size: 0.8rem; font-weight: 500; text-transform: uppercase; border-radius: var(--radius-card) var(--radius-card) 0 0;">
              No Image
            </div>
<div style="padding: var(--space-lg);">
<span class="text-overline" style="font-size: 0.7rem; color: var(--color-accent-red);"><?php echo get_field('overline_21'); ?></span>
<h3 style="font-family: var(--font-heading); margin-top: 0.5rem; margin-bottom: 1rem; line-height: 1.3;"><?php echo get_field('h3_15'); ?></h3>
<p style="color: var(--color-text-muted); font-size: 0.9rem; line-height: 1.6; margin-bottom: 1.5rem;"><?php echo get_field('p_18'); ?></p>
<div style="display: flex; justify-content: space-between; align-items: center;">
<span style="font-size: 0.75rem; color: var(--color-text-muted);">October 2025</span>
<a class="btn btn--small" href="#" style="padding: 0.5rem 1rem; font-size: 0.8rem;">Read More</a>
</div>
</div>
</article>
<article class="card-glass">
<div style="width: 100%; aspect-ratio: 16/9; background-color: var(--color-border-light); display: flex; align-items: center; justify-content: center; color: var(--color-text-muted); font-size: 0.8rem; font-weight: 500; text-transform: uppercase; border-radius: var(--radius-card) var(--radius-card) 0 0;">
              No Image
            </div>
<div style="padding: var(--space-lg);">
<span class="text-overline" style="font-size: 0.7rem; color: var(--color-accent-red);"><?php echo get_field('overline_22'); ?></span>
<h3 style="font-family: var(--font-heading); margin-top: 0.5rem; margin-bottom: 1rem; line-height: 1.3;"><?php echo get_field('h3_16'); ?></h3>
<p style="color: var(--color-text-muted); font-size: 0.9rem; line-height: 1.6; margin-bottom: 1.5rem;"><?php echo get_field('p_19'); ?></p>
<div style="display: flex; justify-content: space-between; align-items: center;">
<span style="font-size: 0.75rem; color: var(--color-text-muted);">August 2025</span>
<a class="btn btn--small" href="#" style="padding: 0.5rem 1rem; font-size: 0.8rem;">Read More</a>
</div>
</div>
</article>
<article class="card-glass">
<div style="width: 100%; aspect-ratio: 16/9; background-color: var(--color-border-light); display: flex; align-items: center; justify-content: center; color: var(--color-text-muted); font-size: 0.8rem; font-weight: 500; text-transform: uppercase; border-radius: var(--radius-card) var(--radius-card) 0 0;">
              No Image
            </div>
<div style="padding: var(--space-lg);">
<span class="text-overline" style="font-size: 0.7rem; color: var(--color-accent-red);"><?php echo get_field('overline_23'); ?></span>
<h3 style="font-family: var(--font-heading); margin-top: 0.5rem; margin-bottom: 1rem; line-height: 1.3;"><?php echo get_field('h3_17'); ?></h3>
<p style="color: var(--color-text-muted); font-size: 0.9rem; line-height: 1.6; margin-bottom: 1.5rem;"><?php echo get_field('p_20'); ?></p>
<div style="display: flex; justify-content: space-between; align-items: center;">
<span style="font-size: 0.75rem; color: var(--color-text-muted);">August 2025</span>
<a class="btn btn--small" href="#" style="padding: 0.5rem 1rem; font-size: 0.8rem;">Read More</a>
</div>
</div>
</article>
</div>
</div>
</section>
<!-- section 3 (blush) -->
<section class="section content-panel bg-blush" style="position: relative; overflow: hidden;">
  <!-- Background Floating Icons (Pink-Optimized Mix) -->
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
<div class="journal-grid">
<article class="card-glass">
<div style="width: 100%; aspect-ratio: 16/9; background-color: var(--color-border-light); display: flex; align-items: center; justify-content: center; color: var(--color-text-muted); font-size: 0.8rem; font-weight: 500; text-transform: uppercase; border-radius: var(--radius-card) var(--radius-card) 0 0;">
              No Image
            </div>
<div style="padding: var(--space-lg);">
<span class="text-overline" style="font-size: 0.7rem; color: var(--color-accent-red);"><?php echo get_field('overline_31'); ?></span>
<h3 style="font-family: var(--font-heading); margin-top: 0.5rem; margin-bottom: 1rem; line-height: 1.3;"><?php echo get_field('h3_25'); ?></h3>
<p style="color: var(--color-text-muted); font-size: 0.9rem; line-height: 1.6; margin-bottom: 1.5rem;"><?php echo get_field('p_28'); ?></p>
<div style="display: flex; justify-content: space-between; align-items: center;">
<span style="font-size: 0.75rem; color: var(--color-text-muted);">April 2025</span>
<a class="btn btn--small" href="#" style="padding: 0.5rem 1rem; font-size: 0.8rem;">Read More</a>
</div>
</div>
</article>
<article class="card-glass">
<div style="width: 100%; aspect-ratio: 16/9; background-color: var(--color-border-light); display: flex; align-items: center; justify-content: center; color: var(--color-text-muted); font-size: 0.8rem; font-weight: 500; text-transform: uppercase; border-radius: var(--radius-card) var(--radius-card) 0 0;">
              No Image
            </div>
<div style="padding: var(--space-lg);">
<span class="text-overline" style="font-size: 0.7rem; color: var(--color-accent-red);"><?php echo get_field('overline_32'); ?></span>
<h3 style="font-family: var(--font-heading); margin-top: 0.5rem; margin-bottom: 1rem; line-height: 1.3;"><?php echo get_field('h3_26'); ?></h3>
<p style="color: var(--color-text-muted); font-size: 0.9rem; line-height: 1.6; margin-bottom: 1.5rem;"><?php echo get_field('p_29'); ?></p>
<div style="display: flex; justify-content: space-between; align-items: center;">
<span style="font-size: 0.75rem; color: var(--color-text-muted);">March 2025</span>
<a class="btn btn--small" href="#" style="padding: 0.5rem 1rem; font-size: 0.8rem;">Read More</a>
</div>
</div>
</article>
<article class="card-glass">
<div style="width: 100%; aspect-ratio: 16/9; background-color: var(--color-border-light); display: flex; align-items: center; justify-content: center; color: var(--color-text-muted); font-size: 0.8rem; font-weight: 500; text-transform: uppercase; border-radius: var(--radius-card) var(--radius-card) 0 0;">
              No Image
            </div>
<div style="padding: var(--space-lg);">
<span class="text-overline" style="font-size: 0.7rem; color: var(--color-accent-red);"><?php echo get_field('overline_33'); ?></span>
<h3 style="font-family: var(--font-heading); margin-top: 0.5rem; margin-bottom: 1rem; line-height: 1.3;"><?php echo get_field('h3_27'); ?></h3>
<p style="color: var(--color-text-muted); font-size: 0.9rem; line-height: 1.6; margin-bottom: 1.5rem;"><?php echo get_field('p_30'); ?></p>
<div style="display: flex; justify-content: space-between; align-items: center;">
<span style="font-size: 0.75rem; color: var(--color-text-muted);">February 2025</span>
<a class="btn btn--small" href="#" style="padding: 0.5rem 1rem; font-size: 0.8rem;">Read More</a>
</div>
</div>
</article>
</div>
</div>
</section>
<!-- section 4 (ivory) -->
<section class="section content-panel bg-ivory" style="position: relative; overflow: hidden;">
  <!-- Background Floating Icons (Ivory Optimized Mix) -->
  <div class="floating-bg-icon anim-float-fast" style="top: 10%; left: 8%; color: var(--color-accent-red);">
    <svg viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" /></svg>
  </div>
  <div class="floating-bg-icon anim-pulse" style="top: 15%; right: 10%; color: var(--color-accent-gold);">
    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
  </div>
    <div class="floating-bg-icon anim-float-fast" style="top: 55%; right: 20%; color: var(--color-primary);">
    <svg viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" /></svg>
  </div>
  <div class="floating-bg-icon anim-pulse" style="bottom: 15%; left: 10%; color: var(--color-accent-gold);">
    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
  </div>
  <div class="container" style="position: relative; z-index: 2;">
<div class="journal-grid">
<article class="card-glass">
<div style="width: 100%; aspect-ratio: 16/9; background-color: var(--color-border-light); display: flex; align-items: center; justify-content: center; color: var(--color-text-muted); font-size: 0.8rem; font-weight: 500; text-transform: uppercase; border-radius: var(--radius-card) var(--radius-card) 0 0;">
              No Image
            </div>
<div style="padding: var(--space-lg);">
<span class="text-overline" style="font-size: 0.7rem; color: var(--color-accent-red);"><?php echo get_field('overline_39'); ?></span>
<h3 style="font-family: var(--font-heading); margin-top: 0.5rem; margin-bottom: 1rem; line-height: 1.3;"><?php echo get_field('h3_35'); ?></h3>
<p style="color: var(--color-text-muted); font-size: 0.9rem; line-height: 1.6; margin-bottom: 1.5rem;"><?php echo get_field('p_38'); ?></p>
<div style="display: flex; justify-content: space-between; align-items: center;">
<span style="font-size: 0.75rem; color: var(--color-text-muted);">January 2025</span>
<a class="btn btn--small" href="#" style="padding: 0.5rem 1rem; font-size: 0.8rem;">Read More</a>
</div>
</div>
</article>
<article class="card-glass">
<div style="width: 100%; aspect-ratio: 16/9; background-color: var(--color-border-light); display: flex; align-items: center; justify-content: center; color: var(--color-text-muted); font-size: 0.8rem; font-weight: 500; text-transform: uppercase; border-radius: var(--radius-card) var(--radius-card) 0 0;">
              No Image
            </div>
<div style="padding: var(--space-lg);">
<span class="text-overline" style="font-size: 0.7rem; color: var(--color-accent-red);"><?php echo get_field('overline_40'); ?></span>
<h3 style="font-family: var(--font-heading); margin-top: 0.5rem; margin-bottom: 1.5rem; line-height: 1.3;"><?php echo get_field('h3_36'); ?></h3>
<div style="display: flex; justify-content: space-between; align-items: center;">
<span style="font-size: 0.75rem; color: var(--color-text-muted);">December 2024</span>
<a class="btn btn--small" href="#" style="padding: 0.5rem 1rem; font-size: 0.8rem;">Read More</a>
</div>
</div>
</article>
<article class="card-glass">
<div style="width: 100%; aspect-ratio: 16/9; background-color: var(--color-border-light); display: flex; align-items: center; justify-content: center; color: var(--color-text-muted); font-size: 0.8rem; font-weight: 500; text-transform: uppercase; border-radius: var(--radius-card) var(--radius-card) 0 0;">
              No Image
            </div>
<div style="padding: var(--space-lg);">
<span class="text-overline" style="font-size: 0.7rem; color: var(--color-accent-red);"><?php echo get_field('overline_41'); ?></span>
<h3 style="font-family: var(--font-heading); margin-top: 0.5rem; margin-bottom: 1.5rem; line-height: 1.3;"><?php echo get_field('h3_37'); ?></h3>
<div style="display: flex; justify-content: space-between; align-items: center;">
<span style="font-size: 0.75rem; color: var(--color-text-muted);">December 2024</span>
<a class="btn btn--small" href="#" style="padding: 0.5rem 1rem; font-size: 0.8rem;">Read More</a>
</div>
</div>
</article>
</div>
</div>
</section>
<!-- section 5 (blush) -->
<section class="section content-panel bg-blush" style="position: relative; overflow: hidden;">
  <!-- Background Floating Icons (Pink-Optimized Mix) -->
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
<div class="journal-grid">
<article class="card-glass">
<div style="width: 100%; aspect-ratio: 16/9; background-color: var(--color-border-light); display: flex; align-items: center; justify-content: center; color: var(--color-text-muted); font-size: 0.8rem; font-weight: 500; text-transform: uppercase; border-radius: var(--radius-card) var(--radius-card) 0 0;">
              No Image
            </div>
<div style="padding: var(--space-lg);">
<span class="text-overline" style="font-size: 0.7rem; color: var(--color-accent-red);"><?php echo get_field('overline_49'); ?></span>
<h3 style="font-family: var(--font-heading); margin-top: 0.5rem; margin-bottom: 1rem; line-height: 1.3;"><?php echo get_field('h3_43'); ?></h3>
<p style="color: var(--color-text-muted); font-size: 0.9rem; line-height: 1.6; margin-bottom: 1.5rem;"><?php echo get_field('p_46'); ?></p>
<div style="display: flex; justify-content: space-between; align-items: center;">
<span style="font-size: 0.75rem; color: var(--color-text-muted);">September 2025</span>
<a class="btn btn--small" href="#" style="padding: 0.5rem 1rem; font-size: 0.8rem;">Read More</a>
</div>
</div>
</article>
<article class="card-glass">
<div style="width: 100%; aspect-ratio: 16/9; background-color: var(--color-border-light); display: flex; align-items: center; justify-content: center; color: var(--color-text-muted); font-size: 0.8rem; font-weight: 500; text-transform: uppercase; border-radius: var(--radius-card) var(--radius-card) 0 0;">
              No Image
            </div>
<div style="padding: var(--space-lg);">
<span class="text-overline" style="font-size: 0.7rem; color: var(--color-accent-red);"><?php echo get_field('overline_50'); ?></span>
<h3 style="font-family: var(--font-heading); margin-top: 0.5rem; margin-bottom: 1rem; line-height: 1.3;"><?php echo get_field('h3_44'); ?></h3>
<p style="color: var(--color-text-muted); font-size: 0.9rem; line-height: 1.6; margin-bottom: 1.5rem;"><?php echo get_field('p_47'); ?></p>
<div style="display: flex; justify-content: space-between; align-items: center;">
<span style="font-size: 0.75rem; color: var(--color-text-muted);">July 2025</span>
<a class="btn btn--small" href="#" style="padding: 0.5rem 1rem; font-size: 0.8rem;">Read More</a>
</div>
</div>
</article>
<article class="card-glass">
<div style="width: 100%; aspect-ratio: 16/9; background-color: var(--color-border-light); display: flex; align-items: center; justify-content: center; color: var(--color-text-muted); font-size: 0.8rem; font-weight: 500; text-transform: uppercase; border-radius: var(--radius-card) var(--radius-card) 0 0;">
              No Image
            </div>
<div style="padding: var(--space-lg);">
<span class="text-overline" style="font-size: 0.7rem; color: var(--color-accent-red);"><?php echo get_field('overline_51'); ?></span>
<h3 style="font-family: var(--font-heading); margin-top: 0.5rem; margin-bottom: 1rem; line-height: 1.3;"><?php echo get_field('h3_45'); ?></h3>
<p style="color: var(--color-text-muted); font-size: 0.9rem; line-height: 1.6; margin-bottom: 1.5rem;"><?php echo get_field('p_48'); ?></p>
<div style="display: flex; justify-content: space-between; align-items: center;">
<span style="font-size: 0.75rem; color: var(--color-text-muted);">May 2025</span>
<a class="btn btn--small" href="#" style="padding: 0.5rem 1rem; font-size: 0.8rem;">Read More</a>
</div>
</div>
</article>
</div>
</div>
</section>
</main>

<?php get_footer(); ?>
