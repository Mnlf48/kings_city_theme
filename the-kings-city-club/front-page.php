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
<img alt="Kings City Banner" class="hero__slide is-active" src="<?php echo esc_url(get_field('hero_section_img_1')['url']); ?>" style="position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; opacity: 1; transition: opacity 1s ease-in-out;"/>
<!-- slide 2 -->
<img alt="Kings Place" class="hero__slide" src="<?php echo esc_url(get_field('hero_section_img_2')['url']); ?>" style="position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; opacity: 0; transition: opacity 1s ease-in-out;"/>
<!-- slide 3 -->
<img alt="Kings Bag" class="hero__slide" src="<?php echo esc_url(get_field('hero_section_img_3')['url']); ?>" style="position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; opacity: 0; transition: opacity 1s ease-in-out;"/>
</div>
<!-- text on right -->
<div class="split__content animate-fadeInUp hero__content--index">
<span class="text-overline hero__overline"><?php echo get_field('hero_section_txt_6'); ?></span>
<h1 class="hero__title hero__title--inner"><?php echo get_field('hero_section_txt_4'); ?></h1>
<p class="hero__subtitle"><?php echo get_field('hero_section_txt_5'); ?></p>
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
<section class="section content-panel">
<div class="container">
<div class="section__header text-center mx-auto" style="max-width: 800px; margin-bottom: var(--space-xl);">
<span class="text-overline" style="display: block; margin-bottom: var(--space-sm);"><?php echo get_field('section_txt_22'); ?></span>
<h2 style="color: var(--color-primary); margin-bottom: var(--space-sm);"><?php echo get_field('section_txt_12'); ?></h2>
<p class="text-lead"><?php echo get_field('section_txt_17'); ?></p>
</div>
<div class="spaces-grid stagger-children">
<!-- space card 1 -->
<article class="space-card card-glass animate-fadeInUp">
<div class="space-card__img-wrap">
<img alt="Coworking Space" class="space-card__img" src="<?php echo esc_url(get_field('section_img_8')['url']); ?>"/>
</div>
<div class="space-card__body">
<h3 class="space-card__title"><?php echo get_field('section_txt_13'); ?></h3>
<p class="space-card__desc"><?php echo get_field('section_txt_18'); ?></p>
</div>
<div class="space-card__footer">
<a class="btn btn--small" href="spaces.html">Learn More</a>
<div class="space-card__capacity">
<svg fill="currentColor" height="14" viewbox="0 0 24 24" width="14">
<path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"></path>
</svg>
<span><?php echo get_field('section_txt_23'); ?></span>
</div>
</div>
</article>
<!-- space card 2 -->
<article class="space-card card-glass animate-fadeInUp" style="animation-delay: 0.1s;">
<div class="space-card__img-wrap">
<img alt="Private Office Space" class="space-card__img" src="<?php echo esc_url(get_field('section_img_9')['url']); ?>"/>
</div>
<div class="space-card__body">
<h3 class="space-card__title"><?php echo get_field('section_txt_14'); ?></h3>
<p class="space-card__desc"><?php echo get_field('section_txt_19'); ?></p>
</div>
<div class="space-card__footer">
<a class="btn btn--small" href="spaces.html">Learn More</a>
<div class="space-card__capacity">
<svg fill="currentColor" height="14" viewbox="0 0 24 24" width="14">
<path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"></path>
</svg>
<span><?php echo get_field('section_txt_24'); ?></span>
</div>
</div>
</article>
<!-- space card 3 -->
<article class="space-card card-glass animate-fadeInUp" style="animation-delay: 0.2s;">
<div class="space-card__img-wrap">
<img alt="Enterprise" class="space-card__img" src="<?php echo esc_url(get_field('section_img_10')['url']); ?>"/>
</div>
<div class="space-card__body">
<h3 class="space-card__title"><?php echo get_field('section_txt_15'); ?></h3>
<p class="space-card__desc"><?php echo get_field('section_txt_20'); ?></p>
</div>
<div class="space-card__footer">
<a class="btn btn--small" href="spaces.html">Learn More</a>
<div class="space-card__capacity">
<svg fill="currentColor" height="14" viewbox="0 0 24 24" width="14">
<path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"></path>
</svg>
<span><?php echo get_field('section_txt_25'); ?></span>
</div>
</div>
</article>
<!-- space card 4 -->
<article class="space-card card-glass animate-fadeInUp" style="animation-delay: 0.3s;">
<div class="space-card__img-wrap">
<img alt="On-Demand" class="space-card__img" src="<?php echo esc_url(get_field('section_img_11')['url']); ?>"/>
</div>
<div class="space-card__body">
<h3 class="space-card__title"><?php echo get_field('section_txt_16'); ?></h3>
<p class="space-card__desc"><?php echo get_field('section_txt_21'); ?></p>
</div>
<div class="space-card__footer">
<a class="btn btn--small" href="spaces.html">Learn More</a>
<div class="space-card__capacity">
<svg fill="currentColor" height="14" viewbox="0 0 24 24" width="14">
<path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"></path>
</svg>
<span><?php echo get_field('section_txt_26'); ?></span>
</div>
</div>
</article>
</div>
</div></section>
<!-- offshoring section -->
<section class="section content-panel section--offshoring">
<div class="container grid-12">
<div class="col-12 split">
<div class="split__content" style="margin-top: 3.5rem;">
<span class="text-overline"><?php echo get_field('section_txt_35'); ?></span>
<h2><?php echo get_field('section_txt_33'); ?></h2>
<p class="text-lead"><?php echo get_field('section_txt_34'); ?></p>
<ul style="margin-bottom: var(--space-lg); display:flex; flex-direction:column; gap:0.75rem; text-align: left; list-style: none; padding: 0;">
<li style="display:flex; align-items:center; gap:0.5rem;">
<svg fill="none" height="20" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewbox="0 0 24 24" width="20">
<path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
<polyline points="22 4 12 14.01 9 11.01"></polyline>
</svg>
                Local Dedicated Talent
              </li>
