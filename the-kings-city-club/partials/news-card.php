<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * News card partial.
 * Requires WordPress loop global (the_post() / setup_postdata() must have been called).
 */
$_post_url     = esc_url( get_permalink() );
$_post_url_js  = esc_js( $_post_url );
$_image_id     = get_post_thumbnail_id();
$_excerpt   = get_the_excerpt();
if ( empty( $_excerpt ) ) {
	$_excerpt = wp_trim_words( get_post_field( 'post_content', get_the_ID() ), 20 );
}
?>
<article class="card-glass kc-news-card" style="cursor: pointer; border-radius: 0; display: flex; flex-direction: column;">
	<?php if ( $_image_id ) : ?>
		<a href="<?php echo $_post_url; ?>" class="kc-news-card__img-link" style="display: block; width: 100%; aspect-ratio: 16/9; border-radius: 0; overflow: hidden;">
			<?php echo wp_get_attachment_image( $_image_id, 'large', false, array( 'style' => 'width:100%; height:100%; object-fit:cover;' ) ); ?>
		</a>
	<?php else : ?>
		<div style="width: 100%; aspect-ratio: 16/9; background-color: var(--color-border-light); display: flex; align-items: center; justify-content: center; color: var(--color-text-muted); font-size: 0.8rem; font-weight: 500; text-transform: uppercase; border-radius: 0;">
			No Image
		</div>
	<?php endif; ?>
	<a href="<?php echo $_post_url; ?>" class="kc-news-card__body-link" style="display: flex; flex-direction: column; flex: 1; text-decoration: none; color: inherit; padding: var(--space-lg);">
		<span class="text-overline" style="font-size: 0.7rem; color: var(--color-accent-red);">Kings City News</span>
		<h3 style="font-family: var(--font-heading); margin-top: 0.5rem; margin-bottom: 1rem; line-height: 1.3;"><?php echo esc_html( get_the_title() ); ?></h3>
		<p style="color: var(--color-text-muted); font-size: 0.9rem; line-height: 1.6; margin-bottom: 1.5rem; flex: 1;"><?php echo esc_html( $_excerpt ); ?></p>
		<div style="display: flex; justify-content: space-between; align-items: center; margin-top: auto;">
			<span style="font-size: 0.75rem; color: var(--color-text-muted);"><?php echo esc_html( get_the_date( 'F j, Y' ) ); ?></span>
			<span class="btn btn--small" style="padding: 0.5rem 1rem; font-size: 0.8rem;">Read More</span>
		</div>
	</a>
</article>
