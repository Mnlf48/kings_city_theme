<?php
/* Template Name: Offshoring */
get_header();

// Resolve apply page URL by template name (safe — works regardless of slug)
$apply_page = get_pages( array( 'meta_key' => '_wp_page_template', 'meta_value' => 'page-apply.php' ) );
$apply_url  = ! empty( $apply_page ) ? esc_url( get_permalink( $apply_page[0]->ID ) ) : esc_url( home_url( '/apply/' ) );
?>

<main id="main-content">
<!-- hero section -->
<section class="hero premium-hero">
<div class="container grid-12">
<div class="col-12 split split--media-right">
<!-- text content on left -->
<div class="split__content animate-fadeInUp hero__content--index">
<span class="text-overline hero__overline"><?php echo get_field('overline_3'); ?></span>
<?php
  // Fetch ACF titles with fallbacks
  $h1_1 = get_field('h1_1') ? get_field('h1_1') : 'Build Your';
  $h1_2 = get_field('h1_2') ? get_field('h1_2') : 'Dedicated Team in The Philippines';

  // Prevent orphans for H1 #1
  $words1 = explode(' ', trim($h1_1));
  if (count($words1) >= 3) {
      $last_word = array_pop($words1);
      $second_to_last = array_pop($words1);
      $words1[] = $second_to_last . '&nbsp;' . $last_word;
      $h1_1 = implode(' ', $words1);
  }

  // Prevent orphans for H1 #2
  $words2 = explode(' ', trim($h1_2));
  if (count($words2) >= 3) {
      $last_word = array_pop($words2);
      $second_to_last = array_pop($words2);
      $words2[] = $second_to_last . '&nbsp;' . $last_word;
      $h1_2 = implode(' ', $words2);
  }
?>
<h1 class="hero__title hero__title--inner hero__welcome" style="margin-bottom: 0;"><?php echo $h1_1; ?></h1>
<h1 class="hero__title hero__title--inner hero__title--offshoring" style="text-wrap: balance;"><?php echo $h1_2; ?></h1>
<p class="hero__subtitle"><?php echo get_field('p_2'); ?></p>
<div class="hero__actions hero__actions--index">
<a class="btn" href="<?php echo $apply_url; ?>">
                Request a Consultation
              </a>
</div>
</div>
<!-- media on right -->
<div class="split__media hero__slider" id="hero-slider" style="position: relative; aspect-ratio: 4/3; overflow: hidden; border-radius: var(--radius-card);">
<!-- slide 1 -->
<img alt="Kings City Offshoring Space 1" class="hero__slide is-active" src="<?php $img = get_field('image_4'); echo ($img && is_array($img) && isset($img['url'])) ? esc_url($img['url']) : (is_numeric($img) ? wp_get_attachment_image_url($img, 'full') : get_template_directory_uri() . '/assets/img/placeholder.jpg'); ?>" style="position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; opacity: 1; transition: opacity 1s ease-in-out;"/>
<!-- slide 2 -->
<img alt="Kings City Offshoring Space 2" class="hero__slide" src="<?php $img = get_field('image_5'); echo ($img && is_array($img) && isset($img['url'])) ? esc_url($img['url']) : (is_numeric($img) ? wp_get_attachment_image_url($img, 'full') : get_template_directory_uri() . '/assets/img/placeholder.jpg'); ?>" style="position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; opacity: 0; transition: opacity 1s ease-in-out;"/>
<!-- slide 3 -->
<img alt="Kings City Offshoring Space 3" class="hero__slide" src="<?php $img = get_field('image_6'); echo ($img && is_array($img) && isset($img['url'])) ? esc_url($img['url']) : (is_numeric($img) ? wp_get_attachment_image_url($img, 'full') : get_template_directory_uri() . '/assets/img/placeholder.jpg'); ?>" style="position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; opacity: 0; transition: opacity 1s ease-in-out;"/>
</div>
</div>
</div>
</section>
<!-- offshoring process section -->
<section class="section content-panel" id="offshoring-process" style="position: relative; overflow: hidden;">
<!-- Background Confetti -->
<!-- 1. Top Left Heart -->
<!-- 2. Bottom Right Star -->
<div class="floating-bg-icon anim-float-fast" style="bottom: 10%; right: 5%; color: var(--color-accent-gold);">
  <svg viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" /></svg>
</div>
<!-- 3. Middle Right Circle -->
<div class="floating-bg-icon anim-pulse" style="top: 40%; right: 2%; color: var(--color-primary);">
  <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
</div>
<!-- 4. Bottom Left Star -->
<!-- 5. Top Center Circle -->
<div class="floating-bg-icon anim-float-fast" style="top: 5%; left: 45%; color: var(--color-accent-red);">
  <svg viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" /></svg>
</div>
<!-- 6. Top Right Heart -->
<div class="floating-bg-icon anim-pulse" style="top: 15%; right: 20%; color: var(--color-accent-gold);">
  <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
</div>
<!-- 7. Bottom Center Circle -->

