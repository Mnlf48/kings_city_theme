<?php
if (!defined('ABSPATH')) exit;
/* Template Name: Privacy Policy */
get_header();

$home_url  = esc_url( home_url('/') );
$effective = date('F j, Y');

// Hero
$pp_overline  = get_field('pp_hero_overline') ?: 'Legal & Compliance';
$pp_heading   = get_field('pp_hero_heading')  ?: 'Privacy Policy';
$pp_subtitle  = get_field('pp_hero_subtitle') ?: 'How we collect, use, and protect your personal data in accordance with Philippine law.';

// Intro blush section
$pp_intro_text = get_field('pp_intro_text');

// Section headings + bodies
$pp_s1_heading = get_field('pp_s1_heading') ?: '1. Information We Collect';
$pp_s1_body    = get_field('pp_s1_body');
$pp_s2_heading = get_field('pp_s2_heading') ?: '2. Legal Basis & How We Use Your Information';
$pp_s2_body    = get_field('pp_s2_body');
$pp_s3_heading = get_field('pp_s3_heading') ?: '3. Information Sharing & Third-Party Disclosures';
$pp_s3_body    = get_field('pp_s3_body');
$pp_s4_heading = get_field('pp_s4_heading') ?: '4. Data Retention & Secure Disposal';
$pp_s4_body    = get_field('pp_s4_body');
$pp_s5_heading = get_field('pp_s5_heading') ?: '5. Technical & Organizational Security Measures';
$pp_s5_body    = get_field('pp_s5_body');
$pp_s6_heading = get_field('pp_s6_heading') ?: '6. Your Rights Under Philippine Data Privacy Law';
$pp_s6_body    = get_field('pp_s6_body');
$pp_s7_heading = get_field('pp_s7_heading') ?: '7. Cookie & Tracking Technologies';
$pp_s7_body    = get_field('pp_s7_body');
$pp_s8_heading = get_field('pp_s8_heading') ?: '8. Children\'s Privacy';
$pp_s8_body    = get_field('pp_s8_body');
$pp_s9_heading = get_field('pp_s9_heading') ?: '9. Policy Amendments';
$pp_s9_body    = get_field('pp_s9_body');

// Section 10 — DPO contact (structured fields)
$pp_s10_heading = get_field('pp_s10_heading')  ?: '10. Data Protection Officer (DPO) Contact Details';
$pp_s10_intro   = get_field('pp_s10_intro')    ?: 'For inquiries, exercise of data subject rights, or privacy-related complaints, please reach out to our Data Protection Officer:';
$pp_dpo_email   = get_field('pp_dpo_email')    ?: 'dpo@kingscity.com.ph';
$pp_dpo_phone   = get_field('pp_dpo_phone')    ?: '+63 (2) 8776-6712';
$pp_dpo_address = get_field('pp_dpo_address')  ?: '100 Doña Soledad Ave, Better Living Subdivision, Parañaque City 1711, Metro Manila, Philippines';
$pp_s10_npc     = get_field('pp_s10_npc_note') ?: 'You may also file formal complaints regarding data privacy issues with the <strong>National Privacy Commission (NPC)</strong> at their official portal: <a href="https://www.privacy.gov.ph" target="_blank" rel="noopener noreferrer">www.privacy.gov.ph</a>.';
?>

<main id="main-content">

<!-- hero -->
<section class="hero premium-hero">
<div class="container grid-12">
<div class="col-12 split split--media-right">
<div class="split__content animate-fadeInUp hero__content--index">
  <span class="text-overline hero__overline"><?php echo esc_html($pp_overline); ?></span>
  <h1 class="hero__title hero__title--inner"><?php echo esc_html($pp_heading); ?></h1>
  <p class="hero__subtitle"><?php echo esc_html($pp_subtitle); ?></p>
</div>
<div class="split__media hero__slider" id="hero-slider" style="position: relative; aspect-ratio: 4/3; overflow: hidden; border-radius: var(--radius-card);">
  <img class="hero__slide is-active" alt="Kings City Club exterior"
       src="<?php echo kc_img('pp_hero_img1', 'front-page-img/kings_img02.webp'); ?>"
       style="position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; opacity: 1; transition: opacity 1s ease-in-out;"
       loading="eager"/>
  <img class="hero__slide" alt="Welcome to Kings City"
       src="<?php echo kc_img('pp_hero_img2', 'page-about-img/kings-img30.webp'); ?>"
       style="position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; opacity: 0; transition: opacity 1s ease-in-out;"
       loading="eager"/>
  <img class="hero__slide" alt="Kings City Club staircase"
       src="<?php echo kc_img('pp_hero_img3', 'page-impact-img/kings_img03.webp'); ?>"
       style="position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; opacity: 0; transition: opacity 1s ease-in-out;"
       loading="eager"/>
