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
            update_post_meta($post_id, 'kc_status', 'Pending Payment');
        }
        
        // Send Client Auto-Responder Email (client still gets their confirmation)
        $headers = array('Content-Type: text/html; charset=UTF-8');
        $client_subject = "Booking Request Received: $space_type";
        $client_body = "<h2>We've received your booking request!</h2>
                        <p>Hi $first_name,</p>
                        <p>Thank you for choosing Kings City. Your booking request for <strong>$space_type ($duration)</strong> on <strong>$start_date</strong> at <strong>$arrival_time</strong> has been received by our team.</p>
                        <p><strong>Important Notice:</strong><br/>
                        Your booking is reserved for your selected start date and time. If you do not arrive within <strong>24 hours</strong> of your start date, your reservation will be automatically cancelled. If your reservation expires, you are always welcome to book again through our website or directly at the Kings City reception desk!</p>
                        <p>Please proceed to the Kings City reception desk upon arrival to finalize your payment of Php $price and claim your space.</p>
                        <p>We look forward to seeing you!<br/>- The Kings City Team</p>";
                        
        wp_mail($email, $client_subject, $client_body, $headers);
        
        $booking_submitted = true;
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
<h1 class="hero__title hero__title--inner"><?php echo get_field('h1_1'); ?></h1>
<p class="hero__subtitle"><?php echo get_field('p_2'); ?></p>
</div>
<!-- media on right -->
<div class="split__media hero__slider" id="hero-slider" style="position: relative; aspect-ratio: 4/3; overflow: hidden; border-radius: var(--radius-card);">
<img alt="Kings City Book Now 1" class="hero__slide is-active" src="<?php $img = get_field('image_4'); echo ($img && is_array($img) && isset($img['url'])) ? esc_url($img['url']) : (is_numeric($img) ? wp_get_attachment_image_url($img, 'full') : get_template_directory_uri() . '/assets/img/placeholder.jpg'); ?>" style="position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; opacity: 1; transition: opacity 1s ease-in-out;"/>
<img alt="Kings City Book Now 2" class="hero__slide" src="<?php $img = get_field('image_5'); echo ($img && is_array($img) && isset($img['url'])) ? esc_url($img['url']) : (is_numeric($img) ? wp_get_attachment_image_url($img, 'full') : get_template_directory_uri() . '/assets/img/placeholder.jpg'); ?>" style="position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; opacity: 0; transition: opacity 1s ease-in-out;"/>
<img alt="Kings City Book Now 3" class="hero__slide" src="<?php $img = get_field('image_6'); echo ($img && is_array($img) && isset($img['url'])) ? esc_url($img['url']) : (is_numeric($img) ? wp_get_attachment_image_url($img, 'full') : get_template_directory_uri() . '/assets/img/placeholder.jpg'); ?>" style="position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; opacity: 0; transition: opacity 1s ease-in-out;"/>
</div>
</div>
</div>
</section>
<!-- booking section -->
<section class="section content-panel" style="margin-top: 0;">
<div class="container">
<div class="book-grid">
<!-- left: content information -->
<div class="book-content" id="booking-info">
<div class="book-content__media">
<img alt="Workspace" id="content-image" src="<?php $img = get_field('image_14'); echo ($img && is_array($img) && isset($img['url'])) ? esc_url($img['url']) : (is_numeric($img) ? wp_get_attachment_image_url($img, 'full') : get_template_directory_uri() . '/assets/img/placeholder.jpg'); ?>"/>
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
<?php if ($booking_submitted): ?>
<div class="success-message" style="text-align: center; padding: 3rem 1rem;">
    <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom: 1rem;"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
    <h2 style="color: var(--color-primary); margin-bottom: 1rem;">Booking Requested Successfully!</h2>
    <p style="color: var(--color-text-muted); font-size: 1.1rem; margin-bottom: 1.5rem;">Your booking has been received! We will be in touch to confirm payment details.</p>
