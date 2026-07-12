<?php
if (!defined('ABSPATH')) exit;
/* Template Name: Term of Use */
get_header();

$home_url        = esc_url( home_url('/') );
$privacy_url     = kc_get_page_url( 'page-privacy-policy.php', '/privacy-policy/' );
$effective       = date('F j, Y');
?>

<main id="main-content">

<!-- hero -->
<section class="hero premium-hero">
<div class="container grid-12">
<div class="col-12 split split--media-right">
<div class="split__content animate-fadeInUp hero__content--index">
  <span class="text-overline hero__overline">Legal &amp; Compliance</span>
  <h1 class="hero__title hero__title--inner">Terms<br>of Use</h1>
  <p class="hero__subtitle">The rules and conditions that govern your use of our website and services.</p>
</div>
<div class="split__media" style="position: relative; aspect-ratio: 4/3; overflow: hidden; border-radius: var(--radius-card);">
  <img alt="Kings City Club Terms of Use"
       src="<?php echo kc_img('terms_hero_img', 'page-about-img/kings-img55.webp'); ?>"
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
    Please read these Terms of Use carefully before accessing or using the Kings City Club website and services. By visiting our website, submitting an inquiry, or booking a tour, you agree to be bound by these Terms. If you do not agree, please discontinue use of the site immediately. These Terms are governed by the laws of the <strong>Republic of the Philippines</strong>.
  </p>
  <p style="color: var(--color-text-muted); font-size: 0.9rem; margin-bottom: var(--space-2xl);"><em>Effective Date: <?php echo esc_html($effective); ?> &nbsp;|&nbsp; Last Updated: <?php echo esc_html($effective); ?></em></p>

  <style>
  .legal-section { margin-bottom: var(--space-2xl); }
  .legal-section h2 { font-family: var(--font-heading); color: var(--color-primary); font-size: clamp(1rem, 2vw, 1.25rem); text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: var(--space-sm); padding-bottom: 0.5rem; border-bottom: 2px solid var(--color-primary); }
  .legal-section p, .legal-section li { color: var(--color-text-muted); line-height: 1.9; font-size: 1rem; }
  .legal-section ul { padding-left: 1.5rem; margin-top: 0.75rem; }
  .legal-section li { margin-bottom: 0.5rem; }
  .legal-section a { color: var(--color-primary); }
  </style>

  <div class="legal-section">
    <h2>1. Acceptance of Terms</h2>
    <p>By accessing and using the Kings City Club website and related sub-domains, you acknowledge that you have read, understood, and agree to be bound by these Terms of Use and our <a href="<?php echo $privacy_url; ?>">Privacy Policy</a>. These Terms apply to all visitors, users, and members who access or use our website and services.</p>
    <p style="margin-top: 0.75rem;">We reserve the right to modify these Terms at any time. Continued use of the website after any such changes constitutes your acceptance of the new Terms.</p>
  </div>

  <div class="legal-section">
    <h2>2. About Kings City Club</h2>
    <p>The Kings City Club is a premium coworking and business community in Metro Manila, Philippines, offering flexible workspace solutions including coworking desks, private offices, meeting rooms, enterprise suites, and virtual office services. Our website facilitates tour bookings, space inquiries, membership applications, and community engagement.</p>
  </div>

  <div class="legal-section">
    <h2>3. Use of the Website</h2>
    <p>You agree to use this website only for lawful purposes and in a manner that does not infringe the rights of others. You must not:</p>
    <ul>
      <li>Use the site in any way that violates applicable Philippine laws and regulations.</li>
      <li>Transmit unsolicited commercial communications (spam).</li>
      <li>Attempt to gain unauthorized access to any part of the website, server, or database.</li>
      <li>Upload or transmit any malware, viruses, or harmful code.</li>
      <li>Collect or harvest personal data from the website without our express written consent.</li>
      <li>Reproduce, duplicate, copy, or resell any part of our website content without authorization.</li>
    </ul>
  </div>

  <div class="legal-section">
    <h2>4. Intellectual Property</h2>
    <p>All content on this website — including text, graphics, logos, photographs, videos, icons, and software — is the property of <strong>The Kings City Club</strong> and its affiliated brands, protected under the <strong>Intellectual Property Code of the Philippines (Republic Act No. 8293)</strong>.</p>
    <p style="margin-top: 0.75rem;">You may not reproduce, distribute, modify, or create derivative works from any content on this site without our prior written permission.</p>
  </div>

  <div class="legal-section">
    <h2>5. Booking &amp; Reservations</h2>
    <p>Tour bookings and space reservation inquiries submitted through our website are subject to availability and our internal booking policies. Submission of a booking request does not guarantee a confirmed reservation. We will contact you to confirm availability and finalize your booking.</p>
    <p style="margin-top: 0.75rem;">Kings City Club reserves the right to refuse or cancel a booking at its sole discretion, including in cases of suspected fraud, misrepresentation, or violation of these Terms.</p>
  </div>

  <div class="legal-section">
    <h2>6. Limitation of Liability</h2>
    <p>To the maximum extent permitted by applicable Philippine law, The Kings City Club shall not be liable for any indirect, incidental, special, consequential, or punitive damages arising from your use of, or inability to use, the website or its content.</p>
    <p style="margin-top: 0.75rem;">While we strive to ensure that information on our website is accurate and up to date, we do not warrant that it is complete, current, or error-free. We reserve the right to change or remove content at any time without notice.</p>
  </div>

  <div class="legal-section">
    <h2>7. Third-Party Links</h2>
    <p>Our website may contain links to third-party websites for your convenience. We have no control over the content or privacy practices of those sites and accept no responsibility for them. Visiting third-party links is at your own risk.</p>
  </div>

  <div class="legal-section">
    <h2>8. User-Submitted Content</h2>
    <p>If you submit content to us (such as inquiries, testimonials, or feedback), you grant The Kings City Club a non-exclusive, royalty-free, worldwide license to use, reproduce, and display that content in connection with our services and marketing, unless you explicitly request otherwise.</p>
  </div>

  <div class="legal-section">
    <h2>9. Disclaimer of Warranties</h2>
    <p>The website and its content are provided on an "as is" and "as available" basis without warranties of any kind, whether express or implied. We do not warrant that the website will be uninterrupted, secure, or free from errors or viruses. Your use of the website is entirely at your own risk.</p>
  </div>

  <div class="legal-section">
    <h2>10. Governing Law &amp; Jurisdiction</h2>
    <p>These Terms of Use shall be governed by and construed in accordance with the laws of the <strong>Republic of the Philippines</strong>. Any disputes arising from or in connection with these Terms shall be subject to the exclusive jurisdiction of the appropriate courts of <strong>Metro Manila, Philippines</strong>.</p>
  </div>

  <div class="legal-section">
    <h2>11. Privacy</h2>
    <p>Your use of this website is also governed by our <a href="<?php echo $privacy_url; ?>">Privacy Policy</a>, which is incorporated into these Terms by reference. Please review it to understand our practices regarding your personal data under the <strong>Data Privacy Act of 2012 (RA 10173)</strong>.</p>
  </div>

  <div class="legal-section">
    <h2>12. Contact Us</h2>
    <p>If you have any questions about these Terms of Use, please contact us:</p>
    <ul>
      <li><strong>The Kings City Club</strong></li>
      <li>Email: <a href="mailto:hello@kingscity.com.ph">hello@kingscity.com.ph</a></li>
      <li>Address: The Kings City Club, Metro Manila, Philippines</li>
      <li>Website: <a href="<?php echo $home_url; ?>">kingscity.com.ph</a></li>
    </ul>
  </div>

</div>
</section>

</main>

<?php get_footer(); ?>
