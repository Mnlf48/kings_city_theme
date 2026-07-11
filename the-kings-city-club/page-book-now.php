<?php
/* Template Name: Book a Tour */

$booking_submitted = false;
$error_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['book_submit'])) {
    if (!isset($_POST['book_nonce']) || !wp_verify_nonce($_POST['book_nonce'], 'book_submission')) {
        $error_message = "Security check failed. Please try again.";
    } elseif (!empty($_POST['website_url_trap'])) {
        $error_message = "Spam detected. Security check failed.";
    } else {
        // Sanitize and collect data
        $space_type = sanitize_text_field($_POST['book_space_type']);
        $first_name = sanitize_text_field($_POST['book_first_name']);
        $last_name = sanitize_text_field($_POST['book_last_name']);
        $email = sanitize_email($_POST['book_email']);
        $phone = sanitize_text_field($_POST['book_phone']);
        $duration = sanitize_text_field($_POST['book_duration']);
        $price = sanitize_text_field($_POST['book_price']);
        $start_date = sanitize_text_field($_POST['book_start_date']);
        $arrival_time = sanitize_text_field($_POST['book_arrival_time']);
        $participants = sanitize_text_field($_POST['book_participants']);
        $special = sanitize_textarea_field($_POST['book_special']);
        
        // Check Capacity — limits are stored on each kc_space post via kc_space_capacity
        $opt_map = [];
        $spaces_for_map = get_posts(['post_type' => 'kc_space', 'posts_per_page' => -1, 'post_status' => 'publish']);
        foreach ($spaces_for_map as $sp) {
            $sp_bk_key = get_field('kc_space_booking_key', $sp->ID);
            $sp_cap    = (int) get_field('kc_space_capacity', $sp->ID);
            if ($sp_bk_key) {
                $opt_map[$sp_bk_key] = $sp_cap; // 0 = unlimited
            }
        }

        $is_full = false;
        if (isset($opt_map[$space_type]) && $start_date && $opt_map[$space_type] > 0) {
            $limit = $opt_map[$space_type];

            $existing_query = new WP_Query(array(
                'post_type' => 'kc_booking',
                'posts_per_page' => -1,
                'meta_query' => array(
                    'relation' => 'AND',
                    array(
                        'key' => 'kc_start_date',
                        'value' => $start_date
                    ),
                    array(
                        'key' => 'kc_space_type',
                        'value' => $space_type
                    ),
                    array(
                        'key' => 'kc_status',
                        'value' => array('Pending', 'Contacted', 'Completed'),
                        'compare' => 'IN'
                    )
                )
            ));
            
            if ($existing_query->found_posts >= $limit) {
                $is_full = true;
            }
        }

        if ($is_full) {
            $error_message = "Sorry, " . esc_html($space_type) . " is fully booked on " . esc_html($start_date) . ". Please select another date.";
        } else {
            // Create CRM Booking Ticket
            $post_id = wp_insert_post(array(
                'post_type'   => 'kc_booking',
                'post_title'  => $first_name . ' ' . $last_name,
                'post_status' => 'publish',
            ));

            if ($post_id) {
                update_post_meta($post_id, 'kc_first_name', $first_name);
                update_post_meta($post_id, 'kc_last_name', $last_name);
                update_post_meta($post_id, 'kc_email', $email);
                update_post_meta($post_id, 'kc_phone', $phone);
                update_post_meta($post_id, 'kc_space_type', $space_type);
                update_post_meta($post_id, 'kc_duration', $duration);
                update_post_meta($post_id, 'kc_price', $price);
                update_post_meta($post_id, 'kc_start_date', $start_date);
                update_post_meta($post_id, 'kc_arrival_time', $arrival_time);
                update_post_meta($post_id, 'kc_participants', $participants);
                update_post_meta($post_id, 'kc_special', $special);
                update_post_meta($post_id, 'kc_status', 'Pending');
            }
            
            $booking_submitted = true;
        }
    }
}

get_header();
?>

