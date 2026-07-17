<?php
/**
 * Test Data Cleanup Tool
 *
 * ⚠️  FOR DEVELOPMENT / TESTING USE ONLY ⚠️
 *
 * Access: WP Admin → Tools → Clean Test Data
 *
 * Cleans:
 *   • All kc_booking posts + their post meta
 *   • All kg_quote_lead posts + their post meta
 *   • All rows in the kc_mailing_list table
 *   • All kc_promo posts generated for testing (optional)
 *
 * DELETE THIS FILE before going to production!
 *
 * @package KingsCity
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// Register the admin page under Tools
add_action( 'admin_menu', 'kc_cleanup_tool_menu' );
function kc_cleanup_tool_menu() {
    add_management_page(
        'Clean Test Data',
        'Clean Test Data',
        'manage_options',
        'kc-clean-test-data',
        'kc_cleanup_tool_page'
    );
}

function kc_cleanup_tool_page() {
    if ( ! current_user_can( 'manage_options' ) ) {
        wp_die( 'Unauthorized.' );
    }

    global $wpdb;
    $ml_table = $wpdb->prefix . 'kc_mailing_list';

    // ── Handle form submission ──────────────────────────────────────────────
    $results = array();

    if ( isset( $_POST['kc_do_cleanup'] ) && wp_verify_nonce( $_POST['kc_cleanup_nonce'], 'kc_run_cleanup' ) ) {

        $what = $_POST['kc_clean_what'] ?? array();

        // 1. Bookings
        if ( in_array( 'bookings', $what ) ) {
            $posts = get_posts( array(
                'post_type'      => 'kc_booking',
                'posts_per_page' => -1,
                'post_status'    => 'any',
                'fields'         => 'ids',
            ) );
            $count = 0;
            foreach ( $posts as $id ) {
                // Delete all meta first, then the post
                $wpdb->delete( $wpdb->postmeta, array( 'post_id' => $id ), array( '%d' ) );
                wp_delete_post( $id, true ); // true = bypass trash
                $count++;
            }
            $results[] = "✅ Deleted <strong>{$count}</strong> booking(s) and all their meta.";
        }

        // 2. Quote Leads
        if ( in_array( 'quotes', $what ) ) {
            $posts = get_posts( array(
                'post_type'      => 'kg_quote_lead',
                'posts_per_page' => -1,
                'post_status'    => 'any',
                'fields'         => 'ids',
            ) );
            $count = 0;
            foreach ( $posts as $id ) {
                $wpdb->delete( $wpdb->postmeta, array( 'post_id' => $id ), array( '%d' ) );
                wp_delete_post( $id, true );
                $count++;
            }
            $results[] = "✅ Deleted <strong>{$count}</strong> quote lead(s) and all their meta.";
        }

        // 3. Mailing List
        if ( in_array( 'mailing_list', $what ) ) {
            $count = $wpdb->get_var( "SELECT COUNT(*) FROM {$ml_table}" );
            $wpdb->query( "TRUNCATE TABLE {$ml_table}" );
            // Reset the DB version flag so kc_create_mailing_list_table re-verifies schema on next admin load
            delete_option( 'kc_ml_db_version' );
            $results[] = "✅ Cleared <strong>{$count}</strong> subscriber(s) from the mailing list.";
        }

        // 4. Promo Codes
        if ( in_array( 'promos', $what ) ) {
            $posts = get_posts( array(
                'post_type'      => 'kc_promo',
                'posts_per_page' => -1,
                'post_status'    => 'any',
                'fields'         => 'ids',
            ) );
            $count = 0;
            foreach ( $posts as $id ) {
                $wpdb->delete( $wpdb->postmeta, array( 'post_id' => $id ), array( '%d' ) );
                wp_delete_post( $id, true );
                $count++;
            }
            $results[] = "✅ Deleted <strong>{$count}</strong> promo code(s).";
        }

        // 5. Campaigns
        if ( in_array( 'campaigns', $what ) ) {
            $posts = get_posts( array(
                'post_type'      => 'kc_campaign',
                'posts_per_page' => -1,
                'post_status'    => 'any',
                'fields'         => 'ids',
            ) );
            $count = 0;
            foreach ( $posts as $id ) {
                $wpdb->delete( $wpdb->postmeta, array( 'post_id' => $id ), array( '%d' ) );
                wp_delete_post( $id, true );
                $count++;
            }
            $results[] = "✅ Deleted <strong>{$count}</strong> campaign(s).";
        }

        // Reset any relevant WP options / caches
        wp_cache_flush();
    }

    // ── Handle: Direct Subscribe Test ──────────────────────────────────────
    $sub_test_result = null;
    if ( isset( $_POST['kc_direct_subscribe'] ) && wp_verify_nonce( $_POST['kc_cleanup_nonce'], 'kc_run_cleanup' ) ) {
        $test_email = sanitize_email( $_POST['kc_test_email'] ?? '' );

        if ( ! is_email( $test_email ) ) {
            $sub_test_result = array( 'ok' => false, 'msg' => 'Invalid email address entered.' );
        } else {
            // Step 1: Check table existence
            $table_exists = (int) $wpdb->get_var( $wpdb->prepare(
                "SELECT COUNT(*) FROM information_schema.tables WHERE table_schema = %s AND table_name = %s",
                DB_NAME, $ml_table
            ) );

            if ( ! $table_exists ) {
                // Table missing — try to create it
                if ( function_exists( 'kc_ensure_mailing_list_table_exists' ) ) {
                    kc_ensure_mailing_list_table_exists();
                }
                $sub_test_result = array( 'ok' => false, 'msg' => "❌ Table <code>{$ml_table}</code> did not exist. Attempted creation — please try again." );
            } else {
                // Step 2: Check for duplicate
                $exists = $wpdb->get_var( $wpdb->prepare( "SELECT id FROM {$ml_table} WHERE email = %s", $test_email ) );
                if ( $exists ) {
                    $sub_test_result = array( 'ok' => false, 'msg' => "ℹ️ Email <strong>{$test_email}</strong> is already in the mailing list (row id: {$exists})." );
                } else {
                    // Step 3: Direct insert
                    $inserted = $wpdb->insert(
                        $ml_table,
                        array( 'email' => $test_email, 'status' => 'active', 'subscribed_at' => current_time( 'mysql' ) ),
                        array( '%s', '%s', '%s' )
                    );
                    if ( $inserted !== false ) {
                        $new_id = $wpdb->insert_id;
                        $sub_test_result = array( 'ok' => true, 'msg' => "✅ Successfully inserted <strong>{$test_email}</strong> (row id: {$new_id}). Reload the Mailing List admin page to see it." );
                    } else {
                        $db_err = $wpdb->last_error ?: 'No error string returned from wpdb.';
                        $sub_test_result = array( 'ok' => false, 'msg' => "❌ Insert FAILED. DB error: <code>" . esc_html( $db_err ) . "</code>" );
                    }
                }
            }
        }
    }

    // ── Count current records ───────────────────────────────────────────────
    $booking_count = wp_count_posts( 'kc_booking' );
    $booking_total = ( $booking_count->publish ?? 0 ) + ( $booking_count->private ?? 0 ) + ( $booking_count->draft ?? 0 );

    $quote_count = wp_count_posts( 'kg_quote_lead' );
    $quote_total = ( $quote_count->publish ?? 0 ) + ( $quote_count->private ?? 0 ) + ( $quote_count->draft ?? 0 );

    $ml_count = (int) $wpdb->get_var( "SELECT COUNT(*) FROM {$ml_table}" );

    $promo_count = wp_count_posts( 'kc_promo' );
    $promo_total = ( $promo_count->publish ?? 0 ) + ( $promo_count->private ?? 0 ) + ( $promo_count->draft ?? 0 );

    $campaign_count = wp_count_posts( 'kc_campaign' );
    $campaign_total = ( $campaign_count->publish ?? 0 ) + ( $campaign_count->private ?? 0 ) + ( $campaign_count->draft ?? 0 );

    // ── UI ──────────────────────────────────────────────────────────────────
    ?>
    <div class="wrap">
        <h1>Clean Test Data</h1>

        <div style="background:#fff3cd;border-left:5px solid #f0ad4e;padding:15px 20px;margin:15px 0;border-radius:4px;">
            <strong>Development Tool:</strong> This will <u>permanently delete</u> the selected records.
            There is no undo — deleted records bypass the Trash.
            <br><strong>Delete <code>/inc/dev-cleanup.php</code> and its menu registration before going live.</strong>
        </div>

        <?php if ( ! empty( $results ) ) : ?>
        <div style="background:#d4edda;border-left:5px solid #28a745;padding:15px 20px;margin:15px 0;border-radius:4px;">
            <strong>Cleanup complete:</strong><br>
            <?php foreach ( $results as $r ) echo '<p style="margin:5px 0;">' . $r . '</p>'; ?>
        </div>
        <?php endif; ?>

        <div style="background:#fff;border:1px solid #ccd0d4;border-radius:6px;padding:25px;max-width:700px;margin-top:20px;">
            <h2 style="margin-top:0;">Current Test Records</h2>
            <table style="border-collapse:collapse;width:100%;font-size:14px;">
                <thead>
                    <tr style="background:#f1f5f9;">
                        <th style="padding:10px 15px;text-align:left;border-bottom:2px solid #e2e8f0;">Record Type</th>
                        <th style="padding:10px 15px;text-align:center;border-bottom:2px solid #e2e8f0;">Count</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="padding:10px 15px;border-bottom:1px solid #f1f5f9;">Bookings (<code>kc_booking</code>)</td>
                        <td style="padding:10px 15px;text-align:center;font-weight:bold;color:<?php echo $booking_total > 0 ? '#dc2626' : '#22c55e'; ?>;"><?php echo $booking_total; ?></td>
                    </tr>
                    <tr>
                        <td style="padding:10px 15px;border-bottom:1px solid #f1f5f9;">Quote Leads (<code>kg_quote_lead</code>)</td>
                        <td style="padding:10px 15px;text-align:center;font-weight:bold;color:<?php echo $quote_total > 0 ? '#dc2626' : '#22c55e'; ?>;"><?php echo $quote_total; ?></td>
                    </tr>
                    <tr>
                        <td style="padding:10px 15px;border-bottom:1px solid #f1f5f9;">Mailing List Subscribers</td>
                        <td style="padding:10px 15px;text-align:center;font-weight:bold;color:<?php echo $ml_count > 0 ? '#dc2626' : '#22c55e'; ?>;"><?php echo $ml_count; ?></td>
                    </tr>
                    <tr>
                        <td style="padding:10px 15px;border-bottom:1px solid #f1f5f9;">Promo Codes (<code>kc_promo</code>)</td>
                        <td style="padding:10px 15px;text-align:center;font-weight:bold;color:<?php echo $promo_total > 0 ? '#dc2626' : '#22c55e'; ?>;"><?php echo $promo_total; ?></td>
                    </tr>
                    <tr>
                        <td style="padding:10px 15px;">Campaigns (<code>kc_campaign</code>)</td>
                        <td style="padding:10px 15px;text-align:center;font-weight:bold;color:<?php echo $campaign_total > 0 ? '#dc2626' : '#22c55e'; ?>;"><?php echo $campaign_total; ?></td>
                    </tr>
                </tbody>
            </table>

            <hr style="margin:25px 0;">

            <form method="POST" action="">
                <?php wp_nonce_field( 'kc_run_cleanup', 'kc_cleanup_nonce' ); ?>

                <h3 style="margin-top:0;">Select what to delete:</h3>

                <label style="display:flex;align-items:center;gap:10px;margin-bottom:12px;cursor:pointer;">
                    <input type="checkbox" name="kc_clean_what[]" value="bookings" style="width:18px;height:18px;"
                        <?php echo $booking_total > 0 ? 'checked' : 'disabled'; ?>>
                    <span><strong>Bookings</strong> — <?php echo $booking_total; ?> record(s) + all post meta</span>
                </label>

                <label style="display:flex;align-items:center;gap:10px;margin-bottom:12px;cursor:pointer;">
                    <input type="checkbox" name="kc_clean_what[]" value="quotes" style="width:18px;height:18px;"
                        <?php echo $quote_total > 0 ? 'checked' : 'disabled'; ?>>
                    <span><strong>Quote Leads</strong> — <?php echo $quote_total; ?> record(s) + all post meta</span>
                </label>

                <label style="display:flex;align-items:center;gap:10px;margin-bottom:12px;cursor:pointer;">
                    <input type="checkbox" name="kc_clean_what[]" value="mailing_list" style="width:18px;height:18px;"
                        <?php echo $ml_count > 0 ? 'checked' : 'disabled'; ?>>
                    <span><strong>Mailing List</strong> — <?php echo $ml_count; ?> subscriber(s)</span>
                </label>

                <label style="display:flex;align-items:center;gap:10px;margin-bottom:12px;cursor:pointer;">
                    <input type="checkbox" name="kc_clean_what[]" value="promos" style="width:18px;height:18px;">
                    <span><strong>Promo Codes</strong> — <?php echo $promo_total; ?> code(s) (optional — uncheck to keep manual codes)</span>
                </label>

                <label style="display:flex;align-items:center;gap:10px;margin-bottom:20px;cursor:pointer;">
                    <input type="checkbox" name="kc_clean_what[]" value="campaigns" style="width:18px;height:18px;">
                    <span><strong>Campaigns</strong> — <?php echo $campaign_total; ?> campaign(s) (optional — uncheck to keep existing campaigns)</span>
                </label>

                <?php
                $all_empty = $booking_total === 0 && $quote_total === 0 && $ml_count === 0;
                if ( $all_empty ) : ?>
                    <p style="color:#22c55e;font-weight:bold;">✅ All records are already clean! Nothing to delete.</p>
                <?php else : ?>
                    <input
                        type="submit"
                        name="kc_do_cleanup"
                        class="button button-primary"
                        value="🗑️ Delete Selected Records"
                        style="background:#dc2626;border-color:#b91c1c;font-size:14px;padding:6px 20px;height:auto;"
                        onclick="return confirm('Are you sure? This will permanently delete the selected records. There is no undo!');"
                    >
                <?php endif; ?>
            </form>
        </div>

        <hr style="margin: 40px 0 30px;">

        <div style="background:#fff;border:1px solid #ccd0d4;border-radius:6px;padding:25px;max-width:700px;">
            <h2 style="margin-top:0;">Direct Subscribe Test (No JS / No AJAX)</h2>
            <p style="color:#4b5563;margin-top:0;">This test inserts directly into the database via PHP, bypassing all JavaScript and AJAX.
            Use this to find out whether the problem is in the <strong>database layer</strong> or the <strong>frontend AJAX layer</strong>.</p>

            <?php if ( $sub_test_result !== null ) : ?>
                <div style="padding:14px 18px;border-radius:6px;margin-bottom:20px;font-size:14px;
                    background:<?php echo $sub_test_result['ok'] ? '#d4edda' : '#fff3cd'; ?>;
                    border-left:5px solid <?php echo $sub_test_result['ok'] ? '#28a745' : '#f0ad4e'; ?>;">
                    <?php echo $sub_test_result['msg']; ?>
                </div>
            <?php endif; ?>

            <?php
            // Show current table state
            $tbl_chk = (int) $wpdb->get_var( $wpdb->prepare(
                "SELECT COUNT(*) FROM information_schema.tables WHERE table_schema = %s AND table_name = %s",
                DB_NAME, $ml_table
            ) );
            $ml_rows = $tbl_chk ? (int) $wpdb->get_var( "SELECT COUNT(*) FROM {$ml_table}" ) : 0;
            ?>
            <table style="border-collapse:collapse;width:100%;font-size:13px;margin-bottom:20px;">
                <tr>
                    <td style="padding:8px 14px;border-bottom:1px solid #f1f5f9;color:#6b7280;">Table name</td>
                    <td style="padding:8px 14px;border-bottom:1px solid #f1f5f9;"><code><?php echo esc_html($ml_table); ?></code></td>
                </tr>
                <tr>
                    <td style="padding:8px 14px;border-bottom:1px solid #f1f5f9;color:#6b7280;">Table exists?</td>
                    <td style="padding:8px 14px;border-bottom:1px solid #f1f5f9;font-weight:bold;color:<?php echo $tbl_chk ? '#22c55e' : '#dc2626'; ?>;">
                        <?php echo $tbl_chk ? 'YES' : 'NO — table is missing!'; ?>
                    </td>
                </tr>
                <tr>
                    <td style="padding:8px 14px;color:#6b7280;">Current row count</td>
                    <td style="padding:8px 14px;font-weight:bold;"><?php echo $ml_rows; ?></td>
                </tr>
            </table>

            <form method="POST">
                <?php wp_nonce_field( 'kc_run_cleanup', 'kc_cleanup_nonce' ); ?>
                <div style="display:flex;gap:10px;align-items:flex-end;">
                    <div style="flex:1;">
                        <label style="display:block;font-weight:600;margin-bottom:6px;">Test email address</label>
                        <input type="email" name="kc_test_email" placeholder="test@example.com"
                            style="width:100%;padding:8px 12px;border:1px solid #d1d5db;border-radius:4px;font-size:14px;" required>
                    </div>
                    <input type="submit" name="kc_direct_subscribe" class="button button-primary"
                        value="Insert Directly →"
                        style="background:#1d4ed8;border-color:#1e40af;padding:8px 20px;height:auto;font-size:14px;white-space:nowrap;">
                </div>
                <p style="font-size:12px;color:#94a3b8;margin-top:8px;">
                    If this succeeds but the footer form doesn't work → the bug is in the AJAX/JS layer.<br>
                    If this also fails → the bug is in the PHP/DB layer (check the error code above).
                </p>
            </form>
        </div>

        <p style="color:#94a3b8;font-size:12px;margin-top:30px;">
            Registered via <code>/inc/dev-cleanup.php</code> — Remove this file and its include in <code>functions.php</code> before deploying to production.
        </p>
    </div>
    <?php
}
