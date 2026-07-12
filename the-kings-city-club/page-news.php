<?php
if (!defined('ABSPATH')) exit;
/* Template Name: News & Insights */
get_header();
?>

<main id="main-content">
<!-- hero section -->
<!-- hero section -->
<section class="hero premium-hero">
<div class="container grid-12">
<div class="col-12 split split--media-right">
<!-- text content on left -->
<div class="split__content animate-fadeInUp hero__content--index">
<span class="text-overline hero__overline"><?php echo esc_html(get_field('overline_3')); ?></span>
<h1 class="hero__title hero__title--inner"><?php $h = esc_html(get_field('h1_1')); if ($h) { $w = explode(' ', trim($h)); echo (count($w) === 3) ? $w[0] . '&nbsp;' . $w[1] . ' ' . $w[2] : $h; } ?></h1>
<p class="hero__subtitle"><?php echo esc_html(get_field('p_2')); ?></p>
</div>
<!-- media on right -->
<div class="split__media hero__slider" id="hero-slider" style="position: relative; aspect-ratio: 4/3; overflow: hidden; border-radius: var(--radius-card);">
<!-- slide 1 -->
<img class="hero__slide is-active" alt="Kings City News" src="<?php echo kc_img('news_hero_img1', 'page-about-img/kings-img55.webp'); ?>" style="position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; opacity: 1; transition: opacity 1s ease-in-out;"/>
<!-- slide 2 -->
<img class="hero__slide" alt="Kings City News" src="<?php echo kc_img('news_hero_img2', 'page-news-img/kings-img99.webp'); ?>" style="position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; opacity: 0; transition: opacity 1s ease-in-out;"/>
<!-- slide 3 -->
<img class="hero__slide" alt="Kings City News" src="<?php echo kc_img('news_hero_img3', 'page-news-img/kings-img100.webp'); ?>" style="position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; opacity: 0; transition: opacity 1s ease-in-out;"/>
</div>
</div>
</div>
</section>
<?php
$news_args = array(
    'post_type'      => 'post',
    'posts_per_page' => -1, // Fetch all for now
    'post_status'    => 'publish',
    'orderby'        => 'date',
    'order'          => 'DESC',
);
$news_query = new WP_Query($news_args);

if ($news_query->have_posts()) :
    $all_posts = $news_query->posts;
    $chunked_posts = array_chunk($all_posts, 3);
    
    foreach ($chunked_posts as $index => $group) :
        $bg_class = ($index % 2 === 0) ? 'bg-blush' : 'bg-ivory';
        if ($bg_class === 'bg-blush') {
            $c1 = 'var(--color-primary)';
            $c2 = 'var(--color-accent-red)';
            $c3 = 'var(--color-bg-ivory)';
        } else {
            $c1 = 'var(--color-primary)';
            $c2 = 'var(--color-accent-red)';
            $c3 = 'var(--color-secondary)';
        }
        ?>
        <!-- dynamic section <?php echo $index + 1; ?> -->
        <section class="section content-panel <?php echo esc_attr($bg_class); ?>" style="position: relative; overflow: hidden;">
          <!-- Background Floating Icons -->
          <!-- 1. Star -->
          <div class="floating-bg-icon anim-float-fast" style="top: 10%; right: 8%; color: <?php echo $c1; ?>;">
            <svg viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" /></svg>
          </div>
          <!-- 2. Heart -->
          <div class="floating-bg-icon anim-pulse" style="bottom: 15%; left: 8%; color: <?php echo $c2; ?>;">
            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
          </div>
          <!-- 3. Star -->
          <div class="floating-bg-icon anim-float-fast" style="top: 25%; right: 40%; color: <?php echo $c3; ?>;">
            <svg viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" /></svg>
          </div>
          <!-- 4. Heart -->
          <div class="floating-bg-icon anim-pulse" style="bottom: 10%; right: 10%; color: <?php echo $c1; ?>;">
            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
          </div>
          <!-- 5. Star -->
          <div class="floating-bg-icon anim-float-fast" style="top: 15%; left: 12%; color: <?php echo $c2; ?>;">
            <svg viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" /></svg>
          </div>
          <!-- 6. Heart -->
          <div class="floating-bg-icon anim-pulse" style="top: 45%; left: 25%; color: <?php echo $c3; ?>;">
            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
          </div>
        
          <div class="container" style="position: relative; z-index: 2;">
            <?php if ($index === 0) : ?>
            <div style="margin-bottom: var(--space-xl); text-align: center;">
              <h2 style="font-family: var(--font-heading); font-size: clamp(2rem, 5vw, 3rem); letter-spacing: 0.12em; text-transform: uppercase; color: var(--color-primary); margin: 0;">ARTICLES</h2>
              <div style="width: 60px; height: 3px; background: var(--color-accent-red); margin-top: 0.5rem; border-radius: 2px; margin-left: auto; margin-right: auto;"></div>
            </div>
            <?php endif; ?>
            <div class="journal-grid">
              <?php foreach ($group as $post) : setup_postdata($post); ?>
                <?php $post_url = esc_url(get_permalink($post->ID)); ?>
                <article class="card-glass" onclick="window.location.href='<?php echo esc_js($post_url); ?>'" style="cursor: pointer; border-radius: 0;">
                  <?php $image_id = get_post_thumbnail_id($post->ID); if ($image_id) : ?>
                    <div style="width: 100%; aspect-ratio: 16/9; border-radius: 0; overflow:hidden;">
                        <?php echo wp_get_attachment_image($image_id, 'large', false, array('style' => 'width:100%; height:100%; object-fit:cover;')); ?>
                    </div>
                  <?php else : ?>
                    <div style="width: 100%; aspect-ratio: 16/9; background-color: var(--color-border-light); display: flex; align-items: center; justify-content: center; color: var(--color-text-muted); font-size: 0.8rem; font-weight: 500; text-transform: uppercase; border-radius: 0;">
                      No Image
                    </div>
                  <?php endif; ?>

                  <div style="padding: var(--space-lg);">
                    <span class="text-overline" style="font-size: 0.7rem; color: var(--color-accent-red);">Kings City News</span>
                    <h3 style="font-family: var(--font-heading); margin-top: 0.5rem; margin-bottom: 1rem; line-height: 1.3;"><?php echo esc_html(get_the_title($post->ID)); ?></h3>
                    <p style="color: var(--color-text-muted); font-size: 0.9rem; line-height: 1.6; margin-bottom: 1.5rem;">
                        <?php
                        $excerpt = get_the_excerpt($post->ID);
                        if (empty($excerpt)) { $excerpt = wp_trim_words(get_post_field('post_content', $post->ID), 20); }
                        echo esc_html($excerpt);
                        ?>
                    </p>
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                      <span style="font-size: 0.75rem; color: var(--color-text-muted);"><?php echo esc_html(get_the_date('F j, Y', $post->ID)); ?></span>
                      <a class="btn btn--small" href="<?php echo $post_url; ?>" style="padding: 0.5rem 1rem; font-size: 0.8rem;">Read More</a>
                    </div>
                  </div>
                </article>
              <?php endforeach; wp_reset_postdata(); ?>
            </div>
          </div>
        </section>
        <?php
    endforeach;
else :
    echo '<section class="section content-panel bg-ivory" style="padding: 120px 0;"><div class="container" style="display: flex; align-items: center; justify-content: center; width: 100%;"><p style="font-family: var(--font-heading); font-size: 2.2rem; color: var(--color-text-muted); opacity: 0.7; margin: 0; text-align: center;">No recent news.</p></div></section>';
endif;
?>
</main>


<?php get_footer(); ?>