<style>
    /* Legacy section helpers — now superseded by .content-panel alternating rhythm */
    .bg-ivory-section {
      background-color: var(--color-bg-ivory) !important;
    }

    .book-grid {
      display: grid;
      grid-template-columns: 1fr;
      gap: var(--space-xl);
      align-items: start;
    }

    @media (min-width: 1024px) {
      .book-grid {
        grid-template-columns: 1.2fr 0.8fr;
      }
    }

    /* Booking Tabs */
    .book-tabs {
      display: flex;
      gap: var(--space-md);
      overflow-x: auto;
      padding-bottom: var(--space-sm);
      margin-bottom: var(--space-xl);
      border-bottom: 1px solid var(--color-border-light);
      scrollbar-width: none;
    }
    .book-tabs::-webkit-scrollbar { display: none; }

    .book-tab {
      white-space: nowrap;
      padding: 0.75rem 0;
      font-family: var(--font-body);
      font-size: 0.875rem;
      font-weight: 600;
      color: var(--color-text-muted);
      cursor: pointer;
      position: relative;
      transition: color var(--transition-fast);
    }
    .book-tab.is-active {
      color: var(--color-accent-red);
    }
    .book-tab.is-active::after {
      content: '';
      position: absolute;
      bottom: -1px;
      left: 0;
      right: 0;
      height: 2px;
      background: var(--color-accent-red);
    }

    /* Booking Form Card */
    .book-form-card {
      background: var(--color-bg-ivory);
      border-radius: var(--radius-card);
      overflow: hidden;
      box-shadow: var(--glass-shadow-lg);
    }

    .book-form-header {
      background: var(--color-primary);
      padding: 1.5rem 2rem;
      color: white;
    }
    .book-form-header h3 {
      font-family: var(--font-heading);
      font-size: 1.25rem;
      margin-bottom: 0.25rem;
      color: white;
    }
    .book-form-header p {
      font-size: 0.8125rem;
      opacity: 0.8;
      margin-bottom: 0;
    }

    .book-form-body {
      padding: 2rem;
    }

    /* Price Estimator */
    .price-est {
      background: rgba(189, 69, 31, 0.05);
      border-radius: var(--radius-sm);
      padding: 1rem 1.5rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 2rem;
      border: 1px solid rgba(189, 69, 31, 0.1);
    }
    .price-est__label {
      font-size: 0.8125rem;
      font-weight: 600;
      color: var(--color-text-muted);
      text-transform: uppercase;
      letter-spacing: 0.05em;
    }
    .price-est__value {
      font-family: var(--font-heading);
      font-size: 1.5rem;
      font-weight: 700;
      color: var(--color-primary);
    }

    /* Form Elements */
    .form-row {
      align-items: flex-end;
    }
    .form-group {
      margin-bottom: 1.25rem;
    }
    .form-label {
      display: block;
      font-size: 0.75rem;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.05em;
      color: var(--color-text-muted);
      margin-bottom: 0.5rem;
    }
    .form-control {
      width: 100%;
      padding: 0.75rem 1rem;
      border: 1px solid var(--color-border-light);
      border-radius: var(--radius-sm);
      font-family: var(--font-body);
      font-size: 0.9375rem;
      background: white;
      transition: border-color var(--transition-fast);
    }
    .form-control:focus {
      outline: none;
      border-color: var(--color-accent-red);
    }
    select.form-control, input.form-control {
      height: 50px;
    }
    select.form-control {
      -webkit-appearance: none;
      -moz-appearance: none;
      appearance: none;
      background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%232B2B2B' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
      background-repeat: no-repeat;
      background-position: right 1rem center;
      background-size: 16px;
      padding-right: 2.5rem;
    }
    textarea.form-control {
      min-height: 100px;
      resize: vertical;
    }

    .btn-book {
      width: 100%;
      margin-top: 1rem;
      background-color: var(--color-accent-red) !important;
      color: var(--color-bg-ivory) !important;
      border: 1px solid var(--color-accent-red);
      transition: all 0.3s ease-in-out;
    }
    .btn-book:hover {
      background-color: var(--color-btn-hover) !important;
      color: var(--color-bg-ivory) !important;
      border-color: var(--color-btn-hover) !important;
      transform: translateY(-2px);
    }

    /* Booking Content */
    .book-content__media {
      border-radius: var(--radius-card);
      overflow: hidden;
      margin-bottom: 2rem;
    }
    .book-content__media img {
      width: 100%;
      aspect-ratio: 4/3;
      object-fit: cover;
    }

    .book-content__title {
      font-family: var(--font-heading);
      font-size: 2rem;
      margin-bottom: 1rem;
      color: var(--color-primary);
    }
    .book-content__text {
      color: var(--color-text-muted);
      line-height: 1.7;
      margin-bottom: 1.5rem;
    }

    .feature-tag-grid {
      display: flex;
      flex-wrap: wrap;
      gap: 0.5rem;
      margin-top: 1.5rem;
    }
    .feature-tag {
      font-size: 0.75rem;
      font-weight: 600;
      padding: 0.35rem 0.75rem;
      background: rgba(255, 191, 191, 0.15);  /* Soft Blush tint — accent-gold for prestige indicators only */
      color: var(--color-accent-red);
      border-radius: var(--radius-pill);
    }
  </style>

