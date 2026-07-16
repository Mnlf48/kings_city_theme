<?php
if (!defined('ABSPATH')) exit;
/**
 * HTML Email Template: Payment Receipt
 *
 * Variables available:
 * - $fname, $lname, $email
 * - $space, $duration
 * - $amount       (float) — amount just paid
 * - $note         (string) — payment reference/note
 * - $total_paid   (float) — cumulative total paid
 * - $total_due    (float) — original total due
 * - $balance      (float) — remaining balance
 * - $inv_number   (string) — invoice number
 * - $fully_paid   (bool)
 * - $email_heading (string)
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

            <h2 style="margin-top: 0; color: #BD451F; font-size: 24px;">
                <?php echo esc_html($email_heading); ?>
            </h2>

            <p style="font-size: 15px; line-height: 1.7; color: #2B2B2B; margin-bottom: 24px;">
                Dear <?php echo esc_html($fname . ' ' . $lname); ?>,<br><br>
                <?php if ($fully_paid): ?>
                    Your balance for your booking at <strong><?php echo esc_html($space); ?></strong> has been <strong>fully settled</strong>. Thank you for your payment — we look forward to having you with us!
                <?php else: ?>
                    We have received your payment for your booking at <strong><?php echo esc_html($space); ?></strong>. Below is your updated payment summary.
                <?php endif; ?>
            </p>

            <!-- Payment Summary Table -->
            <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border: 1px solid rgba(189,69,31,0.2); margin-bottom: 28px;">
                <tr style="background-color: #FFF9EF;">
                    <td colspan="2" style="padding: 12px 16px; font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #BD451F; border-bottom: 1px solid rgba(189,69,31,0.2);">
                        Payment Summary
                        <?php if (!empty($inv_number)): ?>
                        &nbsp;&mdash;&nbsp;<span style="color:#94a3b8; font-weight:400;"><?php echo esc_html($inv_number); ?></span>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 10px 16px; font-size: 13px; color: #64748b; border-bottom: 1px solid #f1f5f9;">Space / Pass</td>
                    <td style="padding: 10px 16px; font-size: 13px; font-weight: 600; text-align: right; border-bottom: 1px solid #f1f5f9;"><?php echo esc_html($space . ' — ' . $duration); ?></td>
                </tr>
                <tr>
                    <td style="padding: 10px 16px; font-size: 13px; color: #64748b; border-bottom: 1px solid #f1f5f9;">Total Amount Due</td>
                    <td style="padding: 10px 16px; font-size: 13px; font-weight: 600; text-align: right; border-bottom: 1px solid #f1f5f9;">Php <?php echo number_format($total_due, 2); ?></td>
                </tr>
                <tr style="background-color: #f0fdf4;">
                    <td style="padding: 10px 16px; font-size: 13px; color: #065f46; font-weight: 700; border-bottom: 1px solid #f1f5f9;">
                        Payment Just Received
                        <?php if (!empty($note)): ?><br><span style="font-weight:400; font-size:11px; color:#94a3b8;"><?php echo esc_html($note); ?></span><?php endif; ?>
                    </td>
                    <td style="padding: 10px 16px; font-size: 15px; font-weight: 800; color: #22c55e; text-align: right; border-bottom: 1px solid #f1f5f9;">+ Php <?php echo number_format($amount, 2); ?></td>
                </tr>
                <tr>
                    <td style="padding: 10px 16px; font-size: 13px; color: #64748b; border-bottom: 1px solid #f1f5f9;">Total Paid So Far</td>
                    <td style="padding: 10px 16px; font-size: 13px; font-weight: 600; text-align: right; border-bottom: 1px solid #f1f5f9;">Php <?php echo number_format($total_paid, 2); ?></td>
                </tr>
                <tr style="background-color: <?php echo $fully_paid ? '#f0fdf4' : '#fff7ed'; ?>;">
                    <td style="padding: 12px 16px; font-size: 14px; font-weight: 700; color: <?php echo $fully_paid ? '#065f46' : '#9a3412'; ?>;">Remaining Balance</td>
                    <td style="padding: 12px 16px; font-size: 18px; font-weight: 800; color: <?php echo $fully_paid ? '#22c55e' : '#ea580c'; ?>; text-align: right;">
                        <?php echo $fully_paid ? 'Fully Paid' : 'Php ' . number_format($balance, 2); ?>
                    </td>
                </tr>
            </table>

            <?php if (!$fully_paid): ?>
            <div style="background-color: #fff7ed; border: 1px solid rgba(189,69,31,0.2); border-left: 4px solid #BD451F; padding: 14px 18px; margin-bottom: 28px;">
                <p style="margin: 0; font-size: 13px; color: #9a3412; line-height: 1.6;">
                    Your remaining balance of <strong>Php <?php echo number_format($balance, 2); ?></strong> can be paid at the front desk at your convenience.
                </p>
            </div>
            <?php endif; ?>

            <!-- Sign Off -->
            <div style="margin-top: 32px; text-align: right;">
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
        </td>
    </tr>

</table>
</body>
</html>
