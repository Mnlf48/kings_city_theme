<?php
/**
 * Template Name: Footer Settings
 */

// This page is just for editing ACF fields in the backend.
// If someone visits it on the frontend, redirect them to the home page.
wp_redirect(home_url());
exit;
