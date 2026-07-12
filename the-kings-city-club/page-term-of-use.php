<?php
if (!defined('ABSPATH')) exit;
/* Template Name: Term of Use */
get_header();

$home_url    = esc_url( home_url('/') );
$privacy_url = kc_get_page_url( 'page-privacy-policy.php', '/privacy-policy/' );
$effective   = date('F j, Y');

// Hero
$tu_overline = get_field('tu_hero_overline') ?: 'Legal & Compliance';
$tu_heading  = get_field('tu_hero_heading')  ?: 'Terms of Use';
$tu_subtitle = get_field('tu_hero_subtitle') ?: 'The rules and conditions that govern your use of our website and services.';

// Intro
$tu_intro_text = get_field('tu_intro_text');

// Section headings + bodies
$tu_s1_heading  = get_field('tu_s1_heading')  ?: '1. Acceptance of Terms';
$tu_s1_body     = get_field('tu_s1_body');
$tu_s2_heading  = get_field('tu_s2_heading')  ?: '2. Description of Services & Site Scope';
$tu_s2_body     = get_field('tu_s2_body');
$tu_s3_heading  = get_field('tu_s3_heading')  ?: '3. User Representation & Eligibility';
$tu_s3_body     = get_field('tu_s3_body');
$tu_s4_heading  = get_field('tu_s4_heading')  ?: '4. Tour Bookings & Space Reservations';
$tu_s4_body     = get_field('tu_s4_body');
$tu_s5_heading  = get_field('tu_s5_heading')  ?: '5. Inquiries & Quote Requests';
$tu_s5_body     = get_field('tu_s5_body');
$tu_s6_heading  = get_field('tu_s6_heading')  ?: '6. Intellectual Property Rights';
$tu_s6_body     = get_field('tu_s6_body');
$tu_s7_heading  = get_field('tu_s7_heading')  ?: '7. Prohibited Code of Conduct';
$tu_s7_body     = get_field('tu_s7_body');
$tu_s8_heading  = get_field('tu_s8_heading')  ?: '8. Disclaimer of Warranties';
$tu_s8_body     = get_field('tu_s8_body');
$tu_s9_heading  = get_field('tu_s9_heading')  ?: '9. Limitation of Liability';
$tu_s9_body     = get_field('tu_s9_body');
$tu_s10_heading = get_field('tu_s10_heading') ?: '10. Indemnification';
$tu_s10_body    = get_field('tu_s10_body');
$tu_s11_heading = get_field('tu_s11_heading') ?: '11. Dispute Resolution & Governing Law';
$tu_s11_body    = get_field('tu_s11_body');
$tu_s12_heading = get_field('tu_s12_heading') ?: '12. General Provisions';
$tu_s12_body    = get_field('tu_s12_body');

// Section 13 — Contact (structured fields)
$tu_s13_heading = get_field('tu_s13_heading')     ?: '13. Contact Information & Legal Inquiries';
$tu_s13_intro   = get_field('tu_s13_intro')       ?: 'For questions, formal notices, or legal inquiries regarding these Terms, please contact us:';
$tu_contact_email   = get_field('tu_contact_email')   ?: 'hello@kingscity.com.ph';
$tu_contact_phone   = get_field('tu_contact_phone')   ?: '+63 (2) 8776-6712';
$tu_contact_address = get_field('tu_contact_address') ?: '100 Doña Soledad Ave, Better Living Subdivision, Parañaque City 1711, Metro Manila, Philippines';
?>

<main id="main-content">

<!-- hero -->
<section class="hero premium-hero">
<div class="container grid-12">
<div class="col-12 split split--media-right">
<div class="split__content animate-fadeInUp hero__content--index">
  <span class="text-overline hero__overline"><?php echo esc_html($tu_overline); ?></span>
  <h1 class="hero__title hero__title--inner"><?php echo esc_html($tu_heading); ?></h1>
  <p class="hero__subtitle"><?php echo esc_html($tu_subtitle); ?></p>
