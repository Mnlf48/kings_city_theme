<?php
if (!defined('ABSPATH')) exit;
// Admin Menu Hook
add_action('admin_menu', 'kc_tb_currency_manager_menu');
function kc_tb_currency_manager_menu() {
    add_submenu_page(
        'edit.php?post_type=tb_role',
        'Currency Rates',
        'Currency Rates',
        'edit_posts',
        'kc-tb-currency-rates',
        'kc_tb_currency_manager_page'
    );
}

// Handle Save Logic and Render Page
function kc_tb_currency_manager_page() {
    // Default Data
    $default_currencies = array(
        array('code' => 'AUD', 'rate' => 0.026),
        array('code' => 'USD', 'rate' => 0.017),
        array('code' => 'PHP', 'rate' => 1) // Always 1
    );

    // Save Data
    if (isset($_POST['kc_tb_currencies_nonce']) && wp_verify_nonce($_POST['kc_tb_currencies_nonce'], 'kc_tb_save_currencies')) {
        if (isset($_POST['currency_code']) && is_array($_POST['currency_code'])) {
            $new_currencies = array();
            for ($i = 0; $i < count($_POST['currency_code']); $i++) {
                $code = sanitize_text_field($_POST['currency_code'][$i]);
                $rate = floatval($_POST['currency_rate'][$i]);
                
                if (!empty($code)) {
                    $new_currencies[] = array(
                        'code' => strtoupper($code),
                        'rate' => $rate > 0 ? $rate : 1
                    );
                }
            }
            update_option('kc_tb_currencies', $new_currencies);
            echo '<div class="updated"><p>Currency rates saved successfully!</p></div>';
        }
    }

    // Get Data
    $currencies = get_option('kc_tb_currencies', $default_currencies);
    ?>
    <div class="wrap">
        <h1 class="wp-heading-inline">Team Builder - Currency Rates</h1>
        <hr class="wp-header-end">
        <p>Manage the dynamic exchange rates for the Team Builder pricing calculator. Base prices are in PHP (Rate: 1).</p>
        
        <form method="POST">
            <?php wp_nonce_field('kc_tb_save_currencies', 'kc_tb_currencies_nonce'); ?>
            <table class="form-table" style="max-width: 600px; background: #fff; padding: 20px; border: 1px solid #ccd0d4; box-shadow: 0 1px 1px rgba(0,0,0,.04);">
                <thead>
                    <tr>
                        <th style="padding-left: 0;">Currency Code (e.g. AUD)</th>
                        <th>Multiplier vs PHP</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="currency-rows">
                    <?php foreach ($currencies as $curr): ?>
                        <tr>
                            <td style="padding-left: 0;"><input type="text" name="currency_code[]" value="<?php echo esc_attr($curr['code']); ?>" style="width: 100%;"></td>
                            <td><input type="number" step="0.000001" name="currency_rate[]" value="<?php echo esc_attr($curr['rate']); ?>" style="width: 100%;"></td>
                            <td>
                                <?php if ($curr['code'] !== 'PHP'): ?>
                                    <button type="button" class="button remove-curr">Remove</button>
                                <?php else: ?>
                                    <span style="color:#646970;">Base Currency</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            
            <div style="margin-top: 15px; max-width: 600px; display: flex; justify-content: space-between;">
                <button type="button" id="add-curr" class="button">Add Currency</button>
                <input type="submit" name="submit" id="submit" class="button button-primary" value="Save Rates">
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('add-curr').addEventListener('click', function() {
                var tbody = document.getElementById('currency-rows');
                var tr = document.createElement('tr');
                tr.innerHTML = `
                    <td style="padding-left: 0;"><input type="text" name="currency_code[]" value="" style="width: 100%;" placeholder="e.g. GBP"></td>
                    <td><input type="number" step="0.000001" name="currency_rate[]" value="0.00" style="width: 100%;"></td>
                    <td><button type="button" class="button remove-curr">Remove</button></td>
                `;
                tbody.appendChild(tr);
            });

            document.getElementById('currency-rows').addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-curr')) {
                    e.target.closest('tr').remove();
                }
            });
        });
    </script>
    <?php
}
