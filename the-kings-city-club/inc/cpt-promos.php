<?php
/**
 * Custom Post Type for Promo Codes
 */

// 1. Register CPT
add_action('init', 'kc_register_promo_cpt');
function kc_register_promo_cpt() {
    $labels = array(
        'name'               => 'Promo Codes',
        'singular_name'      => 'Promo Code',
        'menu_name'          => 'Promo Codes',
        'name_admin_bar'     => 'Promo Code',
        'add_new'            => 'Add New Code',
        'add_new_item'       => 'Add New Promo Code',
        'new_item'           => 'New Promo Code',
        'edit_item'          => 'Edit Promo Code',
        'view_item'          => 'View Promo Code',
        'all_items'          => 'All Promo Codes',
        'search_items'       => 'Search Promo Codes',
        'not_found'          => 'No promo codes found.',
    );

    $args = array(
        'labels'             => $labels,
        'public'             => false, // Only used in backend and via AJAX
        'show_ui'            => true,
        'show_in_menu'       => 'edit.php?post_type=kc_welcome_packet', // Nest under Newsletters menu
        'query_var'          => false,
        'rewrite'            => false,
        'capability_type'    => 'post',
        'has_archive'        => false,
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'           => array('title'), // Title will be the Promo Code itself (e.g., SUMMER10)
    );

    register_post_type('kc_promo', $args);
}

// 2. Add Meta Box for Promo Settings
add_action('add_meta_boxes', 'kc_promo_meta_boxes');
function kc_promo_meta_boxes() {
    add_meta_box(
        'kc_promo_settings',
        'Promo Settings',
        'kc_render_promo_meta_box',
        'kc_promo',
        'normal',
        'high'
    );
}

function kc_render_promo_meta_box($post) {
    wp_nonce_field('kc_promo_save_meta', 'kc_promo_nonce');

    $type = get_post_meta($post->ID, 'kc_discount_type', true) ?: 'percentage';
    $value = get_post_meta($post->ID, 'kc_discount_value', true) ?: '';
    $max_uses = get_post_meta($post->ID, 'kc_max_uses', true) ?: '';
    $current_uses = get_post_meta($post->ID, 'kc_current_uses', true) ?: '0';
    $expires = get_post_meta($post->ID, 'kc_expires_at', true) ?: '';

    ?>
    <style>
        .kc-promo-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-top: 10px; }
        .kc-promo-field label { display: block; font-weight: 600; margin-bottom: 5px; }
        .kc-promo-field input, .kc-promo-field select { width: 100%; }
        .kc-promo-info { background: #f8fafc; padding: 15px; border-left: 4px solid #3b82f6; margin-bottom: 15px; }
    </style>

    <div class="kc-promo-info">
        <p style="margin:0;"><strong>Note:</strong> The title of this post acts as the actual Promo Code (e.g., <code>SUMMER10</code>). It is case-insensitive during checkout.</p>
    </div>

    <div class="kc-promo-grid">
        <div class="kc-promo-field">
            <label>Discount Type</label>
            <select name="kc_discount_type">
                <option value="percentage" <?php selected($type, 'percentage'); ?>>Percentage (%)</option>
                <option value="flat" <?php selected($type, 'flat'); ?>>Flat Amount (Php)</option>
            </select>
        </div>
        
        <div class="kc-promo-field">
            <label>Discount Value</label>
            <input type="number" step="0.01" name="kc_discount_value" value="<?php echo esc_attr($value); ?>" placeholder="e.g. 10 for 10%, or 500 for Php 500" required />
        </div>

        <div class="kc-promo-field">
            <label>Max Uses (Optional)</label>
            <input type="number" name="kc_max_uses" value="<?php echo esc_attr($max_uses); ?>" placeholder="Leave blank for unlimited" />
        </div>

        <div class="kc-promo-field">
            <label>Current Uses</label>
            <input type="number" name="kc_current_uses" value="<?php echo esc_attr($current_uses); ?>" readonly style="background:#e2e8f0;" />
        </div>

        <div class="kc-promo-field">
            <label>Expiration Date (Optional)</label>
            <input type="date" name="kc_expires_at" value="<?php echo esc_attr($expires); ?>" />
        </div>
    </div>
    <?php
}

