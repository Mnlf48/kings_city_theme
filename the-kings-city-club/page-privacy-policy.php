<?php
if (!defined('ABSPATH')) exit;
/* Template Name: Privacy Policy */
get_header();

$home_url    = esc_url( home_url('/') );
$effective   = date('F j, Y');
?>

<main id="main-content">

<!-- hero -->
<section class="hero premium-hero">
<div class="container grid-12">
<div class="col-12 split split--media-right">
<div class="split__content animate-fadeInUp hero__content--index">
  <span class="text-overline hero__overline">Legal &amp; Compliance</span>
  <h1 class="hero__title hero__title--inner">Privacy<br>Policy</h1>
  <p class="hero__subtitle">How we collect, use, and protect your personal data in accordance with Philippine law.</p>
</div>
<div class="split__media" style="position: relative; aspect-ratio: 4/3; overflow: hidden; border-radius: var(--radius-card);">
  <img alt="Kings City Club Privacy Policy"
       src="<?php echo kc_img('privacy_hero_img', 'page-about-img/kings-img30.webp'); ?>"
       style="position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover;"
       loading="eager"/>
</div>
</div>
</div>
</section>

<!-- content -->
<section class="section content-panel bg-ivory">
<div class="container" style="max-width: 860px;">

  <p style="color: var(--color-text-muted); line-height: 1.9; font-size: 1.05rem; margin-bottom: var(--space-md);">
    <strong>The Kings City Club</strong> ("Kings City," "we," "us," "our") is fully committed to safeguarding the privacy and security of your personal data. This Privacy Policy explains how we collect, process, use, share, retain, and dispose of your personal information when you visit our website, book a tour, inquire about our spaces, or communicate with us — all in accordance with the <strong>Data Privacy Act of 2012 (Republic Act No. 10173)</strong> of the Republic of the Philippines, its Implementing Rules and Regulations (IRR), and all applicable data privacy frameworks.
  </p>
  <p style="color: var(--color-text-muted); font-size: 0.9rem; margin-bottom: var(--space-2xl);"><em>Effective Date: <?php echo esc_html($effective); ?> &nbsp;|&nbsp; Last Updated: <?php echo esc_html($effective); ?></em></p>

  <!-- section styles shared -->
  <style>
  .legal-section { margin-bottom: var(--space-2xl); }
  .legal-section h2 { font-family: var(--font-heading); color: var(--color-primary); font-size: clamp(1rem, 2vw, 1.25rem); text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: var(--space-sm); padding-bottom: 0.5rem; border-bottom: 2px solid var(--color-primary); }
  .legal-section p, .legal-section li { color: var(--color-text-muted); line-height: 1.9; font-size: 1rem; }
  .legal-section ul { padding-left: 1.5rem; margin-top: 0.75rem; }
  .legal-section li { margin-bottom: 0.5rem; }
  .legal-section a { color: var(--color-primary); }
  </style>

  <div class="legal-section">
    <h2>1. Information We Collect</h2>
    <p>When you interact with our website or services, we may collect the following types of personal information:</p>
    <ul>
      <li><strong>Identity &amp; Contact Data:</strong> Full name, email address, phone number, and company name when you submit a booking inquiry, tour request, mailing list sign-up, or contact form.</li>
      <li><strong>Usage &amp; Technical Data:</strong> IP address, browser type, pages visited, time spent on site, and referral source, collected automatically through cookies and analytics tools for site improvement purposes.</li>
      <li><strong>Communication Data:</strong> Messages, feedback, or requests you send to us via email, contact forms, or social media.</li>
      <li><strong>Booking &amp; Transaction Data:</strong> Space type preferences, booking dates, pricing information, and related correspondence needed to process your reservation.</li>
    </ul>
    <p style="margin-top: 0.75rem;">We do not collect sensitive personal information (as defined under RA 10173) unless strictly necessary and with your explicit consent.</p>
  </div>

  <div class="legal-section">
    <h2>2. How We Use Your Information</h2>
    <p>We process your personal data only for the following legitimate purposes:</p>
    <ul>
      <li>To respond to your inquiries, tour bookings, and service requests.</li>
      <li>To send you relevant updates, newsletters, and promotional content — only with your consent and with an easy opt-out option.</li>
      <li>To improve our website, services, and user experience through analytics.</li>
      <li>To comply with our legal and regulatory obligations under Philippine law.</li>
      <li>To protect the security and integrity of our facilities, members, and staff.</li>
    </ul>
    <p style="margin-top: 0.75rem;">We will not sell, rent, or trade your personal information to third parties for their marketing purposes.</p>
  </div>

  <div class="legal-section">
    <h2>3. Legal Basis for Processing</h2>
    <p>Under the Data Privacy Act of 2012 and its IRR, we process your personal data on the following bases:</p>
    <ul>
      <li><strong>Consent:</strong> When you voluntarily submit your information through our website forms or subscribe to our mailing list.</li>
      <li><strong>Contractual Necessity:</strong> When processing is required to fulfill a booking or service agreement.</li>
      <li><strong>Legitimate Interests:</strong> When we need to maintain site security, prevent fraud, or improve our services, provided this does not override your rights.</li>
      <li><strong>Legal Obligation:</strong> When required by applicable Philippine laws and regulations.</li>
    </ul>
  </div>

  <div class="legal-section">
    <h2>4. Sharing Your Information</h2>
    <p>We may share your personal data with:</p>
    <ul>
      <li><strong>Service Providers:</strong> Trusted third-party partners (e.g., email platform providers, analytics tools) who assist us in operating our website and services, bound by strict confidentiality obligations.</li>
      <li><strong>Kings Group of Companies:</strong> Our affiliated brands — The Social Manila, Kings Manpower, The Social Manila Bakehouse, and Home Culinary School — only where necessary for coordinated service delivery and with your knowledge.</li>
      <li><strong>Government Authorities:</strong> Where required by law, court order, or lawful request from Philippine regulatory bodies such as the National Privacy Commission (NPC).</li>
    </ul>
    <p style="margin-top: 0.75rem;">We do not transfer your personal data outside the Philippines without appropriate safeguards as required by the NPC.</p>
  </div>

  <div class="legal-section">
    <h2>5. Data Retention</h2>
    <p>We retain your personal data only for as long as necessary to fulfill the purposes for which it was collected, or as required by Philippine law. Booking and transaction records are retained for a minimum of five (5) years in compliance with applicable regulations. Mailing list subscriptions are maintained until you unsubscribe or request deletion.</p>
  </div>

  <div class="legal-section">
    <h2>6. Cookies</h2>
    <p>Our website uses cookies and similar tracking technologies to enhance your browsing experience and analyze site usage. You may disable cookies through your browser settings; however, some features of the site may not function correctly without them.</p>
  </div>

  <div class="legal-section">
    <h2>7. Your Rights Under RA 10173</h2>
    <p>As a data subject under the Data Privacy Act of 2012, you have the following rights:</p>
    <ul>
      <li><strong>Right to be Informed:</strong> To know how your data is being collected and processed.</li>
      <li><strong>Right to Access:</strong> To obtain a copy of your personal data that we hold.</li>
      <li><strong>Right to Rectification:</strong> To correct inaccurate or incomplete data.</li>
      <li><strong>Right to Erasure or Blocking:</strong> To request deletion or suspension of your data under certain conditions.</li>
      <li><strong>Right to Object:</strong> To object to the processing of your data for direct marketing or other purposes.</li>
      <li><strong>Right to Data Portability:</strong> To receive your data in a structured, commonly used format.</li>
      <li><strong>Right to Lodge a Complaint:</strong> To file a complaint with the <strong>National Privacy Commission (NPC)</strong> at <a href="https://www.privacy.gov.ph" target="_blank" rel="noopener noreferrer">www.privacy.gov.ph</a>.</li>
    </ul>
  </div>

  <div class="legal-section">
    <h2>8. Data Security</h2>
    <p>We implement appropriate technical and organizational security measures to protect your personal data against unauthorized access, disclosure, alteration, or destruction. In the event of a personal data breach that is likely to harm your rights and freedoms, we will notify the NPC and affected individuals in accordance with RA 10173.</p>
  </div>

  <div class="legal-section">
    <h2>9. Changes to This Policy</h2>
    <p>We may update this Privacy Policy from time to time to reflect changes in our practices or legal requirements. The updated version will be posted on this page with a revised effective date. We encourage you to review this policy periodically.</p>
  </div>

  <div class="legal-section">
    <h2>10. Contact Our Data Protection Officer</h2>
    <p>For questions, concerns, or requests regarding your personal data, please contact us:</p>
    <ul>
      <li><strong>The Kings City Club — Data Protection Officer</strong></li>
      <li>Email: <a href="mailto:dpo@kingscity.com.ph">dpo@kingscity.com.ph</a></li>
      <li>Address: The Kings City Club, Metro Manila, Philippines</li>
    </ul>
    <p style="margin-top: 0.75rem;">You may also reach us via our <a href="<?php echo $home_url; ?>">website contact form</a>.</p>
  </div>

</div>
</section>

</main>

<?php get_footer(); ?>
