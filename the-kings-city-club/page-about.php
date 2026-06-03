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
<h1 class="hero__title hero__title--inner"><?php echo get_field('h1_1'); ?></h1>
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
<h2 style="font-family: var(--font-heading); font-weight: 400; font-size: clamp(2.5rem, 4vw, 3.5rem); color: var(--color-primary); margin-bottom: var(--space-lg); line-height: 1.2;"><?php echo get_field('h2_8'); ?></h2>
<p style="font-size: 1.125rem; color: var(--color-text-muted); line-height: 1.8; margin-bottom: var(--space-md);"><?php echo get_field('p_9'); ?></p>
<p style="font-size: 1.125rem; color: var(--color-text-muted); line-height: 1.8; margin-bottom: 0;"><?php echo get_field('p_10'); ?></p>
</div>
</div>
</div>
</section>
<!-- philippines map section -->
<section class="section content-panel section--map">
<div class="container grid-12">
<div class="col-12 split">
<div class="split__media text-center">
<img alt="Philippine Map" src="<?php $img = get_field('image_18'); echo ($img && is_array($img) && isset($img['url'])) ? esc_url($img['url']) : (is_numeric($img) ? wp_get_attachment_image_url($img, 'full') : get_template_directory_uri() . '/assets/img/placeholder.jpg'); ?>" style="max-width: 100%; height: auto; max-height: 400px; object-fit: contain; filter: drop-shadow(0 10px 20px rgba(0,0,0,0.05));"/>
</div>
<div class="split__content animate-fadeInUp">
<span class="text-overline"><?php echo get_field('overline_17'); ?></span>
<h2 style="font-family: var(--font-heading); font-weight: 400; font-size: clamp(2.5rem, 4vw, 3rem); color: var(--color-primary); margin-bottom: var(--space-md);"><?php echo get_field('h2_14'); ?></h2>
<p style="color: var(--color-text-muted); line-height: 1.7; margin-bottom: var(--space-md);"><?php echo get_field('p_15'); ?></p>
<p style="color: var(--color-text-muted); line-height: 1.7; margin-bottom: 0;"><?php echo get_field('p_16'); ?></p>
</div>
</div>
</div>
</section>
<!-- core values grid -->
<section class="core-values-section content-panel">
<div class="core-values-container">
<div class="text-center" style="margin-bottom: var(--space-2xl);">
<span class="text-overline"><?php echo get_field('overline_29'); ?></span>
<h2 style="font-family: var(--font-heading); font-weight: 400; font-size: clamp(2rem, 3.5vw, 3rem); color: var(--color-primary);"><?php echo get_field('h2_20'); ?></h2>
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
<h2 style="font-family: var(--font-heading); font-weight: 400; font-size: clamp(2.5rem, 4vw, 3.5rem); color: var(--color-primary);"><?php echo get_field('h2_31'); ?></h2>
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
<!-- the founders -->
<section class="founders-section content-panel">
<div class="container">
<div class="text-center" style="margin-bottom: var(--space-3xl);">
<span class="text-overline"><?php echo get_field('overline_56'); ?></span>
<h2 style="font-family: var(--font-heading); font-weight: 400; font-size: clamp(2.5rem, 4vw, 3.5rem); color: var(--color-primary);"><?php echo get_field('h2_52'); ?></h2>
<div style="width: 50px; height: 3px; background: var(--color-accent-red); margin: 1rem auto 0; border-radius: 2px;"></div>
</div>
<div class="founders-grid">
<div class="founder-card">
<div style="width: 100%; aspect-ratio: 3/4; background-color: var(--color-bg-ivory); border-radius: var(--radius-card); overflow: hidden; margin-bottom: 1.5rem; position: relative; box-shadow: 0 16px 48px rgba(0,0,0,.12); transition: transform .4s ease, box-shadow .4s ease;">
<img alt="Cory Navarro" onmouseout="this.style.transform='scale(1)'" onmouseover="this.style.transform='scale(1.05)'" src="<?php $img = get_field('image_57'); echo ($img && is_array($img) && isset($img['url'])) ? esc_url($img['url']) : (is_numeric($img) ? wp_get_attachment_image_url($img, 'full') : get_template_directory_uri() . '/assets/img/placeholder.jpg'); ?>" style="width: 100%; height: 100%; object-fit: cover; transition: transform .4s ease;"/>
</div>
<span style="display: block; font-size: .65rem; font-weight: 700; letter-spacing: .22em; text-transform: uppercase; color: var(--color-accent-red); margin-bottom: .4rem;">Founder, Kings Group of Companies</span>
<h3 style="color: var(--color-primary); font-family: var(--font-heading); font-size: 1.5rem; margin-bottom: 1rem;"><?php echo get_field('h3_53'); ?></h3>
<ul style="list-style: none; padding: 0; margin: 0; text-align: left;">
<li style="font-size: .85rem; line-height: 1.5; color: var(--color-text-muted); padding: .4rem 0; border-bottom: 1px solid var(--color-border-light); display: flex; align-items: flex-start; gap: .5rem;">
<span style="color: var(--color-accent-red); font-weight: 700; flex-shrink: 0;">•</span> Hall of Famer, Manila's Best Dressed
              </li>