<main id="main-content">
<!-- hero section -->
<section class="hero premium-hero">
<div class="container grid-12">
<div class="col-12 split split--media-right">
<!-- text on left -->
<div class="split__content animate-fadeInUp hero__content--index">
<span class="text-overline hero__overline"><?php echo esc_html(get_field('overline_3')); ?></span>
<h1 class="hero__title hero__title--inner"><?php $h = esc_html(get_field('h1_1')); if ($h) { $w = explode(' ', trim($h)); echo (count($w) === 3) ? $w[0] . '&nbsp;' . $w[1] . ' ' . $w[2] : $h; } ?></h1>
<p class="hero__subtitle"><?php echo esc_html(get_field('p_2')); ?></p>
</div>
<!-- media on right -->
<?php
$bk_video_url = get_field('bk_hero_video_url');
$bk_vimeo_id  = '';
if ( $bk_video_url ) {
    // Extract numeric ID from e.g. https://vimeo.com/123456789 or https://vimeo.com/channels/foo/123456789
    if ( preg_match( '/vimeo\.com\/(?:.*\/)?(\d+)/', $bk_video_url, $bk_vm ) ) {
        $bk_vimeo_id = $bk_vm[1];
    }
}
?>
<?php if ( $bk_vimeo_id ) :
    $bk_thumb = kc_img( 'image_4', 'page-news-img/kings-img98.webp' );
    $bk_title = esc_attr( get_field('h1_1') ?: 'Book a Tour' );
?>
<!-- Video facade: thumbnail + play button → portrait modal on click -->
<div class="split__media kc-vid-thumb"
     id="kc-vid-thumb"
     role="button"
     tabindex="0"
     aria-label="Play video"
     style="position:relative;aspect-ratio:4/3;overflow:hidden;border-radius:var(--radius-card);cursor:pointer;">
    <img src="<?php echo esc_url( $bk_thumb ); ?>"
         alt="<?php echo $bk_title; ?>"
         style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;transition:transform .5s ease;" />
    <div class="kc-vid-overlay" style="position:absolute;inset:0;background:rgba(0,0,0,.3);transition:background .3s;"></div>
    <div style="position:absolute;inset:0;display:flex;align-items:center;justify-content:center;">
        <div class="kc-play-circle" style="width:72px;height:72px;background:rgba(255,249,239,.95);border-radius:50%;display:flex;align-items:center;justify-content:center;box-shadow:0 6px 28px rgba(0,0,0,.28);transition:transform .25s,box-shadow .25s;">
            <svg width="26" height="26" viewBox="0 0 24 24" fill="#BD451F" style="margin-left:4px;">
                <polygon points="5,3 19,12 5,21"/>
            </svg>
        </div>
    </div>
</div>
<style>
    #kc-vid-thumb:hover .kc-vid-overlay { background: rgba(0,0,0,.45) !important; }
    #kc-vid-thumb:hover .kc-play-circle { transform: scale(1.1); box-shadow: 0 10px 36px rgba(0,0,0,.38) !important; }
    #kc-vid-thumb:focus-visible { outline: 3px solid var(--color-primary); outline-offset: 3px; }
</style>

<!-- Portrait video modal: iframe preloaded hidden so video is buffered before user clicks -->
<div id="kc-vid-modal"
     role="dialog"
     aria-modal="true"
     aria-label="Video player"
     style="display:none;position:fixed;inset:0;z-index:9999;background:rgba(0,0,0,.88);align-items:center;justify-content:center;padding:1rem;">
    <button id="kc-vid-close"
            aria-label="Close video"
            style="position:absolute;top:1.25rem;right:1.5rem;background:none;border:none;color:#fff;font-size:2.5rem;line-height:1;cursor:pointer;opacity:.75;transition:opacity .2s;"
            onmouseenter="this.style.opacity=1" onmouseleave="this.style.opacity=.75">&times;</button>
    <div style="position:relative;width:min(92vw,calc(82vh*(9/16)));aspect-ratio:9/16;">
        <!-- iframe rendered at page load so Vimeo buffers immediately; visibility toggled via JS -->
        <iframe id="kc-vid-iframe"
                src="https://player.vimeo.com/video/<?php echo esc_attr( $bk_vimeo_id ); ?>?badge=0&autopause=0&player_id=0&app_id=58479&background=0"
                style="width:100%;height:100%;border:0;border-radius:var(--radius-card);"
                allow="autoplay;fullscreen;picture-in-picture;clipboard-write;encrypted-media"
                allowfullscreen
                title="<?php echo $bk_title; ?>"></iframe>
    </div>