<div class="container" style="position: relative; z-index: 2;">
<div class="text-center" style="margin-bottom: var(--space-2xl);">
<span class="text-overline"><?php echo get_field('overline_18'); ?></span>
<h2><?php echo get_field('h2_8'); ?></h2>
<p class="text-lead mx-auto" style="margin-top: var(--space-sm); max-width: 600px;"><?php echo get_field('p_13'); ?></p>
</div>
<div class="off-process-steps cycle-card-bg">
<!-- process card 1 -->
<div class="off-process-card card-glass">
<div class="universal-icon-wrapper">
<svg width="40" height="40" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<rect x="3" y="6" width="18" height="15" rx="2" fill="var(--color-bg-ivory)" stroke="var(--color-primary)" stroke-width="2"/>
<path d="M3 11H21" stroke="var(--color-primary)" stroke-width="2"/>
<path d="M8 3V7" stroke="var(--color-accent-red)" stroke-width="2" stroke-linecap="round"/>
<path d="M16 3V7" stroke="var(--color-accent-red)" stroke-width="2" stroke-linecap="round"/>
<rect x="7" y="14" width="4" height="4" rx="1" fill="var(--color-secondary)"/>
</svg>
</div>
<div class="off-process-card__img">
<img alt="Discovery &amp; Scoping Meeting" src="<?php $img = get_field('image_19'); echo ($img && is_array($img) && isset($img['url'])) ? esc_url($img['url']) : (is_numeric($img) ? wp_get_attachment_image_url($img, 'full') : get_template_directory_uri() . '/assets/img/placeholder.jpg'); ?>" style="width:100%; height:100%; object-fit:cover;"/>
</div>
<h3><?php echo get_field('h3_9'); ?></h3>
<p><?php echo get_field('p_14'); ?></p>
<div class="off-process-card__breakdown">
<strong>You do:</strong> Share your goals and role requirements<br/>
<strong>Kings City does:</strong> Prepares detailed job profiles and a scoped hiring plan
</div>
</div>
<!-- process card 2 -->
<div class="off-process-card card-glass">
<div class="universal-icon-wrapper">
<svg width="40" height="40" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<circle cx="10" cy="10" r="6" fill="var(--color-bg-ivory)" stroke="var(--color-primary)" stroke-width="2"/>
<path d="M15 15L21 21" stroke="var(--color-primary)" stroke-width="2" stroke-linecap="round"/>
<circle cx="10" cy="9" r="2" fill="var(--color-accent-red)"/>
<path d="M7 13C7 11.5 8.5 10.5 10 10.5C11.5 10.5 13 11.5 13 13" stroke="var(--color-secondary)" stroke-width="2" stroke-linecap="round"/>
</svg>
</div>
<div class="off-process-card__img">
<img alt="Talent Working in Office" src="<?php $img = get_field('image_20'); echo ($img && is_array($img) && isset($img['url'])) ? esc_url($img['url']) : (is_numeric($img) ? wp_get_attachment_image_url($img, 'full') : get_template_directory_uri() . '/assets/img/placeholder.jpg'); ?>" style="width:100%; height:100%; object-fit:cover;"/>
</div>
<h3><?php echo get_field('h3_10'); ?></h3>
<p><?php echo get_field('p_15'); ?></p>
<div class="off-process-card__breakdown">
<strong>You do:</strong> Review candidates and select who joins your team<br/>
<strong>Kings City does:</strong> Sourcing, screening, interviewing, and presenting the best fit
</div>
</div>
<!-- process card 3 -->
<div class="off-process-card card-glass">
<div class="universal-icon-wrapper">
<svg width="40" height="40" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" fill="var(--color-bg-ivory)" stroke="var(--color-primary)" stroke-width="2"/>
<path d="M8 12L11 15L16 9" stroke="var(--color-accent-red)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
<circle cx="12" cy="12" r="8" stroke="var(--color-secondary)" stroke-width="1.5" stroke-dasharray="4 4"/>
</svg>
</div>
<div class="off-process-card__img">
<img alt="Onboarding Consultation" src="<?php $img = get_field('image_21'); echo ($img && is_array($img) && isset($img['url'])) ? esc_url($img['url']) : (is_numeric($img) ? wp_get_attachment_image_url($img, 'full') : get_template_directory_uri() . '/assets/img/placeholder.jpg'); ?>" style="width:100%; height:100%; object-fit:cover;"/>
</div>
<h3><?php echo get_field('h3_11'); ?></h3>
<p><?php echo get_field('p_16'); ?></p>
<div class="off-process-card__breakdown">
<strong>You do:</strong> Define KPIs, workflows, and communication preferences<br/>
<strong>Kings City does:</strong> Workspace setup, IT infrastructure, HR onboarding, and compliance
</div>
</div>
<!-- process card 4 -->
<div class="off-process-card card-glass">
<div class="universal-icon-wrapper">
<svg width="40" height="40" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<rect x="3" y="14" width="4" height="7" rx="1" fill="var(--color-secondary)" stroke="var(--color-primary)" stroke-width="1.5"/>
<rect x="10" y="9" width="4" height="12" rx="1" fill="var(--color-accent-gold)" stroke="var(--color-primary)" stroke-width="1.5"/>
<rect x="17" y="3" width="4" height="18" rx="1" fill="var(--color-accent-red)" stroke="var(--color-primary)" stroke-width="1.5"/>
<path d="M4 12L10 6L14 9L20 2" stroke="var(--color-primary)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
</svg>
</div>
<div class="off-process-card__img">
<img alt="Team Member Productive in Office" src="<?php $img = get_field('image_22'); echo ($img && is_array($img) && isset($img['url'])) ? esc_url($img['url']) : (is_numeric($img) ? wp_get_attachment_image_url($img, 'full') : get_template_directory_uri() . '/assets/img/placeholder.jpg'); ?>" style="width:100%; height:100%; object-fit:cover;"/>
</div>
<h3><?php echo get_field('h3_12'); ?></h3>
<p><?php echo get_field('p_17'); ?></p>
<div class="off-process-card__breakdown">
<strong>You do:</strong> Direct your team's output, quality, and productivity<br/>
<strong>Kings City does:</strong> Payroll, benefits, compliance, facilities, and HR management
</div>
</div>
</div>
</div>
</section>
<!-- offshoring models section -->
<section class="section content-panel" id="offshoring-models" style="position: relative; overflow: hidden;">
<!-- Background Confetti -->
<div class="floating-bg-icon anim-float-fast" style="top: 15%; left: 8%; color: var(--color-secondary);">
  <svg viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" /></svg>
</div>
<div class="floating-bg-icon anim-pulse" style="bottom: 10%; right: 10%; color: var(--color-accent-gold);">
  <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
</div>
<div class="floating-bg-icon anim-float-fast" style="bottom: 20%; left: 15%; color: var(--color-secondary);">
  <svg viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" /></svg>
</div>

