<?php
if (!defined('ABSPATH')) exit;
/**
 * HTML Email Template: Booking Confirmed
 * 
 * Variables available:
 * - $fname (string)
 * - $space (string)
 * - $date (string)
 * - $duration (string)
 * - $price (string)
 * - $arrival (string)
 * - $participants (string)
 * - $special (string)
 * - $send_packet (bool)
 * - $packet_url (string)
 * - $email_heading (string)
 * - $email_body (string)
 * - $email_banner (string)
 * - $email_btn_text (string)
 * - $email_btn_url (string)
 * - $hide_table (bool)
 */

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Your Kings City Booking is Confirmed!</title>
</head>
<body style="font-family: 'Outfit', Arial, Helvetica, sans-serif; background-color: #FFF9EF; margin: 0; padding: 40px 10px; color: #2B2B2B;">

<table width="100%" border="0" cellspacing="0" cellpadding="0" style="max-width: 650px; margin: 0 auto; background-color: #ffffff; overflow: hidden; border: 1px solid rgba(189,69,31,0.2);">
    
    <!-- Top Stripe Bar (Terracotta) -->
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
            <h2 style="margin-top: 0; color: #BD451F; font-size: 24px;"><?php echo esc_html(!empty($email_heading) ? $email_heading : 'Booking Confirmation'); ?></h2>
            <?php 
                if (!empty($email_body)) {
                    echo '<div style="font-size: 16px; line-height: 1.6; color: #2B2B2B; margin-bottom: 30px;">' . wp_kses_post($email_body) . '</div>';
                } else {
            ?>
            <p style="font-size: 16px; line-height: 1.6; color: #2B2B2B;">Dear <?php echo esc_html($fname); ?>,</p>
            <p style="font-size: 16px; line-height: 1.6; color: #2B2B2B; margin-bottom: 30px;">
                Your booking for the <strong><?php echo esc_html($space); ?></strong> has been successfully confirmed. We are thrilled to host you and your team. Please arrive on your chosen date and complete your payment at our front desk.
            </p>
            <?php } ?>

            <?php if (empty($hide_table)): ?>

            <h3 style="color: #BD451F; font-size: 18px; margin-bottom: 15px;">Your Booking Details</h3>

            <!-- Data Table -->
            <table width="100%" border="0" cellspacing="0" cellpadding="15" style="border-collapse: collapse; background-color: #ffffff; border: 1px solid rgba(189,69,31,0.2);">
                <tbody>
                    <tr>
                        <td width="35%" style="border-bottom: 1px solid rgba(189,69,31,0.2); font-size: 14px; color: #666666; font-weight: bold; text-transform: uppercase; letter-spacing: 0.05em; background-color: #FFF9EF;">Space Reserved</td>
                        <td style="border-bottom: 1px solid rgba(189,69,31,0.2); font-size: 16px; color: #2B2B2B; font-weight: 600;"><?php echo esc_html($space); ?></td>
                    </tr>
                    <tr>
                        <td width="35%" style="border-bottom: 1px solid rgba(189,69,31,0.2); font-size: 14px; color: #666666; font-weight: bold; text-transform: uppercase; letter-spacing: 0.05em; background-color: #FFF9EF;">Pass / Duration</td>
                        <td style="border-bottom: 1px solid rgba(189,69,31,0.2); font-size: 15px; color: #2B2B2B;"><?php echo esc_html($duration); ?></td>
                    </tr>
                    <tr>
                        <td width="35%" style="border-bottom: 1px solid rgba(189,69,31,0.2); font-size: 14px; color: #666666; font-weight: bold; text-transform: uppercase; letter-spacing: 0.05em; background-color: #FFF9EF;">Date & Time</td>
                        <td style="border-bottom: 1px solid rgba(189,69,31,0.2); font-size: 15px; color: #2B2B2B;"><?php echo esc_html($date); ?> <br><span style="color:#666666; font-size: 14px;">Arrival: <?php echo esc_html($arrival); ?></span></td>
                    </tr>
                    <tr>
                        <td width="35%" style="border-bottom: 1px solid rgba(189,69,31,0.2); font-size: 14px; color: #666666; font-weight: bold; text-transform: uppercase; letter-spacing: 0.05em; background-color: #FFF9EF;">Headcount</td>
                        <td style="border-bottom: 1px solid rgba(189,69,31,0.2); font-size: 15px; color: #2B2B2B;"><?php echo esc_html($participants); ?> Participant(s)</td>
                    </tr>
                    <?php if (!empty($special)): ?>
                    <tr>
                        <td width="35%" style="border-bottom: 1px solid rgba(189,69,31,0.2); font-size: 14px; color: #666666; font-weight: bold; text-transform: uppercase; letter-spacing: 0.05em; background-color: #FFF9EF;">Special Requests</td>
                        <td style="border-bottom: 1px solid rgba(189,69,31,0.2); font-size: 15px; color: #2B2B2B;"><i><?php echo nl2br(esc_html($special)); ?></i></td>
                    </tr>
                    <?php endif; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td style="background-color: #BD451F; padding: 20px 15px; font-weight: bold; color: #FFF9EF; font-size: 16px; text-transform: uppercase; letter-spacing: 0.05em;">Total Amount Due</td>
                        <td style="background-color: #BD451F; padding: 20px 15px; font-weight: bold; color: #FFF9EF; font-size: 20px;">
                            PHP <?php echo esc_html($price); ?>
                        </td>
                    </tr>
                </tfoot>
            </table>
            <?php endif; ?>

            <?php if (!empty($email_banner) && ($template_type !== 'booking_confirmed' || $send_packet)): ?>
            <!-- Dynamic Highlight Box -->
            <div style="margin-top: 30px; background-color: #FFBFBF; border: 1px solid rgba(189,69,31,0.2); padding: 25px; text-align: center;">
                <?php if ($template_type === 'booking_confirmed'): ?>
                <h3 style="margin-top:0; color: #BD451F; font-size: 18px;">Your Kings City Newsletter</h3>
                <?php endif; ?>
                <p style="margin: 0; font-size: 15px; line-height: 1.6; color: #2B2B2B;">
                    <?php echo esc_html($email_banner); ?>
                </p>
                <?php if (!empty($email_btn_text) && !empty($email_btn_url) && $email_btn_url !== '{packet_url}'): ?>
                <a href="<?php echo esc_url($email_btn_url); ?>" style="display: inline-block; margin-top: 20px; padding: 14px 28px; background-color: #AC201A; color: #FFF9EF; text-decoration: none; font-weight: bold; font-size: 15px;">
                    <?php echo esc_html($email_btn_text); ?>
                </a>
                <?php endif; ?>
            </div>
            <?php endif; ?>

            <?php if (empty($email_body)): ?>
            <p style="margin-top: 30px; font-size: 15px; line-height: 1.6; color: #2B2B2B;">
                If you need to make any changes to your reservation, please reply directly to this correspondence. We look forward to seeing you soon!
            </p>
            <?php endif; ?>

            <?php
            // Payment instructions block — shown only on booking_confirmed emails
            if (!isset($hide_table) || !$hide_table):
                $pay_bank_name    = get_option('kc_pay_bank_name', '');
                $pay_account_name = get_option('kc_pay_account_name', '');
                $pay_account_no   = get_option('kc_pay_account_no', '');
                $pay_gcash_name   = get_option('kc_pay_gcash_name', '');
                $pay_gcash_no     = get_option('kc_pay_gcash_no', '');
                $pay_proof_email  = get_option('kc_pay_proof_email', '');
            ?>
            <div style="margin-top: 30px; border: 1px solid rgba(189,69,31,0.2); border-left: 4px solid #BD451F; background-color: #fff7ed; padding: 20px 24px;">
                <div style="font-size: 13px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px; color: #BD451F; margin-bottom: 14px;">How to Pay</div>

                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td style="vertical-align: top; padding-right: 20px; width: 50%;">
                            <?php if (!empty($pay_gcash_name) || !empty($pay_gcash_no)): ?>
                            <div style="margin-bottom: 14px;">
                                <div style="font-size: 12px; font-weight: 700; color: #9a3412; text-transform: uppercase; letter-spacing: 0.4px; margin-bottom: 5px;">GCash</div>
                                <?php if ($pay_gcash_name): ?>
                                <div style="font-size: 13px; color: #2B2B2B;">Name: <strong><?php echo esc_html($pay_gcash_name); ?></strong></div>
                                <?php endif; ?>
                                <?php if ($pay_gcash_no): ?>
                                <div style="font-size: 13px; color: #2B2B2B;">Number: <strong><?php echo esc_html($pay_gcash_no); ?></strong></div>
                                <?php endif; ?>
                            </div>
                            <?php endif; ?>

                            <div style="font-size: 12px; font-weight: 700; color: #9a3412; text-transform: uppercase; letter-spacing: 0.4px; margin-bottom: 5px;">Cash</div>
                            <div style="font-size: 13px; color: #2B2B2B;">Pay at our front desk on your visit date.</div>
                        </td>

                        <?php if (!empty($pay_bank_name) || !empty($pay_account_name) || !empty($pay_account_no)): ?>
                        <td style="vertical-align: top; border-left: 1px solid rgba(189,69,31,0.15); padding-left: 20px; width: 50%;">
                            <div style="font-size: 12px; font-weight: 700; color: #9a3412; text-transform: uppercase; letter-spacing: 0.4px; margin-bottom: 5px;">Bank Transfer</div>
                            <?php if ($pay_bank_name): ?>
                            <div style="font-size: 13px; color: #2B2B2B;">Bank: <strong><?php echo esc_html($pay_bank_name); ?></strong></div>
                            <?php endif; ?>
                            <?php if ($pay_account_name): ?>
                            <div style="font-size: 13px; color: #2B2B2B;">Account Name: <strong><?php echo esc_html($pay_account_name); ?></strong></div>
                            <?php endif; ?>
                            <?php if ($pay_account_no): ?>
                            <div style="font-size: 13px; color: #2B2B2B;">Account No.: <strong><?php echo esc_html($pay_account_no); ?></strong></div>
                            <?php endif; ?>
                        </td>
                        <?php endif; ?>
                    </tr>
                </table>

                <?php if (!empty($pay_proof_email) || !empty($ref_number)): ?>
                <div style="margin-top: 16px; padding-top: 14px; border-top: 1px solid rgba(189,69,31,0.15); font-size: 13px; color: #2B2B2B; line-height: 1.7;">
                    After transferring, please email your <strong>proof of payment</strong> along with your booking reference number
                    <?php if (!empty($ref_number)): ?>
                    <strong style="color: #AC201A;"><?php echo esc_html($ref_number); ?></strong>
                    <?php endif; ?>
                    to
                    <?php if (!empty($pay_proof_email)): ?>
                    <a href="mailto:<?php echo esc_attr($pay_proof_email); ?>" style="color: #AC201A; font-weight: 700;"><?php echo esc_html($pay_proof_email); ?></a>.
                    <?php else: ?>
                    our team.
                    <?php endif; ?>
                    Our team will manually verify and confirm your payment.
                </div>
                <?php endif; ?>
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
                <a href="https://kingsgroup.com.ph" style="color: #FBCB77; text-decoration: none;">kingsgroup.com.ph</a>
            </p>
        </td>
    </tr>

</table>

</body>
</html>
