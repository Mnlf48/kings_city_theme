<?php
if (!defined('ABSPATH')) exit;
/**
 * HTML Email Template: Newsletter Broadcast (Mailing List)
 *
 * Variables available:
 * - $email_heading (string)
 * - $email_body    (string, HTML)
 * - $email_banner  (string)
 * - $email_btn_text (string)
 * - $email_btn_url  (string)
 */
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo esc_html($email_heading); ?></title>
</head>
<body style="font-family: 'Outfit', Arial, Helvetica, sans-serif; background-color: #FFF9EF; margin: 0; padding: 40px 10px; color: #2B2B2B;">

<table width="100%" border="0" cellspacing="0" cellpadding="0" style="max-width: 650px; margin: 0 auto; background-color: #ffffff; overflow: hidden; border: 1px solid rgba(189,69,31,0.2);">

    <!-- Top Stripe Bar -->
    <tr>
        <td style="height: 8px; background-color: #BD451F;"></td>
    </tr>

    <!-- Header / Logo -->
    <tr>
        <td style="padding: 30px; text-align: center; border-bottom: 1px solid rgba(189,69,31,0.2); background-color: #FFF9EF;">
            <a href="<?php echo esc_url(home_url()); ?>" style="text-decoration: none; color: #BD451F; font-size: 26px; font-weight: 800; letter-spacing: 0.5px; text-transform: uppercase;">
                Kings City Club
            </a>
        </td>
    </tr>

    <!-- Main Content -->
    <tr>
        <td style="padding: 40px 30px; background-color: #ffffff;">

            <h2 style="margin-top: 0; color: #BD451F; font-size: 24px;">
                <?php echo esc_html($email_heading ?: 'Stay in the Loop'); ?>
            </h2>

            <?php if (!empty($email_body)): ?>
            <div style="font-size: 16px; line-height: 1.7; color: #2B2B2B; margin-bottom: 30px;">
                <?php echo wp_kses_post(wpautop($email_body)); ?>
            </div>
            <?php endif; ?>

            <?php if (!empty($email_promo_code ?? '')): ?>
            <!-- Promo Code Box -->
            <div style="margin: 28px 0; text-align: center;">
                <p style="margin: 0 0 10px; font-size: 13px; color: #646970; text-transform: uppercase; letter-spacing: 0.08em;">Your Exclusive Promo Code</p>
                <div style="display: inline-block; background-color: #FFF9EF; border: 2px dashed #BD451F; padding: 16px 36px;">
                    <span style="font-size: 26px; font-weight: 800; letter-spacing: 0.12em; color: #AC201A; font-family: 'Courier New', Courier, monospace;">
                        <?php echo esc_html($email_promo_code); ?>
                    </span>
                </div>
                <p style="margin: 10px 0 0; font-size: 12px; color: #646970;">Copy this code and use it at checkout to claim your discount.</p>
            </div>
            <?php endif; ?>

            <?php if (!empty($email_banner)): ?>
            <!-- Highlight Banner -->
            <div style="margin: 24px 0; background-color: #FFBFBF; border: 1px solid rgba(189,69,31,0.2); border-left: 4px solid #BD451F; padding: 20px 24px;">
                <p style="margin: 0; font-size: 15px; line-height: 1.6; color: #2B2B2B;">
                    <?php echo esc_html($email_banner); ?>
                </p>
            </div>
            <?php endif; ?>

            <?php if (!empty($email_btn_text) && !empty($email_btn_url)): ?>
            <!-- CTA Button -->
            <div style="text-align: center; margin: 32px 0 8px;">
                <a href="<?php echo esc_url($email_btn_url); ?>"
                   style="display: inline-block; padding: 14px 32px; background-color: #AC201A; color: #FFF9EF; text-decoration: none; font-weight: 700; font-size: 15px; letter-spacing: 0.04em;">
                    <?php echo esc_html($email_btn_text); ?>
                </a>
            </div>
            <?php endif; ?>

            <!-- Sign Off -->
            <div style="margin-top: 40px; text-align: right;">
                <p style="margin: 0; font-size: 15px; color: #2B2B2B;">Regards,</p>
                <p style="margin: 5px 0 0 0; font-size: 18px; font-weight: bold; color: #BD451F;">The Kings City Team</p>
            </div>

        </td>
    </tr>

    <!-- Footer -->
    <tr>
        <td style="background-color: #BD451F; padding: 30px; text-align: center;">
            <p style="margin: 0; color: #FFF9EF; font-size: 13px; line-height: 1.6;">
                <strong>&#128205; Kings Headquarters:</strong> 100 Doña Soledad Ave, Better Living, Parañaque, 1711 Philippines
            </p>
            <p style="margin: 8px 0 0 0; color: #FFF9EF; font-size: 13px;">
                &#128222; <a href="tel:+63286964490" style="color: #FBCB77; text-decoration: none;">+63 (2) 8696 4490</a> |
                <a href="<?php echo esc_url(home_url()); ?>" style="color: #FBCB77; text-decoration: none;">kingsgroup.com.ph</a>
            </p>
            <p style="margin: 12px 0 0 0; color: rgba(255,255,255,0.6); font-size: 11px;">
                You received this because you subscribed via The Kings City Club website.
            </p>
        </td>
    </tr>

</table>
</body>
</html>
