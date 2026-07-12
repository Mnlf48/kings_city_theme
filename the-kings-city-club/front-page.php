<?php
if (!defined('ABSPATH')) exit;
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
<span class="text-overline hero__overline"><?php $h = get_field('hero_section_txt_6'); if ($h) { $w = explode(' ', trim($h)); echo (count($w) === 3) ? esc_html($w[0]) . '&nbsp;' . esc_html($w[1]) . ' ' . esc_html($w[2]) : esc_html($h); } ?></span>
<h1 class="hero__title hero__title--inner hero__welcome" style="margin-bottom: 0;"><?php $h = get_field('hero_section_txt_welcome'); if ($h) { $w = explode(' ', trim($h)); echo (count($w) === 3) ? esc_html($w[0]) . '&nbsp;' . esc_html($w[1]) . ' ' . esc_html($w[2]) : esc_html($h); } ?></h1>
<h1 class="hero__title hero__title--inner"><?php $h = get_field('hero_section_txt_4'); if ($h) { $w = explode(' ', trim($h)); echo (count($w) === 3) ? esc_html($w[0]) . '&nbsp;' . esc_html($w[1]) . ' ' . esc_html($w[2]) : esc_html($h); } ?></h1>
<p class="hero__subtitle"><?php $h = get_field('hero_section_txt_5'); if ($h) { $w = explode(' ', trim($h)); echo (count($w) === 3) ? esc_html($w[0]) . '&nbsp;' . esc_html($w[1]) . ' ' . esc_html($w[2]) : esc_html($h); } ?></p>
<div class="hero__actions hero__actions--index" style="display: block; margin-top: 40px; height: 54px; overflow: hidden;">
<?php
$hero_btn_url = kc_url('proposed_hero_btn_url', '/apply/');
?>
<a class="btn" href="<?php echo esc_url($hero_btn_url); ?>"><?php echo esc_html(get_field('hero_section_txt_7') ?: 'Become a Member'); ?></a>
</div>
</div>
</div>
</div>
</section>
<!-- spaces section -->
<?php
$space_btn_text = get_field('proposed_space_btn_text') ?: 'Learn More';
$space_btn_url  = kc_url('proposed_space_btn_url', '/spaces/');

$kc_clicks_coworking      = (int) get_option('kc_clicks_coworking', 0);
$kc_clicks_private_office = (int) get_option('kc_clicks_private_office', 0);
$kc_clicks_enterprise     = (int) get_option('kc_clicks_enterprise', 0);
$kc_clicks_on_demand      = (int) get_option('kc_clicks_on_demand', 0);
$kc_clicks_virtual_office = (int) get_option('kc_clicks_virtual_office', 0);
$kc_clicks_meeting_rooms  = (int) get_option('kc_clicks_meeting_rooms', 0);

