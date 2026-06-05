<?php
/* Template Name: Offshoring */
get_header();
?>

<main id="main-content">
<!-- hero section -->
<section class="hero premium-hero">
<div class="container grid-12">
<div class="col-12 split split--media-right">
<!-- text content on left -->
<div class="split__content animate-fadeInUp hero__content--index">
<span class="text-overline hero__overline"><?php echo get_field('overline_3'); ?></span>
<h1 class="hero__title hero__title--inner"><?php echo get_field('h1_1'); ?></h1>
<p class="hero__subtitle"><?php echo get_field('p_2'); ?></p>
<div class="hero__actions hero__actions--index">
<a class="btn" href="apply.html">
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
<section class="section content-panel" id="offshoring-process">
<div class="container">
<div class="text-center" style="margin-bottom: var(--space-2xl);">
<span class="text-overline"><?php echo get_field('overline_18'); ?></span>
<h2><?php echo get_field('h2_8'); ?></h2>
<p class="text-lead mx-auto" style="margin-top: var(--space-sm); max-width: 600px;"><?php echo get_field('p_13'); ?></p>
</div>
<div class="off-process-steps">
<!-- process card 1 -->
<div class="off-process-card card-glass">
<div class="off-process-card__num">
<svg fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" width="28" height="28"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
<span>1</span>
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
<div class="off-process-card__num">
<svg fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" width="28" height="28"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
<span>2</span>
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
<div class="off-process-card__num">
<svg fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" width="28" height="28"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect><line x1="8" y1="21" x2="16" y2="21"></line><line x1="12" y1="17" x2="12" y2="21"></line></svg>
<span>3</span>
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
<div class="off-process-card__num">
<svg fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" width="28" height="28"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline></svg>
<span>4</span>
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
<section class="section content-panel" id="offshoring-models">
<div class="container">
<div class="text-center" style="margin-bottom: var(--space-2xl);">
<span class="text-overline"><?php echo get_field('overline_models') ?: 'Our Service Models'; ?></span>
<h2><?php echo get_field('h2_models') ?: 'Two Ways to Build Your Team'; ?></h2>
<p class="text-lead mx-auto" style="margin-top: var(--space-sm); max-width: 650px;"><?php echo get_field('p_intro_models') ?: 'Whether you want a fully managed offshore division or targeted staff placement, we have a model that fits.'; ?></p>
</div>
<div style="display: flex; gap: var(--space-xl); flex-wrap: wrap;">
<!-- model 1 card -->
<div class="card-glass" style="background: #FBCB77; padding: var(--space-xl); flex: 1; min-width: 280px;">
<span class="text-overline">Model 1</span>
<h3 style="margin-bottom: var(--space-sm);"><?php echo get_field('h3_model1'); ?></h3>
<p style="font-size: 0.9rem; color: var(--color-text-muted); line-height: 1.65; margin-bottom: var(--space-lg);"><?php echo get_field('p_model1'); ?></p>
<ul style="list-style: none; padding: 0; margin: 0 0 var(--space-lg) 0; display: flex; flex-direction: column; gap: 0.6rem;">
<li style="display: flex; gap: 0.75rem; font-size: 0.9rem; align-items: flex-start;"><svg width="20" height="20" fill="none" stroke="var(--color-primary)" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink: 0; margin-top: 2px;"><polyline points="20 6 9 17 4 12"></polyline></svg>Your team works exclusively for you full-time</li>
<li style="display: flex; gap: 0.75rem; font-size: 0.9rem; align-items: flex-start;"><svg width="20" height="20" fill="none" stroke="var(--color-primary)" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink: 0; margin-top: 2px;"><polyline points="20 6 9 17 4 12"></polyline></svg>Fully managed facilities IT and disaster recovery</li>
<li style="display: flex; gap: 0.75rem; font-size: 0.9rem; align-items: flex-start;"><svg width="20" height="20" fill="none" stroke="var(--color-primary)" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink: 0; margin-top: 2px;"><polyline points="20 6 9 17 4 12"></polyline></svg>Employee engagement and performance frameworks</li>
<li style="display: flex; gap: 0.75rem; font-size: 0.9rem; align-items: flex-start;"><svg width="20" height="20" fill="none" stroke="var(--color-primary)" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink: 0; margin-top: 2px;"><polyline points="20 6 9 17 4 12"></polyline></svg>Best for businesses scaling a dedicated offshore division</li>
</ul>
<a class="btn" href="<?php echo get_field('model1_btn_url') ?: 'apply.html'; ?>" style="width: 100%; display: flex; justify-content: center;"><?php echo get_field('model1_btn_text') ?: 'Get Started'; ?></a>
</div>
<!-- model 2 card -->
<div class="card-glass" style="background: var(--color-primary); border-color: transparent; color: #fff; padding: var(--space-xl); flex: 1; min-width: 280px;">
<span class="text-overline" style="color: rgba(255,255,255,0.65);">Model 2</span>
<h3 style="color: #fff; margin-bottom: var(--space-sm);"><?php echo get_field('h3_model2'); ?></h3>
<p style="font-size: 0.9rem; color: rgba(255,255,255,0.8); line-height: 1.65; margin-bottom: var(--space-lg);"><?php echo get_field('p_model2'); ?></p>
<ul style="list-style: none; padding: 0; margin: 0 0 var(--space-lg) 0; display: flex; flex-direction: column; gap: 0.6rem;">
<li style="display: flex; gap: 0.75rem; font-size: 0.9rem; color: rgba(255,255,255,0.9); align-items: flex-start;"><svg width="20" height="20" fill="none" stroke="#fff" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink: 0; margin-top: 2px;"><polyline points="20 6 9 17 4 12"></polyline></svg>Fixed fee per employee per month with no hidden costs</li>
<li style="display: flex; gap: 0.75rem; font-size: 0.9rem; color: rgba(255,255,255,0.9); align-items: flex-start;"><svg width="20" height="20" fill="none" stroke="#fff" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink: 0; margin-top: 2px;"><polyline points="20 6 9 17 4 12"></polyline></svg>First invoice only after your team starts working</li>
<li style="display: flex; gap: 0.75rem; font-size: 0.9rem; color: rgba(255,255,255,0.9); align-items: flex-start;"><svg width="20" height="20" fill="none" stroke="#fff" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink: 0; margin-top: 2px;"><polyline points="20 6 9 17 4 12"></polyline></svg>Communicate your way via Zoom Skype email or on-site</li>
<li style="display: flex; gap: 0.75rem; font-size: 0.9rem; color: rgba(255,255,255,0.9); align-items: flex-start;"><svg width="20" height="20" fill="none" stroke="#fff" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink: 0; margin-top: 2px;"><polyline points="20 6 9 17 4 12"></polyline></svg>Best for targeted hires and growing teams quickly</li>
</ul>
<a class="btn" href="<?php echo get_field('model2_btn_url') ?: 'apply.html'; ?>" style="background: rgba(255,255,255,0.15); color: #fff; border: 1px solid rgba(255,255,255,0.3); width: 100%; display: flex; justify-content: center;"><?php echo get_field('model2_btn_text') ?: 'Request a Quote'; ?></a>
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
<section class="section content-panel" id="offshoring-roles">
<div class="container">
<div class="text-center" style="margin-bottom: var(--space-2xl);">
<span class="text-overline"><?php echo get_field('overline_38'); ?></span>
<h2><?php echo get_field('h2_24'); ?></h2>
<p style="color: var(--color-text-muted); margin: var(--space-sm) auto 0; max-width: 560px;"><?php echo get_field('p_25'); ?></p>
</div>
<div class="off-roles-grid">
<div class="off-role-item card-glass compact-mobile">
<div class="off-role-icon">
<svg fill="none" height="24" stroke="var(--color-primary)" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewbox="0 0 24 24" width="24"><rect height="14" rx="2" ry="2" width="20" x="2" y="7"></rect><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path></svg>
</div>
<h4>Accountants</h4>
<p><?php echo get_field('p_26'); ?></p>
</div>
<div class="off-role-item card-glass compact-mobile">
<div class="off-role-icon">
<svg fill="none" height="24" stroke="var(--color-primary)" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewbox="0 0 24 24" width="24"><rect height="14" rx="2" ry="2" width="20" x="2" y="7"></rect><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path></svg>
</div>
<h4>Bookkeepers</h4>
<p><?php echo get_field('p_27'); ?></p>
</div>
<div class="off-role-item card-glass compact-mobile">
<div class="off-role-icon">
<svg fill="none" height="24" stroke="var(--color-primary)" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewbox="0 0 24 24" width="24"><rect height="14" rx="2" ry="2" width="20" x="2" y="7"></rect><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path></svg>
</div>
<h4>Virtual Assistants</h4>
<p><?php echo get_field('p_28'); ?></p>
</div>
<div class="off-role-item card-glass compact-mobile">
<div class="off-role-icon">
<svg fill="none" height="24" stroke="var(--color-primary)" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewbox="0 0 24 24" width="24"><rect height="14" rx="2" ry="2" width="20" x="2" y="7"></rect><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path></svg>
</div>
<h4>Graphic Designers</h4>
<p><?php echo get_field('p_29'); ?></p>
</div>
<div class="off-role-item card-glass compact-mobile">
<div class="off-role-icon">
<svg fill="none" height="24" stroke="var(--color-primary)" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewbox="0 0 24 24" width="24"><rect height="14" rx="2" ry="2" width="20" x="2" y="7"></rect><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path></svg>
</div>
<h4>Web Developers</h4>
<p><?php echo get_field('p_30'); ?></p>
</div>
<div class="off-role-item card-glass compact-mobile">
<div class="off-role-icon">
<svg fill="none" height="24" stroke="var(--color-primary)" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewbox="0 0 24 24" width="24"><rect height="14" rx="2" ry="2" width="20" x="2" y="7"></rect><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path></svg>
</div>
<h4>Customer Service</h4>
<p><?php echo get_field('p_31'); ?></p>
</div>
<div class="off-role-item card-glass compact-mobile">
<div class="off-role-icon">
<svg fill="none" height="24" stroke="var(--color-primary)" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewbox="0 0 24 24" width="24"><rect height="14" rx="2" ry="2" width="20" x="2" y="7"></rect><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path></svg>
</div>
<h4>Digital Marketers</h4>
<p><?php echo get_field('p_32'); ?></p>
</div>
<div class="off-role-item card-glass compact-mobile">
<div class="off-role-icon">
<svg fill="none" height="24" stroke="var(--color-primary)" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewbox="0 0 24 24" width="24"><rect height="14" rx="2" ry="2" width="20" x="2" y="7"></rect><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path></svg>
</div>
<h4>Data Analysts</h4>
<p><?php echo get_field('p_33'); ?></p>
</div>
<div class="off-role-item card-glass compact-mobile">
<div class="off-role-icon">
<svg fill="none" height="24" stroke="var(--color-primary)" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewbox="0 0 24 24" width="24"><rect height="14" rx="2" ry="2" width="20" x="2" y="7"></rect><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path></svg>
</div>
<h4>HR Specialists</h4>
<p><?php echo get_field('p_34'); ?></p>
</div>
<div class="off-role-item card-glass compact-mobile">
<div class="off-role-icon">
<svg fill="none" height="24" stroke="var(--color-primary)" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewbox="0 0 24 24" width="24"><rect height="14" rx="2" ry="2" width="20" x="2" y="7"></rect><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path></svg>
</div>
<h4>IT Support</h4>
<p><?php echo get_field('p_35'); ?></p>
</div>
<div class="off-role-item card-glass compact-mobile">
<div class="off-role-icon">
<svg fill="none" height="24" stroke="var(--color-primary)" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewbox="0 0 24 24" width="24"><rect height="14" rx="2" ry="2" width="20" x="2" y="7"></rect><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path></svg>
</div>
<h4>Content Writers</h4>
<p><?php echo get_field('p_36'); ?></p>
</div>
<div class="off-role-item card-glass compact-mobile">
<div class="off-role-icon">
<svg fill="none" height="24" stroke="var(--color-primary)" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewbox="0 0 24 24" width="24"><rect height="14" rx="2" ry="2" width="20" x="2" y="7"></rect><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path></svg>
</div>
<h4>Project Managers</h4>
<p><?php echo get_field('p_37'); ?></p>
</div>
</div>
</div>
</section>
<!-- offshoring comparison section -->
<section class="section content-panel" id="offshoring-comparison">
<div class="container">
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
<td class="col-highlight" data-label="You Save">~70%</td>
</tr>
<tr>
<td data-label="Role">Virtual Assistant</td>
<td data-label="Onshore (Annual)">?3,575,000</td>
<td class="col-highlight" data-label="Philippines with Kings City">?990,000</td>
<td class="col-highlight" data-label="You Save">~72%</td>
</tr>
<tr>
<td data-label="Role">Web Developer</td>
<td data-label="Onshore (Annual)">?5,775,000</td>
<td class="col-highlight" data-label="Philippines with Kings City">?1,760,000</td>
<td class="col-highlight" data-label="You Save">~70%</td>
</tr>
<tr>
<td data-label="Role">Customer Service Rep</td>
<td data-label="Onshore (Annual)">?3,300,000</td>
<td class="col-highlight" data-label="Philippines with Kings City">?880,000</td>
<td class="col-highlight" data-label="You Save">~73%</td>
</tr>
<tr>
<td data-label="Role">Graphic Designer</td>
<td data-label="Onshore (Annual)">?4,125,000</td>
<td class="col-highlight" data-label="Philippines with Kings City">?1,210,000</td>
<td class="col-highlight" data-label="You Save">~71%</td>
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
<section class="section content-panel" id="offshoring-services">
<div class="container text-center">
<span class="text-overline" style="margin-bottom: var(--space-sm); display: block;"><?php echo get_field('overline_50'); ?></span>
<h2 style="margin-bottom: var(--space-xl);"><?php echo get_field('h2_45'); ?></h2>
<div class="spaces-services-grid">
<div class="spaces-services__item">
<div class="spaces-services__item-icon">
<svg fill="none" height="24" stroke="var(--color-primary)" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewbox="0 0 24 24" width="24">
<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
<circle cx="9" cy="7" r="4"></circle>
<path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
<path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
</svg>
</div>
<div>
<h4 class="spaces-services__item-title">Talent Recruitment</h4>
<p class="spaces-services__item-text"><?php echo get_field('p_46'); ?></p>
</div>
</div>
<div class="spaces-services__item">
<div class="spaces-services__item-icon">
<svg fill="none" height="24" stroke="var(--color-primary)" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewbox="0 0 24 24" width="24">
<rect height="14" rx="2" ry="2" width="20" x="2" y="3"></rect>
<line x1="8" x2="16" y1="21" y2="21"></line>
<line x1="12" x2="12" y1="17" y2="21"></line>
</svg>
</div>
<div>
<h4 class="spaces-services__item-title">Infrastructure &amp; IT</h4>
<p class="spaces-services__item-text"><?php echo get_field('p_47'); ?></p>
</div>
</div>
<div class="spaces-services__item">
<div class="spaces-services__item-icon">
<svg fill="none" height="24" stroke="var(--color-primary)" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewbox="0 0 24 24" width="24">
<path d="M12 22s-8-4.5-8-11.8A8 8 0 0 1 12 2a8 8 0 0 1 8 8.2c0 7.3-8 11.8-8 11.8z"></path>
<circle cx="12" cy="10" r="3"></circle>
</svg>
</div>
<div>
<h4 class="spaces-services__item-title">Managed Facilities</h4>
<p class="spaces-services__item-text"><?php echo get_field('p_48'); ?></p>
</div>
</div>
<div class="spaces-services__item">
<div class="spaces-services__item-icon">
<svg fill="none" height="24" stroke="var(--color-primary)" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewbox="0 0 24 24" width="24">
<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
<polyline points="14 2 14 8 20 8"></polyline>
<line x1="16" x2="8" y1="13" y2="13"></line>
<line x1="16" x2="8" y1="17" y2="17"></line>
<polyline points="10 9 9 9 8 9"></polyline>
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
<a class="btn" href="apply.html">Request a Detailed Quote</a>
</div>
</div>
</section>
<!-- offshoring gallery section -->
<section class="section content-panel" style="position: relative;">
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
