<?php
/**
 * The main template file
 *
 * @package KingsCity
 */

get_header();
?>

<main id="primary" class="site-main">
    <section class="section content-panel" style="background-color: var(--color-bg-ivory);">
        <div class="container grid-12">
            <div class="col-12 text-center" style="padding: var(--space-xl) 0;">
                <?php
                if ( have_posts() ) :

                    if ( is_home() && ! is_front_page() ) :
                        ?>
                        <header>
                            <h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
                        </header>
                        <?php
                    endif;

                    /* Start the Loop */
                    while ( have_posts() ) :
                        the_post();
                        ?>
                        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                            <header class="entry-header">
                                <?php
                                if ( is_singular() ) :
                                    the_title( '<h1 class="entry-title" style="font-family: var(--font-heading); color: var(--color-primary); font-size: clamp(2.5rem, 4vw, 3.5rem);">', '</h1>' );
                                else :
                                    the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
                                endif;
                                ?>
                            </header><!-- .entry-header -->

                            <div class="entry-content" style="color: var(--color-text-muted); font-size: 1.125rem; line-height: 1.8; max-width: 800px; margin: 0 auto; text-align: left;">
                                <?php
                                the_content();

                                wp_link_pages(
                                    array(
                                        'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'kingscity' ),
                                        'after'  => '</div>',
                                    )
                                );
                                ?>
                            </div><!-- .entry-content -->
                        </article><!-- #post-<?php the_ID(); ?> -->
                        <?php
                    endwhile;

                    the_posts_navigation();

                else :
                    ?>
                    <h1 style="font-family: var(--font-heading); color: var(--color-primary);">Nothing Found</h1>
                    <p>It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.</p>
                    <?php
                    get_search_form();

                endif;
                ?>
            </div>
        </div>
    </section>
</main><!-- #main -->

<?php
get_footer();
