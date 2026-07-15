<?php
if (!defined('ABSPATH')) exit;
get_header();

// --- Social URLs (pulled from footer settings for consistency) ---
$footer_id = kc_get_page_id_by_title('Footer');
$fb_url      = get_field('footer_facebook_url', $footer_id) ?: 'https://www.facebook.com/KingsCityPH/';
$ig_url      = get_field('footer_instagram_url', $footer_id) ?: 'https://www.instagram.com/kingscityph';
$share_url   = esc_url(get_permalink());
$share_title = esc_attr(get_the_title());
?>

<main id="main-content" style="background-color: var(--color-bg-ivory); padding-top: 160px; padding-bottom: 100px;">
  <?php while (have_posts()) : the_post(); ?>

    <?php
    $news_pages = get_pages(array(
        'meta_key' => '_wp_page_template',
        'meta_value' => 'page-news.php',
        'number' => 1
    ));
    $back_url = !empty($news_pages) ? get_permalink($news_pages[0]->ID) : home_url('/news/');
    ?>
    
    <article class="single-article-container">

      <!-- Back Button -->
      <a href="<?php echo esc_url($back_url); ?>" class="single-article__back-btn">
        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5"/><polyline points="12 19 5 12 12 5"/></svg>
        <span>Back to News</span>
      </a>
      
      <!-- Meta Row -->
      <div class="single-article__meta">
        <div class="single-article__meta-left">
          <span><?php echo esc_html(get_the_date('M j')); ?></span>
          <span>&middot;</span>
          <span>1 min read</span>
        </div>
        <!-- Three dots sharing toggle -->
        <div class="single-article__share-toggle" id="share-toggle">
          <button type="button" class="single-article__dots-btn" aria-label="Share options" id="share-dots-btn">
            <svg viewBox="0 0 24 24" width="18" height="18" fill="currentColor"><path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"/></svg>
          </button>
          <!-- Sharing Dropdown -->
          <div class="sharing-dropdown" id="sharing-dropdown" aria-hidden="true">
            <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode($share_url); ?>" target="_blank" rel="noopener noreferrer" class="sharing-dropdown__item">
              <svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
              <span>Share on Facebook</span>
            </a>
            <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode($share_url); ?>&text=<?php echo urlencode($share_title); ?>" target="_blank" rel="noopener noreferrer" class="sharing-dropdown__item">
              <svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
              <span>Share on X</span>
            </a>
            <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo urlencode($share_url); ?>&title=<?php echo urlencode($share_title); ?>" target="_blank" rel="noopener noreferrer" class="sharing-dropdown__item">
              <svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
              <span>Share on LinkedIn</span>
            </a>
            <a href="<?php echo esc_url($ig_url); ?>" target="_blank" rel="noopener noreferrer" class="sharing-dropdown__item">
              <svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.162 6.162 6.162 6.162-2.759 6.162-6.162-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
              <span>Visit Instagram</span>
            </a>
            <button type="button" class="sharing-dropdown__item js-copy-link" style="position: relative;">
              <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></svg>
              <span>Copy Link</span>
              <span class="copy-tooltip">Copied!</span>
            </button>
          </div>
        </div>
      </div>

      <!-- Title -->
      <h1 class="single-article__title">
        <?php echo esc_html(get_the_title()); ?>
      </h1>

      <!-- Content -->
      <div class="single-article-content">
          <div class="single-article__text-block">
            <?php the_content(); ?>
          </div>
      </div>

      <!-- Article Footer: Social Icons -->
      <div class="single-article__social-footer">
        <div class="single-article__social-divider"></div>
        <div class="single-article__social-icons">
          <a href="<?php echo esc_url($fb_url); ?>" target="_blank" rel="noopener noreferrer" aria-label="Facebook" class="single-article__social-link">
            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="currentColor" width="20" height="20"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
          </a>
          <a href="<?php echo esc_url($ig_url); ?>" target="_blank" rel="noopener noreferrer" aria-label="Instagram" class="single-article__social-link">
            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="currentColor" width="20" height="20"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.162 6.162 6.162 6.162-2.759 6.162-6.162-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
          </a>
          <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode($share_url); ?>&text=<?php echo urlencode($share_title); ?>" target="_blank" rel="noopener noreferrer" aria-label="X (Twitter)" class="single-article__social-link">
            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="currentColor" width="20" height="20"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
          </a>
          <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo urlencode($share_url); ?>&title=<?php echo urlencode($share_title); ?>" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn" class="single-article__social-link">
            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="currentColor" width="20" height="20"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
          </a>
          <button type="button" aria-label="Copy Link" class="single-article__social-link js-copy-link" style="position: relative; background:none; border:none; padding:0; cursor:pointer; color:var(--color-primary); display: flex; align-items: center; justify-content: center;">
            <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></svg>
            <span class="copy-tooltip">Copied!</span>
          </button>
        </div>
      </div>

    </article>

    <!-- Recent Posts Section -->
    <section class="single-article-recent">
      <div class="single-article-recent__header">
        <h2 class="single-article-recent__title">Recent Posts</h2>
        <?php
        $news_page = get_page_by_path('news');
        $news_url  = $news_page ? get_permalink($news_page->ID) : home_url('/news/');
        ?>
        <a href="<?php echo esc_url($news_url); ?>" class="single-article-recent__see-all">See All</a>
      </div>

      <?php
      $recent_args = array(
        'post_type'      => 'post',
        'posts_per_page' => 3,
        'post_status'    => 'publish',
        'orderby'        => 'date',
        'order'          => 'DESC',
        'post__not_in'   => array( get_the_ID() ),
      );
      $recent_query = new WP_Query($recent_args);

      if ($recent_query->have_posts()) :
      ?>
        <div class="journal-grid single-article-recent__grid">
          <?php while ($recent_query->have_posts()) : $recent_query->the_post(); ?>
            <?php get_template_part( 'partials/news-card' ); ?>
          <?php endwhile; wp_reset_postdata(); ?>
        </div>
      <?php else : ?>
        <p class="single-article-recent__empty" style="text-align: center; width: 100%;">There are no recent posts at this time.</p>
      <?php endif; ?>
    </section>

  <?php endwhile; ?>