</div>

<!-- Vimeo Player SDK — gives us play()/pause() without recreating the iframe -->
<script src="https://player.vimeo.com/api/player.js"></script>
<script>
(function(){
    var thumb    = document.getElementById('kc-vid-thumb');
    var modal    = document.getElementById('kc-vid-modal');
    var closeBtn = document.getElementById('kc-vid-close');
    var iframe   = document.getElementById('kc-vid-iframe');
    if (!thumb || !modal || !iframe) return;

    var player = new Vimeo.Player(iframe);

    function openModal() {
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
        player.play();
    }
    function closeModal() {
        player.pause();
        modal.style.display = 'none';
        document.body.style.overflow = '';
    }

    thumb.addEventListener('click', openModal);
    thumb.addEventListener('keydown', function(e){ if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); openModal(); } });
    closeBtn.addEventListener('click', closeModal);
    modal.addEventListener('click', function(e){ if (e.target === modal) closeModal(); });
    document.addEventListener('keydown', function(e){ if (e.key === 'Escape' && modal.style.display === 'flex') closeModal(); });
})();
</script>
<?php else : ?>
<div class="split__media hero__slider" id="hero-slider" style="position: relative; aspect-ratio: 4/3; overflow: hidden; border-radius: var(--radius-card);">
<img alt="Kings City Book Now 1" class="hero__slide is-active" src="<?php echo kc_img('image_4', 'page-book-now-img/kings_img09.webp'); ?>" style="position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; opacity: 1; transition: opacity 1s ease-in-out;"/>
<img alt="Kings City Book Now 2" class="hero__slide" src="<?php echo kc_img('image_5', 'page-book-now-img/kings_img010.webp'); ?>" style="position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; opacity: 0; transition: opacity 1s ease-in-out;"/>
<img alt="Kings City Book Now 3" class="hero__slide" src="<?php echo kc_img('image_6', 'page-book-now-img/kings_img011.webp'); ?>" style="position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; opacity: 0; transition: opacity 1s ease-in-out;"/>
</div>
<?php endif; ?>
</div>
</div>
</section>
<!-- booking section -->
<section class="section content-panel" style="margin-top: 0; position: relative; overflow: hidden;">
  <!-- Background Floating Icons -->
  
          <!-- 1. Star -->
          <!-- 2. Heart -->
          <!-- 3. Star -->
          <!-- 4. Heart -->
          <!-- 5. Star -->
          <div class="container" style="position: relative; z-index: 2;">
<div class="book-grid">
<!-- left: content information -->
<div class="book-content" id="booking-info">
<div class="book-content__media">
<img alt="Workspace" id="content-image" src="<?php echo kc_img('image_14', 'page-book-now-img/kings-img12.webp'); ?>"/>
</div>
<span class="text-overline" id="content-overline"></span>
<h2 class="book-content__title" id="content-title"></h2>
<div class="book-content__text" id="content-text"></div>
<div class="feature-tag-grid" id="content-features">
<span class="feature-tag">High-Speed Wi-Fi</span>
<span class="feature-tag">Dedicated Seats</span>
<span class="feature-tag">Kitchen Access</span>
<span class="feature-tag">In-House Cafe</span>
<span class="feature-tag">Community Events</span>
<span class="feature-tag">24/7 Access</span>
</div>
</div>
<!-- right: booking form -->
<div class="book-sidebar">
<div class="book-form-card">
<div class="book-form-header">
<h3 id="form-title"></h3>
<p><?php echo esc_html(get_field('p_12') ?: 'Select your dates and duration below'); ?></p>
</div>
<div class="book-form-body">

<!-- price est -->
<div class="price-est">
<span class="price-est__label"><?php echo esc_html(get_field('bk_label_est_price') ?: 'Estimated Price'); ?></span>
<span class="price-est__value" id="price-display">Php 500</span>
</div>
<?php if (!empty($error_message)): ?>
    <div class="booking-error-alert" style="background: #fee2e2; color: #b91c1c; padding: 1rem; border-radius: var(--radius-md); margin-bottom: 1.5rem;">
        <?php echo esc_html($error_message); ?>
    </div>
