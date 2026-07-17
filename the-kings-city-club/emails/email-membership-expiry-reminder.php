<?php
if (!defined('ABSPATH')) exit;
/**
 * HTML Email Template: Membership & Pass Expiry Reminder
 *
 * Variables available:
 * - $fname        (string) — client first name
 * - $lname        (string) — client last name
 * - $email        (string) — client email
 * - $space        (string) — space name e.g. "Office Leasing"
 * - $duration     (string) — pass type e.g. "Monthly Pass"
 * - $expiry_date  (string) — formatted expiry date e.g. "July 24, 2026"
 * - $booking_id   (int)    — WP post ID of the booking
 */
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Your Membership is Expiring Soon — Kings City Club</title>
</head>
<body style="font-family: 'Outfit', Arial, Helvetica, sans-serif; background-color: #FFF9EF; margin: 0; padding: 40px 10px; color: #2B2B2B;">

<table width="100%" border="0" cellspacing="0" cellpadding="0" style="max-width: 650px; margin: 0 auto; background-color: #ffffff; overflow: hidden; border: 1px solid rgba(189,69,31,0.2);">

    <!-- Top Stripe -->
    <tr>
        <td style="height: 8px; background-color: #BD451F;"></td>
    </tr>

    <!-- Header -->
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

            <h2 style="margin-top: 0; color: #BD451F; font-size: 22px;">
                Your Membership is Expiring in 7 Days
            </h2>

            <p style="font-size: 15px; line-height: 1.7; color: #2B2B2B; margin-bottom: 24px;">
                Hi <?php echo esc_html($fname); ?>,<br><br>
                Just a heads-up — your pass and membership access at Kings City Club are coming to an end soon. Here are your expiry details:
            </p>

            <!-- Expiry Detail Card -->
            <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border: 1px solid rgba(189,69,31,0.25); margin-bottom: 28px;">
                <tr style="background-color: #FFF9EF;">
                    <td colspan="2" style="padding: 12px 16px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #BD451F; border-bottom: 1px solid rgba(189,69,31,0.2);">
                        Expiry Summary
                    </td>
                </tr>
                <tr>
                    <td style="padding: 12px 16px; font-size: 13px; color: #64748b; border-bottom: 1px solid #f1f5f9; width: 40%;">Space</td>
                    <td style="padding: 12px 16px; font-size: 13px; font-weight: 700; color: #0f172a; border-bottom: 1px solid #f1f5f9;"><?php echo esc_html($space); ?></td>
                </tr>
                <tr>
                    <td style="padding: 12px 16px; font-size: 13px; color: #64748b; border-bottom: 1px solid #f1f5f9;">Pass Type</td>
                    <td style="padding: 12px 16px; font-size: 13px; font-weight: 700; color: #0f172a; border-bottom: 1px solid #f1f5f9;"><?php echo esc_html($duration); ?></td>
                </tr>
                <tr style="background-color: #fff7ed;">
                    <td style="padding: 14px 16px; font-size: 13px; font-weight: 700; color: #9a3412;">Expiry Date</td>
                    <td style="padding: 14px 16px; font-size: 16px; font-weight: 800; color: #ea580c;"><?php echo esc_html($expiry_date); ?></td>
                </tr>
                <tr>
                    <td style="padding: 12px 16px; font-size: 13px; color: #64748b;">Membership Access</td>
                    <td style="padding: 12px 16px; font-size: 13px; font-weight: 700; color: #0f172a;">Active until <?php echo esc_html($expiry_date); ?></td>
                </tr>
            </table>

            <!-- Renewal Notice -->
            <div style="background-color: #fff7ed; border: 1px solid rgba(189,69,31,0.2); border-left: 4px solid #BD451F; padding: 16px 20px; margin-bottom: 28px;">
                <div style="font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #BD451F; margin-bottom: 8px;">Renew Your Pass</div>
                <p style="margin: 0; font-size: 13px; color: #9a3412; line-height: 1.6;">
                    To continue enjoying access to <strong><?php echo esc_html($space); ?></strong>, please visit our front desk or contact us to renew your <strong><?php echo esc_html($duration); ?></strong> before it expires on <strong><?php echo esc_html($expiry_date); ?></strong>.
                </p>
            </div>

            <p style="font-size: 14px; line-height: 1.7; color: #475569; margin-bottom: 32px;">
                We'd love to have you continue as part of the Kings City community. See you soon!
            </p>

            <!-- Sign Off -->
            <div style="text-align: right;">
                <p style="margin: 0; font-size: 15px; color: #2B2B2B;">Regards,</p>
                <p style="margin: 5px 0 0 0; font-size: 18px; font-weight: bold; color: #BD451F;">The Kings City Team</p>
            </div>

        </td>
    </tr>

    <!-- Footer -->
    <tr>
        <td style="background-color: #BD451F; padding: 30px; text-align: center;">
            <p style="margin: 0; color: #FFF9EF; font-size: 13px; line-height: 1.6;">
                <strong>&#128205; Kings Headquarters:</strong> 100 Don&#771;a Soledad Ave, Better Living, Paran&#771;aque, 1711 Philippines
            </p>
            <p style="margin: 8px 0 0 0; color: #FFF9EF; font-size: 13px;">
                &#128222; <a href="tel:+63286964490" style="color: #FBCB77; text-decoration: none;">+63 (2) 8696 4490</a> |
                <a href="<?php echo esc_url(home_url()); ?>" style="color: #FBCB77; text-decoration: none;">kingsgroup.com.ph</a>
            </p>
        </td>
    </tr>

</table>
</body>
</html>