</main>

<!-- Sharing Dropdown & Copy Link Script -->
<script>
(function() {
  'use strict';
  var dotsBtn   = document.getElementById('share-dots-btn');
  var dropdown  = document.getElementById('sharing-dropdown');
  var copyBtns  = document.querySelectorAll('.js-copy-link');

  if (!dotsBtn || !dropdown) return;

  // Toggle dropdown
  dotsBtn.addEventListener('click', function(e) {
    e.stopPropagation();
    var isOpen = dropdown.getAttribute('aria-hidden') === 'false';
    dropdown.setAttribute('aria-hidden', isOpen ? 'true' : 'false');
  });

  // Close on outside click
  document.addEventListener('click', function(e) {
    if (!dropdown.contains(e.target) && e.target !== dotsBtn) {
      dropdown.setAttribute('aria-hidden', 'true');
    }
  });

  // Close on Escape
  document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
      dropdown.setAttribute('aria-hidden', 'true');
    }
  });

  // Copy link securely
  copyBtns.forEach(function(btn) {
    btn.addEventListener('click', function(e) {
      e.stopPropagation(); // prevent dropdown from closing immediately
      var url = <?php echo wp_json_encode($share_url); ?>;
      
      function showCopied() {
        btn.classList.add('is-copied');
        setTimeout(function() {
          btn.classList.remove('is-copied');
          // Close dropdown if it's open
          if (dropdown.getAttribute('aria-hidden') === 'false') {
            dropdown.setAttribute('aria-hidden', 'true');
          }
        }, 2000);
      }

      if (navigator.clipboard && window.isSecureContext) {
        navigator.clipboard.writeText(url).then(showCopied);
      } else {
        // Fallback for non-HTTPS / older browsers
        var ta = document.createElement('textarea');
        ta.value = url;
        ta.style.position = 'fixed';
        ta.style.left = '-9999px';
        document.body.appendChild(ta);
        ta.select();
        try { 
          document.execCommand('copy'); 
          showCopied();
        } catch(err) {}
        document.body.removeChild(ta);
      }
    });
  });
})();
</script>

<?php get_footer(); ?>