<li style="display:flex; align-items:center; gap:0.5rem;">
<svg fill="none" height="20" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewbox="0 0 24 24" width="20">
<path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
<polyline points="22 4 12 14.01 9 11.01"></polyline>
</svg>
                Fully Maintained Facilities
              </li>
<li style="display:flex; align-items:center; gap:0.5rem;">
<svg fill="none" height="20" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewbox="0 0 24 24" width="20">
<path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
<polyline points="22 4 12 14.01 9 11.01"></polyline>
</svg>
                Professional HR Framework
              </li>
</ul>
<div style="margin-top: var(--space-md);"><?php echo get_field('section_txt_36'); ?></div>
</div>
<div class="split__media">
<img alt="Offshoring Power - A professional team working in a modern office" src="<?php echo esc_url(get_field('section_img_32')['url']); ?>"/>
</div>
</div>
</div>
</section>
<!-- membership perks section -->
<section class="section content-panel section--pass">
<div class="container grid-12">
<div class="col-12 split">
<div class="split__media">
<img alt="One Pass. All Access. - Membership Perks" src="<?php echo esc_url(get_field('section_img_37')['url']); ?>"/>
</div>
<div class="split__content" style="margin-top: 0;">
<span class="text-overline" style="display: block; margin-bottom: var(--space-sm);"><?php echo get_field('section_txt_40'); ?></span>
<h2 style="margin-bottom: var(--space-md);"><?php echo get_field('section_txt_38'); ?></h2>
<p style="margin-bottom: var(--space-lg);"><?php echo get_field('section_txt_39'); ?></p>
<ul style="display:flex; flex-direction:column; gap:1.25rem; list-style: none; padding: 0; text-align: left;">
<li style="display:flex; align-items:center; gap:1rem;">
<svg fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewbox="0 0 24 24" width="24">
<path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
<polyline points="9 22 9 12 15 12 15 22"></polyline>
</svg>
<span style="font-size: 0.95rem;"><?php echo get_field('section_txt_41'); ?></span>
</li>
<li style="display:flex; align-items:center; gap:1rem;">
<svg fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewbox="0 0 24 24" width="24">
<rect height="18" rx="2" ry="2" width="18" x="3" y="3"></rect>
<line x1="3" x2="21" y1="9" y2="9"></line>
<line x1="9" x2="9" y1="21" y2="9"></line>
</svg>
<span style="font-size: 0.95rem;"><?php echo get_field('section_txt_42'); ?></span>
</li>
<li style="display:flex; align-items:center; gap:1rem;">
<svg fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewbox="0 0 24 24" width="24">
<polygon points="23 7 16 12 23 17 23 7"></polygon>
<rect height="14" rx="2" ry="2" width="15" x="1" y="5"></rect>
</svg>
<span style="font-size: 0.95rem;"><?php echo get_field('section_txt_43'); ?></span>
</li>
<li style="display:flex; align-items:center; gap:1rem;">
<svg fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewbox="0 0 24 24" width="24">
<path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path>
<line x1="7" x2="7.01" y1="7" y2="7"></line>
</svg>
<span style="font-size: 0.95rem;"><?php echo get_field('section_txt_44'); ?></span>
</li>
<li style="display:flex; align-items:center; gap:1rem;">
<svg fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewbox="0 0 24 24" width="24">
<path d="M18 8h1a4 4 0 0 1 0 8h-1"></path>
<path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"></path>
<line x1="6" x2="6" y1="1" y2="4"></line>
<line x1="10" x2="10" y1="1" y2="4"></line>
<line x1="14" x2="14" y1="1" y2="4"></line>
</svg>
<span style="font-size: 0.95rem;"><?php echo get_field('section_txt_45'); ?></span>
</li>
</ul>
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
<img alt="Kings Club Makati" src="<?php echo esc_url(get_field('section_img_46')['url']); ?>" style="width:100%; height:100%; object-fit:cover;"/>
</div>
<div class="gallery-card">
<img alt="Kings Club BGC" src="<?php echo esc_url(get_field('section_img_47')['url']); ?>" style="width:100%; height:100%; object-fit:cover;"/>
</div>
<div class="gallery-card">
<img alt="Kings Club Ortigas" src="<?php echo esc_url(get_field('section_img_48')['url']); ?>" style="width:100%; height:100%; object-fit:cover;"/>
</div>
<div class="gallery-card">
<img alt="Kings Club Alabang" src="<?php echo esc_url(get_field('section_img_49')['url']); ?>" style="width:100%; height:100%; object-fit:cover;"/>
</div>
<div class="gallery-card">
<img alt="Kings Club Quezon City" src="<?php echo esc_url(get_field('section_img_50')['url']); ?>" style="width:100%; height:100%; object-fit:cover;"/>
</div>
<div class="gallery-card">
<img alt="Kings Club Pasay" src="<?php echo esc_url(get_field('section_img_51')['url']); ?>" style="width:100%; height:100%; object-fit:cover;"/>
</div>
<!-- duplicated set for infinite loop -->
<div class="gallery-card">
<img alt="Kings Club Makati" src="<?php echo esc_url(get_field('section_img_52')['url']); ?>" style="width:100%; height:100%; object-fit:cover;"/>
</div>
<div class="gallery-card">
<img alt="Kings Club BGC" src="<?php echo esc_url(get_field('section_img_53')['url']); ?>" style="width:100%; height:100%; object-fit:cover;"/>
</div>
<div class="gallery-card">
<img alt="Kings Club Ortigas" src="<?php echo esc_url(get_field('section_img_54')['url']); ?>" style="width:100%; height:100%; object-fit:cover;"/>
</div>
<div class="gallery-card">
<img alt="Kings Club Alabang" src="<?php echo esc_url(get_field('section_img_55')['url']); ?>" style="width:100%; height:100%; object-fit:cover;"/>
</div>
<div class="gallery-card">
<img alt="Kings Club Quezon City" src="<?php echo esc_url(get_field('section_img_56')['url']); ?>" style="width:100%; height:100%; object-fit:cover;"/>
</div>
<div class="gallery-card">
<img alt="Kings Club Pasay" src="<?php echo esc_url(get_field('section_img_57')['url']); ?>" style="width:100%; height:100%; object-fit:cover;"/>
</div>
</div>
<button aria-label="Next image" class="gallery-nav gallery-nav--next" onclick="scrollGallery(1)">
<svg fill="none" height="20" stroke="currentColor" stroke-width="2" viewbox="0 0 24 24" width="20">
<polyline points="9 18 15 12 9 6"></polyline>
</svg>
</button>

