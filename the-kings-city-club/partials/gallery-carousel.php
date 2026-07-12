<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * Gallery carousel partial — 10 cards (5 original + 5 duplicated for infinite loop).
 * Relies on gallery-carousel.js for auto-scroll behaviour.
 */
?>
<button aria-label="Previous image" class="gallery-nav gallery-nav--prev" onclick="scrollGallery(-1)">
	<svg fill="none" height="20" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" width="20"><polyline points="15 18 9 12 15 6"></polyline></svg>
</button>
<div class="gallery-carousel" id="gallery-carousel">
	<!-- original set -->
	<div class="gallery-card"><img alt="Kings Club Makati"      src="<?php echo kc_img('section_img_46', 'front-page-img/kings-img53.webp'); ?>" style="width:100%; height:100%; object-fit:cover;" loading="lazy"/></div>
	<div class="gallery-card"><img alt="Kings Club BGC"         src="<?php echo kc_img('section_img_47', 'front-page-img/kings-img16.webp'); ?>" style="width:100%; height:100%; object-fit:cover;" loading="lazy"/></div>
	<div class="gallery-card"><img alt="Kings Club Ortigas"     src="<?php echo kc_img('section_img_48', 'front-page-img/kings-img17.webp'); ?>" style="width:100%; height:100%; object-fit:cover;" loading="lazy"/></div>
	<div class="gallery-card"><img alt="Kings Club Alabang"     src="<?php echo kc_img('section_img_49', 'front-page-img/kings_img06.webp'); ?>" style="width:100%; height:100%; object-fit:cover;" loading="lazy"/></div>
	<div class="gallery-card"><img alt="Kings Club Quezon City" src="<?php echo kc_img('section_img_50', 'front-page-img/kings-img40.webp'); ?>" style="width:100%; height:100%; object-fit:cover;" loading="lazy"/></div>
	<!-- duplicated set for infinite loop -->
	<div class="gallery-card"><img alt="Kings Club Makati"      src="<?php echo kc_img('section_img_52', 'front-page-img/kings-img37.webp'); ?>" style="width:100%; height:100%; object-fit:cover;" loading="lazy"/></div>
	<div class="gallery-card"><img alt="Kings Club BGC"         src="<?php echo kc_img('section_img_53', 'front-page-img/kings-img20.webp'); ?>" style="width:100%; height:100%; object-fit:cover;" loading="lazy"/></div>
	<div class="gallery-card"><img alt="Kings Club Ortigas"     src="<?php echo kc_img('section_img_54', 'front-page-img/kings_img06.webp'); ?>" style="width:100%; height:100%; object-fit:cover;" loading="lazy"/></div>
	<div class="gallery-card"><img alt="Kings Club Alabang"     src="<?php echo kc_img('section_img_55', 'front-page-img/kings-img53.webp'); ?>" style="width:100%; height:100%; object-fit:cover;" loading="lazy"/></div>
	<div class="gallery-card"><img alt="Kings Club Quezon City" src="<?php echo kc_img('section_img_56', 'front-page-img/kings-img47.webp'); ?>" style="width:100%; height:100%; object-fit:cover;" loading="lazy"/></div>
</div>
<button aria-label="Next image" class="gallery-nav gallery-nav--next" onclick="scrollGallery(1)">
	<svg fill="none" height="20" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" width="20"><polyline points="9 18 15 12 9 6"></polyline></svg>
</button>
