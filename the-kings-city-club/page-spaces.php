<?php
/* Template Name: Spaces */
get_header();

// Resolve apply and book-now page URLs by template name (safe — works regardless of slug)
$apply_page    = get_pages( array( 'meta_key' => '_wp_page_template', 'meta_value' => 'page-apply.php' ) );
$book_now_page = get_pages( array( 'meta_key' => '_wp_page_template', 'meta_value' => 'page-book-now.php' ) );
$apply_url     = ! empty( $apply_page )    ? esc_url( get_permalink( $apply_page[0]->ID ) )    : esc_url( home_url( '/apply/' ) );
$book_now_url  = ! empty( $book_now_page ) ? esc_url( get_permalink( $book_now_page[0]->ID ) ) : esc_url( home_url( '/book-now/' ) );
?>

<style>
    /* Enforce exactly the same size for all space sections on desktop (Full Viewport Height) */
    @media (min-width: 1024px) {
      .section--spaces {
        min-height: 100vh;
        min-height: 100dvh;
        display: flex;
        flex-direction: column;
        justify-content: center;
      }
    }
  </style>

<main id="main-content">
<!-- hero section -->
<section class="hero premium-hero">
<div class="container grid-12">
<div class="col-12 split split--media-right">
<!-- text on left -->
<div class="split__content animate-fadeInUp hero__content--index">
<span class="text-overline hero__overline"><?php echo get_field('overline_3'); ?></span>
<h1 class="hero__title hero__title--inner" style="width: 100%; text-transform: uppercase;">
<?php 
$h1_val = get_field('h1_1');
if (!$h1_val) $h1_val = 'The Kings City Space';

if (stripos($h1_val, 'the kings city space') !== false) {
    echo '<span style="display: block;">' . trim(str_ireplace('City Space', '', $h1_val)) . '</span>';
    echo '<span style="display: block;">City Space</span>';
} else {
    $w = explode(' ', trim($h1_val)); 
    echo (count($w) === 3) ? $w[0] . '&nbsp;' . $w[1] . ' ' . $w[2] : $h1_val;
}
?>
</h1>
<p class="hero__subtitle"><?php echo get_field('p_2'); ?></p>
<div class="hero__actions hero__actions--index">
<?php
$spaces_hero_btn_text = get_field('proposed_spaces_hero_btn_text') ?: 'Become a Member';
$spaces_hero_btn_url  = kc_url('proposed_spaces_hero_btn_url', '/book-a-tour/');
?>
<a class="btn" href="<?php echo $spaces_hero_btn_url; ?>"><?php echo esc_html($spaces_hero_btn_text); ?></a>
</div>
</div>
<!-- slider on right -->
<div class="split__media hero__slider" id="hero-slider" style="position: relative; aspect-ratio: 4/3; overflow: hidden; border-radius: var(--radius-card);">
<!-- slide 1 -->
<img alt="Collaborative Workspace" class="hero__slide is-active" src="<?php echo kc_img('image_4', 'page-spaces-img/kings-img49.webp'); ?>" style="position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; opacity: 1; transition: opacity 1s ease-in-out;"/>
<!-- slide 2 -->
<img alt="Comfortable Lounge Area" class="hero__slide" src="<?php echo kc_img('image_5', 'page-spaces-img/kings-img19.webp'); ?>" style="position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; opacity: 0; transition: opacity 1s ease-in-out;"/>
<!-- slide 3 -->
<img alt="Modern Open Office" class="hero__slide" src="<?php echo kc_img('image_6', 'page-spaces-img/kings-img52.webp'); ?>" style="position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; opacity: 0; transition: opacity 1s ease-in-out;"/>
</div>
</div>
</div>
</section>
<?php
$spaces_query = new WP_Query([
    'post_type'      => 'kc_space',
    'posts_per_page' => -1,
    'post_status'    => 'publish',
    'meta_query'     => [['key' => 'kc_space_is_active', 'value' => '1']],
    'orderby'        => 'menu_order',
    'order'          => 'ASC',
]);
$space_index = 0;
if ($spaces_query->have_posts()) :
    while ($spaces_query->have_posts()) : $spaces_query->the_post();
        $sp_id          = get_the_ID();
        $sp_booking_key = get_field('kc_space_booking_key', $sp_id);
        $sp_overline    = get_field('kc_space_overline', $sp_id);
        $sp_heading     = get_field('kc_space_heading', $sp_id);
        $sp_desc1       = get_field('kc_space_description_1', $sp_id);
        $sp_desc2       = get_field('kc_space_description_2', $sp_id);
        $sp_img1        = get_field('kc_space_img_1', $sp_id);
        $sp_img2        = get_field('kc_space_img_2', $sp_id);
        $sp_img3        = get_field('kc_space_img_3', $sp_id);
        $sp_pricing_note  = get_field('kc_space_pricing_note', $sp_id);
        $sp_pricing_table = get_field('kc_space_pricing_table', $sp_id);
        $sp_section_id  = sanitize_title($sp_booking_key);
        $split_class    = ($space_index % 2 === 0) ? 'split' : 'split split--reverse';
        $pricing_rows   = $sp_pricing_table ? array_filter(array_map('trim', explode("\n", $sp_pricing_table))) : [];