<?php endif; ?>
<form method="POST" action="" id="booking-form">
<?php wp_nonce_field('book_submission', 'book_nonce'); ?>
<input type="text" name="website_url_trap" style="display:none !important;" tabindex="-1" autocomplete="off">
<input type="hidden" name="book_price" id="hidden-price" value="">
<!-- space type selection -->
<div class="form-group">
<label class="form-label"><?php echo esc_html(get_field('bk_label_space_type') ?: 'Space Type'); ?></label>
<select class="form-control" name="book_space_type" id="space-type-select">
<?php
$bk_active_spaces = get_posts([
    'post_type'      => 'kc_space',
    'posts_per_page' => -1,
    'post_status'    => 'publish',
    'meta_query'     => [['key' => 'kc_space_is_active', 'value' => '1']],
    'orderby'        => 'menu_order',
    'order'          => 'ASC',
]);
foreach ($bk_active_spaces as $bk_sp) {
    $bk_key   = get_field('kc_space_booking_key', $bk_sp->ID);
    $bk_label = get_field('kc_space_heading', $bk_sp->ID) ?: $bk_sp->post_title;
    if (!$bk_key) continue;
    echo '<option value="' . esc_attr($bk_key) . '">' . esc_html($bk_label) . '</option>' . "\n";
}
?>
</select>
</div>
<div class="form-row">
<div class="form-group">
<label class="form-label"><?php echo esc_html(get_field('bk_label_first_name') ?: 'First Name'); ?></label>
<input class="form-control" name="book_first_name" placeholder="First name" required="" type="text"/>
</div>
<div class="form-group">
<label class="form-label"><?php echo esc_html(get_field('bk_label_last_name') ?: 'Last Name'); ?></label>
<input class="form-control" name="book_last_name" placeholder="Last name" required="" type="text"/>
</div>
</div>
<div class="form-group">
<label class="form-label"><?php echo esc_html(get_field('bk_label_email') ?: 'Email Address'); ?></label>
<input class="form-control" name="book_email" placeholder="you@company.com" required="" type="email"/>
</div>
<div class="form-group">
<label class="form-label"><?php echo esc_html(get_field('bk_label_phone') ?: 'Phone Number'); ?></label>
<input class="form-control" name="book_phone" placeholder="+63 XXX XXX XXXX" required="" type="tel"/>
</div>
<div class="form-row">
<div class="form-group">
<label class="form-label"><?php echo esc_html(get_field('bk_label_participants') ?: 'Number of Participants'); ?></label>
<input class="form-control" name="book_participants" placeholder="e.g. 1" required="" type="number" min="1"/>
</div>
<div class="form-group">
<label class="form-label"><?php echo esc_html(get_field('bk_label_duration') ?: 'Duration'); ?></label>
<select class="form-control" name="book_duration" id="duration-select">
<!-- options dynamic based on selection -->
<option value="Day Pass" data-price="500">Day Pass — Php 500</option>
<option value="Weekly Pass" data-price="2500">Weekly Pass — Php 2,500</option>
<option value="Monthly Pass" data-price="6000">Monthly Pass — Php 6,000</option>
<option value="Annual Pass" data-price="60000">Annual Pass — Php 60,000</option>
</select>
</div>
</div>
<div class="form-row">
<div class="form-group">
<label class="form-label"><?php echo esc_html(get_field('bk_label_start_date') ?: 'Start Date'); ?></label>
<input class="form-control" name="book_start_date" id="date-input" required="" type="date"/>
</div>
<div class="form-group">
<label class="form-label"><?php echo esc_html(get_field('bk_label_arrival_time') ?: 'Arrival Time'); ?></label>
<select class="form-control" name="book_arrival_time" required>
<option value="08:00 AM">08:00 AM</option>
<option value="09:00 AM">09:00 AM</option>
<option value="10:00 AM">10:00 AM</option>
<option value="11:00 AM">11:00 AM</option>
<option value="12:00 PM">12:00 PM</option>
<option value="01:00 PM">01:00 PM</option>
<option value="02:00 PM">02:00 PM</option>
<option value="03:00 PM">03:00 PM</option>
<option value="04:00 PM">04:00 PM</option>
<option value="05:00 PM">05:00 PM</option>
</select>
</div>
</div>
<div class="form-group">
<label class="form-label"><?php echo esc_html(get_field('bk_label_special') ?: 'Special Requests'); ?></label>
<textarea class="form-control" name="book_special" placeholder="Any special requirements..."></textarea>
</div>
<button class="btn btn-book" name="book_submit" type="submit"><?php echo esc_html(get_field('bk_btn_submit') ?: 'Confirm Booking'); ?></button>
</form>

