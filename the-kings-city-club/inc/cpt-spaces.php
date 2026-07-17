<?php
if (!defined('ABSPATH')) exit;

// ─── A. Register kc_space CPT ────────────────────────────────────────────────

function kc_register_space_cpt() {
    $labels = [
        'name'               => 'Spaces',
        'singular_name'      => 'Space',
        'menu_name'          => 'Space Add',
        'add_new'            => 'Add New',
        'add_new_item'       => 'Add New Space',
        'edit_item'          => 'Edit Space',
        'new_item'           => 'New Space',
        'view_item'          => 'View Space',
        'search_items'       => 'Search Spaces',
        'not_found'          => 'No spaces found.',
        'not_found_in_trash' => 'No spaces found in Trash.',
        'all_items'          => 'All Spaces',
    ];

    register_post_type('kc_space', [
        'labels'        => $labels,
        'public'        => false,
        'show_ui'       => true,
        'show_in_menu'  => true,
        'menu_icon'     => 'dashicons-building',
        'menu_position' => 26,
        'supports'      => ['title', 'page-attributes'],
        'has_archive'   => false,
        'rewrite'       => false,
    ]);
}
add_action('init', 'kc_register_space_cpt');

// ─── B. Register ACF Field Group ─────────────────────────────────────────────

function kc_register_space_acf_fields() {
    if (!function_exists('acf_add_local_field_group')) return;

    acf_add_local_field_group([
        'key'      => 'group_kc_space',
        'title'    => 'Space Details',
        'location' => [[['param' => 'post_type', 'operator' => '==', 'value' => 'kc_space']]],
        'fields'   => [

            // ── TAB: Content ──
            [
                'key'       => 'field_kc_tab_content',
                'label'     => 'Content',
                'type'      => 'tab',
                'placement' => 'left',
            ],
            [
                'key'           => 'field_kc_space_overline',
                'name'          => 'kc_space_overline',
                'label'         => 'Overline Text',
                'type'          => 'text',
                'wrapper'       => ['width' => '50'],
            ],
            [
                'key'           => 'field_kc_space_heading',
                'name'          => 'kc_space_heading',
                'label'         => 'Space Name / Heading',
                'type'          => 'text',
                'wrapper'       => ['width' => '50'],
            ],
            [
                'key'           => 'field_kc_space_description_1',
                'name'          => 'kc_space_description_1',
                'label'         => 'Description Paragraph 1',
                'type'          => 'textarea',
                'rows'          => 3,
            ],
            [
                'key'           => 'field_kc_space_description_2',
                'name'          => 'kc_space_description_2',
                'label'         => 'Description Paragraph 2 (optional)',
                'type'          => 'textarea',
                'rows'          => 3,
            ],

            // ── TAB: Images ──
            [
                'key'       => 'field_kc_tab_images',
                'label'     => 'Images',
                'type'      => 'tab',
                'placement' => 'left',
            ],
            [
                'key'           => 'field_kc_space_img_1',
                'name'          => 'kc_space_img_1',
                'label'         => 'Image 1 (Main)',
                'type'          => 'image',
                'return_format' => 'url',
            ],
            [
                'key'           => 'field_kc_space_img_2',
                'name'          => 'kc_space_img_2',
                'label'         => 'Image 2',
                'type'          => 'image',
                'return_format' => 'url',
                'wrapper'       => ['width' => '50'],
            ],
            [
                'key'           => 'field_kc_space_img_3',
                'name'          => 'kc_space_img_3',
                'label'         => 'Image 3',
                'type'          => 'image',
                'return_format' => 'url',
                'wrapper'       => ['width' => '50'],
            ],

            // ── TAB: Pricing ──
            [
                'key'       => 'field_kc_tab_pricing',
                'label'     => 'Pricing',
                'type'      => 'tab',
                'placement' => 'left',
            ],
            [
                'key'          => 'field_kc_space_pricing_table',
                'name'         => 'kc_space_pricing_table',
                'label'        => 'Pricing Table Rows',
                'type'         => 'textarea',
                'rows'         => 6,
                'instructions' => 'One row per line. Format: Label|Price — Example: Day Pass|Php 500',
            ],
            [
                'key'   => 'field_kc_space_pricing_note',
                'name'  => 'kc_space_pricing_note',
                'label' => 'Pricing Header Label (e.g. \'Pricing\' or \'Monthly Pricing\')',
                'type'  => 'text',
            ],

            // ── TAB: Booking Form ──
            [
                'key'       => 'field_kc_tab_booking',
                'label'     => 'Booking Form',
                'type'      => 'tab',
                'placement' => 'left',
            ],
            [
                'key'          => 'field_kc_space_booking_key',
                'name'         => 'kc_space_booking_key',
                'label'        => 'Booking Key (UNIQUE slug — e.g. \'Co-Working\', \'Bakehouse\')',
                'type'         => 'text',
                'instructions' => 'This exact string is used in the booking form as the space identifier and stored on each booking ticket. Must be unique. Do not change after bookings exist.',
            ],
            [
                'key'   => 'field_kc_space_form_title',
                'name'  => 'kc_space_form_title',
                'label' => 'Book Form Title (e.g. \'Book Co-Working\')',
                'type'  => 'text',
            ],
            [
                'key'   => 'field_kc_space_form_overline',
                'name'  => 'kc_space_form_overline',
                'label' => 'Book Form Overline',
                'type'  => 'text',
            ],
            [
                'key'          => 'field_kc_space_features',
                'name'         => 'kc_space_features',
                'label'        => 'Feature Tags',
                'type'         => 'textarea',
                'rows'         => 4,
                'instructions' => 'One tag per line. Example: High-speed Wi-Fi',
            ],
            [
                'key'          => 'field_kc_space_pricing_options',
                'name'         => 'kc_space_pricing_options',
                'label'        => 'Booking Duration Options',
                'type'         => 'textarea',
                'rows'         => 6,
                'instructions' => 'One option per line. Format: Display Label|Value|Price(number) — Example: Day Pass — Php 500|Day Pass|500',
            ],
            [
                'key'          => 'field_kc_space_book_image_key',
                'name'         => 'kc_space_book_image_key',
                'label'        => 'Book Now Image ACF Key (leave blank to use Image 1)',
                'type'         => 'text',
                'instructions' => 'Optional. If you have a separate image uploaded for the Book Now page, enter its ACF field key here. Otherwise leave blank.',
            ],

            // ── TAB: Settings ──
            [
                'key'       => 'field_kc_tab_settings',
                'label'     => 'Settings',
                'type'      => 'tab',
                'placement' => 'left',
            ],
            [
                'key'           => 'field_kc_space_is_active',
                'name'          => 'kc_space_is_active',
                'label'         => 'Show on Spaces Page & Booking Form',
                'type'          => 'true_false',
                'default_value' => 1,
                'ui'            => 1,
                'instructions'  => 'You can also toggle this from Space Add → Capacity in the sidebar.',
            ],
            [
                'key'           => 'field_kc_space_has_membership',
                'name'          => 'kc_space_has_membership',
                'label'         => 'Supports Membership (Monthly / Annual Pass)',
                'type'          => 'true_false',
                'default_value' => 0,
                'ui'            => 1,
                'instructions'  => 'Enable this if this space offers a Monthly or Annual Pass. When enabled, completing or activating a booking will create a membership record with an expiry date, and a 7-day renewal reminder email will be sent to the client before it expires.',
            ],
        ],
    ]);
}
add_action('acf/init', 'kc_register_space_acf_fields');