?>
<section class="section content-panel section--spaces" id="<?php echo esc_attr($sp_section_id); ?>" style="position: relative; overflow: hidden;">
          <div class="container grid-12" style="position: relative; z-index: 2;">
<div class="col-12 <?php echo esc_attr($split_class); ?>">
<div class="split__media spaces-img-slider" style="position: relative; aspect-ratio: 4/3; overflow: hidden; border-radius: var(--radius-card);">
<?php if ($sp_img1) : ?>
<img class="spaces__slide is-active" alt="<?php echo esc_attr($sp_heading); ?> 1" src="<?php echo esc_url($sp_img1); ?>" style="position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; opacity: 1; transition: opacity 1s ease-in-out;"/>
<?php endif; ?>
<?php if ($sp_img2) : ?>
<img class="spaces__slide" alt="<?php echo esc_attr($sp_heading); ?> 2" src="<?php echo esc_url($sp_img2); ?>" style="position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; opacity: 0; transition: opacity 1s ease-in-out;"/>
<?php endif; ?>
<?php if ($sp_img3) : ?>
<img class="spaces__slide" alt="<?php echo esc_attr($sp_heading); ?> 3" src="<?php echo esc_url($sp_img3); ?>" style="position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; opacity: 0; transition: opacity 1s ease-in-out;"/>
<?php endif; ?>
</div>
<div class="split__content text-center">
<?php if ($sp_overline) : ?><span class="text-overline"><?php echo esc_html($sp_overline); ?></span><?php endif; ?>
<h2><?php echo esc_html($sp_heading); ?></h2>
<?php if ($sp_desc1) : ?><p style="color: var(--color-text-muted); margin-left: auto; margin-right: auto;"><?php echo esc_html($sp_desc1); ?></p><?php endif; ?>
<?php if ($sp_desc2) : ?><p style="color: var(--color-text-muted); margin-left: auto; margin-right: auto;"><?php echo esc_html($sp_desc2); ?></p><?php endif; ?>
<?php if ($pricing_rows) : ?>
<div class="spaces-price-table">
<?php if ($sp_pricing_note) : ?><div class="spaces-price-table__head"><?php echo esc_html($sp_pricing_note); ?></div><?php endif; ?>
<?php foreach ($pricing_rows as $row) :
    $parts = explode('|', $row, 2);
    if (count($parts) === 2) : ?>
<div class="spaces-price-table__row"><span><?php echo esc_html(trim($parts[0])); ?></span><span><?php echo esc_html(trim($parts[1])); ?></span></div>
<?php endif; endforeach; ?>
</div>
<?php endif; ?>
<div class="spaces-ctas">
<a class="btn" href="<?php echo $book_now_url; ?>">Book Now</a>
</div>
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
<?php
        $space_index++;
    endwhile;
    wp_reset_postdata();
endif;
?>

