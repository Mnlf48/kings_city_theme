<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php wp_title('|', true, 'right'); bloginfo('name'); ?></title>
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<header class="site-header" id="header">
  <div class="container container--wide site-header__inner">
    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-header__logo" aria-label="Kings City Home" style="text-decoration: none;">
      <span class="logo-black" style="font-family: var(--font-heading); font-size: 1.25rem; font-weight: bold; letter-spacing: 0.05em; color: var(--color-primary);">THE KINGS CITY CLUB</span>
      <span class="logo-white" style="font-family: var(--font-heading); font-size: 1.25rem; font-weight: bold; letter-spacing: 0.05em; color: #fff;">THE KINGS CITY CLUB</span>
    </a>

    <!-- desktop navigation -->
    <nav class="nav-desktop" aria-label="Primary Navigation">
      <div class="nav-desktop__list">
        <div class="nav-desktop__item has-mega-menu">
          <a href="#" class="nav-desktop__link" style="display: flex; align-items: center;">
            More <svg class="nav-icon" viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-left: 6px;"><polyline points="6 9 12 15 18 9"></polyline></svg>
          </a>
          
          <!-- mega menu dropdown -->
          <div class="mega-menu">
            <div class="container mega-menu__inner">
              <div class="mega-menu__main-row">
                <div class="mega-menu__info">
                  <h3 class="mega-menu__title">More by Kings Club</h3>
                  <p class="mega-menu__desc">As your business grows, we understand that Kings Club must grow with you.</p>
                </div>
                <div class="mega-menu__links">
                  <a href="<?php echo esc_url( home_url( '/our-brands/' ) ); ?>" class="mega-menu__link">
                    <svg class="mega-menu__link-arrow" viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                    Our Brands
                  </a>
                  <a href="<?php echo esc_url( home_url( '/about/' ) ); ?>" class="mega-menu__link">
                    <svg class="mega-menu__link-arrow" viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                    About Us
                  </a>
                  <a href="<?php echo esc_url( home_url( '/impact/' ) ); ?>" class="mega-menu__link">
                    <svg class="mega-menu__link-arrow" viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                    Impact
                  </a>
                  <a href="<?php echo esc_url( home_url( '/news-insights/' ) ); ?>" class="mega-menu__link">
                    <svg class="mega-menu__link-arrow" viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                    News
                  </a>
                </div>
                <div class="mega-menu__logo-box">
                  <!-- rationale: using png logo instead of svg as per direct user request. documented in project_context.md -->
                  <img src="<?php echo get_template_directory_uri(); ?>/assets/img/the_kings_city_club_terracotta_01.png" alt="Kings City Icon" class="mega-menu__logo-img">
                </div>
              </div>
            </div>
          </div>
        </div>
        <a href="<?php echo esc_url( home_url( '/spaces/' ) ); ?>" class="nav-desktop__link">Space Hire</a>
        <a href="<?php echo esc_url( home_url( '/offshoring/' ) ); ?>" class="nav-desktop__link">Offshoring Staffing</a>
        <a href="https://kingscity.com.ph/" class="nav-desktop__link" target="_blank" rel="noopener noreferrer">Shop</a>
      </div>
      <div class="nav-desktop__actions">
        <a href="<?php echo esc_url( home_url( '/apply-now/' ) ); ?>" class="btn btn--small">Apply</a>
        <a href="<?php echo esc_url( home_url( '/book-a-tour/' ) ); ?>" class="btn btn--small">Book Now</a>
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
  <nav class="nav-drawer__list">
    <div class="nav-drawer__item has-submenu">
      <button class="nav-drawer__link submenu-toggle" style="width: 100%; text-align: left; background: none; border: none; display: flex; justify-content: space-between; align-items: center;">
        More <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"></polyline></svg>
      </button>
      <div class="nav-drawer__submenu" style="display: none; padding-left: 1.5rem; background: rgba(0,0,0,0.05);">
        <a href="<?php echo esc_url( home_url( '/our-brands/' ) ); ?>" class="nav-drawer__link" style="font-size: 1.1rem; padding: 0.75rem 0;">Our Brands</a>
        <a href="<?php echo esc_url( home_url( '/about/' ) ); ?>" class="nav-drawer__link" style="font-size: 1.1rem; padding: 0.75rem 0;">About Us</a>
        <a href="<?php echo esc_url( home_url( '/impact/' ) ); ?>" class="nav-drawer__link" style="font-size: 1.1rem; padding: 0.75rem 0;">Impact</a>
        <a href="<?php echo esc_url( home_url( '/news-insights/' ) ); ?>" class="nav-drawer__link" style="font-size: 1.1rem; padding: 0.75rem 0;">News</a>
      </div>
    </div>
    <a href="<?php echo esc_url( home_url( '/spaces/' ) ); ?>" class="nav-drawer__link">Space Hire</a>
    <a href="<?php echo esc_url( home_url( '/offshoring/' ) ); ?>" class="nav-drawer__link">Offshoring Staffing</a>
    <a href="https://kingscity.com.ph/" class="nav-drawer__link" target="_blank" rel="noopener noreferrer">Shop</a>
    <a href="<?php echo esc_url( home_url( '/apply-now/' ) ); ?>" class="btn mt-4" style="display: block; text-align: center;">Apply</a>
    <a href="<?php echo esc_url( home_url( '/book-a-tour/' ) ); ?>" class="btn mt-2" style="display: block; text-align: center;">Book Now</a>
  </nav>
</div>

