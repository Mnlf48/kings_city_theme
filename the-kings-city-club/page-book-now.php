<?php
if (!defined('ABSPATH')) exit;
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
        $birthdate = sanitize_text_field($_POST['book_birthdate'] ?? '');
        $promo_code = sanitize_text_field(trim($_POST['kc_promo_code'] ?? ''));
        
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
            
            $base_price = (float) $price;
            $discount_amount = 0;
            
            // Validate Promo Code server-side
            if (!empty($promo_code)) {
                $promo_query = get_posts([
                    'post_type'      => 'kc_promo',
                    'title'          => $promo_code,
                    'posts_per_page' => 1,
                    'post_status'    => 'any',
                ]);
                
                if (!empty($promo_query)) {
                    $promo_id = $promo_query[0]->ID;
                    $expires = get_post_meta($promo_id, 'kc_expires_at', true);
                    $max_uses = get_post_meta($promo_id, 'kc_max_uses', true);
                    $current_uses = (int) (get_post_meta($promo_id, 'kc_current_uses', true) ?: 0);
                    
                    $valid = true;
                    if (!empty($expires) && strtotime($expires) < current_time('timestamp')) $valid = false;
                    if (!empty($max_uses) && $current_uses >= (int)$max_uses) $valid = false;
                    
                    if ($valid) {
                        $type = get_post_meta($promo_id, 'kc_discount_type', true);
                        $value = (float) get_post_meta($promo_id, 'kc_discount_value', true);
                        
                        if ($type === 'percentage') {
                            $discount_amount = $base_price * ($value / 100);
                        } else {
                            $discount_amount = $value;
                        }
                        
                        if ($discount_amount > $base_price) $discount_amount = $base_price;
                        
                        // Increment current uses
                        update_post_meta($promo_id, 'kc_current_uses', $current_uses + 1);
                        
                        // Update the final price!
                        $price = $base_price - $discount_amount;
                    } else {
                        $promo_code = ''; // Invalidated
                    }
                } else {
                    $promo_code = ''; // Not found
                }
            }

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
                
                if (isset($base_price)) update_post_meta($post_id, 'kc_base_price', $base_price);
                if (!empty($promo_code)) {
                    update_post_meta($post_id, 'kc_promo_code', $promo_code);
                    update_post_meta($post_id, 'kc_discount_amount', $discount_amount);
                }
                
                if ($birthdate) {
                    update_post_meta($post_id, 'kc_birthdate', $birthdate);
                }
            }
            
            // Add or update mailing list
            global $wpdb;
            $table = $wpdb->prefix . 'kc_mailing_list';
            $exists = $wpdb->get_var($wpdb->prepare("SELECT id FROM {$table} WHERE email = %s", $email));
            
            $bd_val = $birthdate ? $birthdate : null;
            if ($exists) {
                // Update existing subscriber's birthdate if not set, or override
                $wpdb->update(
                    $table,
                    array('birthdate' => $bd_val),
                    array('email' => $email),
                    array('%s'),
                    array('%s')
                );
            } else {
                // Insert new subscriber
                $wpdb->insert(
                    $table,
                    array(
                        'email' => $email,
                        'birthdate' => $bd_val,
                        'status' => 'pending',
                        'subscribed_at' => current_time('mysql')
                    ),
                    array('%s', '%s', '%s', '%s')
                );
            }
            
            $booking_submitted = true;
        }
    }
}

get_header();
?>


