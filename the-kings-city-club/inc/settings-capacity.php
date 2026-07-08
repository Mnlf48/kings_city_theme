<?php
if (!defined('ABSPATH')) exit;

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

