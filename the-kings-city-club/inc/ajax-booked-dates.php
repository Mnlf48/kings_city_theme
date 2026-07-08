<?php
if (!defined('ABSPATH')) exit;

add_action('wp_ajax_kc_get_booked_dates',        'kc_ajax_get_booked_dates');
add_action('wp_ajax_nopriv_kc_get_booked_dates', 'kc_ajax_get_booked_dates');

function kc_ajax_get_booked_dates() {
    check_ajax_referer('kc_booked_dates_nonce', 'nonce');

    $space_key = sanitize_text_field($_POST['space_key'] ?? '');
    if (!$space_key) {
        wp_send_json_success(['disabled' => [], 'mode' => 'blacklist']);
        return;
    }

    // Find the kc_space post for this booking key
    $sp_posts = get_posts([
        'post_type'      => 'kc_space',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'fields'         => 'ids',
    ]);

    $sp_id    = null;
    $capacity = 0;
    foreach ($sp_posts as $id) {
        if (get_field('kc_space_booking_key', $id) === $space_key) {
            $sp_id    = $id;
            $capacity = (int) get_field('kc_space_capacity', $id);
            break;
        }
    }

    if (!$sp_id) {
        wp_send_json_success(['disabled' => [], 'mode' => 'blacklist']);
        return;
    }

    // ── A. Availability Windows ──────────────────────────────────────────────
    $avail_enabled = (int) get_post_meta($sp_id, 'kc_space_avail_enabled', true);
    $avail_windows = trim(get_post_meta($sp_id, 'kc_space_avail_windows', true));

    if ($avail_enabled) {
        // Build the set of ALL allowed dates from the defined windows
        $allowed = [];
        if ($avail_windows) {
            foreach (array_filter(array_map('trim', explode("\n", $avail_windows))) as $line) {
                $parts = explode('|', $line, 2);
                if (count($parts) !== 2) continue;
                $start = trim($parts[0]);
                $end   = trim($parts[1]);
                if (!$start || !$end) continue;
                $cursor = strtotime($start);
                $stop   = strtotime($end);
                if (!$cursor || !$stop || $cursor > $stop) continue;
                while ($cursor <= $stop) {
                    $allowed[] = date('Y-m-d', $cursor);
                    $cursor    = strtotime('+1 day', $cursor);
                }
            }
        }
        // Return whitelist mode — JS will grey everything EXCEPT these dates
        // Also subtract dates that are full (capacity hit)
        $full = kc_get_capacity_full_dates($space_key, $capacity);
        $allowed_open = array_values(array_diff($allowed, $full));

        wp_send_json_success([
            'mode'    => 'whitelist',   // JS: only these dates are selectable
            'allowed' => $allowed_open,
        ]);
        return;
    }

    // ── B. Capacity-only (no availability windows) ───────────────────────────
    if ($capacity === 0) {
        wp_send_json_success(['disabled' => [], 'mode' => 'blacklist']);
        return;
    }

    $disabled = kc_get_capacity_full_dates($space_key, $capacity);
    wp_send_json_success(['disabled' => $disabled, 'mode' => 'blacklist']);
}

function kc_get_capacity_full_dates($space_key, $capacity) {
    if ($capacity === 0) return [];

    $booking_ids = get_posts([
        'post_type'      => 'kc_booking',
        'posts_per_page' => -1,
        'fields'         => 'ids',
        'meta_query'     => [
            'relation' => 'AND',
            ['key' => 'kc_space_type', 'value' => $space_key],
            ['key' => 'kc_status',     'value' => ['Pending', 'Contacted', 'Completed'], 'compare' => 'IN'],
        ],
    ]);

    $date_counts = [];
    foreach ($booking_ids as $post_id) {
        $date = get_post_meta($post_id, 'kc_start_date', true);
        if ($date) {
            $date_counts[$date] = ($date_counts[$date] ?? 0) + 1;
        }
    }

    $full = [];
    foreach ($date_counts as $date => $count) {
        if ($count >= $capacity) {
            $full[] = $date;
        }
    }
    return $full;
}