</section>
<!-- trust bar -->
<!-- what defines us -->
<!-- get social with us -->
<section class="section content-panel section--social">
<div class="container grid-12">
<!-- top row: heading + description -->
<div class="col-12 split">
<div class="split__content" style="margin-top: 3rem;">
<span class="text-overline" style="display: block; margin-bottom: var(--space-sm);"><?php echo get_field('section_txt_67'); ?></span>
<h2 style="margin-bottom: var(--space-md);"><?php echo get_field('section_txt_59'); ?></h2>
<p style="font-size: 0.95rem; line-height: 1.7; max-width: 480px;"><?php echo get_field('section_txt_60'); ?></p>
<!-- feature icons grid -->
<div class="social-features-grid">
<!-- feature 1: book spaces -->
<div class="social-feature">
<div class="social-feature__icon">
<svg fill="none" height="32" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewbox="0 0 24 24" width="32">
<rect height="18" rx="2" ry="2" width="18" x="3" y="4"></rect>
<line x1="16" x2="16" y1="2" y2="6"></line>
<line x1="8" x2="8" y1="2" y2="6"></line>
<line x1="3" x2="21" y1="10" y2="10"></line>
<rect height="3" rx="0.5" width="3" x="8" y="14"></rect>
</svg>
</div>
<p class="social-feature__text"><?php echo get_field('section_txt_61'); ?></p>
</div>
<!-- feature 2: events & notifications -->
<div class="social-feature">
<div class="social-feature__icon">
<svg fill="none" height="32" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewbox="0 0 24 24" width="32">
<path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
<path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
</svg>
</div>
<p class="social-feature__text"><?php echo get_field('section_txt_62'); ?></p>
</div>
<!-- feature 3: network & connect -->
<div class="social-feature">
<div class="social-feature__icon">
<svg fill="none" height="32" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewbox="0 0 24 24" width="32">
<circle cx="12" cy="5" r="3"></circle>
<circle cx="4" cy="12" r="2.5"></circle>
<circle cx="20" cy="12" r="2.5"></circle>
<circle cx="12" cy="19" r="2.5"></circle>
<line x1="12" x2="12" y1="8" y2="16.5"></line>
<line x1="6.3" x2="9.8" y1="13" y2="17.5"></line>
<line x1="17.7" x2="14.2" y1="13" y2="17.5"></line>
</svg>
</div>
<p class="social-feature__text"><?php echo get_field('section_txt_63'); ?></p>
</div>
<!-- feature 4: interactive newsfeed -->
<div class="social-feature">
<div class="social-feature__icon">
<svg fill="none" height="32" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewbox="0 0 24 24" width="32">
<rect height="18" rx="2" width="20" x="2" y="3"></rect>
<line x1="2" x2="22" y1="8" y2="8"></line>
<line x1="9" x2="9" y1="8" y2="21"></line>
<line x1="13" x2="19" y1="13" y2="13"></line>
<line x1="13" x2="18" y1="16.5" y2="16.5"></line>
</svg>
</div>
<p class="social-feature__text"><?php echo get_field('section_txt_64'); ?></p>
</div>
<!-- feature 5: direct message -->
<div class="social-feature">
<div class="social-feature__icon">
<svg fill="none" height="32" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewbox="0 0 24 24" width="32">
<line x1="22" x2="11" y1="2" y2="13"></line>
<polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
</svg>
</div>
<p class="social-feature__text"><?php echo get_field('section_txt_65'); ?></p>
</div>
<!-- feature 6: promote business -->
<div class="social-feature">
<div class="social-feature__icon">
<svg fill="none" height="32" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewbox="0 0 24 24" width="32">
<circle cx="12" cy="12" r="10"></circle>
<line x1="12" x2="12" y1="8" y2="12"></line>
<circle cx="12" cy="12" fill="currentColor" r="1" stroke="none"></circle>
<circle cx="8" cy="6" fill="currentColor" r="0.5" stroke="none"></circle>
<circle cx="16" cy="6" fill="currentColor" r="0.5" stroke="none"></circle>
<circle cx="18" cy="10" fill="currentColor" r="0.5" stroke="none"></circle>
</svg>
</div>
<p class="social-feature__text"><?php echo get_field('section_txt_66'); ?></p>
</div>
</div>
</div>
<div class="split__media">
<img alt="Get Social With Us - Kings Club Community App" src="<?php echo esc_url(get_field('section_img_58')['url']); ?>"/>
</div>
</div>
</div>
</section>
<!-- impact section -->
<section class="section content-panel section--impact" style="position: relative; padding: var(--space-3xl) 0;">
<!-- impact background image -->
<img alt="Impact - Giving Back" src="<?php echo esc_url(get_field('section_img_68')['url']); ?>" style="position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; z-index: 0;"/>
<div class="container" style="position: relative; z-index: 1;">
<div class="impact-card" style="background-color: var(--color-bg-ivory); padding: clamp(2rem, 4vw, 4rem); border-radius: var(--radius-card); max-width: 650px;">
<span class="text-overline" style="display: block; margin-bottom: var(--space-sm); color: var(--color-primary);"><?php echo get_field('section_txt_72'); ?></span>
<h2 style="color: var(--color-primary); margin-bottom: var(--space-md);"><?php echo get_field('section_txt_69'); ?></h2>
<p style="color: var(--color-primary); margin-bottom: var(--space-md); line-height: 1.7;"><?php echo get_field('section_txt_70'); ?></p>
<p style="color: var(--color-primary); margin-bottom: var(--space-xl); line-height: 1.7;"><?php echo get_field('section_txt_71'); ?></p>
<div style="display: flex; align-items: center; gap: var(--space-lg); flex-wrap: wrap;">
<a class="btn" href="impact.html">Learn More</a>
<!-- badges placeholder -->
<div style="display: flex; gap: var(--space-sm);">
<div style="width: 50px; height: 50px; background-color: white; border: 1px solid var(--color-border-light); border-radius: var(--radius-pill); display: flex; align-items: center; justify-content: center; font-size: 0.6rem; text-align: center; color: var(--color-primary);"><?php echo get_field('section_txt_73'); ?></div>
<div style="width: 50px; height: 50px; background-color: white; border: 1px solid var(--color-border-light); border-radius: var(--radius-pill); display: flex; align-items: center; justify-content: center; font-size: 0.6rem; text-align: center; color: var(--color-primary);"><?php echo get_field('section_txt_74'); ?></div>
</div>
</div>
</div>
</div>
</section>
<!-- journal preview -->
<section class="section content-panel">
<div class="container">
<div class="section__header-row" style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: var(--space-xl); flex-wrap: wrap; gap: var(--space-md);">
<div>
<span class="text-overline"><?php echo get_field('section_txt_85'); ?></span>
<h2 style="margin-bottom: 0;"><?php echo get_field('section_txt_78'); ?></h2>
</div>
<div class="journal-cta-wrap journal-cta-wrap--desktop" style="align-self: flex-end; margin-bottom: 5px;">
<a class="btn" href="news.html">Read News <svg fill="none" height="16" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" style="margin-left: 8px;" viewbox="0 0 24 24" width="16">
<line x1="5" x2="19" y1="12" y2="12"></line>
<polyline points="12 5 19 12 12 19"></polyline>
</svg></a>
</div>
</div>
<div class="journal-grid">
<!-- journal card 1 -->
<article class="card-glass">
<img alt="Galentine's 2026" src="<?php echo esc_url(get_field('section_img_75')['url']); ?>" style="width: 100%; aspect-ratio: 16/9; object-fit: cover; border-radius: var(--radius-card) var(--radius-card) 0 0;"/>
<div class="journal-card__body">
<div class="journal-card__meta"><?php echo get_field('section_txt_87'); ?></div>
<h3 class="journal-card__title"><?php echo get_field('section_txt_79'); ?></h3>
<p class="journal-card__excerpt"><?php echo get_field('section_txt_82'); ?></p>
</div>
</article>
<!-- journal card 2 -->
<article class="card-glass">
<img alt="Triple Anniversary Celebration" src="<?php echo esc_url(get_field('section_img_76')['url']); ?>" style="width: 100%; aspect-ratio: 16/9; object-fit: cover; border-radius: var(--radius-card) var(--radius-card) 0 0;"/>
<div class="journal-card__body">
<div class="journal-card__meta"><?php echo get_field('section_txt_88'); ?></div>
<h3 class="journal-card__title"><?php echo get_field('section_txt_80'); ?></h3>
<p class="journal-card__excerpt"><?php echo get_field('section_txt_83'); ?></p>
</div>
</article>
<!-- journal card 3 -->
<article class="card-glass">
<img alt="Manille Céramique Pottery Studio" src="<?php echo esc_url(get_field('section_img_77')['url']); ?>" style="width: 100%; aspect-ratio: 16/9; object-fit: cover; border-radius: var(--radius-card) var(--radius-card) 0 0;"/>
<div class="journal-card__body">
<div class="journal-card__meta"><?php echo get_field('section_txt_89'); ?></div>
<h3 class="journal-card__title"><?php echo get_field('section_txt_81'); ?></h3>
<p class="journal-card__excerpt"><?php echo get_field('section_txt_84'); ?></p>
</div>
</article>
</div>
<!-- mobile read news cta -->
<div class="journal-cta-wrap journal-cta-wrap--mobile text-right" style="margin-top: var(--space-md);">
<a class="btn" href="news.html">Read News <svg fill="none" height="16" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" style="margin-left: 8px;" viewbox="0 0 24 24" width="16">
<line x1="5" x2="19" y1="12" y2="12"></line>
<polyline points="12 5 19 12 12 19"></polyline>
</svg></a>
</div>
</div>
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
