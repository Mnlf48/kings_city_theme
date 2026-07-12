<?php
if (!defined('ABSPATH')) exit;
/* Template Name: Term of Use */
get_header();
?>

<main id="main-content">

<!-- hero section -->
<section class="hero premium-hero">
<div class="container grid-12">
<div class="col-12 split split--media-right">
<!-- text on left -->
<div class="split__content animate-fadeInUp hero__content--index">
<span class="text-overline hero__overline">Legal &amp; Compliance</span>
<h1 class="hero__title hero__title--inner">Terms<br>of Use</h1>
<p class="hero__subtitle">The rules and conditions that govern your use of our website and services.</p>
</div>
<!-- image on right -->
<div class="split__media" style="position: relative; aspect-ratio: 4/3; overflow: hidden; border-radius: var(--radius-card);">
<img alt="Kings City Club Terms of Use" src="<?php echo kc_img('terms_hero_img', 'page-about-img/kings-img55.webp'); ?>" style="position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover;" loading="eager"/>
</div>
</div>
</div>
</section>

<!-- intro -->
<section class="section content-panel bg-ivory" style="position: relative; overflow: hidden;">
<div class="container" style="max-width: 860px; position: relative; z-index: 2;">
<p style="color: var(--color-text-muted); line-height: 1.9; font-size: 1.05rem; margin-bottom: var(--space-md);">
Please read these Terms of Use carefully before accessing or using the Kings City Club website and services. By visiting our website, submitting an inquiry, or booking a tour, you agree to be bound by these Terms. If you do not agree, please discontinue use of the site immediately. These Terms are governed by the laws of the <strong>Republic of the Philippines</strong>.
</p>
<p style="color: var(--color-text-muted); line-height: 1.9; font-size: 0.95rem;">
<em>Effective Date: <?php echo date('F j, Y'); ?> &nbsp;|&nbsp; Last Updated: <?php echo date('F j, Y'); ?></em>
</p>
</div>
</section>