<div class="container" style="position: relative; z-index: 2;">
<div class="text-center" style="margin-bottom: var(--space-2xl);">
<span class="text-overline"><?php echo get_field('overline_models') ?: 'Our Service Models'; ?></span>
<h2><?php echo get_field('h2_models') ?: 'Two Ways to Build Your Team'; ?></h2>
<p class="text-lead mx-auto" style="margin-top: var(--space-sm); max-width: 650px;"><?php echo get_field('p_intro_models') ?: 'Whether you want a fully managed offshore division or targeted staff placement, we have a model that fits.'; ?></p>
</div>
<div class="off-models-container">
<!-- model 1 card -->
<div class="off-models-card off-models-card--pink card-glass">
<span class="text-overline" style="color: var(--color-primary);">Model 1</span>
<h3><?php echo get_field('h3_model1'); ?></h3>
<p class="off-models-card__desc"><?php echo get_field('p_model1'); ?></p>
<ul class="off-models-card__list">
<li><span class="badge badge--pink"><svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"></polyline></svg></span>Your team works exclusively for you full-time</li>
<li><span class="badge badge--pink"><svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"></polyline></svg></span>Fully managed facilities IT and disaster recovery</li>
<li><span class="badge badge--pink"><svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"></polyline></svg></span>Employee engagement and performance frameworks</li>
<li><span class="badge badge--pink"><svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"></polyline></svg></span>Best for businesses scaling a dedicated offshore division</li>
</ul>
<a class="btn btn--red off-models-btn" href="<?php echo get_field('model1_btn_url') ? esc_url(get_field('model1_btn_url')) : $apply_url; ?>"><?php echo get_field('model1_btn_text') ?: 'Get Started'; ?></a>
</div>
<!-- model 2 card -->
<div class="off-models-card off-models-card--terracotta card-glass">
<span class="text-overline" style="color: var(--color-bg-ivory);">Model 2</span>
<h3><?php echo get_field('h3_model2'); ?></h3>
<p class="off-models-card__desc"><?php echo get_field('p_model2'); ?></p>
<ul class="off-models-card__list">
<li><span class="badge badge--terracotta"><svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"></polyline></svg></span>Fixed fee per employee per month with no hidden costs</li>
<li><span class="badge badge--terracotta"><svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"></polyline></svg></span>First invoice only after your team starts working</li>
<li><span class="badge badge--terracotta"><svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"></polyline></svg></span>Communicate your way via Zoom Skype email or on-site</li>
<li><span class="badge badge--terracotta"><svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"></polyline></svg></span>Best for targeted hires and growing teams quickly</li>
</ul>
<a class="btn btn--glass-white off-models-btn" href="<?php echo get_field('model2_btn_url') ? esc_url(get_field('model2_btn_url')) : $apply_url; ?>"><?php echo get_field('model2_btn_text') ?: 'Request a Quote'; ?></a>
</div>
</div>
<!-- transparent billing callout -->
<div class="card-glass" style="background: var(--color-bg-ivory); margin-top: var(--space-xl); padding: var(--space-lg) var(--space-xl); text-align: center; display: block; max-width: 680px; margin-left: auto; margin-right: auto;">
<div>
<h4 style="margin: 0 0 0.5rem;"><?php echo get_field('billing_title') ?: 'Transparent Billing — No Surprises'; ?></h4>
<p style="font-size: 0.9rem; color: var(--color-text-muted); margin: 0;"><?php echo get_field('p_billing'); ?></p>
</div>
</div>
</div>
</section>
<!-- offshoring roles section -->
<section class="section content-panel" id="offshoring-roles" style="position: relative; overflow: hidden;">
<!-- Background Confetti for Roles -->
<div class="floating-bg-icon anim-pulse" style="top: 5%; left: 10%; color: var(--color-bg-ivory);">
  <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
</div>
<div class="floating-bg-icon anim-float-fast" style="top: 45%; left: 5%; color: var(--color-primary);">
  <svg viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" /></svg>
</div>
<div class="floating-bg-icon anim-pulse" style="top: 70%; right: 12%; color: var(--color-bg-ivory);">
  <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