<!-- service section -->
<section class="section content-panel" id="spaces-services" style="position: relative; overflow: hidden;">

          <!-- 1. Star -->
          <!-- 2. Heart -->
          <!-- 3. Star -->
          <!-- 4. Heart -->
          <!-- 5. Star -->
          <div class="container text-center" style="position: relative; z-index: 2;">
<span class="text-overline" style="margin-bottom: var(--space-sm); display: block;"><?php echo get_field('overline_43'); ?></span>
<h2 style="margin-bottom: var(--space-xl);"><?php echo get_field('h2_38'); ?></h2>
<div class="spaces-services-grid cycle-card-bg">
<div class="spaces-services__item card-glass compact-mobile">
<div class="universal-icon-wrapper">
<svg fill="none" height="48" stroke="var(--color-primary)" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24" width="48">
<circle cx="11" cy="11" r="8" fill="var(--color-bg-ivory)" stroke="none"></circle>
<path d="M12 22s-8-4.5-8-11.8A8 8 0 0 1 12 2a8 8 0 0 1 8 8.2c0 7.3-8 11.8-8 11.8z"></path>
<circle cx="12" cy="10" r="3"></circle>
</svg>
</div>
<div>
<h4 class="spaces-services__item-title"><?php echo esc_html(get_field('proposed_spaces_service_1_heading') ?: 'Premium Spaces'); ?></h4>
<p class="spaces-services__item-text"><?php echo get_field('p_39'); ?></p>
</div>
</div>
<div class="spaces-services__item card-glass compact-mobile">
<div class="universal-icon-wrapper">
<svg fill="none" height="48" stroke="var(--color-primary)" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24" width="48">
<circle cx="11" cy="11" r="8" fill="var(--color-bg-ivory)" stroke="none"></circle>
<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
<circle cx="9" cy="7" r="4"></circle>
<path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
<path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
</svg>
</div>
<div>
<h4 class="spaces-services__item-title"><?php echo esc_html(get_field('proposed_spaces_service_2_heading') ?: 'Dedicated Team'); ?></h4>
<p class="spaces-services__item-text"><?php echo get_field('p_40'); ?></p>
</div>
</div>
<div class="spaces-services__item card-glass compact-mobile">
<div class="universal-icon-wrapper">
<svg fill="none" height="48" stroke="var(--color-primary)" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24" width="48">
<circle cx="11" cy="11" r="8" fill="var(--color-bg-ivory)" stroke="none"></circle>
<path d="M6 13.87A4 4 0 0 1 7.41 6a5.11 5.11 0 0 1 1.05-1.54 5 5 0 0 1 7.08 0A5.11 5.11 0 0 1 16.59 6 4 4 0 0 1 18 13.87V21H6Z"></path>
<line x1="6" x2="18" y1="17" y2="17"></line>
</svg>
</div>
<div>
<h4 class="spaces-services__item-title"><?php echo esc_html(get_field('proposed_spaces_service_3_heading') ?: 'Social Manila Bakehouse'); ?></h4>
<p class="spaces-services__item-text"><?php echo get_field('p_41'); ?></p>
</div>
</div>
<div class="spaces-services__item card-glass compact-mobile">
<div class="universal-icon-wrapper">
<svg fill="none" height="48" stroke="var(--color-primary)" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24" width="48">
<circle cx="11" cy="11" r="8" fill="var(--color-bg-ivory)" stroke="none"></circle>
<path d="M18 8h1a4 4 0 0 1 0 8h-1"></path>
<path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"></path>
<line x1="6" x2="6" y1="1" y2="4"></line>
<line x1="10" x2="10" y1="1" y2="4"></line>
<line x1="14" x2="14" y1="1" y2="4"></line>
</svg>
</div>
<div>
<h4 class="spaces-services__item-title"><?php echo esc_html(get_field('proposed_spaces_service_4_heading') ?: 'Taza'); ?></h4>
<p class="spaces-services__item-text"><?php echo get_field('p_42'); ?></p>
</div>
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
<!-- locations gallery carousel -->
<section class="section content-panel section--gallery gallery-theme-pink" style="position: relative; padding: var(--space-lg) 0 var(--space-2xl) 0; overflow: hidden;">
<!-- Background Confetti -->
<div class="gallery-bg-icon" style="top: 10%; right: 15%; color: var(--color-bg-ivory); animation: floatJournal 4.5s infinite ease-in-out;">
  <svg width="45" height="45" viewBox="0 0 24 24" fill="currentColor" opacity="0.3"><path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z"/></svg>