// ─── C. Capacity Submenu Page ─────────────────────────────────────────────────

function kc_register_capacity_submenu() {
    add_submenu_page(
        'edit.php?post_type=kc_space',
        'Space Capacities',
        'Capacity',
        'manage_options',
        'kc-space-capacity',
        'kc_render_capacity_submenu_page'
    );
}
add_action('admin_menu', 'kc_register_capacity_submenu');

function kc_render_capacity_submenu_page() {
    $saved = false;

    if (isset($_POST['kc_save_capacities']) && check_admin_referer('kc_save_capacities_nonce')) {
        $all_spaces = get_posts([
            'post_type'      => 'kc_space',
            'posts_per_page' => -1,
            'post_status'    => 'publish',
            'orderby'        => 'menu_order',
            'order'          => 'ASC',
        ]);
        foreach ($all_spaces as $sp) {
            if (isset($_POST['kc_cap_' . $sp->ID])) {
                update_field('kc_space_capacity', max(0, (int) $_POST['kc_cap_' . $sp->ID]), $sp->ID);
            }
            if (isset($_POST['kc_active_' . $sp->ID])) {
                update_field('kc_space_is_active', (int) $_POST['kc_active_' . $sp->ID], $sp->ID);
            }
            $avail_enabled = isset($_POST['kc_avail_enabled_' . $sp->ID]) ? (int) $_POST['kc_avail_enabled_' . $sp->ID] : 0;
            update_post_meta($sp->ID, 'kc_space_avail_enabled', $avail_enabled);
            $avail_windows = isset($_POST['kc_avail_windows_' . $sp->ID])
                ? sanitize_textarea_field($_POST['kc_avail_windows_' . $sp->ID])
                : '';
            update_post_meta($sp->ID, 'kc_space_avail_windows', $avail_windows);
        }
        $saved = true;
    }

    $spaces = get_posts([
        'post_type'      => 'kc_space',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'orderby'        => 'menu_order',
        'order'          => 'ASC',
    ]);
    ?>
    <div class="wrap">
        <h1 style="display:flex; align-items:center; gap:10px;">
            <span class="dashicons dashicons-building" style="font-size:28px; color:#BD451F; margin-top:2px;"></span>
            Space Capacities
        </h1>
        <p style="color:#666; margin-bottom:20px; max-width:700px;">
            Set the maximum number of bookings allowed per space per day.
            <strong>0 = unlimited</strong> — the booking form will accept any number of submissions with no cap.
            New spaces added via <a href="<?php echo esc_url(admin_url('post-new.php?post_type=kc_space')); ?>">Add New Space</a> appear here automatically.
        </p>

        <?php if ($saved): ?>
        <div class="notice notice-success is-dismissible"><p><strong>Capacities saved.</strong></p></div>
        <?php endif; ?>

        <?php
        // Warn about any Enabled spaces with no windows defined
        $broken = [];
        foreach ($spaces as $sp) {
            $en  = (int) get_post_meta($sp->ID, 'kc_space_avail_enabled', true);
            $win = trim(get_post_meta($sp->ID, 'kc_space_avail_windows', true));
            if ($en && empty($win)) {
                $broken[] = get_field('kc_space_heading', $sp->ID) ?: $sp->post_title;
            }
        }
        if ($broken): ?>
        <div class="notice notice-warning is-dismissible">
            <p><strong>Warning:</strong> The following spaces have Availability set to <strong>Enabled</strong> but no date windows defined — their calendar is fully blocked for clients:<br>
            <strong><?php echo esc_html(implode(', ', $broken)); ?></strong><br>
            Add date windows below or set Availability to <strong>Disabled</strong> to re-open them.</p>
        </div>
        <?php endif; ?>

        <?php if (empty($spaces)): ?>
        <div class="notice notice-warning"><p>No spaces found. <a href="<?php echo esc_url(admin_url('post-new.php?post_type=kc_space')); ?>">Add your first space.</a></p></div>
        <?php else: ?>

        <form method="POST">
            <?php wp_nonce_field('kc_save_capacities_nonce'); ?>
            <table class="wp-list-table widefat fixed striped" style="max-width:800px;">
                <thead>
                    <tr>
                        <th style="width:20%;">Space</th>
                        <th style="width:12%;">Status</th>
                        <th style="width:12%;">Capacity</th>
                        <th style="width:12%;">Availability</th>
                        <th style="width:36%;">Date Windows <span style="font-weight:400; font-size:11px; color:#888;">(one range per line: YYYY-MM-DD|YYYY-MM-DD)</span></th>
                        <th style="width:8%;"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($spaces as $sp):
                        $cap            = (int) get_field('kc_space_capacity', $sp->ID);
                        $active         = get_field('kc_space_is_active', $sp->ID);
                        $heading        = get_field('kc_space_heading', $sp->ID) ?: $sp->post_title;
                        $avail_enabled  = (int) get_post_meta($sp->ID, 'kc_space_avail_enabled', true);
                        $avail_windows  = get_post_meta($sp->ID, 'kc_space_avail_windows', true);
                        $row_id         = 'avail-row-' . $sp->ID;
                    ?>
                    <tr>
                        <td>
                            <strong><?php echo esc_html($heading); ?></strong>
                            <div style="font-size:11px; color:#999; margin-top:2px;">
                                <?php echo esc_html(get_field('kc_space_booking_key', $sp->ID) ?: '—'); ?>
                            </div>
                        </td>
                        <td>
                            <select
                                name="kc_active_<?php echo esc_attr($sp->ID); ?>"
                                style="padding:4px 28px 4px 10px; border-radius:4px; border:1px solid #ccc; font-size:12px; font-weight:600; appearance:none; -webkit-appearance:none; -moz-appearance:none; background-image:url('data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%2212%22 height=%2212%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22%23555%22 stroke-width=%222.5%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22%3E%3Cpolyline points=%226 9 12 15 18 9%22/%3E%3C/svg%3E'); background-repeat:no-repeat; background-position:right 8px center; background-size:12px; cursor:pointer;
                                    color:<?php echo $active ? '#155724' : '#721c24'; ?>;
                                    background-color:<?php echo $active ? '#d4edda' : '#f8d7da'; ?>;"
                                onchange="this.style.color=this.value=='1'?'#155724':'#721c24'; this.style.backgroundColor=this.value=='1'?'#d4edda':'#f8d7da';"
                            >
                                <option value="1" <?php selected($active, 1); ?>>Active</option>
                                <option value="0" <?php selected($active, 0); ?>>Inactive</option>
                            </select>
                        </td>
                        <td>
                            <input
                                type="number"
                                name="kc_cap_<?php echo esc_attr($sp->ID); ?>"
                                value="<?php echo esc_attr($cap); ?>"
                                min="0"
                                style="width:75px; padding:4px 8px; border:1px solid #ddd; border-radius:4px;"
                            >
                        </td>
                        <td>
                            <select
                                name="kc_avail_enabled_<?php echo esc_attr($sp->ID); ?>"
                                style="padding:4px 28px 4px 10px; border-radius:4px; border:1px solid #ccc; font-size:12px; font-weight:600; appearance:none; -webkit-appearance:none; -moz-appearance:none; background-image:url('data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%2212%22 height=%2212%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22%23555%22 stroke-width=%222.5%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22%3E%3Cpolyline points=%226 9 12 15 18 9%22/%3E%3C/svg%3E'); background-repeat:no-repeat; background-position:right 8px center; background-size:12px; cursor:pointer;
                                    color:<?php echo $avail_enabled ? '#155724' : '#555'; ?>;
                                    background-color:<?php echo $avail_enabled ? '#d4edda' : '#f5f5f5'; ?>;"
                                onchange="
                                    this.style.color=this.value=='1'?'#155724':'#555';
                                    this.style.backgroundColor=this.value=='1'?'#d4edda':'#f5f5f5';
                                    document.getElementById('<?php echo esc_js($row_id); ?>').style.display=this.value=='1'?'table-row':'none';
                                "
                            >
                                <option value="0" <?php selected($avail_enabled, 0); ?>>Disabled</option>
                                <option value="1" <?php selected($avail_enabled, 1); ?>>Enabled</option>
                            </select>
                        </td>
                        <td>
                            <textarea
                                name="kc_avail_windows_<?php echo esc_attr($sp->ID); ?>"
                                rows="3"
                                placeholder="2026-07-01|2026-07-07&#10;2026-08-15|2026-08-21"
                                style="width:100%; font-size:12px; font-family:monospace; padding:6px 8px; border:1px solid #ddd; border-radius:4px; resize:vertical;"
                            ><?php echo esc_textarea($avail_windows); ?></textarea>
                            <div style="font-size:11px; color:#999; margin-top:3px;">Only active when Availability is set to <strong>Enabled</strong>.</div>
                        </td>
                        <td style="vertical-align:middle; text-align:left;">
                            <a href="<?php echo esc_url(get_edit_post_link($sp->ID)); ?>" style="font-size:12px; color:#BD451F; white-space:nowrap;">Edit Space</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <p class="submit" style="max-width:800px;">
                <input
                    type="submit"
                    name="kc_save_capacities"
                    class="button button-primary"
                    value="Save Capacities"
                    style="background-color:#AC201A; border-color:#8E1510;"
                >
            </p>
        </form>

        <?php endif; ?>
    </div>
    <?php
}