</div>
<div class="container" style="position: relative; z-index: 2;">
<div class="text-center" style="margin-bottom: var(--space-2xl);">
<span class="text-overline"><?php echo get_field('overline_38'); ?></span>
<h2><?php echo get_field('h2_24'); ?></h2>
<p style="color: var(--color-text-muted); margin: var(--space-sm) auto 0; max-width: 560px;"><?php echo get_field('p_25'); ?></p>
</div>
<div class="off-roles-desktop-grid">
<div class="off-roles-mobile-row off-roles-mobile-row--1 cycle-card-bg">
<!-- 1. Accountants (Calculator) -->
<div class="off-role-item card-glass compact-mobile">
<div class="universal-icon-wrapper">
<svg fill="none" height="32" stroke="var(--color-primary)" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewbox="0 0 24 24" width="32"><rect fill="var(--color-secondary)" fill-opacity="0.3" height="18" rx="2" ry="2" width="16" x="4" y="3"></rect><rect height="4" width="10" x="7" y="6" fill="var(--color-bg-ivory)"></rect><circle cx="9" cy="14" r="1" fill="var(--color-accent-gold)"></circle><circle cx="15" cy="14" r="1"></circle><circle cx="9" cy="18" r="1"></circle><circle cx="15" cy="18" r="1"></circle></svg>
</div>
<h4>Accountants</h4>
<p><?php echo get_field('p_26'); ?></p>
</div>
<!-- 2. Bookkeepers (Book) -->
<div class="off-role-item card-glass compact-mobile">
<div class="universal-icon-wrapper">
<svg fill="none" height="32" stroke="var(--color-primary)" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewbox="0 0 24 24" width="32"><path fill="var(--color-bg-ivory)" d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path fill="var(--color-accent-gold)" fill-opacity="0.3" d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path></svg>
</div>
<h4>Bookkeepers</h4>
<p><?php echo get_field('p_27'); ?></p>
</div>
<!-- 3. Virtual Assistants (Calendar/Clock) -->
<div class="off-role-item card-glass compact-mobile">
<div class="universal-icon-wrapper">
<svg fill="none" height="32" stroke="var(--color-primary)" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewbox="0 0 24 24" width="32"><rect fill="var(--color-secondary)" fill-opacity="0.4" height="18" rx="2" ry="2" width="18" x="3" y="4"></rect><line x1="16" x2="16" y1="2" y2="6"></line><line x1="8" x2="8" y1="2" y2="6"></line><line x1="3" x2="21" y1="10" y2="10" stroke="var(--color-primary)"></line><circle cx="12" cy="16" r="2" fill="var(--color-accent-gold)"></circle></svg>
</div>
<h4>Virtual Assistants</h4>
<p><?php echo get_field('p_28'); ?></p>
</div>
<!-- 4. Graphic Designers (Palette) -->
<div class="off-role-item card-glass compact-mobile">
<div class="universal-icon-wrapper">
<svg fill="none" height="32" stroke="var(--color-primary)" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewbox="0 0 24 24" width="32"><path fill="var(--color-secondary)" fill-opacity="0.5" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10c1.38 0 2.5-1.12 2.5-2.5 0-.53-.21-1.04-.59-1.41-.37-.38-.59-.88-.59-1.41 0-1.1.9-2 2-2h1.67c2.65 0 4.83-2.18 4.83-4.83C21.83 6.31 17.43 2 12 2z"></path><circle cx="6.5" cy="10.5" r="1.5" fill="var(--color-accent-gold)"></circle><circle cx="10.5" cy="5.5" r="1.5" fill="var(--color-bg-ivory)"></circle><circle cx="16.5" cy="8.5" r="1.5" fill="var(--color-primary)"></circle></svg>
</div>
<h4>Graphic Designers</h4>
<p><?php echo get_field('p_29'); ?></p>
</div>
<!-- 5. Web Developers (Code) -->
<div class="off-role-item card-glass compact-mobile">
<div class="universal-icon-wrapper">
<svg fill="none" height="32" stroke="var(--color-primary)" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewbox="0 0 24 24" width="32"><rect x="2" y="4" width="20" height="16" rx="2" fill="var(--color-accent-gold)" fill-opacity="0.2"></rect><polyline points="8 10 5 13 8 16" stroke="var(--color-primary)"></polyline><polyline points="16 10 19 13 16 16" stroke="var(--color-primary)"></polyline><line x1="14" x2="10" y1="8" y2="18" stroke="var(--color-secondary)"></line></svg>
</div>
<h4>Web Developers</h4>
<p><?php echo get_field('p_30'); ?></p>
</div>
<!-- 6. Customer Service (Headset) -->
<div class="off-role-item card-glass compact-mobile">
<div class="universal-icon-wrapper">
<svg fill="none" height="32" stroke="var(--color-primary)" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewbox="0 0 24 24" width="32"><path fill="var(--color-secondary)" fill-opacity="0.3" d="M3 18v-6a9 9 0 0 1 18 0v6"></path><path d="M21 19a2 2 0 0 1-2 2h-1a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h3zM3 19a2 2 0 0 0 2 2h1a2 2 0 0 0 2-2v-3a2 2 0 0 0-2-2H3z" fill="var(--color-accent-gold)"></path></svg>
</div>
<h4>Customer Service</h4>
<p><?php echo get_field('p_31'); ?></p>
</div>
</div>
<div class="off-roles-mobile-row off-roles-mobile-row--2 cycle-card-bg">
<!-- 7. Digital Marketers (Megaphone) -->
<div class="off-role-item card-glass compact-mobile">
<div class="universal-icon-wrapper">
<svg fill="none" height="32" stroke="var(--color-primary)" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewbox="0 0 24 24" width="32"><path fill="var(--color-bg-ivory)" d="M11 5L6 9H2v6h4l5 4V5z"></path><path d="M19.07 4.93a10 10 0 0 1 0 14.14M15.54 8.46a5 5 0 0 1 0 7.07" stroke="var(--color-accent-gold)"></path></svg>
</div>
<h4>Digital Marketers</h4>
<p><?php echo get_field('p_32'); ?></p>
</div>
<!-- 8. Data Analysts (Bar Chart) -->
<div class="off-role-item card-glass compact-mobile">
<div class="universal-icon-wrapper">
<svg fill="none" height="32" stroke="var(--color-primary)" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewbox="0 0 24 24" width="32"><line x1="18" x2="18" y1="20" y2="10" stroke="var(--color-secondary)" stroke-width="4"></line><line x1="12" x2="12" y1="20" y2="4" stroke="var(--color-accent-gold)" stroke-width="4"></line><line x1="6" x2="6" y1="20" y2="14" stroke="var(--color-primary)" stroke-width="4"></line></svg>
</div>
<h4>Data Analysts</h4>
<p><?php echo get_field('p_33'); ?></p>
</div>
<!-- 9. HR Specialists (Heart/People) -->
<div class="off-role-item card-glass compact-mobile">
<div class="universal-icon-wrapper">
<svg fill="none" height="32" stroke="var(--color-primary)" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewbox="0 0 24 24" width="32"><path fill="var(--color-secondary)" fill-opacity="0.8" stroke="none" d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path><circle cx="12" cy="11" r="3" fill="var(--color-bg-ivory)" stroke="var(--color-primary)"></circle></svg>
</div>
<h4>HR Specialists</h4>
<p><?php echo get_field('p_34'); ?></p>
</div>
<!-- 10. IT Support (Wrench) -->
<div class="off-role-item card-glass compact-mobile">
<div class="universal-icon-wrapper">
<svg fill="none" height="32" stroke="var(--color-primary)" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewbox="0 0 24 24" width="32"><path fill="var(--color-bg-ivory)" d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"></path><circle cx="18" cy="6" r="1" fill="var(--color-accent-gold)" stroke="none"></circle></svg>
</div>
<h4>IT Support</h4>
<p><?php echo get_field('p_35'); ?></p>
</div>
<!-- 11. Content Writers (Pen) -->
<div class="off-role-item card-glass compact-mobile">
<div class="universal-icon-wrapper">
<svg fill="none" height="32" stroke="var(--color-primary)" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewbox="0 0 24 24" width="32"><path fill="var(--color-secondary)" fill-opacity="0.4" d="M12 19l7-7 3 3-7 7-3-3z"></path><path d="M18 13l-1.5-7.5L2 2l3.5 14.5L13 18l5-5z"></path><path d="M2 2l7.586 7.586" stroke="var(--color-accent-gold)"></path><circle cx="11" cy="11" r="2" fill="var(--color-bg-ivory)"></circle></svg>
</div>
<h4>Content Writers</h4>
<p><?php echo get_field('p_36'); ?></p>
</div>
<!-- 12. Project Managers (Clipboard) -->
<div class="off-role-item card-glass compact-mobile">
<div class="universal-icon-wrapper">
<svg fill="none" height="32" stroke="var(--color-primary)" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewbox="0 0 24 24" width="32"><path fill="var(--color-bg-ivory)" d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path><rect fill="var(--color-accent-gold)" fill-opacity="0.6" height="4" rx="1" ry="1" width="8" x="8" y="2"></rect><path d="M9 14l2 2 4-4" stroke="var(--color-secondary)"></path></svg>
</div>
<h4>Project Managers</h4>
<p><?php echo get_field('p_37'); ?></p>
</div>
</div>
</div>
</div>
</section>
<!-- offshoring comparison section -->
<section class="section content-panel" id="offshoring-comparison" style="position: relative; overflow: hidden;">
<!-- Background Coins/Sparkles for Comparison -->
<div class="floating-bg-icon anim-float-fast" style="top: 10%; left: 5%; color: var(--color-accent-gold);">
  <svg viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" /></svg>
