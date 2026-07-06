<?php
/**
 * HTML Email Template: Quote Contacted
 * 
 * Variables available:
 * - $first_name (string)
 * - $team_data (array)
 * - $total_est (string)
 */

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Quote Request Acknowledgment</title>
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
            <h2 style="margin-top: 0; color: #BD451F; font-size: 24px;"><?php echo esc_html(!empty($email_heading) ? $email_heading : 'Proposal Request Acknowledgment'); ?></h2>
            <?php 
                if (!empty($email_body)) {
                    // Wrap the WYSIWYG output in a div with the email's base font styling
                    echo '<div style="font-size: 16px; line-height: 1.6; color: #2B2B2B; margin-bottom: 30px;">' . wp_kses_post($email_body) . '</div>';
                } else {
            ?>
            <p style="font-size: 16px; line-height: 1.6; color: #2B2B2B;">Dear <?php echo esc_html($first_name); ?>,</p>
            <p style="font-size: 16px; line-height: 1.6; color: #2B2B2B; margin-bottom: 30px;">
                Thank you for considering Kings City as your workforce solutions partner. We have successfully received your service configuration request. Our business development team is currently analyzing your requirements to formulate a comprehensive proposal.
            </p>
            <?php } ?>

            <h3 style="color: #BD451F; font-size: 18px; margin-bottom: 15px;">Your Team Configuration Summary</h3>

            <!-- Data Table -->
            <table width="100%" border="0" cellspacing="0" cellpadding="15" style="border-collapse: collapse; background-color: #ffffff; border: 1px solid rgba(189,69,31,0.2);">
                <thead>
                    <tr>
                        <th style="background-color: #BD451F; color: #FFF9EF; text-align: left; font-size: 14px; text-transform: uppercase; letter-spacing: 0.12em;">Role</th>
                        <th style="background-color: #BD451F; color: #FFF9EF; text-align: center; font-size: 14px; text-transform: uppercase; letter-spacing: 0.12em;">Level / Qty</th>
                        <th style="background-color: #BD451F; color: #FFF9EF; text-align: right; font-size: 14px; text-transform: uppercase; letter-spacing: 0.12em;">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($team_data) && is_array($team_data)): ?>
                        <?php foreach ($team_data as $role): ?>
                        <tr>
                            <td style="border-bottom: 1px solid rgba(189,69,31,0.2); font-size: 15px; color: #2B2B2B;">
                                <strong><?php echo esc_html(isset($role['title']) ? $role['title'] : 'Role'); ?></strong>
                            </td>
                            <td style="border-bottom: 1px solid rgba(189,69,31,0.2); font-size: 15px; color: #2B2B2B; text-align: center;">
                                <?php echo esc_html(isset($role['level']) ? $role['level'] : 'Standard'); ?> &times; <?php echo esc_html(isset($role['headcount']) ? $role['headcount'] : 1); ?>
                            </td>
                            <td style="border-bottom: 1px solid rgba(189,69,31,0.2); font-size: 15px; color: #BD451F; font-weight: bold; text-align: right;">
                                <?php echo esc_html(isset($role['monthly']) ? $role['monthly'] : 'Custom'); ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" style="text-align: center; color: #2B2B2B; padding: 20px;">No specific roles selected. Custom inquiry.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="2" style="background-color: #FFF9EF; padding: 20px 15px; text-align: right; font-weight: bold; color: #BD451F; font-size: 16px;">Estimated Monthly Total</td>
                        <td style="background-color: #FFF9EF; padding: 20px 15px; text-align: right; font-weight: bold; color: #BD451F; font-size: 18px;">
                            <?php echo esc_html(!empty($total_est) ? $total_est : 'Custom Estimate'); ?>
                        </td>
                    </tr>
                </tfoot>
            </table>

            <!-- Highlight Box -->
            <div style="margin-top: 30px; background-color: #FFBFBF; border: 1px solid rgba(189,69,31,0.2); padding: 20px;">
                <p style="margin: 0; font-size: 15px; line-height: 1.6; color: #2B2B2B; font-weight: bold;">
                    <?php echo esc_html(!empty($email_banner) ? $email_banner : 'A dedicated representative will contact you within one business day to present a detailed pricing breakdown and discuss your specific needs.'); ?>
                </p>
            </div>

            <p style="margin-top: 30px; font-size: 15px; line-height: 1.6; color: #2B2B2B;">
                Should you require immediate assistance, please reply directly to this correspondence or contact our corporate office.
            </p>

            <!-- CTA Button (Deep Red Action Color) -->
            <div style="margin-top: 35px; text-align: left;">
                <a href="<?php echo esc_url(!empty($email_btn_url) ? $email_btn_url : home_url()); ?>" style="display: inline-block; background-color: #AC201A; color: #FFF9EF; font-weight: bold; text-decoration: none; padding: 16px 40px; font-size: 16px;">
                    <?php echo esc_html(!empty($email_btn_text) ? $email_btn_text : 'Visit Kings City'); ?>
                </a>
            </div>

            <!-- Sign Off -->
            <div style="margin-top: 40px; text-align: right;">
                <p style="margin: 0; font-size: 15px; color: #2B2B2B;">Regards,</p>
                <p style="margin: 5px 0 0 0; font-size: 18px; font-weight: bold; color: #BD451F;">Kings Recruitment Team</p>
                <p style="margin: 2px 0 0 0; font-size: 13px; color: #BD451F; letter-spacing: 0.12em; text-transform: uppercase;">Kings City</p>
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