// ─── D. Custom admin columns ──────────────────────────────────────────────────

function kc_space_add_columns($columns) {
    $new = [];
    foreach ($columns as $key => $label) {
        $new[$key] = $label;
        if ($key === 'title') {
            $new['kc_booking_key'] = 'Booking Key';
            $new['kc_active']      = 'Active';
            $new['kc_order']       = 'Order';
        }
    }
    return $new;
}
add_filter('manage_kc_space_posts_columns', 'kc_space_add_columns');

function kc_space_render_columns($column, $post_id) {
    if ($column === 'kc_booking_key') {
        echo esc_html(get_field('kc_space_booking_key', $post_id) ?: '—');
    }
    if ($column === 'kc_active') {
        $active = get_field('kc_space_is_active', $post_id);
        echo $active ? '<span style="color:#46b450;">&#10003; Yes</span>' : '<span style="color:#dc3232;">&#10007; No</span>';
    }
    if ($column === 'kc_order') {
        $post = get_post($post_id);
        echo esc_html($post->menu_order);
    }
}
add_action('manage_kc_space_posts_custom_column', 'kc_space_render_columns', 10, 2);

function kc_space_sortable_columns($columns) {
    $columns['kc_order'] = 'menu_order';
    return $columns;
}
add_filter('manage_edit-kc_space_sortable_columns', 'kc_space_sortable_columns');