</div>
<div class="gallery-bg-icon" style="bottom: 15%; left: 10%; color: #BD451F; animation: floatJournal 6s infinite ease-in-out reverse;">
  <svg width="55" height="55" viewBox="0 0 24 24" fill="currentColor" opacity="0.2"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
</div>
<div class="gallery-bg-icon" style="top: 50%; left: 3%; color: var(--color-accent-gold); animation: floatJournal 5.5s infinite ease-in-out;">
  <svg width="30" height="30" viewBox="0 0 24 24" fill="currentColor" opacity="0.4"><circle cx="12" cy="12" r="10"/></svg>
</div>

<!-- Heading -->
<div class="container" style="position: relative; z-index: 2;">
  <div style="text-align: center; margin-bottom: var(--space-xl);">
    <h2 class="gallery-heading" style="margin-bottom: 0; font-size: clamp(2rem, 4vw, 3rem); font-weight: 700;"><?php $heading = get_field('section_txt_gallery_heading'); echo $heading ? $heading : 'Virtual Tour'; ?></h2>
  </div>
</div>

<button aria-label="Previous image" class="gallery-nav gallery-nav--prev" onclick="scrollGallery(-1)">
<svg fill="none" height="20" stroke="currentColor" stroke-width="2" viewbox="0 0 24 24" width="20"><polyline points="15 18 9 12 15 6"></polyline></svg>
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
<svg fill="none" height="20" stroke="currentColor" stroke-width="2" viewbox="0 0 24 24" width="20"><polyline points="9 18 15 12 9 6"></polyline></svg>
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
          const halfWidth = gallery.scrollWidth / 2;

          if (direction > 0) {
            // Scrolling forward — loop back if at/near end of duplicated set
            if (gallery.scrollLeft + gallery.clientWidth >= gallery.scrollWidth - 4) {
              gallery.style.scrollBehavior = 'auto';
              gallery.scrollLeft = 0;
              void gallery.offsetWidth;
              gallery.style.scrollBehavior = 'smooth';
              gallery.scrollBy({ left: scrollAmount });
            } else if (gallery.scrollLeft >= halfWidth) {
              gallery.style.scrollBehavior = 'auto';
              gallery.scrollLeft -= halfWidth;
              void gallery.offsetWidth;
              gallery.style.scrollBehavior = 'smooth';
              gallery.scrollBy({ left: scrollAmount });
            } else {
              gallery.style.scrollBehavior = 'smooth';
              gallery.scrollBy({ left: scrollAmount });
            }
          } else {
            // Scrolling backward — loop to end if at/near start
            if (gallery.scrollLeft <= 4) {
              gallery.style.scrollBehavior = 'auto';
              gallery.scrollLeft = halfWidth - scrollAmount;
              void gallery.offsetWidth;
              gallery.style.scrollBehavior = 'smooth';
              gallery.scrollBy({ left: -scrollAmount });
            } else {
              gallery.style.scrollBehavior = 'smooth';
              gallery.scrollBy({ left: scrollAmount * direction });
            }
          }
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
</script>
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

    // Generic Image Sliders
    (function() {
      const sliders = document.querySelectorAll('.spaces-img-slider');
      sliders.forEach(slider => {
        const slides = slider.querySelectorAll('.spaces__slide');
        if (slides.length < 2) return;
        let current = 0;
        setInterval(() => {
          slides[current].style.opacity = '0';
          slides[current].classList.remove('is-active');
          current = (current + 1) % slides.length;
          slides[current].style.opacity = '1';
          slides[current].classList.add('is-active');
        }, 4000);
      });
    })();
  </script>


<?php get_footer(); ?>