</div>
<div class="floating-bg-icon anim-pulse" style="top: 30%; right: 10%; color: var(--color-secondary);">
  <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
</div>
<div class="floating-bg-icon anim-float-fast" style="bottom: 15%; right: 5%; color: var(--color-accent-gold);">
  <svg viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" /></svg>
</div>
<div class="container" style="position: relative; z-index: 2;">
<div class="text-center" style="margin-bottom: var(--space-2xl);">
<span class="text-overline"><?php echo get_field('overline_43'); ?></span>
<h2><?php echo get_field('h2_40'); ?></h2>
<p class="text-lead mx-auto" style="margin-top: var(--space-sm); max-width: 700px;"><?php echo get_field('p_41'); ?></p>
</div>
<div class="compare-table-wrapper card-glass">
<table class="compare-table">
<thead>
<tr>
<th class="head-dark">Role</th>
<th class="head-dark">Onshore (Annual)</th>
<th class="head-accent">Philippines with Kings City</th>
<th class="head-accent">You Save</th>
</tr>
</thead>
<tbody>
<tr>
<td data-label="Role">Accountant</td>
<td data-label="Onshore (Annual)">?4,675,000</td>
<td class="col-highlight" data-label="Philippines with Kings City">?1,375,000</td>
<td class="col-highlight" data-label="You Save"><span class="save-badge">~70%</span></td>
</tr>
<tr>
<td data-label="Role">Virtual Assistant</td>
<td data-label="Onshore (Annual)">?3,575,000</td>
<td class="col-highlight" data-label="Philippines with Kings City">?990,000</td>
<td class="col-highlight" data-label="You Save"><span class="save-badge">~72%</span></td>
</tr>
<tr>
<td data-label="Role">Web Developer</td>
<td data-label="Onshore (Annual)">?5,775,000</td>
<td class="col-highlight" data-label="Philippines with Kings City">?1,760,000</td>
<td class="col-highlight" data-label="You Save"><span class="save-badge">~70%</span></td>
</tr>
<tr>
<td data-label="Role">Customer Service Rep</td>
<td data-label="Onshore (Annual)">?3,300,000</td>
<td class="col-highlight" data-label="Philippines with Kings City">?880,000</td>
<td class="col-highlight" data-label="You Save"><span class="save-badge">~73%</span></td>
</tr>
<tr>
<td data-label="Role">Graphic Designer</td>
<td data-label="Onshore (Annual)">?4,125,000</td>
<td class="col-highlight" data-label="Philippines with Kings City">?1,210,000</td>
<td class="col-highlight" data-label="You Save"><span class="save-badge">~71%</span></td>
</tr>
</tbody>
</table>
<div class="compare-table-footer">
<p><?php echo get_field('p_42'); ?></p>
</div>
</div>
</div>
</section>
<!-- offshoring services section -->
<section class="section content-panel" id="offshoring-services" style="position: relative; overflow: hidden;">
<!-- Magical Floating Background Confetti -->
<div class="floating-bg-icon anim-pulse" style="top: 15%; left: 8%; color: var(--color-bg-ivory);">
  <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
</div>
<div class="floating-bg-icon anim-float-fast" style="bottom: 20%; left: 15%; color: var(--color-primary);">
  <svg viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" /></svg>
</div>
<div class="floating-bg-icon anim-pulse" style="bottom: 10%; right: 8%; color: var(--color-bg-ivory);">
  <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
</div>

<div class="container text-center" style="position: relative; z-index: 2;">
<span class="text-overline" style="margin-bottom: var(--space-sm); display: block;"><?php echo get_field('overline_50'); ?></span>
<h2 style="margin-bottom: var(--space-xl);"><?php echo get_field('h2_45'); ?></h2>
<div class="spaces-services-grid cycle-card-bg">

<!-- Talent Recruitment -->
<div class="spaces-services__item card-glass compact-mobile">
<div class="universal-icon-wrapper">
<svg fill="none" height="48" viewBox="0 0 24 24" width="48" stroke="var(--color-primary)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
  <circle cx="11" cy="11" r="8" fill="var(--color-bg-ivory)"></circle>
  <line x1="21" y1="21" x2="16.65" y2="16.65" stroke-width="2.5"></line>
  <path fill="var(--color-secondary)" stroke="none" d="M12 14.5l-3-3a2.5 2.5 0 0 1 3.5-3.5 2.5 2.5 0 0 1 3.5 3.5z"></path>
</svg>
</div>
<div>
<h4 class="spaces-services__item-title">Talent Recruitment</h4>
<p class="spaces-services__item-text"><?php echo get_field('p_46'); ?></p>
</div>
</div>

<!-- Infrastructure & IT -->
<div class="spaces-services__item card-glass compact-mobile">
<div class="universal-icon-wrapper">
<svg fill="none" height="48" viewBox="0 0 24 24" width="48" stroke="var(--color-primary)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
  <rect x="3" y="4" width="18" height="12" rx="2" fill="var(--color-bg-ivory)"></rect>
  <path d="M2 20h20" stroke-width="2.5"></path>
  <circle cx="12" cy="10" r="3" fill="var(--color-secondary)" stroke="none"></circle>
  <path d="M18 2l1.5 1.5L21 2l-1.5 1.5L18 2z" fill="var(--color-accent-gold)" stroke="none"></path>
  <path d="M4 2l1 1 1-1-1-1z" fill="var(--color-accent-gold)" stroke="none"></path>
</svg>
</div>
<div>
<h4 class="spaces-services__item-title">Infrastructure &amp; IT</h4>
<p class="spaces-services__item-text"><?php echo get_field('p_47'); ?></p>
</div>
</div>

<!-- Managed Facilities -->
<div class="spaces-services__item card-glass compact-mobile">
<div class="universal-icon-wrapper">
<svg fill="none" height="48" viewBox="0 0 24 24" width="48" stroke="var(--color-primary)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
  <path d="M4 22V8a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v14" fill="var(--color-bg-ivory)"></path>
  <path d="M12 22V12" stroke-dasharray="3 3"></path>
  <circle cx="8" cy="10" r="2" fill="var(--color-secondary)" stroke="none"></circle>
  <circle cx="16" cy="10" r="2" fill="var(--color-accent-gold)" stroke="none"></circle>
  <circle cx="8" cy="16" r="2" fill="var(--color-secondary)" stroke="none"></circle>
  <circle cx="16" cy="16" r="2" fill="var(--color-accent-gold)" stroke="none"></circle>
