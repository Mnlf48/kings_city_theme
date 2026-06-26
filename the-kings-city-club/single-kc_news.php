<?php
get_header();
?>

<main id="main-content" style="background-color: var(--color-bg-ivory); padding-top: 160px; padding-bottom: 100px;">
  <?php while (have_posts()) : the_post(); ?>
    
    <article class="container" style="max-width: 760px; margin: 0 auto; padding: 0 20px;">
      
      <!-- Meta -->
      <div style="font-size: 0.85rem; color: var(--color-primary); margin-bottom: 1rem; opacity: 0.9; display: flex; align-items: center; gap: 0.5rem; justify-content: space-between;">
        <div style="display: flex; align-items: center; gap: 0.5rem;">
            <span><?php echo get_the_date('M j'); ?></span>
            <span>&middot;</span>
            <span>1 min read</span>
        </div>
        <!-- Three dots icon to mimic screenshot -->
        <svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor"><path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"/></svg>
      </div>

      <!-- Title -->
      <h1 style="font-family: var(--font-heading); font-size: 2.2rem; color: var(--color-primary); margin-bottom: 2.5rem; line-height: 1.3;">
        <?php the_title(); ?>
      </h1>

      <!-- Content -->
      <div class="single-article-content">
        <?php
        $article_raw = get_field('news_article_content');
        // Separate any <img> that is inline inside a <p> with text:
        // 1. Close the paragraph before any img tag
        $article_clean = preg_replace('/<img(\s[^>]*)>/i', '</p><figure><img$1></figure><p>', $article_raw);
        // 2. Remove empty <p></p> and <p> </p> artifacts left over
        $article_clean = preg_replace('/<p[^>]*>\s*<\/p>/i', '', $article_clean);
        // 3. Strip inline float styles
        $article_clean = preg_replace('/\s*style="[^"]*float[^"]*"/i', '', $article_clean);
        // 4. Replace WP align classes that cause floats
        $article_clean = str_replace(['alignleft', 'alignright'], 'alignnone', $article_clean);
        echo apply_filters('the_content', $article_clean);
        ?>
      </div>

    </article>

  <?php endwhile; ?>
</main>

<?php get_footer(); ?>