<li style="font-size: .85rem; line-height: 1.5; color: var(--color-text-muted); padding: .4rem 0; border-bottom: 1px solid var(--color-border-light); display: flex; align-items: flex-start; gap: .5rem;">
<span style="color: var(--color-accent-red); font-weight: 700; flex-shrink: 0;">•</span> Hall of Famer, Zamboanga's Best Dressed
              </li>
<li style="font-size: .85rem; line-height: 1.5; color: var(--color-text-muted); padding: .4rem 0; border-bottom: 1px solid var(--color-border-light); display: flex; align-items: flex-start; gap: .5rem;">
<span style="color: var(--color-accent-red); font-weight: 700; flex-shrink: 0;">•</span> Huwarang Ina Awardee (2017)
              </li>
<li style="font-size: .85rem; line-height: 1.5; color: var(--color-text-muted); padding: .4rem 0; border-bottom: 1px solid var(--color-border-light); display: flex; align-items: flex-start; gap: .5rem;">
<span style="color: var(--color-accent-red); font-weight: 700; flex-shrink: 0;">•</span> Empowered Women of the Philippines (2012 / 2013)
              </li>
<li style="font-size: .85rem; line-height: 1.5; color: var(--color-text-muted); padding: .4rem 0; border-bottom: 1px solid var(--color-border-light); display: flex; align-items: flex-start; gap: .5rem;">
<span style="color: var(--color-accent-red); font-weight: 700; flex-shrink: 0;">•</span> Charter President, Ambassador Charter Club of Melbourne
              </li>
<li style="font-size: .85rem; line-height: 1.5; color: var(--color-text-muted); padding: .4rem 0; display: flex; align-items: flex-start; gap: .5rem;">
<span style="color: var(--color-accent-red); font-weight: 700; flex-shrink: 0;">•</span> Pioneer Nursing Batch, Ateneo de Zamboanga University
              </li>
</ul>
</div>
<div class="founder-card">
<div style="width: 100%; aspect-ratio: 3/4; background-color: var(--color-bg-ivory); border-radius: var(--radius-card); overflow: hidden; margin-bottom: 1.5rem; position: relative; box-shadow: 0 16px 48px rgba(0,0,0,.12); transition: transform .4s ease, box-shadow .4s ease;">
<img alt="Camille Makasiar" onmouseout="this.style.transform='scale(1)'" onmouseover="this.style.transform='scale(1.05)'" src="<?php $img = get_field('image_58'); echo ($img && is_array($img) && isset($img['url'])) ? esc_url($img['url']) : (is_numeric($img) ? wp_get_attachment_image_url($img, 'full') : get_template_directory_uri() . '/assets/img/placeholder.jpg'); ?>" style="width: 100%; height: 100%; object-fit: cover; transition: transform .4s ease;"/>
</div>
<span style="display: block; font-size: .65rem; font-weight: 700; letter-spacing: .22em; text-transform: uppercase; color: var(--color-accent-red); margin-bottom: .4rem;">Founder and Executive Director</span>
<h3 style="color: var(--color-primary); font-family: var(--font-heading); font-size: 1.5rem; margin-bottom: 1rem;"><?php echo get_field('h3_54'); ?></h3>
<ul style="list-style: none; padding: 0; margin: 0; text-align: left;">
<li style="font-size: .85rem; line-height: 1.5; color: var(--color-text-muted); padding: .4rem 0; border-bottom: 1px solid var(--color-border-light); display: flex; align-items: flex-start; gap: .5rem;">
<span style="color: var(--color-accent-red); font-weight: 700; flex-shrink: 0;">•</span> Master in Entrepreneurship, Ateneo Graduate School of Business
              </li>
<li style="font-size: .85rem; line-height: 1.5; color: var(--color-text-muted); padding: .4rem 0; border-bottom: 1px solid var(--color-border-light); display: flex; align-items: flex-start; gap: .5rem;">
<span style="color: var(--color-accent-red); font-weight: 700; flex-shrink: 0;">•</span> Member, Entrepreneurs Organization (EO), PH South Chapter
              </li>
<li style="font-size: .85rem; line-height: 1.5; color: var(--color-text-muted); padding: .4rem 0; border-bottom: 1px solid var(--color-border-light); display: flex; align-items: flex-start; gap: .5rem;">
<span style="color: var(--color-accent-red); font-weight: 700; flex-shrink: 0;">•</span> Trustee, Bayan Innovation Group, Inc.
              </li>
