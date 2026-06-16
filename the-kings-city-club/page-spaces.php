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
    /* Enforce exactly the same size for all 5 service types on desktop (Full Viewport Height) */
    @media (min-width: 1024px) {
      #coworking,
      #meeting,
      #events,
      #office,
      #virtual {
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
<h1 class="hero__title hero__title--inner" style="width: 100%;">
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
<a class="btn" href="<?php echo $apply_url; ?>">
                Become a Member
              </a>
</div>
</div>
<!-- slider on right -->
<div class="split__media hero__slider" id="hero-slider" style="position: relative; aspect-ratio: 4/3; overflow: hidden; border-radius: var(--radius-card);">
<!-- slide 1 -->
<img alt="Collaborative Workspace" class="hero__slide is-active" src="<?php $img = get_field('image_4'); echo ($img && is_array($img) && isset($img['url'])) ? esc_url($img['url']) : (is_numeric($img) ? wp_get_attachment_image_url($img, 'full') : get_template_directory_uri() . '/assets/img/placeholder.jpg'); ?>" style="position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; opacity: 1; transition: opacity 1s ease-in-out;"/>
<!-- slide 2 -->
<img alt="Comfortable Lounge Area" class="hero__slide" src="<?php $img = get_field('image_5'); echo ($img && is_array($img) && isset($img['url'])) ? esc_url($img['url']) : (is_numeric($img) ? wp_get_attachment_image_url($img, 'full') : get_template_directory_uri() . '/assets/img/placeholder.jpg'); ?>" style="position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; opacity: 0; transition: opacity 1s ease-in-out;"/>
<!-- slide 3 -->
<img alt="Modern Open Office" class="hero__slide" src="<?php $img = get_field('image_6'); echo ($img && is_array($img) && isset($img['url'])) ? esc_url($img['url']) : (is_numeric($img) ? wp_get_attachment_image_url($img, 'full') : get_template_directory_uri() . '/assets/img/placeholder.jpg'); ?>" style="position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; opacity: 0; transition: opacity 1s ease-in-out;"/>
</div>
</div>
</div>
</section>
<!-- co working section -->
<section class="section content-panel section--spaces" id="coworking">
<div class="container grid-12">
<div class="col-12 split">
<div class="split__media">
<img alt="Kings City Co-Working Space" src="<?php $img = get_field('image_12'); echo ($img && is_array($img) && isset($img['url'])) ? esc_url($img['url']) : (is_numeric($img) ? wp_get_attachment_image_url($img, 'full') : get_template_directory_uri() . '/assets/img/placeholder.jpg'); ?>" style="width: 100%; aspect-ratio: 4/3; object-fit: cover; border-radius: var(--radius-card);"/>
</div>
<div class="split__content text-center">
<span class="text-overline"><?php echo get_field('overline_11'); ?></span>
<h2><?php echo get_field('h2_8'); ?></h2>
<p style="color: var(--color-text-muted); margin-left: auto; margin-right: auto;"><?php echo get_field('p_9'); ?></p>
<p style="color: var(--color-text-muted); margin-left: auto; margin-right: auto;"><?php echo get_field('p_10'); ?></p>
<!-- pricing table -->
<div class="spaces-price-table">
<div class="spaces-price-table__head">Pricing</div>
<div class="spaces-price-table__row"><span>Day Pass</span><span>Php 500</span></div>
<div class="spaces-price-table__row"><span>Weekly Pass</span><span>Php 2,500</span></div>
<div class="spaces-price-table__row"><span>Monthly Pass</span><span>Php 6,000</span></div>
<div class="spaces-price-table__row"><span>Annual Pass</span><span>Php 60,000</span></div>
</div>
<div class="spaces-ctas">
<a class="btn" href="<?php echo $book_now_url; ?>">Book Now</a>
<a class="btn btn--outline" href="<?php echo $apply_url; ?>">Apply for Membership</a>
</div>
</div>
</div>
</div>
</section>
<!-- meeting rooms section -->
<section class="section content-panel section--spaces" id="meeting">
<div class="container grid-12">
<div class="col-12 split split--reverse">
<div class="split__media">
<img alt="Kings City Meeting Room" src="<?php $img = get_field('image_18'); echo ($img && is_array($img) && isset($img['url'])) ? esc_url($img['url']) : (is_numeric($img) ? wp_get_attachment_image_url($img, 'full') : get_template_directory_uri() . '/assets/img/placeholder.jpg'); ?>" style="width: 100%; aspect-ratio: 4/3; object-fit: cover; border-radius: var(--radius-card);"/>
</div>
<div class="split__content text-center">
<span class="text-overline"><?php echo get_field('overline_17'); ?></span>
<h2><?php echo get_field('h2_14'); ?></h2>
<p style="color: var(--color-text-muted); margin-left: auto; margin-right: auto;"><?php echo get_field('p_15'); ?></p>
<p style="color: var(--color-text-muted); margin-left: auto; margin-right: auto;"><?php echo get_field('p_16'); ?></p>
<div class="spaces-price-table">
<div class="spaces-price-table__head">Small Meeting Room (up to 6 pax)</div>
<div class="spaces-price-table__row"><span>Per Hour</span><span>Php 500</span></div>
<div class="spaces-price-table__row"><span>Full Day</span><span>Php 4,000</span></div>
<div class="spaces-price-table__head" style="margin-top: 0.5rem;">Conference Room (up to 12 pax)</div>
<div class="spaces-price-table__row"><span>Per Hour</span><span>Php 1,000</span></div>
<div class="spaces-price-table__row"><span>Full Day</span><span>Php 8,000</span></div>
</div>
<div class="spaces-ctas">
<a class="btn" href="<?php echo $book_now_url; ?>">Book Now</a>
<a class="btn btn--outline" href="<?php echo $apply_url; ?>">Apply for Membership</a>
</div>
</div>
</div>
</div>
</section>
<!-- events place section -->
<section class="section content-panel section--spaces" id="events">
<div class="container grid-12">
<div class="col-12 split">
<div class="split__media">
<img alt="Kings City Events Place" src="<?php $img = get_field('image_24'); echo ($img && is_array($img) && isset($img['url'])) ? esc_url($img['url']) : (is_numeric($img) ? wp_get_attachment_image_url($img, 'full') : get_template_directory_uri() . '/assets/img/placeholder.jpg'); ?>" style="width: 100%; aspect-ratio: 4/3; object-fit: cover; border-radius: var(--radius-card);"/>
</div>
<div class="split__content text-center">
<span class="text-overline"><?php echo get_field('overline_23'); ?></span>
<h2><?php echo get_field('h2_20'); ?></h2>
<p style="color: var(--color-text-muted); margin-left: auto; margin-right: auto;"><?php echo get_field('p_21'); ?></p>
<p style="color: var(--color-text-muted); margin-left: auto; margin-right: auto;"><?php echo get_field('p_22'); ?></p>
<!-- pricing table -->
<!-- rates are subject to change -->
<div class="spaces-price-table">
<div class="spaces-price-table__head">Pricing</div>
<div class="spaces-price-table__row"><span>Per Hour</span><span>Php 5,000</span></div>
<div class="spaces-price-table__row"><span>4 Hours</span><span>Php 18,000</span></div>
<div class="spaces-price-table__row"><span>Full Day</span><span>Php 40,000</span></div>
</div>
<div class="spaces-ctas">
<a class="btn" href="<?php echo $book_now_url; ?>">Book Now</a>
<a class="btn btn--outline" href="<?php echo $apply_url; ?>">Apply for Membership</a>
</div>
</div>
</div>
</div>
</section>
<!-- office leasing section -->
<section class="section content-panel section--spaces" id="office">
<div class="container grid-12">
<div class="col-12 split split--reverse">
<div class="split__media">
<img alt="Kings City Private Office" src="<?php $img = get_field('image_30'); echo ($img && is_array($img) && isset($img['url'])) ? esc_url($img['url']) : (is_numeric($img) ? wp_get_attachment_image_url($img, 'full') : get_template_directory_uri() . '/assets/img/placeholder.jpg'); ?>" style="width: 100%; aspect-ratio: 4/3; object-fit: cover; border-radius: var(--radius-card);"/>
</div>
<div class="split__content text-center">
<span class="text-overline"><?php echo get_field('overline_29'); ?></span>
<h2><?php echo get_field('h2_26'); ?></h2>
<p style="color: var(--color-text-muted); margin-left: auto; margin-right: auto;"><?php echo get_field('p_27'); ?></p>
<p style="color: var(--color-text-muted); margin-left: auto; margin-right: auto;"><?php echo get_field('p_28'); ?></p>
<!-- pricing table -->
<!-- rates are subject to change -->
<div class="spaces-price-table">
<div class="spaces-price-table__head">Monthly Pricing</div>
<div class="spaces-price-table__row"><span>6-Seat Office</span><span>Php 48,000 / mo</span></div>
<div class="spaces-price-table__row"><span>9-Seat Office</span><span>Php 55,000 / mo</span></div>
<div class="spaces-price-table__row"><span>14-Seat Office</span><span>Php 112,000 / mo</span></div>
</div>
<div class="spaces-ctas">
<a class="btn" href="<?php echo $book_now_url; ?>">Book Now</a>
<a class="btn btn--outline" href="<?php echo $apply_url; ?>">Apply for Membership</a>
</div>
</div>
</div>
</div>
</section>
<!-- virtual office section -->
<section class="section content-panel section--spaces" id="virtual">
<div class="container grid-12">
<div class="col-12 split">
<div class="split__media">
<img alt="Kings City Virtual Office Service" src="<?php $img = get_field('image_36'); echo ($img && is_array($img) && isset($img['url'])) ? esc_url($img['url']) : (is_numeric($img) ? wp_get_attachment_image_url($img, 'full') : get_template_directory_uri() . '/assets/img/placeholder.jpg'); ?>" style="width: 100%; aspect-ratio: 4/3; object-fit: cover; border-radius: var(--radius-card);"/>
</div>
<div class="split__content text-center">
<span class="text-overline"><?php echo get_field('overline_35'); ?></span>
<h2><?php echo get_field('h2_32'); ?></h2>
<p style="color: var(--color-text-muted); margin-left: auto; margin-right: auto;"><?php echo get_field('p_33'); ?></p>
<p style="color: var(--color-text-muted); margin-left: auto; margin-right: auto;"><?php echo get_field('p_34'); ?></p>
<div class="spaces-price-table">
<div class="spaces-price-table__head">Standard Plan</div>
<div class="spaces-price-table__row"><span>Monthly</span><span>Php 3,000</span></div>
<div class="spaces-price-table__row"><span>Annually</span><span>Php 30,000</span></div>
<div class="spaces-price-table__head" style="margin-top: 0.5rem;">Pro Plan</div>
<div class="spaces-price-table__row"><span>Monthly</span><span>Php 5,000</span></div>
<div class="spaces-price-table__row"><span>Annually</span><span>Php 50,000</span></div>
</div>
<div class="spaces-ctas">
<a class="btn" href="<?php echo $book_now_url; ?>">Book Now</a>
<a class="btn btn--outline" href="<?php echo $apply_url; ?>">Apply for Membership</a>
</div>
</div>
</div>
</div>
</section>
<!-- service section -->
<section class="section content-panel" id="spaces-services">
<div class="container text-center">
<span class="text-overline" style="margin-bottom: var(--space-sm); display: block;"><?php echo get_field('overline_43'); ?></span>
<h2 style="margin-bottom: var(--space-xl);"><?php echo get_field('h2_38'); ?></h2>
<div class="spaces-services-grid">
<div class="spaces-services__item">
<div class="spaces-services__item-icon">
<svg fill="none" height="24" stroke="var(--color-primary)" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewbox="0 0 24 24" width="24">
<path d="M12 22s-8-4.5-8-11.8A8 8 0 0 1 12 2a8 8 0 0 1 8 8.2c0 7.3-8 11.8-8 11.8z"></path>
<circle cx="12" cy="10" r="3"></circle>
</svg>
</div>
<div>
<h4 class="spaces-services__item-title">Premium Spaces</h4>
<p class="spaces-services__item-text"><?php echo get_field('p_39'); ?></p>
</div>
</div>
<div class="spaces-services__item">
<div class="spaces-services__item-icon">
<svg fill="none" height="24" stroke="var(--color-primary)" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewbox="0 0 24 24" width="24">
<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
<circle cx="9" cy="7" r="4"></circle>
<path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
<path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
</svg>
</div>
<div>
<h4 class="spaces-services__item-title">Dedicated Team</h4>
<p class="spaces-services__item-text"><?php echo get_field('p_40'); ?></p>
</div>
</div>
<div class="spaces-services__item">
<div class="spaces-services__item-icon">
<svg fill="none" height="24" stroke="var(--color-primary)" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewbox="0 0 24 24" width="24">
<rect height="14" rx="2" ry="2" width="20" x="2" y="3"></rect>
<line x1="8" x2="16" y1="21" y2="21"></line>
<line x1="12" x2="12" y1="17" y2="21"></line>
</svg>
</div>
<div>
<h4 class="spaces-services__item-title">Facilities &amp; Equipment</h4>
<p class="spaces-services__item-text"><?php echo get_field('p_41'); ?></p>
</div>
</div>
<div class="spaces-services__item">
<div class="spaces-services__item-icon">
<svg fill="none" height="24" stroke="var(--color-primary)" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewbox="0 0 24 24" width="24">
<path d="M18 8h1a4 4 0 0 1 0 8h-1"></path>
<path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"></path>
<line x1="6" x2="6" y1="1" y2="4"></line>
<line x1="10" x2="10" y1="1" y2="4"></line>
<line x1="14" x2="14" y1="1" y2="4"></line>
</svg>
</div>
<div>
<h4 class="spaces-services__item-title">Kitchen &amp; Café</h4>
<p class="spaces-services__item-text"><?php echo get_field('p_42'); ?></p>
</div>
</div>
</div>
</div>
</section>
<!-- spaces gallery carousel -->
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
<img alt="Premium Hot Desking" src="<?php $img = get_field('image_45'); echo ($img && is_array($img) && isset($img['url'])) ? esc_url($img['url']) : (is_numeric($img) ? wp_get_attachment_image_url($img, 'full') : get_template_directory_uri() . '/assets/img/placeholder.jpg'); ?>" style="width:100%; height:100%; object-fit:cover;"/>
</div>
<div class="gallery-card">
<img alt="Executive Meeting Rooms" src="<?php $img = get_field('image_46'); echo ($img && is_array($img) && isset($img['url'])) ? esc_url($img['url']) : (is_numeric($img) ? wp_get_attachment_image_url($img, 'full') : get_template_directory_uri() . '/assets/img/placeholder.jpg'); ?>" style="width:100%; height:100%; object-fit:cover;"/>
</div>
<div class="gallery-card">
<img alt="Event Space" src="<?php $img = get_field('image_47'); echo ($img && is_array($img) && isset($img['url'])) ? esc_url($img['url']) : (is_numeric($img) ? wp_get_attachment_image_url($img, 'full') : get_template_directory_uri() . '/assets/img/placeholder.jpg'); ?>" style="width:100%; height:100%; object-fit:cover;"/>
</div>
<div class="gallery-card">
<img alt="Private Suites" src="<?php $img = get_field('image_48'); echo ($img && is_array($img) && isset($img['url'])) ? esc_url($img['url']) : (is_numeric($img) ? wp_get_attachment_image_url($img, 'full') : get_template_directory_uri() . '/assets/img/placeholder.jpg'); ?>" style="width:100%; height:100%; object-fit:cover;"/>
</div>
<div class="gallery-card">
<img alt="Community Kitchen" src="<?php $img = get_field('image_49'); echo ($img && is_array($img) && isset($img['url'])) ? esc_url($img['url']) : (is_numeric($img) ? wp_get_attachment_image_url($img, 'full') : get_template_directory_uri() . '/assets/img/placeholder.jpg'); ?>" style="width:100%; height:100%; object-fit:cover;"/>
</div>
<!-- duplicated set for infinite loop -->
<div class="gallery-card">
<img alt="Premium Hot Desking" src="<?php $img = get_field('image_50'); echo ($img && is_array($img) && isset($img['url'])) ? esc_url($img['url']) : (is_numeric($img) ? wp_get_attachment_image_url($img, 'full') : get_template_directory_uri() . '/assets/img/placeholder.jpg'); ?>" style="width:100%; height:100%; object-fit:cover;"/>
</div>
<div class="gallery-card">
<img alt="Executive Meeting Rooms" src="<?php $img = get_field('image_51'); echo ($img && is_array($img) && isset($img['url'])) ? esc_url($img['url']) : (is_numeric($img) ? wp_get_attachment_image_url($img, 'full') : get_template_directory_uri() . '/assets/img/placeholder.jpg'); ?>" style="width:100%; height:100%; object-fit:cover;"/>
</div>
<div class="gallery-card">
<img alt="Event Space" src="<?php $img = get_field('image_52'); echo ($img && is_array($img) && isset($img['url'])) ? esc_url($img['url']) : (is_numeric($img) ? wp_get_attachment_image_url($img, 'full') : get_template_directory_uri() . '/assets/img/placeholder.jpg'); ?>" style="width:100%; height:100%; object-fit:cover;"/>
</div>
<div class="gallery-card">
<img alt="Private Suites" src="<?php $img = get_field('image_53'); echo ($img && is_array($img) && isset($img['url'])) ? esc_url($img['url']) : (is_numeric($img) ? wp_get_attachment_image_url($img, 'full') : get_template_directory_uri() . '/assets/img/placeholder.jpg'); ?>" style="width:100%; height:100%; object-fit:cover;"/>
</div>
<div class="gallery-card">
<img alt="Community Kitchen" src="<?php $img = get_field('image_54'); echo ($img && is_array($img) && isset($img['url'])) ? esc_url($img['url']) : (is_numeric($img) ? wp_get_attachment_image_url($img, 'full') : get_template_directory_uri() . '/assets/img/placeholder.jpg'); ?>" style="width:100%; height:100%; object-fit:cover;"/>
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