</svg>
</div>
<div>
<h4 class="spaces-services__item-title">Managed Facilities</h4>
<p class="spaces-services__item-text"><?php echo get_field('p_48'); ?></p>
</div>
</div>

<!-- HR & Compliance -->
<div class="spaces-services__item card-glass compact-mobile">
<div class="universal-icon-wrapper">
<svg fill="none" height="48" viewBox="0 0 24 24" width="48" stroke="var(--color-primary)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
  <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2" fill="var(--color-bg-ivory)"></path>
  <rect x="8" y="2" width="8" height="6" rx="2" fill="var(--color-secondary)" stroke="none"></rect>
  <path d="M9 15l2 2 4-4" stroke="var(--color-accent-gold)" stroke-width="2.5"></path>
</svg>
</div>
<div>
<h4 class="spaces-services__item-title">HR &amp; Compliance</h4>
<p class="spaces-services__item-text"><?php echo get_field('p_49'); ?></p>
</div>
</div>

</div>
<!-- inquiry first cta -->
<div style="margin-top: var(--space-2xl);">
<a class="btn" href="<?php echo $apply_url; ?>">Request a Detailed Quote</a>
</div>
</div>
</section>
<!-- contact us section -->
<section class="section custom-contact-section bg-ivory" id="offshoring-contact" style="padding: var(--space-3xl) 0; position: relative;">

  <!-- Background Floating Icons -->
  <div style="position: absolute; inset: 0; overflow: hidden; pointer-events: none; z-index: 1;">
        <div class="floating-bg-icon anim-float-fast" style="bottom: 10%; right: 5%; color: var(--color-primary);">
  <svg viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" /></svg>
</div>
    <div class="floating-bg-icon anim-pulse" style="top: 50%; left: 30%; color: var(--color-bg-ivory);">
  <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
</div>
  </div>

  <div style="max-width: 100%; padding: 0 5vw; position: relative; z-index: 10;">
    <div class="contact-cards-wrapper cycle-card-bg">
      
      <!-- New Get In Touch Card -->
      <div class="card-glass contact-envelope-card" style="display: flex; flex-direction: column; justify-content: center; padding: var(--space-xl) var(--space-lg);">
        <div class="contact-envelope-content">
          <h2 style="color: var(--color-primary); margin-bottom: var(--space-xs); text-transform: uppercase; line-height: 1.1; font-size: 1.8rem;"><?php echo get_field('off_contact_title') ?: 'GET IN TOUCH'; ?></h2>
          <p style="color: var(--color-primary); font-size: 1rem; opacity: 0.8; margin-bottom: var(--space-md);"><?php echo get_field('off_contact_subtitle') ?: 'We\'d love to hear from you'; ?></p>
          
          <div style="display: flex; flex-direction: column; gap: 1rem;">
            <a href="<?php echo get_field('off_contact_ig') ?: '#'; ?>" style="color: var(--color-primary); display: flex; align-items: center; gap: 12px; text-decoration: none; font-weight: 600; transition: transform 0.3s ease;">
              <svg fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" width="24"><rect height="20" rx="5" ry="5" width="20" x="2" y="2" fill="rgba(255,255,255,0.5)" stroke="none"></rect><rect height="20" rx="5" ry="5" width="20" x="2" y="2"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" x2="17.51" y1="6.5" y2="6.5"></line></svg>
              Instagram
            </a>
            <a href="<?php echo get_field('off_contact_fb') ?: '#'; ?>" style="color: var(--color-primary); display: flex; align-items: center; gap: 12px; text-decoration: none; font-weight: 600; transition: transform 0.3s ease;">
              <svg fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" width="24"><rect height="20" rx="5" ry="5" width="20" x="2" y="2" fill="rgba(255,255,255,0.5)" stroke="none"></rect><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path></svg>
              Facebook
            </a>
          </div>
        </div>
      </div>
          
          <div class="card-glass contact-envelope-card">
            <div class="envelope-icon">
              <svg fill="none" height="36" viewBox="0 0 24 24" width="36" stroke="var(--color-primary)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" fill="var(--color-bg-ivory)"></path><circle cx="12" cy="10" r="3" fill="var(--color-secondary)" stroke="none"></circle></svg>
            </div>
            <div class="contact-envelope-content" >
              <span class="text-overline" style="color: var(--color-primary); margin-bottom: 4px; display: block; font-size: 0.8rem;">Visit Us</span>
              <h3 style="margin-bottom: 8px; font-size: 1.4rem; color: var(--color-primary);">Manila Office</h3>
              <div style="color: var(--color-text-muted); font-size: 1rem; white-space: pre-wrap; line-height: 1.6; margin-bottom: 8px;"><?php 
                $manila_addr = get_field('off_contact_manila_addr') ?: "Manila Office\nKings City, Ground Level, RCS\nBuilding, Doña Soledad Ave,\nBetter Living, Parañaque";
                echo str_replace("Manila Office\n", "", $manila_addr);
              ?></div>
            </div>
          </div>

          <div class="card-glass contact-envelope-card" >
            <div class="envelope-icon" >
              <svg fill="none" height="36" viewBox="0 0 24 24" width="36" stroke="var(--color-primary)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z" fill="var(--color-bg-ivory)"></path><circle cx="17" cy="7" r="4" fill="var(--color-accent-gold)" stroke="none"></circle></svg>
            </div>
            <div class="contact-envelope-content" >
              <span class="text-overline" style="color: var(--color-primary); margin-bottom: 4px; display: block; font-size: 0.8rem;">Contact Us</span>
              <h3 style="margin-bottom: 8px; font-size: 1.4rem; color: var(--color-primary);">Manila Phone</h3>
              <div style="color: var(--color-text-muted); font-size: 1rem; white-space: pre-wrap; line-height: 1.6; margin-bottom: 8px;"><?php 
                $manila_phones = get_field('off_contact_manila_phones') ?: "Manila Office\nTelephone Number:\n+63 (2) 8696 4490\n\nMobile Numbers:\n+63 (917) 187 0031\n+63 (917) 122 8034\n+63 (917) 710 3221";
                echo str_replace("Manila Office\n", "", $manila_phones);
              ?></div>
            </div>
          </div>

          <div class="card-glass contact-envelope-card" >
            <div class="envelope-icon" >
              <svg fill="none" height="36" viewBox="0 0 24 24" width="36" stroke="var(--color-primary)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" fill="var(--color-bg-ivory)"></path><circle cx="12" cy="10" r="3" fill="var(--color-accent-gold)" stroke="none"></circle></svg>
            </div>
            <div class="contact-envelope-content" >
              <span class="text-overline" style="color: var(--color-primary); margin-bottom: 4px; display: block; font-size: 0.8rem;">Visit Us</span>
              <h3 style="margin-bottom: 8px; font-size: 1.4rem; color: var(--color-primary);">Australia Office</h3>
              <div style="color: var(--color-text-muted); font-size: 1rem; white-space: pre-wrap; line-height: 1.6; margin-bottom: 8px;"><?php 
                $aus_addr = get_field('off_contact_aus_addr') ?: "Australia Office\nMelbourne G02 / 23 27,\nWellington Street, St. Kilda VIC\n3182 Australia";
                echo str_replace("Australia Office\n", "", $aus_addr);
              ?></div>
            </div>
          </div>

          <div class="card-glass contact-envelope-card" >
            <div class="envelope-icon" >
              <svg fill="none" height="36" viewBox="0 0 24 24" width="36" stroke="var(--color-primary)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" fill="var(--color-bg-ivory)"></path><polyline points="22,6 12,13 2,6" stroke="var(--color-primary)" stroke-width="2"></polyline><rect x="6" y="8" width="12" height="8" rx="2" fill="var(--color-secondary)" stroke="none"></rect></svg>
            </div>
            <div class="contact-envelope-content" >
              <span class="text-overline" style="color: var(--color-primary); margin-bottom: 4px; display: block; font-size: 0.8rem;">Contact Us</span>
              <h3 style="margin-bottom: 8px; font-size: 1.4rem; color: var(--color-primary);">Aus Phone &amp; Email</h3>
              <div style="color: var(--color-text-muted); font-size: 1rem; white-space: pre-wrap; line-height: 1.6; margin-bottom: 8px;"><?php 
                $aus_phones = get_field('off_contact_aus_phones') ?: "Australia Office\nTelephone Number:\n03 8375 9477 (Australia)";
                echo str_replace("Australia Office\n", "", $aus_phones);
              ?></div>
              <div style="color: var(--color-text-muted); font-size: 1rem; white-space: pre-wrap; line-height: 1.6; word-break: break-word;"><?php 
                echo get_field('off_contact_email') ?: "Email Address:\nkingscity@kingsgroup.com.ph";
              ?></div>
            </div>
          </div>

        </div>

        <!-- Acknowledgement (Moved outside of wrapper) -->
        <div style="width: 100%; position: relative; z-index: 2; margin-top: var(--space-xl);">
          <div style="color: var(--color-text-muted); font-size: 0.85rem; font-style: italic; opacity: 0.8; text-align: center; line-height: 1.6; border-top: 1px solid rgba(189, 69, 31, 0.1); padding-top: var(--space-md);">
            <?php 
              $ack = get_field('off_contact_ack') ?: "We acknowledge and pay respect to the past, present, and future Traditional Custodians and Elders of the nation...";
              echo str_replace("\n", " ", $ack);
            ?>
          </div>
        </div>
  </div>
