<?php
  $footer_page = get_page_by_title('Footer');
  $footer_id   = $footer_page ? $footer_page->ID : false;

  $f_logo_text       = get_field('footer_logo_text', $footer_id) ?: 'THE KINGS CITY CLUB';
  $f_address         = get_field('footer_address', $footer_id) ?: "Ground Level, RCS Building,\nDoña Soledad Ave, Better Living,\nParañaque City, Philippines";
  $f_facebook_url    = get_field('footer_facebook_url', $footer_id) ?: 'https://www.facebook.com/KingsCityPH/';
  $f_instagram_url   = get_field('footer_instagram_url', $footer_id) ?: 'https://www.instagram.com/kingscityph';

  $f_company_title   = get_field('footer_company_title', $footer_id) ?: 'Company';
  $f_company_link1   = get_field('footer_company_link1_label', $footer_id) ?: 'About Us';
  $f_company_link2   = get_field('footer_company_link2_label', $footer_id) ?: 'Space Hire';
  $f_company_link3   = get_field('footer_company_link3_label', $footer_id) ?: 'Offshoring Staffing';
  $f_company_link4   = get_field('footer_company_link4_label', $footer_id) ?: 'Shop';
  $f_company_link5   = get_field('footer_company_link5_label', $footer_id) ?: 'Apply';

  $f_solutions_title = get_field('footer_solutions_title', $footer_id) ?: 'Solutions';
  $f_solutions_link1 = get_field('footer_solutions_link1_label', $footer_id) ?: 'Why Kings City';
  $f_solutions_link2 = get_field('footer_solutions_link2_label', $footer_id) ?: 'Why Philippines';
  $f_solutions_link3 = get_field('footer_solutions_link3_label', $footer_id) ?: 'Outsourcing Models';
  $f_solutions_link4 = get_field('footer_solutions_link4_label', $footer_id) ?: 'News & Updates';

  $f_contact_title   = get_field('footer_contact_title', $footer_id) ?: 'Contact';
  $f_phone           = get_field('footer_phone', $footer_id) ?: '+63 ---- ---- ---';
  $f_email           = get_field('footer_email', $footer_id) ?: 'kingscity@kingsgroup.com.ph';

  $f_copyright       = get_field('footer_copyright', $footer_id) ?: '2026 Home Culinary & Technical School. All rights reserved. | Powered by ITMonsters';
  $f_privacy_label   = get_field('footer_privacy_label', $footer_id) ?: 'Privacy Policy';
  $f_terms_label     = get_field('footer_terms_label', $footer_id) ?: 'Terms of Use';
?>
<footer class="site-footer">
  <div class="container container--wide">
    <div class="footer-grid">
      
      <div class="footer-col" style="text-align: center;">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-header__logo" style="color: white; margin-bottom: 1rem; display: inline-flex; justify-content: center; width: 100%; text-decoration: none;">
          <span style="font-family: var(--font-heading); font-size: 1.25rem; font-weight: bold; letter-spacing: 0.05em;"><?php echo esc_html($f_logo_text); ?></span>
        </a>
        <p style="color: rgba(255,255,255,0.7); font-size: 0.85rem; line-height: 1.6; margin-left: auto; margin-right: auto;">
          <?php echo nl2br(esc_html($f_address)); ?>
        </p>
        <div class="footer-social" style="margin-top: 1rem; justify-content: center;">
          <a href="<?php echo esc_url($f_facebook_url); ?>" class="footer-social__link" aria-label="Facebook" target="_blank" rel="noopener noreferrer">
            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path></svg>
          </a>
          <a href="<?php echo esc_url($f_instagram_url); ?>" class="footer-social__link" aria-label="Instagram" target="_blank" rel="noopener noreferrer">
            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.162 6.162 6.162 6.162-2.759 6.162-6.162-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
          </a>
        </div>
      </div>

      <div class="footer-col" style="text-align: center;">
        <h4 class="footer-col__title"><?php echo esc_html($f_company_title); ?></h4>
        <nav class="footer-col__list" style="align-items: center;">
          <a href="<?php echo esc_url( home_url( '/about/' ) ); ?>"><?php echo esc_html($f_company_link1); ?></a>
          <a href="<?php echo esc_url( home_url( '/spaces/' ) ); ?>"><?php echo esc_html($f_company_link2); ?></a>
          <a href="<?php echo esc_url( home_url( '/offshoring/' ) ); ?>"><?php echo esc_html($f_company_link3); ?></a>
          <a href="https://kingscity.com.ph/" target="_blank" rel="noopener noreferrer"><?php echo esc_html($f_company_link4); ?></a>
          <a href="<?php echo esc_url( home_url( '/apply-now/' ) ); ?>"><?php echo esc_html($f_company_link5); ?></a>
        </nav>
      </div>

      <div class="footer-col" style="text-align: center;">
        <h4 class="footer-col__title"><?php echo esc_html($f_solutions_title); ?></h4>
        <nav class="footer-col__list" style="align-items: center;">
          <a href="<?php echo esc_url( home_url( '/offshoring/' ) ); ?>"><?php echo esc_html($f_solutions_link1); ?></a>
          <a href="<?php echo esc_url( home_url( '/offshoring/' ) ); ?>"><?php echo esc_html($f_solutions_link2); ?></a>
          <a href="<?php echo esc_url( home_url( '/offshoring/' ) ); ?>"><?php echo esc_html($f_solutions_link3); ?></a>
          <a href="<?php echo esc_url( home_url( '/news-insights/' ) ); ?>"><?php echo esc_html($f_solutions_link4); ?></a>
        </nav>
      </div>

      <div class="footer-col" style="text-align: center;">
        <h4 class="footer-col__title"><?php echo esc_html($f_contact_title); ?></h4>
        <nav class="footer-col__list" style="align-items: center;">
          <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $f_phone)); ?>"><?php echo esc_html($f_phone); ?></a>
          <a href="mailto:<?php echo esc_attr($f_email); ?>"><?php echo esc_html($f_email); ?></a>
        </nav>
      </div>

    </div>

    <div class="footer-bottom">
      <div class="footer-bottom__copy">
        &copy; <?php echo date('Y'); ?> <?php echo esc_html($f_copyright); ?>
      </div>
      <div class="footer-bottom__links">
        <a href="#"><?php echo esc_html($f_privacy_label); ?></a>
        <a href="#"><?php echo esc_html($f_terms_label); ?></a>
      </div>
    </div>
  </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
