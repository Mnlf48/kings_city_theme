<?php
if (!defined('ABSPATH')) exit;
/**
 * HTML Email Template: Invoice
 *
 * Variables available:
 * - $fname, $lname, $email
 * - $space, $duration, $start_date, $arrival, $participants
 * - $base_price   (float) — original price before discount
 * - $discount     (float) — discount amount
 * - $total_due    (float) — final amount due
 * - $promo_code   (string) — promo code used, if any
 * - $inv_number   (string) — invoice number e.g. KC-INV-2026-0001
 * - $email_heading (string)
 */
$issue_date = date_i18n('F j, Y');
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo esc_html($inv_number); ?> — Kings City Club</title>
</head>
<body style="font-family: 'Outfit', Arial, Helvetica, sans-serif; background-color: #FFF9EF; margin: 0; padding: 40px 10px; color: #2B2B2B;">

<table width="100%" border="0" cellspacing="0" cellpadding="0" style="max-width: 650px; margin: 0 auto; background-color: #ffffff; overflow: hidden; border: 1px solid rgba(189,69,31,0.2);">

    <!-- Top Stripe -->
    <tr>
        <td style="height: 8px; background-color: #BD451F;"></td>
    </tr>

    <!-- Header -->
    <tr>
        <td style="padding: 30px; border-bottom: 1px solid rgba(189,69,31,0.2); background-color: #FFF9EF;">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td>
                        <a href="<?php echo esc_url(home_url()); ?>" style="text-decoration: none; color: #BD451F; font-size: 26px; font-weight: 800; letter-spacing: 0.5px; text-transform: uppercase;">
                            Kings City Club
                        </a>
                    </td>
                    <td style="text-align: right;">
                        <span style="font-size: 22px; font-weight: 800; color: #BD451F; text-transform: uppercase; letter-spacing: 1px;">Invoice</span><br>
                        <span style="font-size: 12px; color: #94a3b8;"><?php echo esc_html($inv_number); ?></span>
                    </td>
                </tr>
            </table>
        </td>
    </tr>

    <!-- Billed To + Issue Date -->
    <tr>
        <td style="padding: 24px 30px; border-bottom: 1px solid rgba(189,69,31,0.1); background-color: #ffffff;">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td style="vertical-align: top; width: 50%;">
                        <div style="font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #94a3b8; margin-bottom: 6px;">Billed To</div>
                        <div style="font-size: 15px; font-weight: 700; color: #0f172a;"><?php echo esc_html($fname . ' ' . $lname); ?></div>
                        <div style="font-size: 13px; color: #475569;"><?php echo esc_html($email); ?></div>
                    </td>
                    <td style="vertical-align: top; text-align: right;">
                        <div style="font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #94a3b8; margin-bottom: 6px;">Issue Date</div>
                        <div style="font-size: 14px; font-weight: 600; color: #0f172a;"><?php echo esc_html($issue_date); ?></div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>

    <!-- Line Items -->
    <tr>
        <td style="padding: 24px 30px; background-color: #ffffff;">

            <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border: 1px solid rgba(189,69,31,0.2); margin-bottom: 24px;">
                <!-- Table Header -->
                <tr style="background-color: #FFF9EF;">
                    <td style="padding: 10px 14px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #BD451F; border-bottom: 1px solid rgba(189,69,31,0.2);">Description</td>
                    <td style="padding: 10px 14px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #BD451F; border-bottom: 1px solid rgba(189,69,31,0.2); text-align: right;">Amount</td>
                </tr>
                <!-- Space Line Item -->
                <tr>
                    <td style="padding: 14px; border-bottom: 1px solid #f1f5f9; vertical-align: top;">
                        <div style="font-size: 14px; font-weight: 700; color: #0f172a;"><?php echo esc_html($space); ?></div>
                        <div style="font-size: 12px; color: #64748b; margin-top: 3px;"><?php echo esc_html($duration); ?></div>
                        <div style="font-size: 12px; color: #64748b;">
                            Start Date: <?php echo esc_html($start_date); ?>
                            <?php if ($arrival): ?> &nbsp;|&nbsp; Arrival: <?php echo esc_html($arrival); ?><?php endif; ?>
                            <?php if ($participants): ?> &nbsp;|&nbsp; <?php echo esc_html($participants); ?> Participant(s)<?php endif; ?>
                        </div>
                    </td>
                    <td style="padding: 14px; border-bottom: 1px solid #f1f5f9; text-align: right; font-size: 14px; font-weight: 600; vertical-align: top; color: #0f172a;">
                        Php <?php echo number_format($base_price ?: $total_due, 2); ?>
                    </td>
                </tr>
                <?php if ($discount > 0 && !empty($promo_code)): ?>
                <!-- Discount Line Item -->
                <tr>
                    <td style="padding: 10px 14px; border-bottom: 1px solid #f1f5f9; font-size: 13px; color: #22c55e;">
                        Promo Code: <strong><?php echo esc_html($promo_code); ?></strong>
                    </td>
                    <td style="padding: 10px 14px; border-bottom: 1px solid #f1f5f9; text-align: right; font-size: 13px; color: #22c55e; font-weight: 600;">
                        - Php <?php echo number_format($discount, 2); ?>
                    </td>
                </tr>
                <?php endif; ?>
                <!-- Total Row -->
                <tr style="background-color: #FFF9EF;">
                    <td style="padding: 14px; font-size: 15px; font-weight: 800; color: #BD451F;">Total Amount Due</td>
                    <td style="padding: 14px; text-align: right; font-size: 20px; font-weight: 800; color: #AC201A;">Php <?php echo number_format($total_due, 2); ?></td>
                </tr>
            </table>

            <!-- Payment Instructions -->
            <div style="background-color: #fff7ed; border: 1px solid rgba(189,69,31,0.2); border-left: 4px solid #BD451F; padding: 16px 20px; margin-bottom: 28px;">
                <div style="font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #BD451F; margin-bottom: 6px;">Payment Instructions</div>
                <p style="margin: 0; font-size: 13px; color: #9a3412; line-height: 1.6;">
                    Payment is accepted at our front desk — cash or GCash. You may also pay via bank transfer (see details in your booking confirmation email). Settle your balance in full or in installments. Please quote your reference number <strong><?php echo esc_html($inv_number); ?></strong> when making a payment.
                </p>
            </div>

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