</div>
<?php else: ?>
<?php if (!empty($error_message)): ?>
    <div style="background: #fee2e2; color: #b91c1c; padding: 1rem; border-radius: var(--radius-md); margin-bottom: 1.5rem;">
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
<?php endif; ?>
</div>
</div>
</div>
</div>
</div>
</section>
</main>
<script>
    // Tab Data Mapping
    const bookingData = {
      coworking: {
        image: "<?php $img = get_field('image_coworking'); echo ($img && is_array($img) && isset($img['url'])) ? esc_url($img['url']) : (is_numeric($img) ? wp_get_attachment_image_url($img, 'full') : get_template_directory_uri() . '/assets/img/kings_co-working_room01.JPG'); ?>",
        overline: "Hot Desks & Dedicated Seats",
        title: "Co-Working",
        text: "<p>Our communal tables and working stations are designed for connections to happen. Staying true to our purpose, it is our mission to contribute to the growth of the economy by continuously providing jobs and beautiful workspaces for our members.</p><p>Solve your monotonous daily routine with our vibrant environment &mdash; surrounded by like-minded professionals who inspire and energize.</p>",
        features: ["High-Speed Wi-Fi", "Dedicated Seats", "Kitchen Access", "In-House Cafe", "Community Events", "24/7 Access"],
        formTitle: "Book Co-Working",
        options: [
          { label: "Day Pass &mdash; Php 500", value: "Day Pass", price: 500 },
          { label: "Weekly Pass &mdash; Php 2,500", value: "Weekly Pass", price: 2500 },
          { label: "Monthly Pass &mdash; Php 6,000", value: "Monthly Pass", price: 6000 },
          { label: "Annual Pass &mdash; Php 60,000", value: "Annual Pass", price: 60000 }
        ]
      },
      "Meeting Rooms": {
        image: "<?php $img = get_field('image_meeting'); echo ($img && is_array($img) && isset($img['url'])) ? esc_url($img['url']) : (is_numeric($img) ? wp_get_attachment_image_url($img, 'full') : get_template_directory_uri() . '/assets/img/kings_meeting_room03.JPG'); ?>",
        overline: "Private & Professional",
        title: "Meeting Rooms",
        text: "<p>A meeting is like a delicate eco-system &mdash; all the participants and amenities have to be in perfect balance for the call or presentation to reach its greatest potential.</p><p>Our private and professional conference rooms come with comfortable furniture, high-speed Internet, kitchen facilities, and state-of-the-art presentation equipment.</p>",
        features: ["Smart TV / AV", "Whiteboard", "High-Speed Wi-Fi", "Kitchen Access", "Climate Control", "Receptionist Support"],
        formTitle: "Book Meeting Room",
        options: [
          { label: "Small (up to 6 pax) - Per Hour &mdash; Php 500", value: "Small (up to 6 pax) - Per Hour", price: 500 },
          { label: "Small (up to 6 pax) - Full Day &mdash; Php 4,000", value: "Small (up to 6 pax) - Full Day", price: 4000 },
          { label: "Conference (up to 12 pax) - Per Hour &mdash; Php 1,000", value: "Conference (up to 12 pax) - Per Hour", price: 1000 },
          { label: "Conference (up to 12 pax) - Full Day &mdash; Php 8,000", value: "Conference (up to 12 pax) - Full Day", price: 8000 }
        ]
      },
      "Events Place": {
        image: "<?php $img = get_field('image_events'); echo ($img && is_array($img) && isset($img['url'])) ? esc_url($img['url']) : (is_numeric($img) ? wp_get_attachment_image_url($img, 'full') : get_template_directory_uri() . '/assets/img/kings_event_room02.jpg'); ?>",
        overline: "Functions & Events",
        title: "Events Place",
        text: "<p>We offer a venue for your company's special events &mdash; a space perfect for more intimate functions. The layout can accommodate over 100 guests if there will be no tables included in the layout.</p><p>Whether it's a product launch, company party, training seminar, or networking community &mdash; our events place is the perfect backdrop.</p>",
        features: ["Full Venue Access", "Sound System", "Flexible Layout", "Photography Friendly", "Event Support Staff", "Catering Space"],
        formTitle: "Book Events Place",
        options: [
          { label: "Per Hour &mdash; Php 5,000", value: "Per Hour", price: 5000 },
          { label: "4 Hours &mdash; Php 18,000", value: "4 Hours", price: 18000 },
          { label: "Full Day &mdash; Php 40,000", value: "Full Day", price: 40000 }
        ]
      },
      "Office Leasing": {
        image: "<?php $img = get_field('image_office'); echo ($img && is_array($img) && isset($img['url'])) ? esc_url($img['url']) : (is_numeric($img) ? wp_get_attachment_image_url($img, 'full') : get_template_directory_uri() . '/assets/img/kings_office-leasing_room04.JPG'); ?>",
        overline: "Dedicated Private Offices",
        title: "Office Leasing",
        text: "<p>Whether your company is an established enterprise or a growing startup, we offer office spaces that inspire your most impactful work. Our private offices are fully equipped and ready for your team from day one.</p><p>Each office comes with high-speed internet, dedicated IT support, access to our in-house caf&eacute;, and the full Kings City community experience.</p>",
        features: ["Fully Furnished", "Biometric Access", "Dedicated IT", "Company Branding", "Mail Handling", "Private Storage"],
        formTitle: "Inquire for Office Leasing",
        options: [
          { label: "6-Seat Office &mdash; Php 48,000 / mo", value: "6-Seat Office", price: 48000 },
          { label: "9-Seat Office &mdash; Php 55,000 / mo", value: "9-Seat Office", price: 55000 },
          { label: "14-Seat Office &mdash; Php 112,000 / mo", value: "14-Seat Office", price: 112000 }
        ]
      },
      "Virtual Office": {
        image: "<?php $img = get_field('image_virtual'); echo ($img && is_array($img) && isset($img['url'])) ? esc_url($img['url']) : (is_numeric($img) ? wp_get_attachment_image_url($img, 'full') : get_template_directory_uri() . '/assets/img/kings_virtual-office_room05.JPG'); ?>",
        overline: "Work From Anywhere",
        title: "Virtual Office",
        text: "<p>Virtual office is part of a flexible workspace that provides businesses with any combination of services, space and/or technology &mdash; without those businesses bearing the capital expenses of owning or leasing a traditional office.</p><p>Get a prestigious Para&ntilde;aque City business address, mail handling, telephone answering, and access to our facilities &mdash; all without a full-time lease.</p>",
        features: ["Business Address", "Mail Handling", "Lounge Access", "Member Rates", "Reciprocal Access", "Call Answering"],
        formTitle: "Setup Virtual Office",
        options: [
          { label: "Standard (Monthly) &mdash; Php 3,000", value: "Standard (Monthly)", price: 3000 },
          { label: "Standard (Annual) &mdash; Php 30,000", value: "Standard (Annual)", price: 30000 },
          { label: "Pro (Monthly) &mdash; Php 5,000", value: "Pro (Monthly)", price: 5000 },
          { label: "Pro (Annual) &mdash; Php 50,000", value: "Pro (Annual)", price: 50000 }
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


<?php get_footer(); ?>