</div>
</div>
</div>
</section>

<!-- intro blush section -->
<section class="section content-panel bg-blush">
<div class="container" style="max-width: 860px;">

  <style>
  .legal-lead { font-size: 1.1rem; line-height: 1.75; color: var(--color-text); margin-bottom: var(--space-md); }
  .legal-effective { font-size: 0.875rem; color: var(--color-text-muted); margin-bottom: 0; }
  .legal-section { margin-bottom: var(--space-xl); }
  .legal-section h2 { font-family: var(--font-heading); color: var(--color-primary); font-size: clamp(1rem, 2vw, 1.25rem); text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: var(--space-sm); padding-bottom: 0.5rem; border-bottom: 2px solid var(--color-primary); }
  .legal-section h3 { font-family: var(--font-heading); color: var(--color-text); font-size: 1rem; text-transform: uppercase; letter-spacing: 0.04em; margin-top: var(--space-md); margin-bottom: 0.5rem; }
  .legal-section p, .legal-section li { color: var(--color-text-muted); line-height: 1.7; font-size: 1rem; }
  .legal-section ul { padding-left: 1.5rem; margin-top: 0.5rem; }
  .legal-section li { margin-bottom: 0.4rem; }
  .legal-section a { color: var(--color-primary); }
  .legal-npc-box { margin-top: var(--space-md); background: var(--color-bg-blush); border-left: 3px solid var(--color-primary); padding: 1rem 1.25rem; font-size: 0.95rem; color: var(--color-text-muted); line-height: 1.6; }
  </style>

  <?php if ( $pp_intro_text ) : ?>
    <div class="legal-lead"><?php echo wp_kses_post($pp_intro_text); ?></div>
  <?php else : ?>
  <p class="legal-lead">
    <strong>The Kings City Club</strong> ("Kings City," "we," "us," "our") and its affiliated brands under the Kings Group of Companies are fully committed to safeguarding the privacy and security of your personal data. This Privacy Policy details how we collect, process, utilize, share, retain, and dispose of your personal information when you visit our website, book a tour, inquire about our workspaces, submit an application, or request service quotes — all in accordance with the <strong>Data Privacy Act of 2012 (Republic Act No. 10173)</strong> of the Republic of the Philippines, its Implementing Rules and Regulations (IRR), and other relevant data privacy frameworks.
  </p>
  <?php endif; ?>
  <p class="legal-effective"><em>Effective Date: <?php echo esc_html($effective); ?> &nbsp;|&nbsp; Last Updated: <?php echo esc_html($effective); ?></em></p>

</div>
</section>