$kc_track_coworking      = esc_url(add_query_arg('kc_track', 'coworking', home_url('/')));
$kc_track_private_office = esc_url(add_query_arg('kc_track', 'private-office', home_url('/')));
$kc_track_enterprise     = esc_url(add_query_arg('kc_track', 'enterprise', home_url('/')));
$kc_track_on_demand      = esc_url(add_query_arg('kc_track', 'on-demand', home_url('/')));
$kc_track_virtual_office = esc_url(add_query_arg('kc_track', 'virtual-office', home_url('/')));
$kc_track_meeting_rooms  = esc_url(add_query_arg('kc_track', 'meeting-rooms', home_url('/')));
?>
<section class="section content-panel" style="position: relative; overflow: hidden;">
<!-- Background floating confetti -->
<!-- 1. Ivory Sparkle -->
<!-- 2. Deep Red Heart -->
<!-- 3. Muted Gold Circle -->
<!-- 4. Ivory Star -->
<!-- 5. Soft Blush Sparkle -->
<div class="container" style="position: relative; z-index: 1;">
<div class="section__header text-center mx-auto" style="max-width: 800px; margin-bottom: var(--space-xl);">
<span class="text-overline" style="display: block; margin-bottom: var(--space-sm);"><?php echo esc_html(get_field('section_txt_22')); ?></span>
<h2 style="color: #BD451F; margin-bottom: var(--space-sm);"><?php echo esc_html(get_field('section_txt_12')); ?></h2>
<p class="text-lead"><?php echo esc_html(get_field('section_txt_17')); ?></p>
</div>
<div class="spaces-grid stagger-children">
<!-- space card 1 -->
<article class="space-card card-glass animate-fadeInUp" onclick="window.location.href='<?php echo $kc_track_coworking; ?>'" style="cursor: pointer;">
<div class="space-card__img-wrap">
<img alt="Coworking Space" class="space-card__img" src="<?php echo kc_img('section_img_8', 'front-page-img/kings-img45.webp'); ?>" loading="lazy"/>
</div>
<div class="space-card__body">
<h3 class="space-card__title"><?php echo esc_html(get_field('section_txt_13')); ?></h3>
<p class="space-card__desc"><?php echo esc_html(get_field('section_txt_18')); ?></p>
</div>
<div class="space-card__footer">
<a class="btn btn--small" href="<?php echo esc_url($space_btn_url); ?>"><?php echo esc_html($space_btn_text); ?></a>
<div class="space-card__capacity" style="display:flex; align-items:center; gap:0.5rem; font-weight:600; color:var(--color-primary);">
<div class="bg-ivory" style=" color: var(--color-accent-gold); width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; box-shadow: 0 4px 8px rgba(0,0,0,0.05);">
<svg fill="none" height="16" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" viewbox="0 0 24 24" width="16">
<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
<circle cx="9" cy="7" r="4"></circle>
<path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
<path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
</svg>
</div>
<span><?php echo esc_html($kc_clicks_coworking); ?></span>
</div>
</div>
</article>
<!-- space card 2 -->
<article class="space-card card-glass animate-fadeInUp" onclick="window.location.href='<?php echo $kc_track_private_office; ?>'" style="cursor: pointer; animation-delay: 0.1s;">
<div class="space-card__img-wrap">
<img alt="Private Office Space" class="space-card__img" src="<?php echo kc_img('section_img_9', 'front-page-img/kings-img48.webp'); ?>" loading="lazy"/>
</div>
<div class="space-card__body">
<h3 class="space-card__title"><?php echo esc_html(get_field('section_txt_14')); ?></h3>
<p class="space-card__desc"><?php echo esc_html(get_field('section_txt_19')); ?></p>
</div>
<div class="space-card__footer">
<a class="btn btn--small" href="<?php echo esc_url($space_btn_url); ?>"><?php echo esc_html($space_btn_text); ?></a>
<div class="space-card__capacity" style="display:flex; align-items:center; gap:0.5rem; font-weight:600; color:var(--color-primary);">
<div class="bg-ivory" style=" color: var(--color-accent-gold); width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; box-shadow: 0 4px 8px rgba(0,0,0,0.05);">
<svg fill="none" height="16" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" viewbox="0 0 24 24" width="16">
<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
<circle cx="9" cy="7" r="4"></circle>
<path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
<path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
</svg>
</div>
<span><?php echo esc_html($kc_clicks_private_office); ?></span>
</div>
</div>
</article>
<!-- space card 3 -->
<article class="space-card card-glass animate-fadeInUp" onclick="window.location.href='<?php echo $kc_track_enterprise; ?>'" style="cursor: pointer; animation-delay: 0.2s;">
<div class="space-card__img-wrap">
<img alt="Enterprise" class="space-card__img" src="<?php echo kc_img('section_img_10', 'front-page-img/kings-img26.webp'); ?>" loading="lazy"/>
</div>
<div class="space-card__body">
<h3 class="space-card__title"><?php echo esc_html(get_field('section_txt_15')); ?></h3>
<p class="space-card__desc"><?php echo esc_html(get_field('section_txt_20')); ?></p>
</div>
<div class="space-card__footer">
<a class="btn btn--small" href="<?php echo esc_url($space_btn_url); ?>"><?php echo esc_html($space_btn_text); ?></a>
<div class="space-card__capacity" style="display:flex; align-items:center; gap:0.5rem; font-weight:600; color:var(--color-primary);">
<div class="bg-ivory" style=" color: var(--color-accent-gold); width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; box-shadow: 0 4px 8px rgba(0,0,0,0.05);">
<svg fill="none" height="16" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" viewbox="0 0 24 24" width="16">
<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
<circle cx="9" cy="7" r="4"></circle>
<path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
<path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
</svg>
</div>
<span><?php echo esc_html($kc_clicks_enterprise); ?></span>
</div>
</div>
</article>
<!-- space card 4 -->
<article class="space-card card-glass animate-fadeInUp" onclick="window.location.href='<?php echo $kc_track_on_demand; ?>'" style="cursor: pointer; animation-delay: 0.3s;">
<div class="space-card__img-wrap">
<img alt="On-Demand" class="space-card__img" src="<?php echo kc_img('section_img_11', 'front-page-img/kings-img32.webp'); ?>" loading="lazy"/>
</div>
<div class="space-card__body">
<h3 class="space-card__title"><?php echo esc_html(get_field('section_txt_16')); ?></h3>
<p class="space-card__desc"><?php echo esc_html(get_field('section_txt_21')); ?></p>
</div>
<div class="space-card__footer">
<a class="btn btn--small" href="<?php echo esc_url($space_btn_url); ?>"><?php echo esc_html($space_btn_text); ?></a>
<div class="space-card__capacity" style="display:flex; align-items:center; gap:0.5rem; font-weight:600; color:var(--color-primary);">
<div class="bg-ivory" style=" color: var(--color-accent-gold); width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; box-shadow: 0 4px 8px rgba(0,0,0,0.05);">
<svg fill="none" height="16" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" viewbox="0 0 24 24" width="16">
<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
<circle cx="9" cy="7" r="4"></circle>
<path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
<path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
</svg>
</div>
<span><?php echo esc_html($kc_clicks_on_demand); ?></span>
</div>
</div>
</article>
<!-- space card 5 -->
<article class="space-card card-glass animate-fadeInUp" onclick="window.location.href='<?php echo $kc_track_virtual_office; ?>'" style="cursor: pointer; animation-delay: 0.4s;">
<div class="space-card__img-wrap">
<img alt="Virtual Office" class="space-card__img" src="<?php echo kc_img('section_img_100', 'front-page-img/kings-img74.webp'); ?>" loading="lazy"/>
</div>
<div class="space-card__body">
<h3 class="space-card__title"><?php echo esc_html(get_field('section_txt_101')); ?></h3>
<p class="space-card__desc"><?php echo esc_html(get_field('section_txt_102')); ?></p>
</div>
<div class="space-card__footer">
<a class="btn btn--small" href="<?php echo esc_url($space_btn_url); ?>"><?php echo esc_html($space_btn_text); ?></a>
<div class="space-card__capacity" style="display:flex; align-items:center; gap:0.5rem; font-weight:600; color:var(--color-primary);">
<div class="bg-ivory" style=" color: var(--color-accent-gold); width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; box-shadow: 0 4px 8px rgba(0,0,0,0.05);">
<svg fill="none" height="16" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" viewbox="0 0 24 24" width="16">
<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
<circle cx="9" cy="7" r="4"></circle>
<path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
<path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
</svg>
</div>
<span><?php echo esc_html($kc_clicks_virtual_office); ?></span>
</div>
</div>
</article>
<!-- space card 6 -->
<article class="space-card card-glass animate-fadeInUp" onclick="window.location.href='<?php echo $kc_track_meeting_rooms; ?>'" style="cursor: pointer; animation-delay: 0.5s;">
<div class="space-card__img-wrap">
<img alt="Meeting Rooms" class="space-card__img" src="<?php echo kc_img('section_img_104', 'front-page-img/kings-img73.webp'); ?>" loading="lazy"/>
</div>
<div class="space-card__body">
<h3 class="space-card__title"><?php echo esc_html(get_field('section_txt_105')); ?></h3>
<p class="space-card__desc"><?php echo esc_html(get_field('section_txt_106')); ?></p>
</div>
<div class="space-card__footer">
<a class="btn btn--small" href="<?php echo esc_url($space_btn_url); ?>"><?php echo esc_html($space_btn_text); ?></a>
<div class="space-card__capacity" style="display:flex; align-items:center; gap:0.5rem; font-weight:600; color:var(--color-primary);">
<div class="bg-ivory" style=" color: var(--color-accent-gold); width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; box-shadow: 0 4px 8px rgba(0,0,0,0.05);">
<svg fill="none" height="16" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" viewbox="0 0 24 24" width="16">
<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
<circle cx="9" cy="7" r="4"></circle>
<path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
<path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
</svg>
</div>
<span><?php echo esc_html($kc_clicks_meeting_rooms); ?></span>
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
<!-- 1. Ivory Sparkle -->
<!-- 2. Soft Blush Heart -->
<!-- 3. Red Sparkle -->
<!-- 4. Ivory Heart -->
<!-- 5. Soft Blush Sparkle -->
<div class="container grid-12" style="position: relative; z-index: 1;">
<div class="col-12 split" style="align-items: center;">
<div class="split__content">
<span class="text-overline" style="color: var(--color-bg-ivory); opacity: 0.8;"><?php echo esc_html(get_field('section_txt_35')); ?></span>
<h2 style="color: var(--color-bg-ivory); margin-bottom: var(--space-md);"><?php echo esc_html(get_field('section_txt_33')); ?></h2>
<p class="text-lead" style="color: var(--color-bg-ivory); opacity: 0.9;"><?php echo esc_html(get_field('section_txt_34')); ?></p>
<?php
$off_perk_1  = get_field('proposed_offshoring_perk_1') ?: 'Local Dedicated Talent';
$off_perk_2  = get_field('proposed_offshoring_perk_2') ?: 'Fully Maintained Facilities';
$off_perk_3  = get_field('proposed_offshoring_perk_3') ?: 'Professional HR Framework';
$off_btn_url = kc_url('proposed_offshoring_btn_url', '/apply/');
?>
<ul class="perks-list perks-list--offshoring" style="margin-bottom: var(--space-lg); color: var(--color-bg-ivory);">
<li>
<div class="perk-bubble" style="box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
<svg fill="none" height="22" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" viewbox="0 0 24 24" width="22">
<polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 12 2"></polygon>
</svg>
</div>
<span style="font-size: 0.95rem; font-weight: 600;"><?php echo esc_html($off_perk_1); ?></span>
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
<span style="font-size: 0.95rem; font-weight: 600;"><?php echo esc_html($off_perk_2); ?></span>
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
<span style="font-size: 0.95rem; font-weight: 600;"><?php echo esc_html($off_perk_3); ?></span>
</li>
</ul>
<div style="margin-top: var(--space-md);">
<a class="btn" href="<?php echo esc_url($off_btn_url); ?>"><?php echo esc_html(get_field('section_txt_36') ?: 'Calculate Staffing Costs'); ?></a>
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
<span class="text-overline" style="display: block; margin-bottom: var(--space-sm);"><?php echo esc_html(get_field('section_txt_40')); ?></span>
<h2 style="color: #BD451F; margin-bottom: var(--space-md);"><?php echo esc_html(get_field('section_txt_38')); ?></h2>
<p style="margin-bottom: var(--space-lg);"><?php echo esc_html(get_field('section_txt_39')); ?></p>
<ul class="perks-list perks-list--membership">
<li>
<div class="perk-bubble">
<svg fill="none" height="22" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" viewbox="0 0 24 24" width="22">
<path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
<polyline points="9 22 9 12 15 12 15 22"></polyline>
</svg>
</div>
<span style="font-size: 0.95rem; font-weight: 600;"><?php echo esc_html(get_field('section_txt_41')); ?></span>
</li>
<li>
<div class="perk-bubble">
<svg fill="none" height="22" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" viewbox="0 0 24 24" width="22">
<rect height="18" rx="2" ry="2" width="18" x="3" y="3"></rect>
<line x1="3" x2="21" y1="9" y2="9"></line>
<line x1="9" x2="9" y1="21" y2="9"></line>
</svg>
</div>
<span style="font-size: 0.95rem; font-weight: 600;"><?php echo esc_html(get_field('section_txt_42')); ?></span>
</li>
<li>
<div class="perk-bubble">
<svg fill="none" height="22" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" viewbox="0 0 24 24" width="22">
<polygon points="23 7 16 12 23 17 23 7"></polygon>
<rect height="14" rx="2" ry="2" width="15" x="1" y="5"></rect>
</svg>
</div>
<span style="font-size: 0.95rem; font-weight: 600;"><?php echo esc_html(get_field('section_txt_43')); ?></span>
</li>
<li>
<div class="perk-bubble">
<svg fill="none" height="22" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" viewbox="0 0 24 24" width="22">
<path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path>
<line x1="7" x2="7.01" y1="7" y2="7"></line>
</svg>
</div>
<span style="font-size: 0.95rem; font-weight: 600;"><?php echo esc_html(get_field('section_txt_44')); ?></span>
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
<span style="font-size: 0.95rem; font-weight: 600;"><?php echo esc_html(get_field('section_txt_45')); ?></span>
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
    <h2 style="color: var(--color-bg-ivory); margin-bottom: 0; font-size: clamp(2rem, 4vw, 3rem); font-weight: 700;"><?php $heading = get_field('section_txt_gallery_heading'); echo esc_html($heading ? $heading : 'Virtual Tour'); ?></h2>
  </div>
