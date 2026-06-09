<?php
// Prevent direct access
if (!defined('ABSPATH')) exit;

$crm_path = get_template_directory() . '/inc/admin-crm/';

require_once $crm_path . 'cpt-applications.php';
require_once $crm_path . 'cpt-bookings.php';
require_once $crm_path . 'crm-menu.php';
require_once $crm_path . 'crm-email-helpers.php';
require_once $crm_path . 'crm-actions-handler.php';
require_once $crm_path . 'crm-ajax-handlers.php';
require_once $crm_path . 'crm-dashboard.php';
require_once $crm_path . 'crm-offshoring.php';
require_once $crm_path . 'crm-spaces.php';
require_once $crm_path . 'crm-bookings.php';
require_once $crm_path . 'admin-actions.php';
