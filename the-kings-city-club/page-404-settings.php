<?php
/**
 * Template Name: 404 Settings
 */

// Backend-only settings page — redirect visitors to home if accessed directly.
wp_redirect( home_url() );
exit;