</div>

<?php get_template_part( 'partials/gallery-carousel' ); ?>


</section>
<!-- trust bar -->
<!-- what defines us -->
<!-- get social with us -->
<section class="section content-panel section--social bg-blush" style="position: relative; overflow: hidden;">
<!-- Floating Background "Social Stickers" -->

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
<span class="text-overline" style="display: block; margin-bottom: var(--space-sm);"><?php echo esc_html(get_field('section_txt_67')); ?></span>
<h2 style="color: #BD451F; margin-bottom: var(--space-md);"><?php echo esc_html(get_field('section_txt_59')); ?></h2>
<p style="font-size: 0.95rem; line-height: 1.7; max-width: 480px; margin-bottom: var(--space-lg);"><?php echo esc_html(get_field('section_txt_60')); ?></p>

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
<span style="font-size: 0.95rem; font-weight: 600;"><?php echo esc_html(get_field('section_txt_61')); ?></span>
</li>

<!-- feature 2: events & notifications -->
<li>
<div class="perk-bubble" style="box-shadow: 0 4px 12px rgba(189, 69, 31, 0.1);">
<svg fill="none" height="22" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" viewbox="0 0 24 24" width="22">
<path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
<path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
</svg>
</div>
<span style="font-size: 0.95rem; font-weight: 600;"><?php echo esc_html(get_field('section_txt_62')); ?></span>
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
<span style="font-size: 0.95rem; font-weight: 600;"><?php echo esc_html(get_field('section_txt_63')); ?></span>
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
<span style="font-size: 0.95rem; font-weight: 600;"><?php echo esc_html(get_field('section_txt_64')); ?></span>
</li>

