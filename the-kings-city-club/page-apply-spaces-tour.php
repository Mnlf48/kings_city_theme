<?php
/**
 * Template Name: Book a Tour (Secure)
 */

// Block indexing for this secure page
add_action('wp_head', function() {
    echo '<meta name="robots" content="noindex, nofollow">' . "\n";
});

$token = isset($_GET['token']) ? sanitize_text_field($_GET['token']) : '';
$is_valid_link = ($token === 'approved');

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
        <?php if ($is_valid_link): ?>
            <div class="tour-secure-container animate-fadeInUp">
                <div class="tour-secure-header">
                    <span class="text-overline" style="color: var(--color-accent-red); font-size: 0.85rem; font-weight: 700; letter-spacing: 0.1em; text-transform: uppercase; margin-bottom: 0.5rem; display: block;">Application Approved</span>
                    <h1>Book Your Club Tour</h1>
                    <p>Congratulations! We have reviewed your application and would love to invite you to The Kings City Club. Please select a time below to come in for a personal tour and consultation.</p>
                </div>
                
                <!-- Calendly inline widget begin -->
                <div class="calendly-inline-widget" data-url="https://calendly.com/lospedros479/kings-city-club-tour" style="min-width:320px;height:700px;"></div>
                <script type="text/javascript" src="https://assets.calendly.com/assets/external/widget.js" async></script>
                <!-- Calendly inline widget end -->

                <!-- Success Container (Hidden until scheduled) -->
                <div id="tour-success-message" style="display: none; padding: 3rem 1rem; text-align: center;">
                    <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="var(--color-accent-red)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom: 1rem;"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                    <h2 style="color: var(--color-primary); margin-bottom: 1rem; font-family: var(--font-heading);">Tour Scheduled!</h2>
                    <p style="color: var(--color-text-muted); font-size: 1.1rem; line-height: 1.6;">Thank you for booking your Kings City Club tour. We are looking forward to showing you the space!</p>
                    <p style="color: var(--color-text-muted); font-size: 0.9rem; margin-top: 1rem; font-style: italic;">Redirecting you back to the home page...</p>
                </div>

                <script>
                    window.addEventListener(
                        'message',
                        function(e) {
                            if (e.data.event && e.data.event === 'calendly.event_scheduled') {
                                // Hide the calendly widget and header
                                document.querySelector('.calendly-inline-widget').style.display = 'none';
                                document.querySelector('.tour-secure-header').style.display = 'none';
                                
                                // Show the success message (centered)
                                document.getElementById('tour-success-message').style.display = 'block';
                                
                                // Redirect after 4 seconds
                                setTimeout(function() {
                                    window.location.href = "<?php echo home_url('/apply/'); ?>";
                                }, 4000);
                            }
                        }
                    );
                </script>
            </div>
        <?php else: ?>
            <div class="error-container animate-fadeInUp">
                <h1 style="color: var(--color-accent-red); margin-bottom: 1rem;">Link Expired or Invalid</h1>
                <p style="color: var(--color-text-muted); margin-bottom: 2rem;">This tour booking link is invite-only. If you believe this is an error, please check your email for the correct link or contact our support team.</p>
                <a href="<?php echo home_url('/apply/'); ?>" class="btn btn--large">Return to Application</a>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php get_footer(); ?>