</section>
<!-- locations gallery carousel -->
<section class="section content-panel section--gallery gallery-theme-pink" style="position: relative; padding: var(--space-lg) 0 var(--space-2xl) 0; overflow: hidden;">
<!-- Background Confetti -->
<div class="floating-bg-icon anim-float-fast" style="bottom: 15%; left: 10%; color: #BD451F;">
  <svg viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" /></svg>
</div>
<div class="floating-bg-icon anim-pulse" style="top: 50%; left: 3%; color: var(--color-accent-gold);">
  <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
</div>

<!-- Heading -->
<div class="container" style="position: relative; z-index: 2;">
  <div style="text-align: center; margin-bottom: var(--space-xl);">
    <h2 class="gallery-heading" style="margin-bottom: 0; font-size: clamp(2rem, 4vw, 3rem); font-weight: 700;"><?php $heading = get_field('section_txt_gallery_heading'); echo $heading ? $heading : 'Virtual Tour'; ?></h2>
  </div>
</div>

<button aria-label="Previous image" class="gallery-nav gallery-nav--prev" onclick="scrollGallery(-1)">
<svg fill="none" height="20" stroke="currentColor" stroke-width="2" viewbox="0 0 24 24" width="20"><polyline points="15 18 9 12 15 6"></polyline></svg>
</button>
<div class="gallery-carousel" id="gallery-carousel">
<!-- original set -->
<div class="gallery-card">
<img alt="Dedicated Office Teams" src="<?php $img = get_field('image_52'); echo ($img && is_array($img) && isset($img['url'])) ? esc_url($img['url']) : (is_numeric($img) ? wp_get_attachment_image_url($img, 'full') : get_template_directory_uri() . '/assets/img/placeholder.jpg'); ?>" style="width:100%; height:100%; object-fit:cover;"/>
</div>
<div class="gallery-card">
<img alt="Modern Workstations" src="<?php $img = get_field('image_53'); echo ($img && is_array($img) && isset($img['url'])) ? esc_url($img['url']) : (is_numeric($img) ? wp_get_attachment_image_url($img, 'full') : get_template_directory_uri() . '/assets/img/placeholder.jpg'); ?>" style="width:100%; height:100%; object-fit:cover;"/>
</div>
<div class="gallery-card">
<img alt="Training Facilities" src="<?php $img = get_field('image_54'); echo ($img && is_array($img) && isset($img['url'])) ? esc_url($img['url']) : (is_numeric($img) ? wp_get_attachment_image_url($img, 'full') : get_template_directory_uri() . '/assets/img/placeholder.jpg'); ?>" style="width:100%; height:100%; object-fit:cover;"/>
</div>
<div class="gallery-card">
<img alt="Collaborative Spaces" src="<?php $img = get_field('image_55'); echo ($img && is_array($img) && isset($img['url'])) ? esc_url($img['url']) : (is_numeric($img) ? wp_get_attachment_image_url($img, 'full') : get_template_directory_uri() . '/assets/img/placeholder.jpg'); ?>" style="width:100%; height:100%; object-fit:cover;"/>
</div>
<div class="gallery-card">
<img alt="Break &amp; Recreation Areas" src="<?php $img = get_field('image_56'); echo ($img && is_array($img) && isset($img['url'])) ? esc_url($img['url']) : (is_numeric($img) ? wp_get_attachment_image_url($img, 'full') : get_template_directory_uri() . '/assets/img/placeholder.jpg'); ?>" style="width:100%; height:100%; object-fit:cover;"/>
</div>
<!-- duplicated set for infinite loop -->
<div class="gallery-card">
<img alt="Dedicated Office Teams" src="<?php $img = get_field('image_57'); echo ($img && is_array($img) && isset($img['url'])) ? esc_url($img['url']) : (is_numeric($img) ? wp_get_attachment_image_url($img, 'full') : get_template_directory_uri() . '/assets/img/placeholder.jpg'); ?>" style="width:100%; height:100%; object-fit:cover;"/>
</div>
<div class="gallery-card">
<img alt="Modern Workstations" src="<?php $img = get_field('image_58'); echo ($img && is_array($img) && isset($img['url'])) ? esc_url($img['url']) : (is_numeric($img) ? wp_get_attachment_image_url($img, 'full') : get_template_directory_uri() . '/assets/img/placeholder.jpg'); ?>" style="width:100%; height:100%; object-fit:cover;"/>
</div>
<div class="gallery-card">
<img alt="Training Facilities" src="<?php $img = get_field('image_59'); echo ($img && is_array($img) && isset($img['url'])) ? esc_url($img['url']) : (is_numeric($img) ? wp_get_attachment_image_url($img, 'full') : get_template_directory_uri() . '/assets/img/placeholder.jpg'); ?>" style="width:100%; height:100%; object-fit:cover;"/>
</div>
<div class="gallery-card">
<img alt="Collaborative Spaces" src="<?php $img = get_field('image_60'); echo ($img && is_array($img) && isset($img['url'])) ? esc_url($img['url']) : (is_numeric($img) ? wp_get_attachment_image_url($img, 'full') : get_template_directory_uri() . '/assets/img/placeholder.jpg'); ?>" style="width:100%; height:100%; object-fit:cover;"/>
</div>
<div class="gallery-card">
<img alt="Break &amp; Recreation Areas" src="<?php $img = get_field('image_61'); echo ($img && is_array($img) && isset($img['url'])) ? esc_url($img['url']) : (is_numeric($img) ? wp_get_attachment_image_url($img, 'full') : get_template_directory_uri() . '/assets/img/placeholder.jpg'); ?>" style="width:100%; height:100%; object-fit:cover;"/>
</div>
</div>
<button aria-label="Next image" class="gallery-nav gallery-nav--next" onclick="scrollGallery(1)">
<svg fill="none" height="20" stroke="currentColor" stroke-width="2" viewbox="0 0 24 24" width="20"><polyline points="9 18 15 12 9 6"></polyline></svg>
</button>
<script>
        // Gallery Auto-Scroll & Manual Controls with Seamless Loop
        const gallery = document.getElementById('gallery-carousel');
        let autoScrollInterval;

        function getScrollAmount() {
          const card = gallery.querySelector('.gallery-card');
          return card ? card.clientWidth + parseInt(getComputedStyle(gallery).gap || 0) : 320;
        }

        function scrollGallery(direction) {
          if (!gallery) return;
          const scrollAmount = getScrollAmount();
          gallery.style.scrollBehavior = 'smooth';
          gallery.scrollBy({ left: scrollAmount * direction });
          resetAutoScroll();
        }

        function startAutoScroll() {
          if (!gallery) return;
          autoScrollInterval = setInterval(() => {
            const scrollAmount = getScrollAmount();
            if (gallery.scrollLeft >= gallery.scrollWidth / 2) {
              gallery.style.scrollBehavior = 'auto';
              gallery.scrollLeft = 0;
              void gallery.offsetWidth; 
              gallery.style.scrollBehavior = 'smooth';
              gallery.scrollBy({ left: scrollAmount });
            } else {
              gallery.style.scrollBehavior = 'smooth';
              gallery.scrollBy({ left: scrollAmount });
            }
          }, 3500);
        }

        function resetAutoScroll() {
          clearInterval(autoScrollInterval);
          startAutoScroll();
        }

        if (gallery) {
          gallery.addEventListener('mouseenter', () => clearInterval(autoScrollInterval));
          gallery.addEventListener('mouseleave', startAutoScroll);
          gallery.addEventListener('touchstart', () => clearInterval(autoScrollInterval));
          gallery.addEventListener('touchend', startAutoScroll);
          startAutoScroll();
        }
      </script>