<!-- feature 5: direct message -->
<li>
<div class="perk-bubble" style="box-shadow: 0 4px 12px rgba(189, 69, 31, 0.1);">
<svg fill="none" height="22" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" viewbox="0 0 24 24" width="22">
<line x1="22" x2="11" y1="2" y2="13"></line>
<polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
</svg>
</div>
<span style="font-size: 0.95rem; font-weight: 600;"><?php echo esc_html(get_field('section_txt_65')); ?></span>
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
<span style="font-size: 0.95rem; font-weight: 600;"><?php echo esc_html(get_field('section_txt_66')); ?></span>
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
<span class="text-overline" style="display: block; margin-bottom: var(--space-sm); color: var(--color-bg-ivory);"><?php echo esc_html(get_field('section_txt_72')); ?></span>
<h2 style="color: var(--color-bg-ivory); margin-bottom: var(--space-md);"><?php echo esc_html(get_field('section_txt_69')); ?></h2>
<p style="color: var(--color-bg-ivory); margin-bottom: var(--space-md); line-height: 1.7;"><?php echo esc_html(get_field('section_txt_70')); ?></p>
<p style="color: var(--color-bg-ivory); margin-bottom: var(--space-xl); line-height: 1.7;"><?php echo esc_html(get_field('section_txt_71')); ?></p>
<?php
$impact_btn_text = get_field('proposed_impact_btn_text') ?: 'Learn More';
$impact_btn_url  = kc_url('proposed_impact_btn_url', '/impact/');
?>
<div style="display: flex; align-items: center; gap: var(--space-lg); flex-wrap: wrap;">
<a class="btn" href="<?php echo esc_url($impact_btn_url); ?>"><?php echo esc_html($impact_btn_text); ?></a>
</div>
</div>
</div>
</section>
<!-- journal preview -->
<?php
$news_pages = get_pages(array(
    'meta_key' => '_wp_page_template',
    'meta_value' => 'page-news.php'
));
$news_url = !empty($news_pages) ? get_permalink($news_pages[0]->ID) : home_url('/news/');
?>
<section class="section content-panel section--journal" style="position: relative; overflow: hidden;">
<!-- Background floating confetti -->
<!-- 1. Terracotta Sparkle -->
<!-- 2. Soft Blush Heart -->
<!-- 3. Ivory Sparkle -->
<!-- 4. Terracotta Heart -->
<!-- 5. Soft Blush Sparkle -->
<div class="container" style="position: relative; z-index: 1;">
<div class="section__header-row" style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: var(--space-xl); flex-wrap: wrap; gap: var(--space-md);">
<div>
<span class="text-overline"><?php echo esc_html(get_field('section_txt_85')); ?></span>
<h2 style="color: #BD451F; margin-bottom: 0;"><?php echo esc_html(get_field('section_txt_78')); ?></h2>
</div>
<?php $news_btn_text = get_field('proposed_news_btn_text') ?: 'Read News'; ?>
<div class="journal-cta-wrap journal-cta-wrap--desktop" style="align-self: flex-end; margin-bottom: 5px;">
<a class="btn" href="<?php echo esc_url( $news_url ); ?>"><?php echo esc_html($news_btn_text); ?> <svg fill="none" height="16" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" style="margin-left: 8px;" viewbox="0 0 24 24" width="16">
<line x1="5" x2="19" y1="12" y2="12"></line>
<polyline points="12 5 19 12 12 19"></polyline>
</svg></a>
</div>
</div>
<div class="journal-grid">
<?php
$news_args = array(
    'post_type'      => 'post',
    'posts_per_page' => 3,
    'post_status'    => 'publish',
    'orderby'        => 'date',
    'order'          => 'DESC',
);
$news_query = new WP_Query($news_args);
if ($news_query->have_posts()) :
    while ($news_query->have_posts()) : $news_query->the_post();
        $image_id = get_post_thumbnail_id(get_the_ID());
