<?php
/**
 * Template Name: Apply Step 3 (Booking)
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

<main id="primary" class="site-main" style="padding: 6rem 1rem; background: var(--color-background); min-height: 80vh;">
    <div class="step3-container" style="max-width: 800px; width: 100%; background: #fff; padding: 3rem; border-radius: var(--radius-lg); box-shadow: var(--shadow-md); margin: 0 auto;">
        
        <?php if (!$is_valid_link) : ?>
            
            <div class="step3-error" style="text-align: center; padding: 3rem 0;">
                <i class="fa-solid fa-lock" style="font-size: 3rem; color: var(--color-text-muted); margin-bottom: 1rem;"></i>
                <h2>Secure Link Required</h2>
                <p style="color: var(--color-text-muted); margin-bottom: 2rem;">It looks like this link is missing a secure token or has expired.</p>
                <a href="<?php echo esc_url(home_url('/apply')); ?>" class="kc-btn kc-btn-primary">Return to Apply Page</a>
            </div>

        <?php elseif ($status === 'Step 3 - Submitted' || $status === 'Complete') : ?>
            <div class="step3-success" style="text-align: center; padding: 4rem 2rem;">
                <i class="fa-solid fa-circle-check" style="font-size: 4rem; color: #10b981; margin-bottom: 1.5rem;"></i>
                <h2 style="margin-bottom: 1rem; color: var(--color-primary);">Already Booked</h2>
                <p style="color: var(--color-text-muted); font-size: 1.125rem;">You have already booked your discovery call. See you soon!</p>
            </div>

        <?php elseif ($status === 'Step 3 - Discovery Call') : ?>
            
            <div class="step3-header" style="text-align: center; margin-bottom: 2.5rem;">
                <span style="display: block; font-size: 0.875rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; color: var(--color-primary); margin-bottom: 0.5rem; text-align: center;">Step 3 of 3</span>
                <h1 style="margin-bottom: 0.5rem; text-align: center;">Book Your Discovery Call</h1>
                <p style="color: var(--color-text-muted); text-align: center;">Please select a time below to review your custom proposal with our team.</p>
            </div>

            <div id="calendly-container" style="text-align: center; padding: 1rem 0;">
                <!-- Calendly inline widget begin -->
                <div class="calendly-inline-widget" data-url="https://calendly.com/lospedros479/30min" style="min-width:320px;height:700px;"></div>
                <script type="text/javascript" src="https://assets.calendly.com/assets/external/widget.js" async></script>
                <!-- Calendly inline widget end -->
            </div>
            
            <div id="success-message" style="display:none; text-align: center; padding: 4rem 2rem;">
                <i class="fa-solid fa-circle-check" style="font-size: 4rem; color: #10b981; margin-bottom: 1.5rem;"></i>
                <h2 style="margin-bottom: 1rem; color: var(--color-primary);">Booking Confirmed!</h2>
                <p style="color: var(--color-text-muted); font-size: 1.125rem;">Your discovery call has been booked! We will send a confirmation email shortly.</p>
            </div>

            <script>
                var kc_ajax_obj = {
                    ajax_url: "<?php echo admin_url('admin-ajax.php'); ?>",
                    nonce: "<?php echo wp_create_nonce('kc_calendly_nonce'); ?>",
                    token: "<?php echo esc_js($token); ?>"
                };

                function isCalendlyEvent(e) {
                    return e.origin === "https://calendly.com" && e.data.event && e.data.event.indexOf("calendly.") === 0;
                }
                
                window.addEventListener("message", function(e) {
                    if (isCalendlyEvent(e)) {
                        if (e.data.event === "calendly.event_scheduled") {
                            // Hit AJAX
                            var formData = new FormData();
                            formData.append('action', 'kc_calendly_step3_booked');
                            formData.append('nonce', kc_ajax_obj.nonce);
                            formData.append('token', kc_ajax_obj.token);

                            fetch(kc_ajax_obj.ajax_url, {
                                method: 'POST',
                                body: formData
                            }).then(function(response) {
                                document.getElementById('calendly-container').style.display = 'none';
                                document.querySelector('.step3-header').style.display = 'none';
                                document.getElementById('success-message').style.display = 'block';
                            });
                        }
                    }
                });
            </script>
        <?php else : ?>
            <div class="step3-error" style="text-align: center; padding: 3rem 0;">
                <i class="fa-solid fa-lock" style="font-size: 3rem; color: var(--color-text-muted); margin-bottom: 1rem;"></i>
                <h2>Invalid Status</h2>
                <p style="color: var(--color-text-muted); margin-bottom: 2rem;">Your application is not currently waiting for a discovery call booking.</p>
            </div>
        <?php endif; ?>
        
    </div>
</main>

<?php
get_footer();
?>
