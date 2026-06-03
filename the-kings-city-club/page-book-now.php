<?php
/* Template Name: Book a Tour */
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
<span class="price-est__label">Estimated Price</span>
<span class="price-est__value" id="price-display">Php 500</span>
</div>
<form action="#" id="booking-form">
<!-- space type selection -->
<div class="form-group">
<label class="form-label">Space Type</label>
<select class="form-control" id="space-type-select">
<option value="coworking">Co-Working</option>
<option value="meeting">Meeting Rooms</option>
<option value="events">Events Place</option>
<option value="office">Office Leasing</option>
<option value="virtual">Virtual Office</option>
</select>
</div>
<div class="form-row">
<div class="form-group">
<label class="form-label">First Name</label>
<input class="form-control" placeholder="First name" required="" type="text"/>
</div>
<div class="form-group">
<label class="form-label">Last Name</label>
<input class="form-control" placeholder="Last name" required="" type="text"/>
</div>
</div>
<div class="form-group">
<label class="form-label">Email Address</label>
<input class="form-control" placeholder="you@company.com" required="" type="email"/>
</div>
<div class="form-group">
<label class="form-label">Phone Number</label>
<input class="form-control" placeholder="+63 XXX XXX XXXX" required="" type="tel"/>
</div>
<div class="form-group">
<label class="form-label">Duration</label>
<select class="form-control" id="duration-select">
<!-- options dynamic based on selection -->
<option value="500">Day Pass — Php 500</option>
<option value="2500">Weekly Pass — Php 2,500</option>
<option value="6000">Monthly Pass — Php 6,000</option>
<option value="60000">Annual Pass — Php 60,000</option>
</select>
</div>
<div class="form-group">
<label class="form-label">Start Date</label>
<input class="form-control" required="" type="date"/>
</div>
<div class="form-group">
<label class="form-label">Special Requests</label>
<textarea class="form-control" placeholder="Any special requirements..."></textarea>
</div>
<button class="btn btn-book" type="submit">Confirm Booking</button>
</form>
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
          { label: "Day Pass &mdash; Php 500", value: "500" },
          { label: "Weekly Pass &mdash; Php 2,500", value: "2500" },
          { label: "Monthly Pass &mdash; Php 6,000", value: "6000" },
          { label: "Annual Pass &mdash; Php 60,000", value: "60000" }
        ]
      },
      meeting: {
        image: "<?php $img = get_field('image_meeting'); echo ($img && is_array($img) && isset($img['url'])) ? esc_url($img['url']) : (is_numeric($img) ? wp_get_attachment_image_url($img, 'full') : get_template_directory_uri() . '/assets/img/kings_meeting_room03.JPG'); ?>",
        overline: "Private & Professional",
        title: "Meeting Rooms",
        text: "<p>A meeting is like a delicate eco-system &mdash; all the participants and amenities have to be in perfect balance for the call or presentation to reach its greatest potential.</p><p>Our private and professional conference rooms come with comfortable furniture, high-speed Internet, kitchen facilities, and state-of-the-art presentation equipment.</p>",
        features: ["Smart TV / AV", "Whiteboard", "High-Speed Wi-Fi", "Kitchen Access", "Climate Control", "Receptionist Support"],
        formTitle: "Book Meeting Room",
        options: [
          { label: "Small (up to 6 pax) - Per Hour &mdash; Php 500", value: "500" },
          { label: "Small (up to 6 pax) - Full Day &mdash; Php 4,000", value: "4000" },
          { label: "Conference (up to 12 pax) - Per Hour &mdash; Php 1,000", value: "1000" },
          { label: "Conference (up to 12 pax) - Full Day &mdash; Php 8,000", value: "8000" }
        ]
      },
      events: {
        image: "<?php $img = get_field('image_events'); echo ($img && is_array($img) && isset($img['url'])) ? esc_url($img['url']) : (is_numeric($img) ? wp_get_attachment_image_url($img, 'full') : get_template_directory_uri() . '/assets/img/kings_event_room02.jpg'); ?>",
        overline: "Functions & Events",
        title: "Events Place",
        text: "<p>We offer a venue for your company's special events &mdash; a space perfect for more intimate functions. The layout can accommodate over 100 guests if there will be no tables included in the layout.</p><p>Whether it's a product launch, company party, training seminar, or networking community &mdash; our events place is the perfect backdrop.</p>",
        features: ["Full Venue Access", "Sound System", "Flexible Layout", "Photography Friendly", "Event Support Staff", "Catering Space"],
        formTitle: "Book Events Place",
        options: [
          { label: "Per Hour &mdash; Php 5,000", value: "5000" },
          { label: "4 Hours &mdash; Php 18,000", value: "18000" },
          { label: "Full Day &mdash; Php 40,000", value: "40000" }
        ]
      },
      office: {
        image: "<?php $img = get_field('image_office'); echo ($img && is_array($img) && isset($img['url'])) ? esc_url($img['url']) : (is_numeric($img) ? wp_get_attachment_image_url($img, 'full') : get_template_directory_uri() . '/assets/img/kings_office-leasing_room04.JPG'); ?>",
        overline: "Dedicated Private Offices",
        title: "Office Leasing",
        text: "<p>Whether your company is an established enterprise or a growing startup, we offer office spaces that inspire your most impactful work. Our private offices are fully equipped and ready for your team from day one.</p><p>Each office comes with high-speed internet, dedicated IT support, access to our in-house caf&eacute;, and the full Kings City community experience.</p>",
        features: ["Fully Furnished", "Biometric Access", "Dedicated IT", "Company Branding", "Mail Handling", "Private Storage"],
        formTitle: "Inquire for Office Leasing",
        options: [
          { label: "6-Seat Office &mdash; Php 48,000 / mo", value: "48000" },
          { label: "9-Seat Office &mdash; Php 55,000 / mo", value: "55000" },
          { label: "14-Seat Office &mdash; Php 112,000 / mo", value: "112000" }
        ]
      },
      virtual: {
        image: "<?php $img = get_field('image_virtual'); echo ($img && is_array($img) && isset($img['url'])) ? esc_url($img['url']) : (is_numeric($img) ? wp_get_attachment_image_url($img, 'full') : get_template_directory_uri() . '/assets/img/kings_virtual-office_room05.JPG'); ?>",
        overline: "Work From Anywhere",
        title: "Virtual Office",
        text: "<p>Virtual office is part of a flexible workspace that provides businesses with any combination of services, space and/or technology &mdash; without those businesses bearing the capital expenses of owning or leasing a traditional office.</p><p>Get a prestigious Para&ntilde;aque City business address, mail handling, telephone answering, and access to our facilities &mdash; all without a full-time lease.</p>",
        features: ["Business Address", "Mail Handling", "Lounge Access", "Member Rates", "Reciprocal Access", "Call Answering"],
        formTitle: "Setup Virtual Office",
        options: [
          { label: "Standard (Monthly) &mdash; Php 3,000", value: "3000" },
          { label: "Standard (Annual) &mdash; Php 30,000", value: "30000" },
          { label: "Pro (Monthly) &mdash; Php 5,000", value: "5000" },
          { label: "Pro (Annual) &mdash; Php 50,000", value: "50000" }
        ]
      }
    };

    const spaceTypeSelect = document.getElementById('space-type-select');
    const durationSelect = document.getElementById('duration-select');
    const priceDisplay = document.getElementById('price-display');
    const contentImage = document.getElementById('content-image');

    spaceTypeSelect.addEventListener('change', () => {
      const key = spaceTypeSelect.value;
      const data = bookingData[key];

      // Update content
      contentImage.src = data.image;
      document.getElementById('content-overline').innerText = data.overline;
      document.getElementById('content-title').innerText = data.title;
      document.getElementById('content-text').innerHTML = data.text;
      document.getElementById('form-title').innerText = data.formTitle;

      // Update features
      const featureContainer = document.getElementById('content-features');
      featureContainer.innerHTML = data.features.map(f => `<span class="feature-tag">${f}</span>`).join('');

      // Update duration select options
      durationSelect.innerHTML = data.options.map(o => `<option value="${o.value}">${o.label}</option>`).join('');
      
      updatePrice();
    });

    durationSelect.addEventListener('change', updatePrice);

    function updatePrice() {
      const val = parseInt(durationSelect.value).toLocaleString();
      priceDisplay.innerText = `Php ${val}`;
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