<!-- legal content -->
<section class="section content-panel bg-ivory">
<div class="container" style="max-width: 860px;">

  <!-- Section 1 -->
  <div class="legal-section">
    <h2><?php echo esc_html($pp_s1_heading); ?></h2>
    <?php if ( $pp_s1_body ) : echo wp_kses_post($pp_s1_body); else : ?>
    <p>In the course of providing coworking, workspace, and business community services, we collect both personal information and non-personal diagnostic data. The scope of information depends on your interactions with the Site.</p>
    <h3>a) Website Visitors &amp; Tour Inquiries</h3>
    <ul>
      <li><strong>Identity Data:</strong> Full name, email address, phone number, and company or organization name when you submit a tour booking, space inquiry, or contact form.</li>
      <li><strong>Inquiry &amp; Booking Data:</strong> Workspace type preferences, preferred booking dates, team headcount, service tier interest, and related correspondence needed to process your reservation or quote request.</li>
      <li><strong>Application Data:</strong> For visitors using the Apply page — position of interest, CV/resume, employment background, professional references, and application timestamp.</li>
    </ul>
    <h3>b) Member Inquiries &amp; Quote Requestors</h3>
    <ul>
      <li><strong>Business Contact Data:</strong> Corporate name, business address, work email address, and direct corporate phone line.</li>
      <li><strong>Operational Specifications:</strong> Department size needs, required workspace headcount, service terms, billing preferences, and currency selection.</li>
    </ul>
    <h3>c) Automated &amp; Diagnostic Data</h3>
    <ul>
      <li><strong>Technical Log Data:</strong> Internet Protocol (IP) address, browser client user-agent string, operating system version, and system language preferences.</li>
      <li><strong>Clickstream Analytics:</strong> Referral traffic sources, specific pages visited on our Site, duration of visits, scroll depths, and interaction paths.</li>
      <li><strong>Location Geolocation Data:</strong> Country-level geo-routing parameters deduced via IP headers or analytics tools.</li>
    </ul>
    <?php endif; ?>
  </div>

  <!-- Section 2 -->
  <div class="legal-section">
    <h2><?php echo esc_html($pp_s2_heading); ?></h2>
    <?php if ( $pp_s2_body ) : echo wp_kses_post($pp_s2_body); else : ?>
    <p>We process your data based on your explicit consent, contractual necessity, or legitimate interest, specifically for the following purposes:</p>
    <ul>
      <li><strong>Tour &amp; Booking Processing:</strong> Reviewing and evaluating workspace inquiries, matching clients with appropriate space options, and scheduling tours and site visits.</li>
      <li><strong>Mailing List &amp; Communications:</strong> Sending newsletters, event invitations, and member updates — with your consent and with an easy opt-out option at all times.</li>
      <li><strong>Community &amp; Member Engagement:</strong> Connecting members and inquirers with relevant programs, community events, and affiliated brands within the Kings Group of Companies.</li>
      <li><strong>Application Processing:</strong> Reviewing job and membership applications submitted through our Apply page for matching with suitable openings or opportunities.</li>
      <li><strong>Site Optimization:</strong> Monitoring site traffic and diagnosing server workloads to protect the integrity of the Site.</li>
      <li><strong>Compliance &amp; Regulatory Reporting:</strong> Meeting legal obligations mandated by the National Privacy Commission (NPC) and other applicable Philippine regulatory bodies.</li>
    </ul>
    <?php endif; ?>
  </div>

  <!-- Section 3 -->
  <div class="legal-section">
    <h2><?php echo esc_html($pp_s3_heading); ?></h2>
    <?php if ( $pp_s3_body ) : echo wp_kses_post($pp_s3_body); else : ?>
    <p>The Kings City Club strictly enforces a zero-sale policy on personal data. We do not sell or lease personal details. However, we may share relevant personal data under secure protocols with:</p>
    <ul>
      <li><strong>Service Providers:</strong> Trusted third-party partners (e.g., email dispatch platforms, cloud hosting servers, and analytical systems) who act strictly as Data Processors under legally binding Data Processing Agreements.</li>
      <li><strong>Kings Group of Companies:</strong> Our affiliated brands — The Social Manila, Kings Manpower, The Social Manila Bakehouse, and Home Culinary School — only where necessary for coordinated service delivery and with your knowledge.</li>
      <li><strong>Legal &amp; Regulatory Authorities:</strong> Providing data in response to official legal warrants, court subpoenas, regulatory audits, or where disclosure is mandated by law to prevent fraud or coordinate safety operations.</li>
    </ul>
    <p style="margin-top: 0.75rem;">We do not transfer your personal data outside the Philippines without appropriate safeguards as required by the NPC.</p>
    <?php endif; ?>
  </div>

  <!-- Section 4 -->
  <div class="legal-section">
    <h2><?php echo esc_html($pp_s4_heading); ?></h2>
    <?php if ( $pp_s4_body ) : echo wp_kses_post($pp_s4_body); else : ?>
    <p>We establish clear retention criteria to minimize data footprints:</p>
    <ul>
      <li><strong>Booking &amp; Inquiry Records:</strong> Active booking and inquiry data is securely archived for up to <strong>five (5) years</strong>. After this duration, records are automatically queued for deletion unless consent is renewed.</li>
      <li><strong>Mailing List Subscriptions:</strong> Maintained until you unsubscribe or formally request deletion of your data.</li>
      <li><strong>Security &amp; Diagnostic Logs:</strong> Basic diagnostic server logs are purged after ninety (90) days.</li>
      <li><strong>Data Destruction Protocols:</strong> Digital files, including uploaded CVs and documents, are overwritten and permanently erased using secure file-deletion methods. Physical documentation, if any, is destroyed via cross-cut document shredders.</li>
    </ul>
    <?php endif; ?>
  </div>

  <!-- Section 5 -->
  <div class="legal-section">
    <h2><?php echo esc_html($pp_s5_heading); ?></h2>
    <?php if ( $pp_s5_body ) : echo wp_kses_post($pp_s5_body); else : ?>
    <p>We apply robust administrative, physical, and technical safeguards to keep your personal data secure:</p>
    <ul>
      <li><strong>Data in Transit:</strong> The website forces secure connections using HTTPS with TLS encryption protocols.</li>
      <li><strong>Form &amp; Submission Security:</strong> All form submissions (booking requests, applications, mailing list sign-ups) are processed over secure encrypted connections.</li>
      <li><strong>Access Control:</strong> Administrative user roles use the principle of least privilege, requiring secure credentials to view member and inquiry data.</li>
      <li><strong>Data Minimization:</strong> We collect only what is strictly necessary for the stated purposes and avoid storing excess or redundant personal information.</li>
    </ul>
    <?php endif; ?>
  </div>

  <!-- Section 6 -->
  <div class="legal-section">
    <h2><?php echo esc_html($pp_s6_heading); ?></h2>
    <?php if ( $pp_s6_body ) : echo wp_kses_post($pp_s6_body); else : ?>
    <p>As a data subject, you hold comprehensive rights under the Data Privacy Act of 2012, which we respect and facilitate:</p>
    <ul>
      <li><strong>Right to be Informed:</strong> Knowing whether your data is being processed, collected, or shared.</li>
      <li><strong>Right to Access:</strong> Requesting a copy of the personal information we hold about you.</li>
      <li><strong>Right to Object:</strong> Objecting to the processing of your data, including processing for marketing or profiling.</li>
      <li><strong>Right to Rectification:</strong> Requiring us to correct inaccurate or outdated records.</li>
      <li><strong>Right to Erasure (Blocking):</strong> Ordering the removal or destruction of your personal data from our systems under lawful grounds.</li>
      <li><strong>Right to Damages:</strong> Seeking compensation for damages sustained due to inaccurate, incomplete, or unauthorized use of personal data.</li>
      <li><strong>Right to Data Portability:</strong> Obtaining your data in a structured, portable electronic format.</li>
    </ul>
    <?php endif; ?>
  </div>

  <!-- Section 7 -->
  <div class="legal-section">
    <h2><?php echo esc_html($pp_s7_heading); ?></h2>
    <?php if ( $pp_s7_body ) : echo wp_kses_post($pp_s7_body); else : ?>
    <p>Our website utilizes session and persistent cookies to remember user preferences, manage session states, and assess traffic patterns through analytics tools. You may configure your browser to block or refuse cookies; however, some sections of the Site may not load correctly as a result.</p>
    <?php endif; ?>
  </div>

  <!-- Section 8 -->
  <div class="legal-section">
    <h2><?php echo esc_html($pp_s8_heading); ?></h2>
    <?php if ( $pp_s8_body ) : echo wp_kses_post($pp_s8_body); else : ?>
    <p>The coworking and business services offered on this Site are strictly directed to individuals aged 18 and older. We do not knowingly compile or store data from minors. If you believe a minor has submitted personal information, please contact us and we will delete the data immediately.</p>
    <?php endif; ?>
  </div>

  <!-- Section 9 -->
  <div class="legal-section">
    <h2><?php echo esc_html($pp_s9_heading); ?></h2>
    <?php if ( $pp_s9_body ) : echo wp_kses_post($pp_s9_body); else : ?>
    <p>We reserve the right to revise this Privacy Policy to reflect changing regulatory requirements or platform upgrades. Material modifications will be posted on this page with a revised effective date. We encourage you to review this policy periodically to stay informed.</p>
    <?php endif; ?>
  </div>

  <!-- Section 10 -->
  <div class="legal-section">
    <h2><?php echo esc_html($pp_s10_heading); ?></h2>
    <p><?php echo esc_html($pp_s10_intro); ?></p>
    <ul>
      <li><strong>Email:</strong> <a href="mailto:<?php echo esc_attr($pp_dpo_email); ?>"><?php echo esc_html($pp_dpo_email); ?></a></li>
      <li><strong>Landline:</strong> <?php echo esc_html($pp_dpo_phone); ?></li>
      <li><strong>Office Address:</strong> <?php echo esc_html($pp_dpo_address); ?></li>
    </ul>
    <div class="legal-npc-box">
      <?php echo wp_kses_post($pp_s10_npc); ?>
    </div>
  </div>

</div>
</section>

</main>

<?php get_footer(); ?>
