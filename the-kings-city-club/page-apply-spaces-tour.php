<?php
/**
 * Template Name: Book a Tour (Secure)
 */

// Block indexing for this secure page
add_action('wp_head', function() {
    echo '<meta name="robots" content="noindex, nofollow">' . "\n";
});

$token = isset($_GET['token']) ? sanitize_text_field($_GET['token']) : '';
$is_valid_link = false;
$status = '';

if (!empty($token)) {
    $existing_ticket = get_posts(array(
        'post_type'      => 'kc_application',
        'posts_per_page' => 1,
        'meta_query'     => array(
            array(
                'key'   => 'kc_secure_token',
                'value' => $token,
            ),
        ),
    ));

    if (!empty($existing_ticket)) {
        $is_valid_link = true;
        $status = get_post_meta($existing_ticket[0]->ID, 'kc_status', true);
    }
}

get_header();
?>

<style>
    .tour-secure-container {
        max-width: 800px;
        margin: 4rem auto;
        padding: 2rem;
        background: var(--color-bg-ivory);
        border-radius: var(--radius-card);
        box-shadow: var(--glass-shadow-lg);
        text-align: center;
    }
    .tour-secure-header {
        text-align: center;
    }
    .tour-secure-header h1 {
        font-family: var(--font-heading);
        color: var(--color-primary);
        margin-bottom: 1rem;
        text-align: center;
    }
    .tour-secure-header p {
        color: var(--color-text-muted);
        font-size: 1.1rem;
        line-height: 1.6;
        margin-bottom: 2rem;
        text-align: center;
    }
    .error-container {
        text-align: center;
        padding: 4rem 2rem;
    }
</style>

<main id="main-content">
    <div class="container">
        <?php if (!$is_valid_link): ?>
            <div class="error-container animate-fadeInUp">
                <h1 style="color: var(--color-accent-red); margin-bottom: 1rem;">Link Expired or Invalid</h1>
                <p style="color: var(--color-text-muted); margin-bottom: 2rem;">This tour booking link is invite-only. If you believe this is an error, please check your email for the correct link or contact our support team.</p>
                <a href="<?php echo home_url('/apply/'); ?>" class="btn btn--large">Return to Application</a>
            </div>
        <?php elseif ($status === 'Step 2 - Tour Submitted' || $status === 'Complete - Tour Scheduled'): ?>
            <div class="tour-secure-container animate-fadeInUp">
                <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="var(--color-accent-red)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom: 1rem;"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                <h2 style="color: var(--color-primary); margin-bottom: 1rem; font-family: var(--font-heading);">Already Booked</h2>
                <p style="color: var(--color-text-muted); font-size: 1.1rem; line-height: 1.6;">You have already booked your tour. We look forward to seeing you!</p>
            </div>
        <?php elseif ($status === 'Step 2 - Waiting for Tour Booking'): ?>
            <div class="tour-secure-container animate-fadeInUp">
                <div class="tour-secure-header" style="text-align: center; margin-bottom: 2.5rem;">
                    <span class="text-overline" style="color: var(--color-accent-red); font-size: 0.85rem; font-weight: 700; letter-spacing: 0.1em; text-transform: uppercase; margin-bottom: 0.5rem; display: block; text-align: center;">Application Approved</span>
                    <h1 style="text-align: center; margin-bottom: 0.5rem;">Book Your Club Tour</h1>
                    <p style="text-align: center;">Congratulations! We have reviewed your application and would love to invite you to The Kings City Club. Please select a time below to come in for a personal tour and consultation.</p>
                </div>
                
                <div id="calendly-container">
                    <!-- Calendly inline widget begin -->
                    <div class="calendly-inline-widget" data-url="https://calendly.com/lospedros479/kings-city-club-tour" style="min-width:320px;height:700px;"></div>
                    <script type="text/javascript" src="https://assets.calendly.com/assets/external/widget.js" async></script>
                    <!-- Calendly inline widget end -->
                </div>

                <!-- Success Container (Hidden until scheduled) -->
                <div id="tour-success-message" style="display: none; padding: 3rem 1rem; text-align: center;">
                    <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="var(--color-accent-red)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom: 1rem;"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                    <h2 style="color: var(--color-primary); margin-bottom: 1rem; font-family: var(--font-heading);">Tour Scheduled!</h2>
                    <p style="color: var(--color-text-muted); font-size: 1.1rem; line-height: 1.6;">Your tour has been booked! We look forward to welcoming you.</p>
                </div>

                <script>
                    var kc_ajax_obj = {
                        ajax_url: "<?php echo admin_url('admin-ajax.php'); ?>",
                        nonce: "<?php echo wp_create_nonce('kc_calendly_nonce'); ?>",
                        token: "<?php echo esc_js($token); ?>"
                    };
                    
                    window.addEventListener(
                        'message',
                        function(e) {
                            if (e.origin === "https://calendly.com" && e.data.event && e.data.event === 'calendly.event_scheduled') {
                                var formData = new FormData();
                                formData.append('action', 'kc_calendly_tour_booked');
                                formData.append('nonce', kc_ajax_obj.nonce);
                                formData.append('token', kc_ajax_obj.token);

                                fetch(kc_ajax_obj.ajax_url, {
                                    method: 'POST',
                                    body: formData
                                }).then(function(response) {
                                    document.getElementById('calendly-container').style.display = 'none';
                                    document.querySelector('.tour-secure-header').style.display = 'none';
                                    document.getElementById('tour-success-message').style.display = 'block';
                                });
                            }
                        }
                    );
                </script>
            </div>
        <?php else: ?>
            <div class="error-container animate-fadeInUp">
                <h1 style="color: var(--color-accent-red); margin-bottom: 1rem;">Invalid Status</h1>
                <p style="color: var(--color-text-muted); margin-bottom: 2rem;">Your application is not currently waiting for a tour booking.</p>
                <a href="<?php echo home_url('/apply/'); ?>" class="btn btn--large">Return to Application</a>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php get_footer(); ?>