</section>
</main>
<script>
        // Gallery Auto-Scroll & Manual Controls with Seamless Loop
        const gallery = document.getElementById('gallery-carousel');
        let autoScrollInterval;

        function getScrollAmount() {
          const card = gallery.querySelector('.gallery-card');
          return card ? card.clientWidth + parseInt(getComputedStyle(gallery).gap || 0) : 320;
        }

        function scrollGallery(direction) {
          if (!gallery) return;
          const scrollAmount = getScrollAmount();
          gallery.style.scrollBehavior = 'smooth';
          gallery.scrollBy({ left: scrollAmount * direction });
          resetAutoScroll();
        }

        function startAutoScroll() {
          if (!gallery) return;
          autoScrollInterval = setInterval(() => {
            const scrollAmount = getScrollAmount();
            if (gallery.scrollLeft >= gallery.scrollWidth / 2) {
              gallery.style.scrollBehavior = 'auto';
              gallery.scrollLeft = 0;
              void gallery.offsetWidth; 
              gallery.style.scrollBehavior = 'smooth';
              gallery.scrollBy({ left: scrollAmount });
            } else {
              gallery.style.scrollBehavior = 'smooth';
              gallery.scrollBy({ left: scrollAmount });
            }
          }, 3500);
        }

        function resetAutoScroll() {
          clearInterval(autoScrollInterval);
          startAutoScroll();
        }

        if (gallery) {
          gallery.addEventListener('mouseenter', () => clearInterval(autoScrollInterval));
          gallery.addEventListener('mouseleave', startAutoScroll);
          gallery.addEventListener('touchstart', () => clearInterval(autoScrollInterval));
          gallery.addEventListener('touchend', startAutoScroll);
          startAutoScroll();
        }
      </script>
<script>
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