function kc_space_orderby_menu_order($query) {
    if (!is_admin() || !$query->is_main_query()) return;
    if ($query->get('post_type') !== 'kc_space') return;
    // Default the list to menu_order ASC when no explicit sort is chosen
    if (!$query->get('orderby')) {
        $query->set('orderby', 'menu_order');
        $query->set('order', 'ASC');
    } elseif ($query->get('orderby') === 'menu_order') {
        $query->set('order', $query->get('order') ?: 'ASC');
    }
}
add_action('pre_get_posts', 'kc_space_orderby_menu_order');

// ─── E. Auto-assign menu_order on first publish ───────────────────────────────
// WordPress defaults all new posts to menu_order = 0, which floats them to the
// top of the spaces list. This hook fires once — when a space transitions from
// any status to 'publish' for the first time — and sets its order to max + 1.

function kc_space_auto_order_on_publish( $new_status, $old_status, $post ) {
    if ( $post->post_type !== 'kc_space' ) return;
    if ( $new_status !== 'publish' ) return;
    if ( $old_status === 'publish' ) return; // already published → skip re-saves
    if ( (int) $post->menu_order !== 0 ) return; // user already set a custom order

    $highest = get_posts([
        'post_type'      => 'kc_space',
        'posts_per_page' => 1,
        'post_status'    => 'publish',
        'orderby'        => 'menu_order',
        'order'          => 'DESC',
        'exclude'        => [ $post->ID ],
        'fields'         => 'ids',
    ]);

    $max_order = $highest ? (int) get_post( $highest[0] )->menu_order : 0;

    remove_action( 'transition_post_status', 'kc_space_auto_order_on_publish', 10 );
    wp_update_post([ 'ID' => $post->ID, 'menu_order' => $max_order + 1 ]);
    add_action( 'transition_post_status', 'kc_space_auto_order_on_publish', 10, 3 );
}
add_action( 'transition_post_status', 'kc_space_auto_order_on_publish', 10, 3 );
