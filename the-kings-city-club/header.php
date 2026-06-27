<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php wp_title('|', true, 'right'); bloginfo('name'); ?></title>
    <?php wp_head(); ?>
</head>
<body <?php body_class('has-announcement'); ?>>
<?php wp_body_open(); ?>
<?php 
  $header_page = get_page_by_title('Header'); 
  $header_id = $header_page ? $header_page->ID : false; 

  $logo_text         = get_field('header_logo_text', $header_id) ?: 'THE KINGS CITY CLUB';
  $nav_more          = get_field('header_nav_more_label', $header_id) ?: 'More';
  $nav_space         = get_field('header_nav_space_hire_label', $header_id) ?: 'Space Hire';
  $nav_offshoring    = get_field('header_nav_offshoring_label', $header_id) ?: 'Offshoring Staffing';
  $nav_shop          = get_field('header_nav_shop_label', $header_id) ?: 'Shop';
  $nav_shop_url      = get_field('header_nav_shop_url', $header_id) ?: 'https://kingscity.com.ph/';
  $nav_apply         = get_field('header_nav_apply_label', $header_id) ?: 'Apply';
  $nav_book          = get_field('header_nav_book_label', $header_id) ?: 'Book Now';
  $mega_title        = get_field('header_mega_menu_title', $header_id) ?: 'More by Kings Club';
  $mega_desc         = get_field('header_mega_menu_desc', $header_id) ?: 'As your business grows, we understand that Kings Club must grow with you.';
  $mega_link1        = get_field('header_mega_link1_label', $header_id) ?: 'Our Brands';
  $mega_link2        = get_field('header_mega_link2_label', $header_id) ?: 'About Us';
  $mega_link3        = get_field('header_mega_link3_label', $header_id) ?: 'Impact';
  $mega_link4        = get_field('header_mega_link4_label', $header_id) ?: 'News';
  $mega_logo         = get_field('header_mega_menu_logo', $header_id);
  $mega_logo_url     = ($mega_logo && is_array($mega_logo) && isset($mega_logo['url'])) ? esc_url($mega_logo['url']) : (is_numeric($mega_logo) ? wp_get_attachment_image_url($mega_logo, 'full') : get_template_directory_uri() . '/assets/img/page-header-img/kings-img70.png');
?>
<!-- Announcement Bar -->
<div class="announcement-bar" id="top-announcement" aria-hidden="false">
  <div class="container announcement-bar__inner">
    <span class="announcement-bar__text">- WHERE AMBITION MEETS COMMUNITY -</span>
    <button class="announcement-bar__close" id="close-announcement" aria-label="Close Announcement">
      <svg viewBox="0 0 24 24" width="16" height="16" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
    </button>
  </div>
</div>
<script>
  // Instant check to prevent flicker
  if (sessionStorage.getItem('announcementDismissed') === 'true') {
    document.getElementById('top-announcement').style.display = 'none';
    document.body.classList.remove('has-announcement');
  }
</script>
<header class="site-header" id="header">
  <div class="container container--wide site-header__inner">
    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-header__logo" aria-label="Kings City Home" style="text-decoration: none;">
      <span class="logo-black" style="font-family: var(--font-heading); font-size: 1.25rem; font-weight: bold; letter-spacing: 0.05em; color: var(--color-primary);"><?php echo esc_html($logo_text); ?></span>
      <span class="logo-white" style="font-family: var(--font-heading); font-size: 1.25rem; font-weight: bold; letter-spacing: 0.05em; color: #fff;"><?php echo esc_html($logo_text); ?></span>
    </a>

    <!-- desktop navigation -->
    <nav class="nav-desktop" aria-label="Primary Navigation">
      <div class="nav-desktop__list">
        <div class="nav-desktop__item has-mega-menu">
          <a href="#" class="nav-desktop__link" style="display: flex; align-items: center;">
            <?php echo esc_html($nav_more); ?> <svg class="nav-icon" viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-left: 6px;"><polyline points="6 9 12 15 18 9"></polyline></svg>
          </a>
          
          <!-- mega menu dropdown -->
          <div class="mega-menu">
            <div class="container mega-menu__inner">
              <div class="mega-menu__main-row">
                <div class="mega-menu__info">
                  <h3 class="mega-menu__title"><?php echo esc_html($mega_title); ?></h3>
                  <p class="mega-menu__desc"><?php echo esc_html($mega_desc); ?></p>
                </div>
                <div class="mega-menu__links">
                  <a href="<?php echo esc_url( home_url( '/our-brands/' ) ); ?>" class="mega-menu__link">
                    <svg class="mega-menu__link-arrow" viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                    <?php echo esc_html($mega_link1); ?>
                  </a>
                  <a href="<?php echo esc_url( home_url( '/about/' ) ); ?>" class="mega-menu__link">
                    <svg class="mega-menu__link-arrow" viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                    <?php echo esc_html($mega_link2); ?>
                  </a>
                  <a href="<?php echo esc_url( home_url( '/impact/' ) ); ?>" class="mega-menu__link">
                    <svg class="mega-menu__link-arrow" viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                    <?php echo esc_html($mega_link3); ?>
                  </a>
                  <a href="<?php echo esc_url( home_url( '/news-insights/' ) ); ?>" class="mega-menu__link">
                    <svg class="mega-menu__link-arrow" viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                    <?php echo esc_html($mega_link4); ?>
                  </a>
                </div>
                <div class="mega-menu__logo-box">
                  <!-- rationale: using png logo instead of svg as per direct user request. documented in project_context.md -->
                  <img src="<?php echo $mega_logo_url; ?>" alt="Kings City Icon" class="mega-menu__logo-img">
                </div>
              </div>
            </div>
          </div>
        </div>
        <a href="<?php echo esc_url( home_url( '/spaces/' ) ); ?>" class="nav-desktop__link"><?php echo esc_html($nav_space); ?></a>
        <a href="<?php echo esc_url( home_url( '/offshoring/' ) ); ?>" class="nav-desktop__link"><?php echo esc_html($nav_offshoring); ?></a>
        <a href="<?php echo esc_url($nav_shop_url); ?>" class="nav-desktop__link" target="_blank" rel="noopener noreferrer"><?php echo esc_html($nav_shop); ?></a>
      </div>
      <div class="nav-desktop__actions">
        <a href="<?php echo esc_url( home_url( '/apply-now/' ) ); ?>" class="btn btn--small btn--red"><?php echo esc_html($nav_apply); ?></a>
        <a href="<?php echo esc_url( home_url( '/book-a-tour/' ) ); ?>" class="btn btn--small btn--red"><?php echo esc_html($nav_book); ?></a>
      </div>
    </nav>

    <!-- mobile toggle -->
    <button class="nav-mobile-toggle" aria-label="Open Navigation Menu" aria-expanded="false">
      <div class="nav-mobile-toggle__burger">
        <span class="nav-mobile-toggle__bar"></span>
        <span class="nav-mobile-toggle__bar"></span>
        <span class="nav-mobile-toggle__bar"></span>
      </div>
      <svg class="nav-mobile-toggle__close" viewBox="0 0 24 24" width="28" height="28" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round">
        <line x1="18" y1="6" x2="6" y2="18"></line>
        <line x1="6" y1="6" x2="18" y2="18"></line>
      </svg>
    </button>
  </div>