<li style="font-size: .85rem; line-height: 1.5; color: var(--color-text-muted); padding: .4rem 0; border-bottom: 1px solid var(--color-border-light); display: flex; align-items: flex-start; gap: .5rem;">
<span style="color: var(--color-accent-red); font-weight: 700; flex-shrink: 0;">•</span> President, Inner Wheel Club of Metro Manila
              </li>
<li style="font-size: .85rem; line-height: 1.5; color: var(--color-text-muted); padding: .4rem 0; border-bottom: 1px solid var(--color-border-light); display: flex; align-items: flex-start; gap: .5rem;">
<span style="color: var(--color-accent-red); font-weight: 700; flex-shrink: 0;">•</span> Knowledge Management, University of Oxford
              </li>
<li style="font-size: .85rem; line-height: 1.5; color: var(--color-text-muted); padding: .4rem 0; display: flex; align-items: flex-start; gap: .5rem;">
<span style="color: var(--color-accent-red); font-weight: 700; flex-shrink: 0;">•</span> Strategic Management, Imperial College London
              </li>
</ul>
</div>
<div class="founder-card">
<div style="width: 100%; aspect-ratio: 3/4; background-color: var(--color-bg-ivory); border-radius: var(--radius-card); overflow: hidden; margin-bottom: 1.5rem; position: relative; box-shadow: 0 16px 48px rgba(0,0,0,.12); transition: transform .4s ease, box-shadow .4s ease;">
<img alt="Neil John S. Makasiar" onmouseout="this.style.transform='scale(1)'" onmouseover="this.style.transform='scale(1.05)'" src="<?php $img = get_field('image_59'); echo ($img && is_array($img) && isset($img['url'])) ? esc_url($img['url']) : (is_numeric($img) ? wp_get_attachment_image_url($img, 'full') : get_template_directory_uri() . '/assets/img/placeholder.jpg'); ?>" style="width: 100%; height: 100%; object-fit: cover; transition: transform .4s ease;"/>
</div>
<span style="display: block; font-size: .65rem; font-weight: 700; letter-spacing: .22em; text-transform: uppercase; color: var(--color-accent-red); margin-bottom: .4rem;">Managing Director</span>
<h3 style="color: var(--color-primary); font-family: var(--font-heading); font-size: 1.5rem; margin-bottom: 1rem;"><?php echo get_field('h3_55'); ?></h3>
<ul style="list-style: none; padding: 0; margin: 0; text-align: left;">
<li style="font-size: .85rem; line-height: 1.5; color: var(--color-text-muted); padding: .4rem 0; border-bottom: 1px solid var(--color-border-light); display: flex; align-items: flex-start; gap: .5rem;">
<span style="color: var(--color-accent-red); font-weight: 700; flex-shrink: 0;">•</span> Director, Makenter Construction and Development Corp.
              </li>
<li style="font-size: .85rem; line-height: 1.5; color: var(--color-text-muted); padding: .4rem 0; border-bottom: 1px solid var(--color-border-light); display: flex; align-items: flex-start; gap: .5rem;">
<span style="color: var(--color-accent-red); font-weight: 700; flex-shrink: 0;">•</span> Vice President, Human Services Cluster, CDA Region IX
              </li>
<li style="font-size: .85rem; line-height: 1.5; color: var(--color-text-muted); padding: .4rem 0; border-bottom: 1px solid var(--color-border-light); display: flex; align-items: flex-start; gap: .5rem;">
<span style="color: var(--color-accent-red); font-weight: 700; flex-shrink: 0;">•</span> Member, Rotary Club of Makati
              </li>
<li style="font-size: .85rem; line-height: 1.5; color: var(--color-text-muted); padding: .4rem 0; border-bottom: 1px solid var(--color-border-light); display: flex; align-items: flex-start; gap: .5rem;">
<span style="color: var(--color-accent-red); font-weight: 700; flex-shrink: 0;">•</span> Member, Shriners International
              </li>
<li style="font-size: .85rem; line-height: 1.5; color: var(--color-text-muted); padding: .4rem 0; border-bottom: 1px solid var(--color-border-light); display: flex; align-items: flex-start; gap: .5rem;">
<span style="color: var(--color-accent-red); font-weight: 700; flex-shrink: 0;">•</span> Alpha Phi Omega International Service Fraternity
              </li>
<li style="font-size: .85rem; line-height: 1.5; color: var(--color-text-muted); padding: .4rem 0; display: flex; align-items: flex-start; gap: .5rem;">
<span style="color: var(--color-accent-red); font-weight: 700; flex-shrink: 0;">•</span> Bachelor's Degree, De La Salle University – Manila
              </li>
</ul>
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
