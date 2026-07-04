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
        
        // Check Capacity
        $opt_map = array(
            'Co-Working' => 'kc_capacity_co_working',
            'Meeting Rooms' => 'kc_capacity_meeting_rooms',
            'Events Place' => 'kc_capacity_events_place',
            'Office Leasing' => 'kc_capacity_office_leasing',
            'Virtual Office' => 'kc_capacity_virtual_office',
            'Bakehouse' => 'kc_capacity_bakehouse',
            'Manille Ceramic (Limited)' => 'kc_capacity_manille_ceramic',
        );
        $opt_key = isset($opt_map[$space_type]) ? $opt_map[$space_type] : '';
        
        $is_full = false;
        if ($opt_key && $start_date) {
            $limit = get_option($opt_key, 50); // Fallback to 50
            
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
<span class="text-overline hero__overline"><?php echo get_field('overline_3'); ?></span>
<h1 class="hero__title hero__title--inner"><?php $h = get_field('h1_1'); if ($h) { $w = explode(' ', trim($h)); echo (count($w) === 3) ? $w[0] . '&nbsp;' . $w[1] . ' ' . $w[2] : $h; } ?></h1>
<p class="hero__subtitle"><?php echo get_field('p_2'); ?></p>
</div>
<!-- media on right -->
<div class="split__media hero__slider" id="hero-slider" style="position: relative; aspect-ratio: 4/3; overflow: hidden; border-radius: var(--radius-card);">
<img alt="Kings City Book Now 1" class="hero__slide is-active" src="<?php echo kc_img('image_4', 'page-book-now-img/kings_img09.webp'); ?>" style="position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; opacity: 1; transition: opacity 1s ease-in-out;"/>
<img alt="Kings City Book Now 2" class="hero__slide" src="<?php echo kc_img('image_5', 'page-book-now-img/kings_img010.webp'); ?>" style="position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; opacity: 0; transition: opacity 1s ease-in-out;"/>
<img alt="Kings City Book Now 3" class="hero__slide" src="<?php echo kc_img('image_6', 'page-book-now-img/kings_img011.webp'); ?>" style="position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; opacity: 0; transition: opacity 1s ease-in-out;"/>
</div>
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
<span class="text-overline" id="content-overline"><?php echo get_field('overline_13'); ?></span>
<h2 class="book-content__title" id="content-title"><?php echo get_field('h2_8'); ?></h2>
<div class="book-content__text" id="content-text">
<p><?php echo get_field('p_10'); ?></p>
<p><?php echo get_field('p_11'); ?></p>
</div>
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
<h3 id="form-title"><?php echo get_field('h3_9'); ?></h3>
<p><?php echo get_field('p_12'); ?></p>
</div>
<div class="book-form-body">

<!-- price est -->
<div class="price-est">
<span class="price-est__label"><?php echo get_field('bk_label_est_price') ?: 'Estimated Price'; ?></span>
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
<label class="form-label"><?php echo get_field('bk_label_space_type') ?: 'Space Type'; ?></label>
<select class="form-control" name="book_space_type" id="space-type-select">
<option value="Co-Working">Co-Working</option>
<option value="Meeting Rooms">Meeting Rooms</option>
<option value="Events Place">Events Place</option>
<option value="Office Leasing">Office Leasing</option>
<option value="Virtual Office">Virtual Office</option>
<option value="Bakehouse">Bakehouse</option>
<option value="Manille Ceramic (Limited)">Manille Ceramic (Limited)</option>
</select>
</div>
<div class="form-row">
<div class="form-group">
<label class="form-label"><?php echo get_field('bk_label_first_name') ?: 'First Name'; ?></label>
<input class="form-control" name="book_first_name" placeholder="First name" required="" type="text"/>
</div>
<div class="form-group">
<label class="form-label"><?php echo get_field('bk_label_last_name') ?: 'Last Name'; ?></label>
<input class="form-control" name="book_last_name" placeholder="Last name" required="" type="text"/>
</div>
</div>
<div class="form-group">
<label class="form-label"><?php echo get_field('bk_label_email') ?: 'Email Address'; ?></label>
<input class="form-control" name="book_email" placeholder="you@company.com" required="" type="email"/>
</div>
<div class="form-group">
<label class="form-label"><?php echo get_field('bk_label_phone') ?: 'Phone Number'; ?></label>
<input class="form-control" name="book_phone" placeholder="+63 XXX XXX XXXX" required="" type="tel"/>
</div>
<div class="form-row">
<div class="form-group">
<label class="form-label">Number of Participants</label>
<input class="form-control" name="book_participants" placeholder="e.g. 1" required="" type="number" min="1"/>
</div>
<div class="form-group">
<label class="form-label"><?php echo get_field('bk_label_duration') ?: 'Duration'; ?></label>
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
<label class="form-label"><?php echo get_field('bk_label_start_date') ?: 'Start Date'; ?></label>
<input class="form-control" name="book_start_date" required="" type="date"/>
</div>
<div class="form-group">
<label class="form-label">Arrival Time</label>
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
<label class="form-label"><?php echo get_field('bk_label_special') ?: 'Special Requests'; ?></label>
<textarea class="form-control" name="book_special" placeholder="Any special requirements..."></textarea>
</div>
<button class="btn btn-book" name="book_submit" type="submit"><?php echo get_field('bk_btn_submit') ?: 'Confirm Booking'; ?></button>
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
<script>
    // Tab Data Mapping
        const bookingData = {
      "Co-Working": {
        image: "<?php echo kc_img('image_coworking', 'page-book-now-img/kings-img12.webp'); ?>",
        overline: "Co-Working",
        title: "Shared Workspaces",
        text: "<p>Work alongside other professionals in our beautifully designed open-plan coworking areas. Perfect for freelancers, remote workers, and small teams looking for a vibrant and inspiring environment.</p><p>Enjoy access to premium amenities, high-speed internet, and unlimited premium coffee to keep you productive throughout the day.</p>",
        features: ["High-speed Wi-Fi", "Unlimited Coffee", "Lounge Access"],
        formTitle: "Book Co-Working",
        options: [
          { label: "Day Pass &mdash; Php 500", value: "Day Pass", price: 500 },
          { label: "Weekly Pass &mdash; Php 2,500", value: "Weekly Pass", price: 2500 },
          { label: "Monthly Pass &mdash; Php 6,000", value: "Monthly Pass", price: 6000 },
          { label: "Annual Pass &mdash; Php 60,000", value: "Annual Pass", price: 60000 }
        ]
      },
      "Meeting Rooms": {
        image: "<?php echo kc_img('image_meeting', 'page-book-now-img/kings-img28.webp'); ?>",
        overline: "Meeting Rooms",
        title: "Professional Meeting Spaces",
        text: "<p>Host your next client presentation, team brainstorming session, or board meeting in our fully equipped meeting rooms. Designed for productivity and privacy.</p><p>Our meeting rooms feature state-of-the-art audiovisual equipment, high-speed Wi-Fi, and comfortable seating to ensure your meetings run smoothly.</p>",
        features: ["AV Equipment", "High-speed Wi-Fi", "Whiteboards"],
        formTitle: "Book Meeting Room",
        options: [
          { label: "Small Meeting Room (up to 6 pax) - Per Hour &mdash; Php 500", value: "Small Meeting Room - Per Hour", price: 500 },
          { label: "Small Meeting Room (up to 6 pax) - Full Day &mdash; Php 4,000", value: "Small Meeting Room - Full Day", price: 4000 },
          { label: "Conference Room (up to 12 pax) - Per Hour &mdash; Php 1,000", value: "Conference Room - Per Hour", price: 1000 },
          { label: "Conference Room (up to 12 pax) - Full Day &mdash; Php 8,000", value: "Conference Room - Full Day", price: 8000 }
        ]
      },
      "Events Place": {
        image: "<?php echo kc_img('image_events', 'page-book-now-img/kings-img13.webp'); ?>",
        overline: "Events Place",
        title: "Versatile Event Spaces",
        text: "<p>Whether you're hosting a corporate seminar, a product launch, or a networking mixer, our versatile event spaces provide the perfect backdrop for a memorable occasion.</p><p>Our dedicated events team will work with you to customize the layout and arrange catering, ensuring every detail is taken care of.</p>",
        features: ["Customizable Layout", "Dedicated Events Team", "Catering Options"],
        formTitle: "Book Events Place",
        options: [
          { label: "Per Hour &mdash; Php 5,000", value: "Per Hour", price: 5000 },
          { label: "4 Hours &mdash; Php 18,000", value: "4 Hours", price: 18000 },
          { label: "Full Day &mdash; Php 40,000", value: "Full Day", price: 40000 }
        ]
      },
      "Office Leasing": {
        image: "<?php echo kc_img('image_office', 'page-book-now-img/kings-img36.webp'); ?>",
        overline: "Private Offices",
        title: "Dedicated Office Leasing",
        text: "<p>Establish your business presence with a dedicated private office. Fully furnished and move-in ready, our private offices offer the privacy you need with the benefits of a shared community.</p><p>Enjoy 24/7 access, customized branding options, and complimentary meeting room credits every month.</p>",
        features: ["24/7 Access", "Fully Furnished", "Meeting Room Credits"],
        formTitle: "Book Office Leasing",
        options: [
          { label: "6-Seat Office - Monthly &mdash; Php 48,000", value: "6-Seat Office", price: 48000 },
          { label: "9-Seat Office - Monthly &mdash; Php 55,000", value: "9-Seat Office", price: 55000 },
          { label: "14-Seat Office - Monthly &mdash; Php 112,000", value: "14-Seat Office", price: 112000 }
        ]
      },
      "Virtual Office": {
        image: "<?php echo kc_img('image_virtual', 'page-book-now-img/kings-img18.webp'); ?>",
        overline: "Virtual Office",
        title: "Professional Business Address",
        text: "<p>Elevate your brand image with a prestigious business address at The Kings City Club. Our virtual office packages give you a professional presence without the overhead of a physical space.</p><p>Benefit from mail handling services, a dedicated local phone number, and access to our meeting rooms and coworking spaces when you need them.</p>",
        features: ["Prestigious Address", "Mail Handling", "Lounge Access"],
        formTitle: "Book Virtual Office",
        options: [
          { label: "Standard Plan - Monthly &mdash; Php 3,000", value: "Standard Plan - Monthly", price: 3000 },
          { label: "Standard Plan - Annually &mdash; Php 30,000", value: "Standard Plan - Annually", price: 30000 },
          { label: "Pro Plan - Monthly &mdash; Php 5,000", value: "Pro Plan - Monthly", price: 5000 },
          { label: "Pro Plan - Annually &mdash; Php 50,000", value: "Pro Plan - Annually", price: 50000 }
        ]
      },
      "Bakehouse": {
        image: "<?php echo kc_img('image_bakehouse', 'page-spaces-img/kings-img88.webp'); ?>",
        overline: "Test Kitchen",
        title: "Social Manila Bakehouse",
        text: "<p>Welcome to The Social Manila Bakehouse, a fully equipped commercial-grade test kitchen designed to bring your culinary visions to life. Whether you are hosting an intimate baking class, testing a new menu, or organizing a food tasting, our space provides everything you need in a professional yet welcoming environment.</p><p>Beyond its functional layout, the Bakehouse is highly photogenic, making it the ideal setting for food photography, content creation, and culinary demonstrations. You have the option to rent the space exclusively or include the expertise of our resident Baker and Chef.</p>",
        features: ["Ideal for Content Creation", "Baking & Cooking Classes", "Kitchen Access"],
        formTitle: "Book Bakehouse",
        options: [
          { label: "Test Kitchen Exclusive - Per Hour &mdash; Php 5,000", value: "Test Kitchen Exclusive - Per Hour", price: 5000 },
          { label: "With Baker and Chef - Per Hour &mdash; Php 5,000", value: "With Baker and Chef - Per Hour", price: 5000 }
        ]
      },
      "Manille Ceramic (Limited)": {
        image: "<?php echo kc_img('image_manille', 'page-spaces-img/kings-img85.webp'); ?>",
        overline: "Studio Manille",
        title: "Manille Céramique",
        text: "<p>Step into Manille Céramique, a dynamic and beautifully designed studio space perfect for your creative endeavors. Engineered for flexibility, the studio features movable props and modular furniture that can easily adapt to your specific production needs, workshops, or private sessions.</p><p>Designed with content creation in mind, it provides the perfect lighting and backdrops for photo shoots, video production, or artistic gatherings. Choose to rent just the stunning backdrop or secure the entire studio for exclusive use.</p>",
        features: ["Ideal for Content Creation", "Flexible layout", "Movable props & furniture"],
        formTitle: "Book Manille Ceramic",
        options: [
          { label: "Backdrop Only - Per Hour &mdash; Php 1,000", value: "Backdrop Only - Per Hour", price: 1000 },
          { label: "Exclusive Use - Per Hour &mdash; Php 5,000", value: "Exclusive Use - Per Hour", price: 5000 }
        ]
      }
    };

    const spaceTypeSelect = document.getElementById('space-type-select');
    const durationSelect = document.getElementById('duration-select');
    const priceDisplay = document.getElementById('price-display');
    const contentImage = document.getElementById('content-image');
    const hiddenPrice = document.getElementById('hidden-price');

    if (spaceTypeSelect) {
      spaceTypeSelect.addEventListener('change', () => {
        const key = spaceTypeSelect.value;
        const data = bookingData[key] || bookingData['Co-Working']; // fallback if missing

        // Update content
        if (contentImage) contentImage.src = data.image;
        if (document.getElementById('content-overline')) document.getElementById('content-overline').innerText = data.overline;
        if (document.getElementById('content-title')) document.getElementById('content-title').innerText = data.title;
        if (document.getElementById('content-text')) document.getElementById('content-text').innerHTML = data.text;
        if (document.getElementById('form-title')) document.getElementById('form-title').innerText = data.formTitle;

        // Update features
        const featureContainer = document.getElementById('content-features');
        if (featureContainer) featureContainer.innerHTML = data.features.map(f => `<span class="feature-tag">${f}</span>`).join('');

        // Update duration select options
        if (durationSelect) {
            durationSelect.innerHTML = data.options.map(o => `<option value="${o.value}" data-price="${o.price}">${o.label}</option>`).join('');
            updatePrice();
        }
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

    // Initialize first price
    updatePrice();

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
