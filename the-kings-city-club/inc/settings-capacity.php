<?php
if (!defined('ABSPATH')) exit;

function kc_register_capacity_settings() {
    add_submenu_page(
        'edit.php?post_type=kc_booking',
        'Booking Capacities',
        'Space Capacities',
        'manage_options',
        'kc-booking-capacities',
        'kc_render_capacity_settings_page'
    );
}
add_action('admin_menu', 'kc_register_capacity_settings');

function kc_register_capacity_settings_init() {
    register_setting('kc_capacity_group', 'kc_capacity_co_working');
    register_setting('kc_capacity_group', 'kc_capacity_meeting_rooms');
    register_setting('kc_capacity_group', 'kc_capacity_events_place');
    register_setting('kc_capacity_group', 'kc_capacity_office_leasing');
    register_setting('kc_capacity_group', 'kc_capacity_virtual_office');
    register_setting('kc_capacity_group', 'kc_capacity_bakehouse');
    register_setting('kc_capacity_group', 'kc_capacity_manille_ceramic');
}
add_action('admin_init', 'kc_register_capacity_settings_init');

function kc_render_capacity_settings_page() {
    ?>
    <div class="wrap">
        <h1>Kings City Booking Capacities</h1>
        <p>Set the maximum number of bookings allowed per day for each space. If a space reaches this limit on a given day, new bookings will be blocked.</p>
        <form method="post" action="options.php">
            <?php
            settings_fields('kc_capacity_group');
            do_settings_sections('kc_capacity_group');
            ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Co-Working Capacity</th>
                    <td><input type="number" name="kc_capacity_co_working" value="<?php echo esc_attr(get_option('kc_capacity_co_working', 50)); ?>" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Meeting Rooms Capacity</th>
                    <td><input type="number" name="kc_capacity_meeting_rooms" value="<?php echo esc_attr(get_option('kc_capacity_meeting_rooms', 5)); ?>" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Events Place Capacity</th>
                    <td><input type="number" name="kc_capacity_events_place" value="<?php echo esc_attr(get_option('kc_capacity_events_place', 2)); ?>" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Office Leasing Capacity</th>
                    <td><input type="number" name="kc_capacity_office_leasing" value="<?php echo esc_attr(get_option('kc_capacity_office_leasing', 10)); ?>" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Virtual Office Capacity</th>
                    <td><input type="number" name="kc_capacity_virtual_office" value="<?php echo esc_attr(get_option('kc_capacity_virtual_office', 100)); ?>" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Bakehouse Capacity</th>
                    <td><input type="number" name="kc_capacity_bakehouse" value="<?php echo esc_attr(get_option('kc_capacity_bakehouse', 20)); ?>" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Manille Ceramic (Limited) Capacity</th>
                    <td><input type="number" name="kc_capacity_manille_ceramic" value="<?php echo esc_attr(get_option('kc_capacity_manille_ceramic', 10)); ?>" /></td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}