</div>
<div class="split__media hero__slider" id="hero-slider" style="position: relative; aspect-ratio: 4/3; overflow: hidden; border-radius: var(--radius-card);">
  <img class="hero__slide is-active" alt="Kings City Club exterior"
       src="<?php echo kc_img('tu_hero_img1', 'front-page-img/kings_img02.webp'); ?>"
       style="position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; opacity: 1; transition: opacity 1s ease-in-out;"
       loading="eager"/>
  <img class="hero__slide" alt="Welcome to Kings City"
       src="<?php echo kc_img('tu_hero_img2', 'page-about-img/kings-img30.webp'); ?>"
       style="position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; opacity: 0; transition: opacity 1s ease-in-out;"
       loading="eager"/>
  <img class="hero__slide" alt="Kings City Club staircase"
       src="<?php echo kc_img('tu_hero_img3', 'page-impact-img/kings_img03.webp'); ?>"
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
  .legal-section p, .legal-section li { color: var(--color-text-muted); line-height: 1.7; font-size: 1rem; }
  .legal-section ul { padding-left: 1.5rem; margin-top: 0.5rem; }
  .legal-section li { margin-bottom: 0.4rem; }
  .legal-section a { color: var(--color-primary); }
  .legal-npc-box { margin-top: var(--space-md); background: var(--color-bg-blush); border-left: 3px solid var(--color-primary); padding: 1rem 1.25rem; font-size: 0.95rem; color: var(--color-text-muted); line-height: 1.6; }
  </style>

  <?php if ( $tu_intro_text ) : ?>
    <div class="legal-lead"><?php echo wp_kses_post($tu_intro_text); ?></div>
  <?php else : ?>
  <p class="legal-lead">
    These Terms of Use govern your access to and use of the <strong>Kings City Club</strong> website and all related services — including workspace inquiries, tour bookings, membership applications, and community engagement. Please read them carefully before proceeding. They are governed by the laws of the <strong>Republic of the Philippines</strong> and apply to all visitors, inquirers, and members of the Site.
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
    <h2><?php echo esc_html($tu_s1_heading); ?></h2>
    <?php if ( $tu_s1_body ) : echo wp_kses_post($tu_s1_body); else : ?>
    <p>By accessing, browsing, or using the Kings City Club website and its affiliated sub-domains, you acknowledge that you have read, understood, and agree to be bound by these Terms of Use along with our <a href="<?php echo $privacy_url; ?>">Privacy Policy</a>. These Terms apply to all visitors, inquirers, booking clients, and members who access or use our website and services. We reserve the right to modify these Terms at any time. Continued use of the website after any such changes constitutes your acceptance of the updated Terms.</p>
    <?php endif; ?>
  </div>

  <!-- Section 2 -->
  <div class="legal-section">
    <h2><?php echo esc_html($tu_s2_heading); ?></h2>
    <?php if ( $tu_s2_body ) : echo wp_kses_post($tu_s2_body); else : ?>
    <p>The Kings City Club ("Kings City," "we," "us," "our") is a premium coworking and business community in Metro Manila, Philippines. The Site provides information regarding our workspace solutions — including coworking desks, private offices, meeting rooms, enterprise suites, and virtual office services — as well as our affiliated business brands under the Kings Group of Companies. The Site facilitates tour bookings, space inquiries, membership applications, quote requests, and community engagement with our members and partners.</p>
    <?php endif; ?>
  </div>

  <!-- Section 3 -->
  <div class="legal-section">
    <h2><?php echo esc_html($tu_s3_heading); ?></h2>
    <?php if ( $tu_s3_body ) : echo wp_kses_post($tu_s3_body); else : ?>
    <p>By accessing the Site or utilizing any inquiry or booking services, you represent and warrant that:</p>
    <ul>
      <li>You are at least eighteen (18) years of age or have reached the legal age of majority in your jurisdiction.</li>
      <li>You possess the legal capacity and authority to enter into these binding Terms.</li>
      <li>All information you submit to the Site (including contact details, business information, and booking preferences) is genuine, accurate, and completely truthful.</li>
      <li>Your use of the Site does not violate any applicable local, national, or international laws or regulations.</li>
    </ul>
    <?php endif; ?>
  </div>

  <!-- Section 4 -->
  <div class="legal-section">
    <h2><?php echo esc_html($tu_s4_heading); ?></h2>
    <?php if ( $tu_s4_body ) : echo wp_kses_post($tu_s4_body); else : ?>
    <p>When you submit a tour booking or space reservation inquiry through our Site:</p>
    <ul>
      <li><strong>Availability Subject to Confirmation:</strong> Submission of a booking request does not guarantee a confirmed reservation. We will contact you to confirm availability and finalize your booking based on current space availability and our internal scheduling policies.</li>
      <li><strong>Accurate Information:</strong> You agree to provide truthful and complete information in all booking forms. Providing false or misleading information may result in cancellation of your booking and potential restriction from future use of our services.</li>
      <li><strong>Right to Refuse:</strong> Kings City Club reserves the right to refuse or cancel a booking at its sole discretion, including in cases of suspected fraud, misrepresentation, or violation of these Terms.</li>
      <li><strong>No Guarantee of Placement:</strong> Submitting a tour request or inquiry does not guarantee membership, a specific workspace assignment, or pricing lock-in until a formal agreement is executed.</li>
    </ul>
    <?php endif; ?>
  </div>

  <!-- Section 5 -->
  <div class="legal-section">
    <h2><?php echo esc_html($tu_s5_heading); ?></h2>
    <?php if ( $tu_s5_body ) : echo wp_kses_post($tu_s5_body); else : ?>
    <p>For prospective clients or partners requesting service proposals or workspace pricing:</p>
    <ul>
      <li>All generated quotes, estimates, and configurations are for informational purposes only and do not constitute a formal, binding contract or guaranteed pricing.</li>
      <li>Actual service fees, membership rates, and workspace terms will be dictated solely by a formally executed Service Agreement (B2B Contract) signed by authorized representatives of both parties.</li>
      <li>Kings City Club reserves the right to adjust pricing, availability, and service offerings at any time without prior notice through the Site.</li>
    </ul>
    <?php endif; ?>
  </div>

  <!-- Section 6 -->
  <div class="legal-section">
    <h2><?php echo esc_html($tu_s6_heading); ?></h2>
    <?php if ( $tu_s6_body ) : echo wp_kses_post($tu_s6_body); else : ?>
    <p>All materials published on or available through the Site — including text, graphics, logos, photographs, videos, brand assets, design systems, code structures, scripts, and software — are the exclusive property of <strong>The Kings City Club</strong> and its affiliated brands, protected under the <strong>Intellectual Property Code of the Philippines (Republic Act No. 8293)</strong> and applicable international copyright and trademark laws.</p>
    <p style="margin-top: 0.75rem;">You are granted a limited, non-exclusive, non-transferable, and revocable license to access the Site for personal, non-commercial use or legitimate business evaluation. You may not extract, scrape, copy, modify, republish, or distribute any site content without our prior written authorization.</p>
    <?php endif; ?>
  </div>

  <!-- Section 7 -->
  <div class="legal-section">
    <h2><?php echo esc_html($tu_s7_heading); ?></h2>
    <?php if ( $tu_s7_body ) : echo wp_kses_post($tu_s7_body); else : ?>
    <p>You agree not to engage in any of the following prohibited behaviors:</p>
    <ul>
      <li>Submitting fraudulent, defamatory, offensive, or harassing content through any form on the Site.</li>
      <li>Using web scrapers, spiders, robots, crawlers, or other automated mechanisms to download, monitor, or extract data from the Site without explicit consent.</li>
      <li>Engaging in reverse-engineering, decompiling, or attempting to extract source code or core structure of the Site or its databases.</li>
      <li>Attempting to bypass security protocols, authentication barriers, or any access-control mechanisms on the Site.</li>
      <li>Transmitting malware, viruses, trojans, logic bombs, or any script designed to compromise site performance or server resources.</li>
      <li>Impersonating Kings City Club staff, members, or affiliated brand representatives in any communication originating from or directed to our platforms.</li>
    </ul>
    <?php endif; ?>
  </div>

  <!-- Section 8 -->
  <div class="legal-section">
    <h2><?php echo esc_html($tu_s8_heading); ?></h2>
    <?php if ( $tu_s8_body ) : echo wp_kses_post($tu_s8_body); else : ?>
    <p>The Site and all services, content, and information are provided on an "as is" and "as available" basis without warranties of any kind, either express or implied. To the fullest extent permissible under applicable Philippine law, Kings City Club disclaims all warranties, including but not limited to implied warranties of merchantability, fitness for a particular purpose, non-infringement, security, and accuracy. We do not warrant that the Site will operate uninterrupted, error-free, or free of viruses or other harmful elements.</p>
    <?php endif; ?>
  </div>

  <!-- Section 9 -->
  <div class="legal-section">
    <h2><?php echo esc_html($tu_s9_heading); ?></h2>
    <?php if ( $tu_s9_body ) : echo wp_kses_post($tu_s9_body); else : ?>
    <p>To the maximum extent permitted by applicable Philippine law, Kings City Club, its directors, officers, members, employees, and affiliates shall not be liable for any direct, indirect, incidental, special, consequential, or exemplary damages, including but not limited to loss of profits, goodwill, data, career opportunities, or business interruption, arising out of or in connection with:</p>
    <ul>
      <li>Your use of, or inability to use, the Site or its booking and inquiry portals.</li>
      <li>Any unauthorized access to, alteration of, or disclosure of your data submissions.</li>
      <li>Falsified communications or impersonation schemes carried out by third parties pretending to represent Kings City Club outside our verified email domains.</li>
    </ul>
    <?php endif; ?>
  </div>

  <!-- Section 10 -->
  <div class="legal-section">
    <h2><?php echo esc_html($tu_s10_heading); ?></h2>
    <?php if ( $tu_s10_body ) : echo wp_kses_post($tu_s10_body); else : ?>
    <p>You agree to defend, indemnify, and hold harmless Kings City Club, its directors, officers, employees, and members from and against any claims, liabilities, damages, judgments, awards, losses, costs, expenses, or fees (including reasonable attorneys' fees) arising out of or relating to your violation of these Terms or your misuse of the Site, including but not limited to the submission of fraudulent credentials or violation of third-party intellectual property rights.</p>
    <?php endif; ?>
  </div>

  <!-- Section 11 -->
  <div class="legal-section">
    <h2><?php echo esc_html($tu_s11_heading); ?></h2>
    <?php if ( $tu_s11_body ) : echo wp_kses_post($tu_s11_body); else : ?>
    <p>These Terms and any dispute arising out of your use of the Site shall be governed by, interpreted, and enforced in accordance with the laws of the <strong>Republic of the Philippines</strong>. In the event of a dispute, you agree to first submit the matter to amicable mediation and consultation. Should mediation fail, any legal action, suit, or proceeding arising out of or relating to these Terms shall be instituted exclusively in the proper courts of <strong>Parañaque City, Metro Manila, Philippines</strong>, to the exclusion of all other venues.</p>
    <?php endif; ?>
  </div>

  <!-- Section 12 -->
  <div class="legal-section">
    <h2><?php echo esc_html($tu_s12_heading); ?></h2>
    <?php if ( $tu_s12_body ) : echo wp_kses_post($tu_s12_body); else : ?>
    <ul>
      <li><strong>Severability:</strong> If any provision of these Terms is found to be invalid or unenforceable by a court of competent jurisdiction, the remaining provisions shall remain in full force and effect.</li>
      <li><strong>No Waiver:</strong> Our failure to enforce any right or provision of these Terms does not constitute a waiver of such right or provision.</li>
      <li><strong>Entire Agreement:</strong> These Terms constitute the entire agreement between you and Kings City Club regarding the use of the Site, superseding all prior understandings.</li>
      <li><strong>Privacy Policy:</strong> Your use of the Site is also governed by our <a href="<?php echo $privacy_url; ?>">Privacy Policy</a>, incorporated into these Terms by reference and aligned with the <strong>Data Privacy Act of 2012 (RA 10173)</strong>.</li>
    </ul>
    <?php endif; ?>
  </div>

  <!-- Section 13 -->
  <div class="legal-section">
    <h2><?php echo esc_html($tu_s13_heading); ?></h2>
    <p><?php echo esc_html($tu_s13_intro); ?></p>
    <ul>
      <li><strong>Email:</strong> <a href="mailto:<?php echo esc_attr($tu_contact_email); ?>"><?php echo esc_html($tu_contact_email); ?></a></li>
      <li><strong>Phone:</strong> <?php echo esc_html($tu_contact_phone); ?></li>
      <li><strong>Office Address:</strong> <?php echo esc_html($tu_contact_address); ?></li>
      <li><strong>Website:</strong> <a href="<?php echo $home_url; ?>">kingscity.com.ph</a></li>
    </ul>
  </div>

</div>
</section>

</main>

<?php get_footer(); ?>