// 3. Save Meta Box Data
add_action('save_post_kc_promo', 'kc_promo_save_meta_data');
function kc_promo_save_meta_data($post_id) {
    if (!isset($_POST['kc_promo_nonce']) || !wp_verify_nonce($_POST['kc_promo_nonce'], 'kc_promo_save_meta')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;

    $fields = ['kc_discount_type', 'kc_discount_value', 'kc_max_uses', 'kc_expires_at'];
    foreach ($fields as $field) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, $field, sanitize_text_field($_POST[$field]));
        }
    }
}

// 4. Admin Columns
add_filter('manage_kc_promo_posts_columns', 'kc_promo_set_columns');
function kc_promo_set_columns($columns) {
    $new_columns = array();
    $new_columns['cb'] = $columns['cb'];
    $new_columns['title'] = 'Promo Code';
    $new_columns['discount'] = 'Discount';
    $new_columns['usage'] = 'Uses';
    $new_columns['expires'] = 'Expires';
    $new_columns['date'] = $columns['date'];
    return $new_columns;
}

add_action('manage_kc_promo_posts_custom_column', 'kc_promo_custom_column', 10, 2);
function kc_promo_custom_column($column, $post_id) {
    switch ($column) {
        case 'discount':
            $type = get_post_meta($post_id, 'kc_discount_type', true);
            $val = get_post_meta($post_id, 'kc_discount_value', true);
            if ($type === 'percentage') {
                echo esc_html($val . '% Off');
            } else {
                echo esc_html('Php ' . number_format((float)$val, 2) . ' Off');
            }
            break;
        case 'usage':
            $curr = get_post_meta($post_id, 'kc_current_uses', true) ?: '0';
            $max = get_post_meta($post_id, 'kc_max_uses', true);
            echo esc_html($curr) . ' / ' . ($max ? esc_html($max) : '&infin;');
            break;
        case 'expires':
            $exp = get_post_meta($post_id, 'kc_expires_at', true);
            echo $exp ? esc_html(date_i18n('M j, Y', strtotime($exp))) : '<em>Never</em>';
            break;
    }
}

// 5. AJAX Endpoint: Apply Promo Code
add_action('wp_ajax_nopriv_kc_apply_promo', 'kc_ajax_apply_promo');
add_action('wp_ajax_kc_apply_promo',        'kc_ajax_apply_promo');
function kc_ajax_apply_promo() {
    check_ajax_referer('kc_apply_promo_nonce', 'nonce');

    $code = sanitize_text_field(trim($_POST['promo_code'] ?? ''));
    $base_price = (float) ($_POST['base_price'] ?? 0);

    if (empty($code)) {
        wp_send_json_error(['message' => 'Please enter a promo code.']);
    }
    if ($base_price <= 0) {
        wp_send_json_error(['message' => 'Please select a valid booking option first.']);
    }

    // Find the promo code (case-sensitive title match)
    $promo_query = get_posts([
        'post_type'      => 'kc_promo',
        'title'          => $code,
        'posts_per_page' => 1,
        'post_status'    => 'publish',
    ]);

    if (empty($promo_query)) {
        wp_send_json_error(['message' => 'Invalid promo code.']);
    }

    $promo_id = $promo_query[0]->ID;

    // Check expiration
    $expires = get_post_meta($promo_id, 'kc_expires_at', true);
    if (!empty($expires) && strtotime($expires) < current_time('timestamp')) {
        wp_send_json_error(['message' => 'This promo code has expired.']);
    }

    // Check max uses
    $max_uses = get_post_meta($promo_id, 'kc_max_uses', true);
    $current_uses = (int) (get_post_meta($promo_id, 'kc_current_uses', true) ?: 0);
    if (!empty($max_uses) && $current_uses >= (int)$max_uses) {
        wp_send_json_error(['message' => 'This promo code has reached its usage limit.']);
    }

    // Calculate discount
    $type = get_post_meta($promo_id, 'kc_discount_type', true);
    $value = (float) get_post_meta($promo_id, 'kc_discount_value', true);

    $discount_amount = 0;
    if ($type === 'percentage') {
        $discount_amount = $base_price * ($value / 100);
    } else {
        $discount_amount = $value;
    }

    // Ensure we don't discount more than the base price
    if ($discount_amount > $base_price) {
        $discount_amount = $base_price;
    }

    $final_price = $base_price - $discount_amount;

    wp_send_json_success([
        'message' => 'Promo code applied successfully!',
        'discount_amount' => $discount_amount,
        'final_price' => $final_price,
        'code' => $code,
        'type' => $type,
        'value' => $value
    ]);
}