?>
<!-- journal card dynamic -->
<article class="card-glass" onclick="window.location.href='<?php echo esc_url( get_permalink() ); ?>'" style="border-radius: 0;">
<?php if ($image_id) : ?>
    <?php echo wp_get_attachment_image($image_id, 'large', false, array('style' => 'width: 100%; aspect-ratio: 16/9; object-fit: cover; border-radius: 0;')); ?>
<?php else : ?>
    <div style="width: 100%; aspect-ratio: 16/9; background-color: var(--color-border-light); display: flex; align-items: center; justify-content: center; color: var(--color-text-muted); font-size: 0.8rem; font-weight: 500; text-transform: uppercase; border-radius: 0;">
      No Image
    </div>
<?php endif; ?>
<div class="journal-card__body">
<div class="journal-card__meta bg-ivory" style="display:inline-block;  color:var(--color-primary); padding:0.25rem 0.75rem; border-radius:12px; font-size:0.75rem; font-weight:700; margin-bottom:0.75rem; box-shadow:0 4px 8px rgba(0,0,0,0.05); text-transform:uppercase;">Kings City News</div>
<h3 class="journal-card__title"><?php echo esc_html(get_the_title()); ?></h3>
<p class="journal-card__excerpt"><?php 
$excerpt = get_the_excerpt();
echo $excerpt ? $excerpt : wp_trim_words(get_the_content(), 20); 
?></p>
</div>
</article>
<?php 
    endwhile;
    wp_reset_postdata();
else: 
?>
    <p style="text-align: center; color: var(--color-text-muted);">No recent news found.</p>
<?php endif; ?>
</div>
<!-- mobile read news cta -->
<div class="journal-cta-wrap journal-cta-wrap--mobile text-right" style="margin-top: var(--space-md);">
<a class="btn" href="<?php echo esc_url( $news_url ); ?>"><?php echo esc_html($news_btn_text); ?> <svg fill="none" height="16" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" style="margin-left: 8px;" viewbox="0 0 24 24" width="16">
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