</header>

<!-- mobile drawer overlay & menu -->
<div class="nav-drawer__overlay" aria-hidden="true"></div>
<div class="nav-drawer" id="nav-drawer" aria-hidden="true">
  <button class="nav-drawer__close" aria-label="Close Navigation Menu">
    <svg viewBox="0 0 24 24" width="28" height="28" stroke="var(--color-primary)" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round">
      <line x1="18" y1="6" x2="6" y2="18"></line>
      <line x1="6" y1="6" x2="18" y2="18"></line>
    </svg>
  </button>
  <div style="text-align: center; margin-bottom: 2rem;">
    <img src="<?php echo $mega_logo_url; ?>" alt="Kings City Icon" style="max-width: 150px; height: auto;">
  </div>
  <nav class="nav-drawer__list">
    <div class="nav-drawer__item has-submenu">
      <button class="nav-drawer__link submenu-toggle" style="width: 100%; text-align: left; background: none; border: none; display: flex; justify-content: space-between; align-items: center;">
        <?php echo esc_html($nav_more); ?> <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"></polyline></svg>
      </button>
      <div class="nav-drawer__submenu" style="display: none; padding-left: 1.5rem; background: rgba(0,0,0,0.05);">
        <a href="<?php echo esc_url( home_url( '/our-brands/' ) ); ?>" class="nav-drawer__link" style="font-size: 1.1rem; padding: 0.75rem 0;"><?php echo esc_html($mega_link1); ?></a>
        <a href="<?php echo esc_url( home_url( '/about/' ) ); ?>" class="nav-drawer__link" style="font-size: 1.1rem; padding: 0.75rem 0;"><?php echo esc_html($mega_link2); ?></a>
        <a href="<?php echo esc_url( home_url( '/impact/' ) ); ?>" class="nav-drawer__link" style="font-size: 1.1rem; padding: 0.75rem 0;"><?php echo esc_html($mega_link3); ?></a>
        <a href="<?php echo esc_url( home_url( '/news-insights/' ) ); ?>" class="nav-drawer__link" style="font-size: 1.1rem; padding: 0.75rem 0;"><?php echo esc_html($mega_link4); ?></a>
      </div>
    </div>
    <a href="<?php echo esc_url( home_url( '/spaces/' ) ); ?>" class="nav-drawer__link"><?php echo esc_html($nav_space); ?></a>
    <a href="<?php echo esc_url( home_url( '/offshoring/' ) ); ?>" class="nav-drawer__link"><?php echo esc_html($nav_offshoring); ?></a>
    <a href="<?php echo esc_url($nav_shop_url); ?>" class="nav-drawer__link" target="_blank" rel="noopener noreferrer"><?php echo esc_html($nav_shop); ?></a>
    <a href="<?php echo esc_url( home_url( '/apply-now/' ) ); ?>" class="btn btn--red mt-4" style="display: block; text-align: center;"><?php echo esc_html($nav_apply); ?></a>
    <a href="<?php echo esc_url( home_url( '/book-a-tour/' ) ); ?>" class="btn btn--red mt-2" style="display: block; text-align: center;"><?php echo esc_html($nav_book); ?></a>
  </nav>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const annBar = document.getElementById('top-announcement');
  const closeBtn = document.getElementById('close-announcement');
  const header = document.getElementById('header');

  if (closeBtn) {
    closeBtn.addEventListener('click', () => {
      annBar.style.display = 'none';
      document.body.classList.remove('has-announcement');
      sessionStorage.setItem('announcementDismissed', 'true');
    });
  }

  let lastScrollY = window.scrollY;
  window.addEventListener('scroll', () => {
    if (sessionStorage.getItem('announcementDismissed') === 'true') return;
    
    if (window.scrollY > 100 && window.scrollY > lastScrollY) {
      document.body.classList.add('hide-announcement');
    } else {
      document.body.classList.remove('hide-announcement');
    }
    lastScrollY = window.scrollY;
  });
});
</script>