<main id="main-content">
<!-- hero section -->
<section class="hero premium-hero">
<div class="container grid-12">
<div class="col-12 split split--media-right">
<!-- text on left -->
<div class="split__content animate-fadeInUp hero__content--index">
<span class="text-overline hero__overline"><?php echo esc_html(get_field('overline_3')); ?></span>
<h1 class="hero__title hero__title--inner"><?php kc_split_heading(get_field('h1_1')); ?></h1>
<p class="hero__subtitle"><?php echo esc_html(get_field('p_2')); ?></p>
</div>
<!-- media on right -->
<?php
$bk_video_url = get_field('bk_hero_video_url');
$bk_vimeo_id  = '';
if ( $bk_video_url ) {
    // Strip query string and hash before matching — handles share URLs like
    // https://vimeo.com/1209125598?share=copy&fi=sv#t=32
    $bk_clean_url = preg_replace('/[?#].*$/', '', $bk_video_url);
    if ( preg_match( '/vimeo\.com\/(?:.*\/)?(\d+)/', $bk_clean_url, $bk_vm ) ) {
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

<!-- Portrait video modal: iframe preloaded hidden so video is buffered before user clicks -->
<div id="kc-vid-modal"
     role="dialog"
     aria-modal="true"
     aria-label="Video player"
     style="display:none;position:fixed;inset:0;z-index:9999;background:rgba(0,0,0,.88);align-items:center;justify-content:center;padding:1rem;">
    <div style="display:flex;flex-direction:column;width:min(92vw,calc(82vh*(9/16)));gap:0.5rem;">
        <div style="display:flex;justify-content:flex-end;">
            <button id="kc-vid-close"
                    aria-label="Close video"
                    style="background:none;border:none;color:#fff;font-size:2.5rem;line-height:1;cursor:pointer;opacity:.75;transition:opacity .2s;padding:0;"
                    onmouseenter="this.style.opacity=1" onmouseleave="this.style.opacity=.75">&times;</button>
        </div>
        <div style="position:relative;aspect-ratio:9/16;">
            <!-- iframe rendered at page load so Vimeo buffers immediately; visibility toggled via JS -->
            <iframe id="kc-vid-iframe"
                    src="https://player.vimeo.com/video/<?php echo esc_attr( $bk_vimeo_id ); ?>?badge=0&autopause=0&player_id=0&app_id=58479&background=0&api=1"
                    style="width:100%;height:100%;border:0;border-radius:var(--radius-card);"
                    allow="autoplay;fullscreen;picture-in-picture;clipboard-write;encrypted-media"
                    allowfullscreen
                    title="<?php echo $bk_title; ?>"></iframe>
        </div>
    </div>
</div>

<script>
(function(){
    var thumb    = document.getElementById('kc-vid-thumb');
    var modal    = document.getElementById('kc-vid-modal');
    var closeBtn = document.getElementById('kc-vid-close');
    var iframe   = document.getElementById('kc-vid-iframe');
    if (!thumb || !modal || !iframe) return;

    // Send a postMessage command to the Vimeo player iframe
    function vimeoCmd(method, value) {
        var msg = JSON.stringify({ method: method, value: value });
        iframe.contentWindow.postMessage(msg, 'https://player.vimeo.com');
    }

    function openModal() {
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
        // Small delay ensures iframe is visible before issuing play command
        setTimeout(function() { vimeoCmd('play'); }, 150);
    }
    function closeModal() {
        vimeoCmd('pause');
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
$bk_preselect = isset($_GET['space']) ? sanitize_text_field($_GET['space']) : '';
foreach ($bk_active_spaces as $bk_sp) {
    $bk_key   = get_field('kc_space_booking_key', $bk_sp->ID);
    $bk_label = get_field('kc_space_heading', $bk_sp->ID) ?: $bk_sp->post_title;
    if (!$bk_key) continue;
    $bk_selected = ($bk_preselect && strtolower($bk_preselect) === strtolower($bk_key)) ? ' selected' : '';
    echo '<option value="' . esc_attr($bk_key) . '"' . $bk_selected . '>' . esc_html($bk_label) . '</option>' . "\n";
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
<div class="form-row">
<div class="form-group">
<label class="form-label"><?php echo esc_html(get_field('bk_label_phone') ?: 'Phone Number'); ?></label>
<input class="form-control" name="book_phone" placeholder="+63 XXX XXX XXXX" required="" type="tel"/>
</div>
<div class="form-group">
<label class="form-label"><?php echo esc_html(get_field('bk_label_birthdate') ?: 'Date of Birth'); ?> <span style="font-size:12px;color:var(--color-text-muted);">(<?php echo esc_html(get_field('bk_label_birthdate_hint') ?: 'For special promos'); ?>)</span></label>
<input class="form-control" name="book_birthdate" type="date" required=""/>
</div>
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
<label class="form-label"><?php echo esc_html(get_field('bk_label_promo') ?: 'Promo Code'); ?> <span style="font-size:12px;color:var(--color-text-muted);">(<?php echo esc_html(get_field('bk_label_promo_hint') ?: 'Optional'); ?>)</span></label>
<input class="form-control" name="kc_promo_code_input" id="kc_promo_code_input" placeholder="e.g. SUMMER10" type="text" style="text-transform: uppercase;" autocomplete="off"/>
<div id="kc_promo_msg" style="font-size: 13px; margin-top: 5px; font-weight: 500;"></div>
<input type="hidden" name="kc_promo_code" id="kc_promo_code_hidden" value="" />
</div>
<div class="form-group">
<label class="form-label"><?php echo esc_html(get_field('bk_label_special') ?: 'Special Requests'); ?></label>
<textarea class="form-control" name="book_special" placeholder="Any special requirements..."></textarea>
</div>
<button class="btn btn-book" name="book_submit" type="submit"><?php echo esc_html(get_field('bk_btn_submit') ?: 'Confirm Booking'); ?></button>
<p style="margin-top: 0.75rem; font-size: 0.8rem; color: var(--color-text-muted); text-align: center; line-height: 1.5;">
    <?php echo esc_html(get_field('bk_note_no_refund') ?: 'Please note: Payments are non-refundable. Transfer of payment to another date or space type is allowed subject to availability.'); ?>
</p>
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


<?php get_footer(); ?>
