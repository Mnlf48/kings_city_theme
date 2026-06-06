<?php
/**
 * Template Name: Apply Step 3 (Booking)
 */

// Block indexing for this secure page
add_action('wp_head', function() {
    echo '<meta name="robots" content="noindex, nofollow">' . "\n";
});

$token = isset($_GET['token']) ? sanitize_text_field($_GET['token']) : '';
$is_valid_link = !empty($token);

get_header();
?>

<main id="primary" class="site-main" style="padding: 6rem 1rem; background: var(--color-background); min-height: 80vh;">
    <div class="step3-container" style="max-width: 800px; width: 100%; background: #fff; padding: 3rem; border-radius: var(--radius-lg); box-shadow: var(--shadow-md); margin: 0 auto;">
        
        <?php if (!$is_valid_link) : ?>
            
            <div class="step3-error" style="text-align: center; padding: 3rem 0;">
                <i class="fa-solid fa-lock" style="font-size: 3rem; color: var(--color-text-muted); margin-bottom: 1rem;"></i>
                <h2>Secure Link Required</h2>
                <p style="color: var(--color-text-muted); margin-bottom: 2rem;">It looks like this link is missing a secure token or has expired.</p>
                <a href="<?php echo esc_url(home_url('/apply')); ?>" class="kc-btn kc-btn-primary">Return to Apply Page</a>
            </div>

        <?php else : ?>
            
            <div class="step3-header" style="text-align: center; margin-bottom: 2.5rem;">
                <span style="font-size: 0.875rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; color: var(--color-primary);">Step 3 of 3</span>
                <h1 style="margin-bottom: 0.5rem;">Book Your Discovery Call</h1>
                <p style="color: var(--color-text-muted);">Please select a time below to review your custom proposal with our team.</p>
            </div>

            <div style="text-align: center; padding: 1rem 0;">
                <!-- Calendly inline widget begin -->
                <div class="calendly-inline-widget" data-url="https://calendly.com/lospedros479/30min" style="min-width:320px;height:700px;"></div>
                <script type="text/javascript" src="https://assets.calendly.com/assets/external/widget.js" async></script>
                <!-- Calendly inline widget end -->
            </div>

        <?php endif; ?>
        
    </div>
</main>

<?php
get_footer();
?>
