<?php
if (!defined('ABSPATH')) exit;
/* 404 Error Page */

$err_id = kc_get_page_id_by_title('404 Settings');

$err_heading    = esc_html(get_field('err_heading',    $err_id) ?: 'Page Not Found');
$err_subheading = esc_html(get_field('err_subheading', $err_id) ?: 'Oops — looks like this page took the day off.');
$err_body       = esc_html(get_field('err_body',       $err_id) ?: 'The page you are looking for doesn\'t exist or has been moved. Let\'s get you back on track.');
$err_btn_label  = esc_html(get_field('err_btn_label',  $err_id) ?: 'Back to Homepage');

get_header();
?>


<main id="main-content">
<section class="section content-panel bg-ivory" style="min-height: 100vh; display: flex; align-items: center; justify-content: center; position: relative; overflow: hidden;">

  <!-- Floating background icons -->
  <div class="floating-bg-icon anim-float-fast" style="top: 10%; right: 8%; color: var(--color-primary);">
    <svg viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
  </div>
  <div class="floating-bg-icon anim-pulse" style="bottom: 15%; left: 5%; color: var(--color-accent-red);">
    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
  </div>
  <div class="floating-bg-icon anim-float-fast" style="bottom: 20%; right: 5%; color: var(--color-primary); opacity: 0.3;">
    <svg viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
  </div>

  <div class="container" style="position: relative; z-index: 2; text-align: center;">

    <!-- Big 404 -->
    <div aria-hidden="true" style="font-family: var(--font-heading); font-size: clamp(7rem, 20vw, 14rem); font-weight: bold; letter-spacing: 0.05em; color: var(--color-primary); line-height: 1; opacity: 0.12; user-select: none; margin-bottom: var(--space-sm);">404</div>

    <!-- Divider -->
    <div style="width: 60px; height: 4px; background: var(--color-accent-red); margin: 0 auto var(--space-md); border-radius: 2px;"></div>

    <!-- Heading -->
    <h1 style="font-family: var(--font-heading); font-size: clamp(1.8rem, 5vw, 3rem); letter-spacing: 0.1em; text-transform: uppercase; color: var(--color-primary); margin: 0 0 var(--space-sm);"><?php echo $err_heading; ?></h1>

    <!-- Subheading -->
    <p style="font-family: var(--font-heading); font-size: clamp(0.95rem, 2.5vw, 1.2rem); color: var(--color-text-muted); letter-spacing: 0.03em; margin: 0 auto var(--space-sm); text-align: center !important; max-width: 600px;"><?php echo $err_subheading; ?></p>

    <!-- Body -->
    <p style="max-width: 480px; margin: 0 auto var(--space-xl); color: var(--color-text-muted); font-size: 1rem; line-height: 1.7;"><?php echo $err_body; ?></p>

    <!-- Button -->
    <a class="btn btn--red" href="<?php echo esc_url(home_url('/')); ?>" style="padding: 1rem 2.5rem; font-size: 1rem;">
      <?php echo $err_btn_label; ?>
    </a>

  </div>
</section>
</main>

<?php get_footer(); ?>
