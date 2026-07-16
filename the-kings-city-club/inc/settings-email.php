<?php
if (!defined('ABSPATH')) exit;

// Admin Menu Hook
add_action('admin_menu', 'kc_email_templates_menu');
function kc_email_templates_menu() {
    add_menu_page(
        'Email Templates',
        'Email Templates',
        'manage_options',
        'kc-email-templates',
        'kc_email_templates_page',
        'dashicons-email-alt',
        30
    );
}

function kc_email_templates_page() {
    if (!current_user_can('manage_options')) return;

    $quote_tabs = array(
        'quote_contacted' => 'Proposal Request Acknowledgment (Client)',
        'quote_confirmed' => 'Quote Lead Converted/Confirmed Email (Client)',
        'quote_rejected'  => 'Quote Lead Rejected Email (Client)'
    );

    $booking_tabs = array(
        'booking_confirmed' => 'Booking Confirmed Email (Client)',
        'booking_rejected'  => 'Booking Rejected Email (Client)'
    );

    $mailing_list_tabs = array(
        'newsletter_broadcast' => 'Newsletter Broadcast (Mailing List)',
        'birthday_promo'       => 'Birthday Promo (Automated)',
        'campaign_promo'       => 'Campaign / Other Promo (Default Template)',
    );

    $tabs = array_merge($quote_tabs, $booking_tabs, $mailing_list_tabs);

    $active_tab = isset($_GET['tab']) && array_key_exists($_GET['tab'], $tabs) ? $_GET['tab'] : 'quote_contacted';

    // Save Data
    if (isset($_POST['kc_email_templates_nonce']) && wp_verify_nonce($_POST['kc_email_templates_nonce'], 'kc_save_email_templates')) {
        $prefix = 'kc_' . $active_tab . '_';
        update_option($prefix . 'subject',  sanitize_text_field(wp_unslash($_POST['email_subject'])));
        update_option($prefix . 'heading',  sanitize_text_field(wp_unslash($_POST['email_heading'])));
        update_option($prefix . 'body',     wp_kses_post(wp_unslash($_POST['email_body'])));
        update_option($prefix . 'banner',   sanitize_text_field(wp_unslash($_POST['email_banner'])));
        update_option($prefix . 'btn_text', sanitize_text_field(wp_unslash($_POST['email_btn_text'])));
        // Saved as plain text so tokens like {site_url} survive — esc_url() applied at render time
        update_option($prefix . 'btn_url',  sanitize_text_field(wp_unslash($_POST['email_btn_url'])));

        // Birthday Promo: also save discount settings
        if ($active_tab === 'birthday_promo') {
            $disc_type = sanitize_text_field($_POST['bday_discount_type'] ?? 'percentage');
            $disc_val  = (float) ($_POST['bday_discount_value'] ?? 15);
            update_option($prefix . 'discount_type',  $disc_type);
            update_option($prefix . 'discount_value', $disc_val);
        }

        echo '<div class="notice notice-success is-dismissible"><p>Email template settings saved successfully!</p></div>';
    }

    $prefix = 'kc_' . $active_tab . '_';
    
    // Default fallbacks based on tab
    $def_subject = ''; $def_heading = ''; $def_body = ''; $def_banner = ''; $def_btn_text = ''; $def_btn_url = '';
    
    if ($active_tab === 'quote_contacted') {
        $def_subject = 'Proposal Request Acknowledgment - Kings City';
        $def_heading = 'Proposal Request Acknowledgment';
        $def_body = 'Thank you for considering Kings City as your trusted workforce solutions partner. We have successfully received your service configuration request, and our business development team is currently analyzing your specific role requirements to formulate a comprehensive and competitive proposal tailored to your needs. We are committed to providing you with top-tier talent and look forward to the possibility of collaborating with you.';
        $def_banner = 'A dedicated representative will contact you within one business day to present a detailed pricing breakdown, discuss your specific needs, and answer any preliminary questions you may have.';
        $def_btn_text = 'Visit Kings City';
        $def_btn_url = '{site_url}';
    } elseif ($active_tab === 'quote_confirmed') {
        $def_subject = 'Welcome to Kings City - Partnership Confirmed';
        $def_heading = 'Partnership Confirmed';
        $def_body = 'We are absolutely delighted to officially welcome you as a valued partner of Kings City. Your service proposal and team configuration have been marked as confirmed, and we are already initiating the next steps in our onboarding and talent acquisition process. Our team is dedicated to ensuring a seamless transition and delivering exceptional workforce solutions that drive your business forward. You will be introduced to your dedicated account manager shortly.';
        $def_banner = 'We look forward to a successful and long-lasting partnership. Your account manager will be in touch with you shortly to begin the onboarding process.';
        $def_btn_text = 'Visit Kings City';
        $def_btn_url = '{site_url}';
    } elseif ($active_tab === 'quote_rejected') {
        $def_subject = 'Update on your Kings City Quote Request';
        $def_heading = 'Proposal Update';
        $def_body = "Thank you for reaching out to Kings City and giving us the opportunity to review your workforce needs. After carefully analyzing your service configuration request, we unfortunately cannot fulfill your specific role requirements at this time, as they fall outside our current operational capacities or talent pool specialties.\n\nWe deeply appreciate your interest in partnering with us, and we will keep your company profile on hand should our service offerings expand to cover your specific needs in the future.";
        $def_banner = 'We wish you the very best in your search for a suitable workforce solutions partner.';
        $def_btn_text = 'Visit Kings City';
        $def_btn_url = '{site_url}';
    } elseif ($active_tab === 'booking_confirmed') {
        $def_subject = 'Your Kings City Booking is Confirmed!';
        $def_heading = 'Booking Confirmation';
        $def_body = "Dear {fname},\n\nYour booking for the <strong>{space}</strong> has been successfully confirmed. We are thrilled to host you and your team. Please arrive on your chosen date and complete your payment at our front desk.\n\nIf you need to make any changes to your reservation, please reply directly to this correspondence. We look forward to seeing you soon!";
        $def_banner = 'We\'ve prepared some important information and updates for your upcoming visit. Please review this before you arrive.';
        $def_btn_text = 'View Newsletter';
        $def_btn_url = '{packet_url}';
    } elseif ($active_tab === 'booking_rejected') {
        $def_subject = 'Update regarding your Kings City Booking';
        $def_heading = 'Booking Update';
        $def_body = "Hi {fname},\n\nUnfortunately, we are unable to accommodate your booking request for the {space} on {date}.\n\n<strong>Reason:</strong>\n{admin_note}\n\nIf you have any questions, please reply to this email.\n\nThank you,\nThe Kings City Team";
        $def_banner = 'We apologize for the inconvenience and hope to host you in the future.';
        $def_btn_text = '';
        $def_btn_url = '';
    } elseif ($active_tab === 'newsletter_broadcast') {
        $def_subject = 'News & Updates from The Kings City Club';
        $def_heading = 'Stay in the Loop';
        $def_body = "Hi there,\n\nWe have some exciting news and updates to share with you from The Kings City Club. Thank you for being part of our community — we're glad to keep you in the loop!";
        $def_banner = '';
        $def_btn_text = 'Visit Kings City';
        $def_btn_url = '{site_url}';
    } elseif ($active_tab === 'birthday_promo') {
        $def_subject  = 'Happy Birthday from The Kings City Club! 🎂';
        $def_heading  = 'Happy Birthday!';
        $def_body     = "Dear {first_name},\n\nWishing you a wonderful birthday from all of us at The Kings City Club!\n\nAs a special gift, here's your exclusive birthday discount code:\n\n🎁 {promo_code}\n\nUse it when booking any of our spaces to enjoy your birthday savings. This code is valid for 30 days and is one-time use only.\n\nSee you soon!";
        $def_banner   = 'An exclusive birthday discount code, just for you.';
        $def_btn_text = 'Book My Space';
        $def_btn_url  = '{site_url}';
    } elseif ($active_tab === 'campaign_promo') {
        $def_subject  = 'A Special Offer from The Kings City Club';
        $def_heading  = 'A Special Offer Just for You';
        $def_body     = "Hi {first_name},\n\nWe have an exclusive offer we'd love to share with you.\n\nUse code {promo_code} at checkout to enjoy your discount. This offer is valid for a limited time only — don't miss out!\n\nSee you soon at Kings City.";
        $def_banner   = 'Use your exclusive promo code at checkout to redeem your discount.';
        $def_btn_text = 'Book Now';
        $def_btn_url  = '{site_url}';
    }

    $subject = get_option($prefix . 'subject', $def_subject);
    $heading = get_option($prefix . 'heading', $def_heading);
    $body = get_option($prefix . 'body', $def_body);
    $banner = get_option($prefix . 'banner', $def_banner);
    $btn_text = get_option($prefix . 'btn_text', $def_btn_text);
    $btn_url = get_option($prefix . 'btn_url', $def_btn_url);

    // CSS for Sidebar Layout and Branding
    ?>
    <style>
        .kc-email-settings-wrapper { display: flex; margin-top: 20px; gap: 20px; font-family: 'Outfit', Arial, sans-serif; }
        .kc-email-sidebar { width: 280px; flex-shrink: 0; background: #FFF9EF; border: 1px solid rgba(189,69,31,0.2); padding: 15px 0; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); }
        .kc-email-sidebar-heading { font-weight: 800; text-transform: uppercase; font-size: 12px; color: #BD451F; padding: 10px 15px; border-bottom: 1px solid rgba(189,69,31,0.1); margin-top: 0; margin-bottom: 5px; letter-spacing: 0.5px; }
        .kc-email-nav-item { display: block; padding: 12px 15px; text-decoration: none; color: #2B2B2B; font-size: 13px; line-height: 1.4; border-left: 4px solid transparent; transition: all 0.2s; }
        .kc-email-nav-item:hover { background: #FFBFBF; color: #AC201A; }
        .kc-email-nav-item.active { background: #FFBFBF; border-left-color: #BD451F; color: #AC201A; font-weight: 600; }
        .kc-email-content { flex-grow: 1; background: #FFF9EF; border: 1px solid rgba(189,69,31,0.2); padding: 30px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); }
        .kc-email-content h2 { color: #BD451F; font-weight: 800; border-bottom: 2px solid rgba(189,69,31,0.1); padding-bottom: 15px; margin-top: 0; font-size: 20px; }
        .kc-email-content .form-table th { color: #AC201A; font-weight: 600; font-size: 14px; }
        .kc-email-content p.description { color: #646970; font-style: italic; }
        .kc-email-content .button-primary { background: #AC201A; border-color: #8c1713; color: #FFF9EF; text-shadow: none; box-shadow: none; font-weight: bold; padding: 4px 20px; font-size: 14px; transition: background 0.2s; }
        .kc-email-content .button-primary:hover { background: #BD451F; border-color: #AC201A; color: #FFF9EF; }
    </style>
    
    <div class="wrap">
        <h1 class="wp-heading-inline">Email Templates Configuration</h1>
        <hr class="wp-header-end">
        <p style="color: #646970; font-style: italic;">Customize the automated emails sent by the recruitment and sales systems. Use the left menu to navigate through templates.</p>

        <div class="kc-email-settings-wrapper">
            <!-- Sidebar -->
            <div class="kc-email-sidebar">
                <h3 class="kc-email-sidebar-heading">Quote Emails</h3>
                <?php foreach ($quote_tabs as $tab_key => $tab_name): ?>
                    <a href="?page=kc-email-templates&tab=<?php echo esc_attr($tab_key); ?>" class="kc-email-nav-item <?php echo $active_tab === $tab_key ? 'active' : ''; ?>">
                        <?php echo esc_html($tab_name); ?>
                    </a>
                <?php endforeach; ?>

                <h3 class="kc-email-sidebar-heading" style="margin-top: 15px;">Booking Emails</h3>
                <?php foreach ($booking_tabs as $tab_key => $tab_name): ?>
                    <a href="?page=kc-email-templates&tab=<?php echo esc_attr($tab_key); ?>" class="kc-email-nav-item <?php echo $active_tab === $tab_key ? 'active' : ''; ?>">
                        <?php echo esc_html($tab_name); ?>
                    </a>
                <?php endforeach; ?>

                <h3 class="kc-email-sidebar-heading" style="margin-top: 15px;">Mailing List & Campaigns</h3>
                <?php foreach ($mailing_list_tabs as $tab_key => $tab_name): ?>
                    <a href="?page=kc-email-templates&tab=<?php echo esc_attr($tab_key); ?>" class="kc-email-nav-item <?php echo $active_tab === $tab_key ? 'active' : ''; ?>">
                        <?php echo esc_html($tab_name); ?>
                    </a>
                <?php endforeach; ?>
            </div>

            <!-- Content Area -->
            <div class="kc-email-content">
                <h2>Edit Template: <?php echo esc_html($tabs[$active_tab]); ?></h2>
                <form method="POST" action="">
                    <?php wp_nonce_field('kc_save_email_templates', 'kc_email_templates_nonce'); ?>
                    
                    <table class="form-table">
                        <tbody>
                            <tr>
                                <th scope="row"><label for="email_subject">Email Subject</label></th>
                                <td><input type="text" name="email_subject" id="email_subject" value="<?php echo esc_attr($subject); ?>" class="regular-text" style="width: 100%;"></td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="email_heading">Email Heading</label></th>
                                <td>
                                    <input type="text" name="email_heading" id="email_heading" value="<?php echo esc_attr($heading); ?>" class="regular-text" style="width: 100%;">
                                    <p class="description">Main heading text printed in the colored card header at the top of the email.</p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="email_body">Email Body (HTML/Copy)</label></th>
                                <td>
                                    <?php 
                                    $settings = array(
                                        'media_buttons' => false,
                                        'textarea_name' => 'email_body',
                                        'textarea_rows' => 10,
                                        'teeny'         => false
                                    );
                                    wp_editor($body, 'email_body_editor', $settings); 
                                    ?>
                                    <?php 
                                    if ($active_tab === 'booking_rejected') {
                                        echo '<br><span style="font-size: 12px;">Supported tokens: <code>{fname}</code>, <code>{space}</code>, <code>{date}</code>, <code>{duration}</code>, <code>{price}</code>, <code>{arrival}</code>, <code>{participants}</code>, <code>{admin_note}</code></span>';
                                    } elseif ($active_tab === 'booking_confirmed') {
                                        echo '<br><span style="font-size: 12px;">Supported tokens: <code>{fname}</code>, <code>{space}</code>, <code>{date}</code>, <code>{duration}</code>, <code>{price}</code>, <code>{arrival}</code>, <code>{participants}</code></span>';
                                    } elseif ($active_tab === 'newsletter_broadcast') {
                                        echo '<br><span style="font-size: 12px;">Supported tokens: <code>{site_url}</code> &nbsp;|&nbsp; <strong>Note:</strong> This template is used when sending a broadcast from the Mailing List page.</span>';
                                    } elseif ($active_tab === 'birthday_promo') {
                                        echo '<br><span style="font-size: 12px;">Supported tokens: <code>{first_name}</code>, <code>{promo_code}</code>, <code>{discount}</code>, <code>{site_url}</code></span>';
                                    } elseif ($active_tab === 'campaign_promo') {
                                        echo '<br><span style="font-size: 12px;">Supported tokens: <code>{first_name}</code>, <code>{email}</code>, <code>{promo_code}</code>, <code>{site_url}</code>, <code>{unsubscribe_url}</code> &nbsp;|&nbsp; <strong>Note:</strong> This is the default template loaded when you create a new Campaign.</span>';
                                    } else {
                                        echo '<br><span style="font-size: 12px;">Supported tokens: <code>{client_name}</code>, <code>{client_email}</code>, <code>{site_url}</code></span>';
                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="email_banner">Banner Highlight Text</label></th>
                                <td>
                                    <input type="text" name="email_banner" id="email_banner" value="<?php echo esc_attr($banner); ?>" class="regular-text" style="width: 100%;">
                                    <p class="description">Optional highlight text shown in a prominent visual card inside the email.</p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="email_btn_text">Button Text</label></th>
                                <td>
                                    <input type="text" name="email_btn_text" id="email_btn_text" value="<?php echo esc_attr($btn_text); ?>" class="regular-text" style="width: 50%;">
                                    <p class="description">Optional call-to-action button label.</p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="email_btn_url">Button Link (URL)</label></th>
                                <td>
                                    <input type="text" name="email_btn_url" id="email_btn_url" value="<?php echo esc_attr($btn_url); ?>" class="regular-text" style="width: 100%;">
                                    <?php 
                                    if ($active_tab === 'booking_confirmed') {
                                        echo '<br><span style="font-size: 12px;">Supports link URLs or dynamic tokens like <code>{site_url}</code> or <code>{packet_url}</code> (for the newsletter box).</span>';
                                    } else {
                                        echo '<br><span style="font-size: 12px;">Supports link URLs or dynamic tokens like <code>{site_url}</code>.</span>';
                                    }
                                    ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <?php if ($active_tab === 'birthday_promo') : 
                        $bday_disc_type  = get_option($prefix . 'discount_type',  'percentage');
                        $bday_disc_value = get_option($prefix . 'discount_value', 15);
                    ?>
                    <h3 style="color:#AC201A; margin-top: 30px; border-top: 1px solid rgba(189,69,31,0.1); padding-top: 20px;">🎁 Birthday Discount Settings</h3>
                    <p style="color:#646970; font-size:13px; margin-bottom:15px;">Configure the automatic discount generated for each subscriber on their birthday. Each code is unique, one-time use, and expires after 30 days.</p>
                    <table class="form-table"><tbody>
                        <tr>
                            <th scope="row"><label for="bday_discount_type">Discount Type</label></th>
                            <td>
                                <select name="bday_discount_type" id="bday_discount_type">
                                    <option value="percentage" <?php selected($bday_disc_type, 'percentage'); ?>>Percentage (% Off)</option>
                                    <option value="flat"       <?php selected($bday_disc_type, 'flat'); ?>>Flat Amount (Php Off)</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><label for="bday_discount_value">Discount Value</label></th>
                            <td>
                                <input type="number" step="0.01" min="0" name="bday_discount_value" id="bday_discount_value" value="<?php echo esc_attr($bday_disc_value); ?>" class="small-text" />
                                <p class="description">e.g., <code>15</code> for 15% off, or <code>500</code> for Php 500 flat discount.</p>
                            </td>
                        </tr>
                    </tbody></table>
                    <?php endif; ?>

                    <p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Save Template Settings"></p>
                </form>

                <?php if ($active_tab === 'birthday_promo') : ?>
                <hr style="margin:30px 0; border:0; border-top:1px solid rgba(189,69,31,0.15);">
                <h3 style="color:#AC201A; margin:0 0 8px;">🎂 Force Send Birthday Promos</h3>
                <p style="color:#646970; font-size:13px; margin-bottom:14px;">
                    Sends the birthday promo immediately to all <strong>Active</strong> subscribers whose birthday falls today (<strong><?php echo esc_html(date_i18n('F j')); ?></strong>).<br>
                    Birthday promos are also sent automatically every day at midnight — use this button if you prefer not to wait.
                </p>
                <button type="button" id="kc-bday-force-btn" class="button button-primary" style="background:#AC201A; border-color:#8E1510;">
                    Force Send Birthday Promos Now
                </button>
                <span id="kc-bday-force-result" style="display:none; margin-left:12px; font-size:13px; font-weight:600;"></span>

                <script>
                jQuery(document).ready(function($) {
                    $('#kc-bday-force-btn').on('click', function() {
                        var btn = $(this);
                        var res = $('#kc-bday-force-result');
                        btn.prop('disabled', true).text('Sending…');
                        res.hide().removeClass('kc-bday-ok kc-bday-err');

                        $.post(ajaxurl, {
                            action: 'kc_force_birthday_promos',
                            nonce:  '<?php echo esc_js(wp_create_nonce("kc_force_birthday_promos")); ?>'
                        }, function(r) {
                            btn.prop('disabled', false).text('Force Send Birthday Promos Now');
                            if (r.success) {
                                res.css('color', '#166534').text('✓ ' + r.data.message).show();
                            } else {
                                res.css('color', '#991b1b').text('✗ ' + (r.data || 'Unknown error.')).show();
                            }
                        }).fail(function() {
                            btn.prop('disabled', false).text('Force Send Birthday Promos Now');
                            res.css('color', '#991b1b').text('✗ Request failed. Please try again.').show();
                        });
                    });
                });
                </script>
                <?php endif; ?>

            </div>
        </div>
    </div>
    <?php
}