<!-- content sections -->
<section class="section content-panel bg-blush" style="position: relative; overflow: hidden;">
<div class="container" style="max-width: 860px; position: relative; z-index: 2;">

  <?php
  $sections = array(
    array(
      'title' => '1. Acceptance of Terms',
      'body'  => '
        <p>By accessing and using the Kings City Club website (<strong>kingscity.com.ph</strong> and related sub-domains), you acknowledge that you have read, understood, and agree to be bound by these Terms of Use and our Privacy Policy. These Terms apply to all visitors, users, and members who access or use our website and services.</p>
        <p>We reserve the right to modify these Terms at any time. Continued use of the website after any such changes constitutes your acceptance of the new Terms.</p>
      ',
    ),
    array(
      'title' => '2. About Kings City Club',
      'body'  => '
        <p>The Kings City Club is a premium coworking and business community in Metro Manila, Philippines, offering flexible workspace solutions including coworking desks, private offices, meeting rooms, enterprise suites, and virtual office services. Our website facilitates tour bookings, space inquiries, membership applications, and community engagement.</p>
      ',
    ),
    array(
      'title' => '3. Use of the Website',
      'body'  => '
        <p>You agree to use this website only for lawful purposes and in a manner that does not infringe the rights of others. You must not:</p>
        <ul>
          <li>Use the site in any way that violates applicable Philippine laws and regulations.</li>
          <li>Transmit unsolicited commercial communications (spam).</li>
          <li>Attempt to gain unauthorized access to any part of the website, server, or database.</li>
          <li>Upload or transmit any malware, viruses, or harmful code.</li>
          <li>Collect or harvest personal data from the website without our express written consent.</li>
          <li>Reproduce, duplicate, copy, or resell any part of our website content without authorization.</li>
        </ul>
      ',
    ),
    array(
      'title' => '4. Intellectual Property',
      'body'  => '
        <p>All content on this website — including but not limited to text, graphics, logos, photographs, videos, icons, and software — is the property of <strong>The Kings City Club</strong> and its affiliated brands, and is protected under Philippine intellectual property laws including the <strong>Intellectual Property Code of the Philippines (Republic Act No. 8293)</strong>.</p>
        <p>You may not reproduce, distribute, modify, or create derivative works from any content on this site without our prior written permission. Limited personal, non-commercial use is permitted provided you do not remove any copyright or proprietary notices.</p>
      ',
    ),
    array(
      'title' => '5. Booking &amp; Reservations',
      'body'  => '
        <p>Tour bookings and space reservation inquiries submitted through our website are subject to availability and our internal booking policies. Submission of a booking request does not guarantee a confirmed reservation. We will contact you to confirm availability and finalize your booking.</p>
        <p>Kings City Club reserves the right to refuse or cancel a booking at its sole discretion, including in cases of suspected fraud, misrepresentation, or violation of these Terms.</p>
      ',
    ),
    array(
      'title' => '6. Limitation of Liability',
      'body'  => '
        <p>To the maximum extent permitted by applicable Philippine law, The Kings City Club shall not be liable for any indirect, incidental, special, consequential, or punitive damages arising from your use of, or inability to use, the website or its content.</p>
        <p>While we strive to ensure that information on our website is accurate and up to date, we do not warrant that it is complete, current, or error-free. We reserve the right to change or remove content at any time without notice.</p>
      ',
    ),
    array(
      'title' => '7. Third-Party Links',
      'body'  => '
        <p>Our website may contain links to third-party websites for your convenience. We have no control over the content or privacy practices of those sites and accept no responsibility for them. Visiting third-party links is at your own risk, and we encourage you to review their respective terms and privacy policies.</p>
      ',
    ),
    array(
      'title' => '8. User-Submitted Content',
      'body'  => '
        <p>If you submit content to us (such as inquiries, testimonials, or feedback), you grant The Kings City Club a non-exclusive, royalty-free, worldwide license to use, reproduce, and display that content in connection with our services and marketing, unless you explicitly request otherwise.</p>
        <p>You represent that any content you submit is accurate, does not violate any third-party rights, and complies with applicable laws.</p>
      ',
    ),
    array(
      'title' => '9. Disclaimer of Warranties',
      'body'  => '
        <p>The website and its content are provided on an "as is" and "as available" basis without warranties of any kind, whether express or implied. We do not warrant that the website will be uninterrupted, secure, or free from errors or viruses. Your use of the website is entirely at your own risk.</p>
      ',
    ),
    array(
      'title' => '10. Governing Law &amp; Jurisdiction',
      'body'  => '
        <p>These Terms of Use shall be governed by and construed in accordance with the laws of the <strong>Republic of the Philippines</strong>. Any disputes arising from or in connection with these Terms shall be subject to the exclusive jurisdiction of the appropriate courts of <strong>Metro Manila, Philippines</strong>.</p>
      ',
    ),
    array(
      'title' => '11. Privacy',
      'body'  => '
        <p>Your use of this website is also governed by our <a href="' . esc_url( kc_get_page_url('page-privacy-policy.php', '/privacy-policy/') ) . '" style="color: var(--color-primary);">Privacy Policy</a>, which is incorporated into these Terms by reference. Please review it to understand our practices regarding your personal data under the <strong>Data Privacy Act of 2012 (RA 10173)</strong>.</p>
      ',
    ),
    array(
      'title' => '12. Contact Us',
      'body'  => '
        <p>If you have any questions about these Terms of Use, please contact us:</p>
        <ul>
          <li><strong>The Kings City Club</strong></li>
          <li>Email: <a href="mailto:hello@kingscity.com.ph" style="color: var(--color-primary);">hello@kingscity.com.ph</a></li>
          <li>Address: The Kings City Club, Metro Manila, Philippines</li>
          <li>Website: <a href="' . esc_url( home_url('/') ) . '" style="color: var(--color-primary);">kingscity.com.ph</a></li>
        </ul>
      ',
    ),
  );

  foreach ($sections as $i => $s) :
    $bg = ($i % 2 === 0) ? 'transparent' : 'rgba(189,69,31,0.04)';
  ?>
  <div style="margin-bottom: var(--space-2xl); padding: var(--space-xl); background: <?php echo $bg; ?>; border-left: 4px solid var(--color-primary);">
    <h2 style="font-family: var(--font-heading); color: var(--color-primary); font-size: clamp(1.1rem, 2vw, 1.4rem); text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: var(--space-md);"><?php echo esc_html($s['title']); ?></h2>
    <div style="color: var(--color-text-muted); line-height: 1.9; font-size: 1rem;">
      <?php echo wp_kses_post($s['body']); ?>
    </div>
  </div>
  <?php endforeach; ?>

</div>
</section>

</main>

<?php get_footer(); ?>