</div>
</div>
</div>
</div>
</div>


          <!-- 1. Star -->
          <div class="floating-bg-icon anim-float-fast" style="top: 10%; right: 8%; color: var(--color-primary);"><svg viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" /></svg></div>
          <!-- 2. Heart -->
          <div class="floating-bg-icon anim-pulse" style="bottom: 15%; left: 8%; color: var(--color-accent-red);"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg></div>
          <!-- 3. Star -->
          <div class="floating-bg-icon anim-float-fast" style="top: 25%; right: 40%; color: var(--color-secondary);"><svg viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" /></svg></div>
          <!-- 4. Heart -->
          <div class="floating-bg-icon anim-pulse" style="bottom: 10%; right: 10%; color: var(--color-primary);"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg></div>
          <!-- 5. Star -->
          <div class="floating-bg-icon anim-float-fast" style="top: 15%; left: 12%; color: var(--color-accent-red);"><svg viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" /></svg></div>
          <!-- 6. Heart -->
          <div class="floating-bg-icon anim-pulse" style="top: 45%; left: 25%; color: var(--color-secondary);"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg></div>

</section>
</main>
<!-- Flatpickr — custom date picker with per-date enable/disable support -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<style>
.flatpickr-calendar { border-radius: 0 !important; font-family: inherit; box-shadow: 0 8px 30px rgba(0,0,0,0.15); }
.flatpickr-months .flatpickr-month, .flatpickr-weekdays, span.flatpickr-weekday { background: #BD451F; color: #fff; fill: #fff; }
.flatpickr-current-month .flatpickr-monthDropdown-months,
.flatpickr-current-month input.cur-year { color: #fff; }
.flatpickr-prev-month svg, .flatpickr-next-month svg { fill: #fff; }
.flatpickr-prev-month:hover svg, .flatpickr-next-month:hover svg { fill: #FBCB77; }
.flatpickr-day.selected, .flatpickr-day.selected:hover { background: #AC201A; border-color: #AC201A; color: #fff; }
.flatpickr-day:hover:not(.flatpickr-disabled):not(.selected) { background: rgba(189,69,31,0.12); border-color: transparent; }
.flatpickr-day.flatpickr-disabled { color: #ccc !important; background: #f9f9f9 !important; text-decoration: line-through; cursor: not-allowed; }
</style>
<script>
    // Tab Data Mapping — built dynamically from kc_space CPT
    const kcAjax = {
        url:   '<?php echo esc_js(admin_url('admin-ajax.php')); ?>',
        nonce: '<?php echo esc_js(wp_create_nonce('kc_booked_dates_nonce')); ?>',
    };

    const bookingData = <?php
    $bk_data_spaces = get_posts([
        'post_type'      => 'kc_space',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'meta_query'     => [['key' => 'kc_space_is_active', 'value' => '1']],
        'orderby'        => 'menu_order',
        'order'          => 'ASC',
    ]);
    $bk_js_map = [];
    foreach ($bk_data_spaces as $bk_sp) {
        $bk_key        = get_field('kc_space_booking_key', $bk_sp->ID);
        if (!$bk_key) continue;
        $bk_heading    = get_field('kc_space_heading', $bk_sp->ID) ?: $bk_sp->post_title;
        $bk_overline   = get_field('kc_space_form_overline', $bk_sp->ID) ?: $bk_key;
        $bk_desc1      = get_field('kc_space_description_1', $bk_sp->ID) ?: '';
        $bk_desc2      = get_field('kc_space_description_2', $bk_sp->ID) ?: '';
        $bk_form_title = get_field('kc_space_form_title', $bk_sp->ID) ?: 'Book ' . $bk_heading;
        $bk_img_key    = get_field('kc_space_book_image_key', $bk_sp->ID);
        if ($bk_img_key) {
            $bk_img = get_field($bk_img_key, $bk_sp->ID) ?: get_field('kc_space_img_1', $bk_sp->ID);
        } else {
            $bk_img = get_field('kc_space_img_1', $bk_sp->ID);
        }
        $bk_img = $bk_img ?: '';
        // Features: one per line
        $bk_features_raw = get_field('kc_space_features', $bk_sp->ID) ?: '';
        $bk_features = $bk_features_raw
            ? array_values(array_filter(array_map('trim', explode("\n", $bk_features_raw))))
            : [];
        // Pricing options: Label|Value|Price per line
        $bk_opts_raw = get_field('kc_space_pricing_options', $bk_sp->ID) ?: '';
        $bk_options  = [];
        if ($bk_opts_raw) {
            foreach (array_filter(array_map('trim', explode("\n", $bk_opts_raw))) as $opt_line) {
                $opt_parts = explode('|', $opt_line, 3);
                if (count($opt_parts) === 3) {
                    $bk_options[] = [
                        'label' => trim($opt_parts[0]),
                        'value' => trim($opt_parts[1]),
                        'price' => (int) trim($opt_parts[2]),
                    ];
                }
            }
        }
        // Build text HTML from description paragraphs
        $bk_text_html = '';
        if ($bk_desc1) $bk_text_html .= '<p>' . esc_html($bk_desc1) . '</p>';
        if ($bk_desc2) $bk_text_html .= '<p>' . esc_html($bk_desc2) . '</p>';
        $bk_js_map[$bk_key] = [
            'image'     => $bk_img,
            'overline'  => $bk_overline,
            'title'     => $bk_heading,
            'text'      => $bk_text_html,
            'features'  => $bk_features,
            'formTitle' => $bk_form_title,
            'options'   => $bk_options,
        ];
    }
    echo wp_json_encode($bk_js_map, JSON_HEX_TAG | JSON_HEX_AMP);
    ?>;

    const spaceTypeSelect = document.getElementById('space-type-select');
    const durationSelect  = document.getElementById('duration-select');
    const priceDisplay    = document.getElementById('price-display');
    const contentImage    = document.getElementById('content-image');
    const hiddenPrice     = document.getElementById('hidden-price');
    const dateInput       = document.getElementById('date-input');

    // Track fetched constraints per space key so we don't re-fetch on the same page load
    const disabledDatesCache = {};

    // Always destroy + recreate Flatpickr so internal state is fully reset each time
    let fpInstance = null;

    const fpBase = {
        dateFormat:    'Y-m-d',
        minDate:       'today',
        disableMobile: true,
    };

    function reinitFlatpickr(extraConfig) {
        if (!dateInput) return;
        if (fpInstance) {
            fpInstance.destroy();
            fpInstance = null;
        }
        fpInstance = flatpickr(dateInput, Object.assign({}, fpBase, extraConfig || {}));
    }

    function initFlatpickr() {
        reinitFlatpickr({});
    }

    function applyDateConstraints(data) {
        if (!dateInput) return;

        if (data.mode === 'whitelist') {
            const allowed = data.allowed || [];
            if (allowed.length === 0) {
                // Availability enabled but no windows set — block everything
                reinitFlatpickr({ disable: [() => true] });
            } else {
                // Only the exact allowed dates are selectable
                reinitFlatpickr({ enable: allowed });
            }
        } else {
            // Blacklist mode — all dates open except capacity-full ones
            const disabled = data.disabled || [];
            reinitFlatpickr(disabled.length ? { disable: disabled } : {});
        }
    }

    function fetchBookedDates(spaceKey) {
        if (!dateInput) return;

        // Block everything while AJAX is in flight so there's no stale state
        reinitFlatpickr({ disable: [() => true] });

        // Serve from cache if already fetched for this key this page load
        if (disabledDatesCache[spaceKey] !== undefined) {
            applyDateConstraints(disabledDatesCache[spaceKey]);
            return;
        }

        const fd = new FormData();
        fd.append('action',    'kc_get_booked_dates');
        fd.append('nonce',     kcAjax.nonce);
        fd.append('space_key', spaceKey);

        fetch(kcAjax.url, { method: 'POST', body: fd })
            .then(r => r.json())
            .then(res => {
                const result = res.success ? res.data : { mode: 'blacklist', disabled: [] };
                disabledDatesCache[spaceKey] = result;
                applyDateConstraints(result);
            })
            .catch(() => applyDateConstraints({ mode: 'blacklist', disabled: [] }));
    }

    if (spaceTypeSelect) {
      spaceTypeSelect.addEventListener('change', () => {
        const key = spaceTypeSelect.value;
        const data = bookingData[key] || bookingData[Object.keys(bookingData)[0]];

        // Update content panel
        if (contentImage && data.image) contentImage.src = data.image;
        if (document.getElementById('content-overline')) document.getElementById('content-overline').innerText = data.overline;
        if (document.getElementById('content-title'))   document.getElementById('content-title').innerText   = data.title;
        if (document.getElementById('content-text'))    document.getElementById('content-text').innerHTML    = data.text;
        if (document.getElementById('form-title'))      document.getElementById('form-title').innerText      = data.formTitle;

        // Update features
        const featureContainer = document.getElementById('content-features');
        if (featureContainer) featureContainer.innerHTML = data.features.map(f => `<span class="feature-tag">${f}</span>`).join('');

        // Update duration options
        if (durationSelect) {
            durationSelect.innerHTML = data.options.map(o => `<option value="${o.value}" data-price="${o.price}">${o.label}</option>`).join('');
            updatePrice();
        }

        // Fetch and apply disabled dates for this space
        fetchBookedDates(key);
      });
    }

    if (durationSelect) {
        durationSelect.addEventListener('change', updatePrice);
    }

    function updatePrice() {
      if (!durationSelect || durationSelect.selectedIndex === -1) return;
      const selectedOption = durationSelect.options[durationSelect.selectedIndex];
      const priceVal = selectedOption.getAttribute('data-price') || '0';
      const val = parseInt(priceVal).toLocaleString();
      if (priceDisplay) priceDisplay.innerText = `Php ${val}`;
      if (hiddenPrice) hiddenPrice.value = priceVal;
    }

    // Initialize Flatpickr on the date input, then fire first space load
    initFlatpickr();

    // Initialize from first active space — fires the same handler as user-driven changes
    if (spaceTypeSelect) {
        spaceTypeSelect.dispatchEvent(new Event('change'));
    } else {
        updatePrice();
    }

    // hero slider logic
    (function() {
      const slider = document.getElementById('hero-slider');
      if (!slider) return;
      const slides = slider.querySelectorAll('.hero__slide');
      if (slides.length < 2) return;
      let current = 0;
      setInterval(() => {
        slides[current].style.opacity = '0';
        slides[current].classList.remove('is-active');
        current = (current + 1) % slides.length;
        slides[current].style.opacity = '1';
        slides[current].classList.add('is-active');
      }, 4000);
    })();
  </script>

<!-- Booking Success Modal -->
<div class="tb-modal" id="booking-success-modal" aria-hidden="true">
  <div class="tb-modal-content" style="max-width: 450px; text-align: center;">
    <div class="tb-modal-header" style="justify-content: flex-end; padding-bottom: 0;">
      <button type="button" class="tb-modal-close" id="booking-modal-close" aria-label="Close">&times;</button>
    </div>
    <div class="tb-modal-body" style="padding: 10px 30px 40px 30px;">
        <svg width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom: 1.5rem; display: inline-block;"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
        <h2 style="color: var(--color-primary); margin-bottom: 1rem; font-size: 24px;">Booking Requested Successfully!</h2>
        <p style="color: var(--color-text-muted); font-size: 1rem; line-height: 1.6; margin-bottom: 2rem;">Your booking has been received! We will be in touch to confirm payment details shortly.</p>
        <button type="button" id="booking-modal-finish" style="background-color: var(--color-accent-red); color: white; border: none; padding: 12px 30px; font-weight: bold; font-family: var(--font-heading); border-radius: var(--radius-sm); cursor: pointer; text-transform: uppercase;">Finish</button>
    </div>
  </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const modal = document.getElementById('booking-success-modal');
        const btnCloseModal = document.getElementById('booking-modal-close');
        const btnFinish = document.getElementById('booking-modal-finish');
        const form = document.getElementById('booking-form');

        function openModal() {
            modal.setAttribute('aria-hidden', 'false');
            document.body.classList.add('modal-open');
        }

        function closeModal() {
            modal.setAttribute('aria-hidden', 'true');
            document.body.classList.remove('modal-open');
            
            if (modal.dataset.success === 'true') {
                if (form) form.reset();
                const resetSpaceSelect = document.getElementById('space-type-select');
                if (resetSpaceSelect) {
                    resetSpaceSelect.selectedIndex = 0; // Explicitly force first option
                    resetSpaceSelect.dispatchEvent(new Event('change'));
                }
                
                // Scroll back to the top of the section to emulate a fresh page
                const contentTitle = document.getElementById('content-title');
                if (contentTitle) {
                    contentTitle.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
                
                modal.dataset.success = 'false';
            }
        }

        if (btnCloseModal) btnCloseModal.addEventListener('click', closeModal);
        if (btnFinish) btnFinish.addEventListener('click', closeModal);
        modal.addEventListener('click', e => { if (e.target === modal) closeModal(); });

        if (form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault(); // Prevent page reload!
                
                const submitBtn = form.querySelector('button[type="submit"]');
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = 'Processing...';
                submitBtn.disabled = true;

                const formData = new FormData(form);
                formData.append('book_submit', '1');

                fetch(window.location.href, {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const errorDiv = doc.querySelector('.booking-error-alert');
                    
                    if (errorDiv) {
                        alert(errorDiv.innerText.trim());
                    } else {
                        // Success!
                        modal.dataset.success = 'true';
                        openModal();
                    }
                })
                .catch(err => {
                    alert('There was a network error. Please try again.');
                })
                .finally(() => {
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                });
            });
        }
    });
</script>

<?php get_footer(); ?>
