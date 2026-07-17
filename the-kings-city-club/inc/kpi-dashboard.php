<?php
if (!defined('ABSPATH')) exit;

function kc_register_kpi_dashboard() {
    add_menu_page(
        'KPI Dashboard',
        'KPI Dashboard',
        'manage_options',
        'kc-kpi-dashboard',
        'kc_render_kpi_dashboard',
        'dashicons-chart-bar',
        28 // Position below Bookings
    );
}
add_action('admin_menu', 'kc_register_kpi_dashboard');

function kc_parse_revenue_val($val) {
    // Strip everything except numbers and decimals
    $clean = preg_replace('/[^0-9.]/', '', $val);
    return floatval($clean);
}

// Handle CSV Export
function kc_export_kpi_csv() {
    global $wpdb;
    if (!current_user_can('manage_options')) wp_die('Unauthorized');
    check_admin_referer('kc_export_kpi_csv');

    $selected_month = isset($_GET['kpi_month']) ? sanitize_text_field($_GET['kpi_month']) : date('Y-m');

    $date_query     = array();
    $display_period = 'All Time';
    if (!empty($selected_month)) {
        $year  = substr($selected_month, 0, 4);
        $month = substr($selected_month, 5, 2);
        $date_query     = array(array('year' => $year, 'month' => $month));
        $display_period = date('F Y', strtotime($selected_month . '-01'));
    }

    // --- Bookings: single pass over all records ---
    $booking_statuses   = array('Pending', 'Contacted', 'Active', 'Completed', 'Rejected', 'Cancelled');
    $bookings_by_status = array_fill_keys($booking_statuses, 0);

    $b_all_args = array('post_type' => 'kc_booking', 'posts_per_page' => -1, 'fields' => 'ids');
    if (!empty($date_query)) $b_all_args['date_query'] = $date_query;
    $b_all_query        = new WP_Query($b_all_args);
    $bookings_all_count = $b_all_query->found_posts;

    $total_bookings_revenue = 0;
    $revenue_by_space       = array();
    $total_bookings_won     = 0;

    foreach ($b_all_query->posts as $post_id) {
        $status = get_post_meta($post_id, 'kc_status', true) ?: 'Pending';
        if (isset($bookings_by_status[$status])) $bookings_by_status[$status]++;
        if ($status === 'Active' || $status === 'Completed') {
            $space     = get_post_meta($post_id, 'kc_space_type', true) ?: 'Unknown';
            $log_raw   = get_post_meta($post_id, 'kc_payment_log', true);
            $log       = is_array($log_raw) ? $log_raw : array();
            $collected = array_sum(array_column($log, 'amount'));
            $total_bookings_revenue += $collected;
            $revenue_by_space[$space] = ($revenue_by_space[$space] ?? 0) + $collected;
            $total_bookings_won++;
        }
    }
    arsort($revenue_by_space);
    $bookings_conversion    = $bookings_all_count > 0 ? round(($total_bookings_won / $bookings_all_count) * 100, 1) : 0;
    $bookings_pending_action = $bookings_by_status['Pending'] + $bookings_by_status['Contacted'];

    // --- Quotes: single pass over all records ---
    $quote_statuses   = array('Pending', 'Contacted', 'Closed', 'Rejected');
    $quotes_by_status = array_fill_keys($quote_statuses, 0);

    $q_all_args = array('post_type' => 'kg_quote_lead', 'posts_per_page' => -1, 'fields' => 'ids');
    if (!empty($date_query)) $q_all_args['date_query'] = $date_query;
    $q_all_query      = new WP_Query($q_all_args);
    $quotes_all_count = $q_all_query->found_posts;

    $total_quotes_revenue = 0;
    $total_quotes_won     = 0;

    foreach ($q_all_query->posts as $post_id) {
        $status = get_post_meta($post_id, 'lead_status', true) ?: 'Pending';
        if (isset($quotes_by_status[$status])) $quotes_by_status[$status]++;
        if ($status === 'Closed') {
            $total_quotes_revenue += kc_parse_revenue_val(get_post_meta($post_id, 'total_est', true));
            $total_quotes_won++;
        }
    }
    $quotes_conversion    = $quotes_all_count > 0 ? round(($total_quotes_won / $quotes_all_count) * 100, 1) : 0;
    $quotes_pending_action = $quotes_by_status['Pending'] + $quotes_by_status['Contacted'];

    // --- Mailing list (always all-time) ---
    $ml_table   = $wpdb->prefix . 'kc_mailing_list';
    $ml_total   = (int) $wpdb->get_var("SELECT COUNT(*) FROM {$ml_table}");
    $ml_active  = (int) $wpdb->get_var("SELECT COUNT(*) FROM {$ml_table} WHERE status = 'active'");
    $ml_pending = (int) $wpdb->get_var("SELECT COUNT(*) FROM {$ml_table} WHERE status = 'pending'");
    $ml_unsub   = (int) $wpdb->get_var("SELECT COUNT(*) FROM {$ml_table} WHERE status = 'unsubscribed'");

    // --- Summary values ---
    $total_needs_action = $bookings_pending_action + $quotes_pending_action;

    // --- Space Leads (for CSV) ---
    $csv_space_posts = get_posts(array('post_type' => 'kc_space', 'posts_per_page' => -1, 'post_status' => 'publish', 'orderby' => 'menu_order', 'order' => 'ASC'));
    $csv_space_leads = array();
    foreach ($csv_space_posts as $csv_sp) {
        $csv_key   = get_field('kc_space_booking_key', $csv_sp->ID);
        $csv_label = get_field('kc_space_heading', $csv_sp->ID) ?: $csv_sp->post_title;
        if (!$csv_key) continue;
        $csv_space_leads[$csv_key] = array('label' => $csv_label, 'total' => 0, 'Pending' => 0, 'Contacted' => 0, 'Active' => 0, 'Completed' => 0, 'Rejected' => 0, 'Cancelled' => 0, 'revenue' => 0);
    }
    foreach ($b_all_query->posts as $pid) {
        $csv_sp_key  = get_post_meta($pid, 'kc_space_type', true);
        $csv_st      = get_post_meta($pid, 'kc_status', true) ?: 'Pending';
        if (!$csv_sp_key || !isset($csv_space_leads[$csv_sp_key])) continue;
        $csv_space_leads[$csv_sp_key]['total']++;
        if (isset($csv_space_leads[$csv_sp_key][$csv_st])) $csv_space_leads[$csv_sp_key][$csv_st]++;
        if ($csv_st === 'Active' || $csv_st === 'Completed') {
            $csv_log = get_post_meta($pid, 'kc_payment_log', true);
            $csv_log = is_array($csv_log) ? $csv_log : array();
            $csv_space_leads[$csv_sp_key]['revenue'] += array_sum(array_column($csv_log, 'amount'));
        }
    }

    // --- Monthly analytics (last 12 months, for CSV) ---
    $csv_months = array();
    for ($i = 11; $i >= 0; $i--) {
        $csv_months[] = date('Y-m', strtotime("-{$i} months"));
    }
    $csv_bk_monthly  = array_fill_keys($csv_months, 0);
    $csv_rev_monthly = array_fill_keys($csv_months, 0);
    $csv_qt_monthly  = array_fill_keys($csv_months, 0);
    $csv_qt_rev_monthly = array_fill_keys($csv_months, 0);
    $csv_pass_monthly = array('Day Pass' => array_fill_keys($csv_months, 0), 'Weekly Pass' => array_fill_keys($csv_months, 0), 'Monthly Pass' => array_fill_keys($csv_months, 0), 'Annual Pass' => array_fill_keys($csv_months, 0));

    $csv_bk_chart = new WP_Query(array('post_type' => 'kc_booking', 'posts_per_page' => -1, 'fields' => 'ids', 'date_query' => array(array('after' => date('Y-m-d', strtotime('-12 months'))))));
    foreach ($csv_bk_chart->posts as $pid) {
        $mk = substr(get_post_field('post_date', $pid), 0, 7);
        if (!isset($csv_bk_monthly[$mk])) continue;
        $csv_bk_monthly[$mk]++;
        $st = get_post_meta($pid, 'kc_status', true);
        if ($st === 'Active' || $st === 'Completed') {
            $lg = get_post_meta($pid, 'kc_payment_log', true);
            $lg = is_array($lg) ? $lg : array();
            $csv_rev_monthly[$mk] += array_sum(array_column($lg, 'amount'));
        }
        $dur = get_post_meta($pid, 'kc_duration', true);
        if (isset($csv_pass_monthly[$dur])) $csv_pass_monthly[$dur][$mk]++;
    }
    $csv_qt_chart = new WP_Query(array('post_type' => 'kg_quote_lead', 'posts_per_page' => -1, 'fields' => 'ids', 'date_query' => array(array('after' => date('Y-m-d', strtotime('-12 months'))))));
    foreach ($csv_qt_chart->posts as $qid) {
        $mk = substr(get_post_field('post_date', $qid), 0, 7);
        if (!isset($csv_qt_monthly[$mk])) continue;
        $csv_qt_monthly[$mk]++;
        if (get_post_meta($qid, 'lead_status', true) === 'Closed') {
            $csv_qt_rev_monthly[$mk] += kc_parse_revenue_val(get_post_meta($qid, 'total_est', true));
        }
    }

    // --- Members (all-time) ---
    $mem_args = array('post_type' => 'kc_booking', 'posts_per_page' => -1, 'fields' => 'ids');
    $mem_all  = (new WP_Query($mem_args))->posts;
    $mem_active = $mem_expired = $mem_expiring = $mem_none = 0;
    $seen_emails_csv = array();
    $today_csv = date('Y-m-d');
    $in30_csv  = date('Y-m-d', strtotime('+30 days'));
    foreach ($mem_all as $pid) {
        $email = get_post_meta($pid, 'kc_email', true);
        if ($email && in_array($email, $seen_emails_csv, true)) continue;
        if ($email) $seen_emails_csv[] = $email;
        $ms  = get_post_meta($pid, 'kc_membership_status', true);
        $exp = get_post_meta($pid, 'kc_membership_expiry', true);
        if ($ms === 'Active') {
            $mem_active++;
            if ($exp && $exp >= $today_csv && $exp <= $in30_csv) $mem_expiring++;
        } elseif ($ms === 'Expired') {
            $mem_expired++;
        } else {
            $mem_none++;
        }
    }

    // --- Output ---
    $filename = 'Kings_City_KPI_' . $selected_month . '.csv';
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Pragma: no-cache');
    header('Expires: 0');

    $out = fopen('php://output', 'w');

    // ── SECTION 0: Summary ──────────────────────────────────────────────────
    fputcsv($out, array('=== SUMMARY ==='));
    fputcsv($out, array('Reporting Period', 'Metric', 'Value'));
    fputcsv($out, array($display_period, 'Bookings Revenue Collected (Php)',          number_format($total_bookings_revenue, 2)));
    fputcsv($out, array($display_period, 'Team Builder Est. Revenue / mo (Php)',      number_format($total_quotes_revenue, 2)));
    fputcsv($out, array($display_period, 'Needs Action — Pending + Contacted Items', $total_needs_action));

    // ── SECTION 1: Bookings ─────────────────────────────────────────────────
    fputcsv($out, array(''));
    fputcsv($out, array('=== BOOKINGS — SPACES ==='));
    fputcsv($out, array($display_period, 'Total Booking Requests',        $bookings_all_count));
    fputcsv($out, array($display_period, 'Active & Completed',            $total_bookings_won));
    fputcsv($out, array($display_period, 'Conversion Rate',               $bookings_conversion . '%'));
    fputcsv($out, array($display_period, 'Revenue Collected (Php)',       number_format($total_bookings_revenue, 2)));
    fputcsv($out, array(''));
    fputcsv($out, array('--- Pipeline Breakdown ---'));
    foreach ($bookings_by_status as $st => $cnt) {
        fputcsv($out, array($display_period, 'Bookings — ' . $st, $cnt));
    }

    // ── SECTION 1b: Booking Client Records ─────────────────────────────────
    fputcsv($out, array(''));
    fputcsv($out, array('--- Booking Client Records ---'));
    fputcsv($out, array('Client Name', 'Email', 'Phone', 'Space', 'Duration', 'Start Date', 'Total Due (Php)', 'Total Paid (Php)', 'Balance (Php)', 'Invoice', 'Status', 'Membership Status', 'Membership Expiry'));
    $bk_rec_query = new WP_Query(array('post_type' => 'kc_booking', 'posts_per_page' => -1, 'orderby' => 'date', 'order' => 'DESC', 'fields' => 'ids'));
    if (!empty($bk_rec_query->posts)) {
        foreach ($bk_rec_query->posts as $pid) {
            $bk_name    = trim(get_post_meta($pid, 'kc_first_name', true) . ' ' . get_post_meta($pid, 'kc_last_name', true));
            $bk_price   = (float) get_post_meta($pid, 'kc_price', true);
            $bk_log_raw = get_post_meta($pid, 'kc_payment_log', true);
            $bk_log     = is_array($bk_log_raw) ? $bk_log_raw : array();
            $bk_paid    = array_sum(array_column($bk_log, 'amount'));
            $bk_balance = max(0, $bk_price - $bk_paid);
            fputcsv($out, array(
                $bk_name,
                get_post_meta($pid, 'kc_email',             true),
                get_post_meta($pid, 'kc_phone',             true),
                get_post_meta($pid, 'kc_space_type',        true),
                get_post_meta($pid, 'kc_duration',          true),
                get_post_meta($pid, 'kc_start_date',        true),
                number_format($bk_price, 2),
                number_format($bk_paid, 2),
                number_format($bk_balance, 2),
                get_post_meta($pid, 'kc_invoice_number',    true) ?: '—',
                get_post_meta($pid, 'kc_status',            true) ?: 'Pending',
                get_post_meta($pid, 'kc_membership_status', true) ?: '—',
                get_post_meta($pid, 'kc_membership_expiry', true) ?: '—',
            ));
        }
    } else {
        fputcsv($out, array('No booking records found.'));
    }

    // ── SECTION 2: Space Leads ──────────────────────────────────────────────
    fputcsv($out, array(''));
    fputcsv($out, array('=== SPACE LEADS — REQUESTS & CONVERSION PER SPACE ==='));
    fputcsv($out, array('Space', 'Total Requests', 'Pending', 'Contacted', 'Active', 'Completed', 'Rejected', 'Cancelled', 'Revenue Collected (Php)', 'Conversion %'));
    $sl_csv_grand = array('total' => 0, 'Pending' => 0, 'Contacted' => 0, 'Active' => 0, 'Completed' => 0, 'Rejected' => 0, 'Cancelled' => 0, 'revenue' => 0, 'won' => 0);
    foreach ($csv_space_leads as $sl) {
        $sl_won  = $sl['Active'] + $sl['Completed'];
        $sl_conv = $sl['total'] > 0 ? round(($sl_won / $sl['total']) * 100, 1) : 0;
        fputcsv($out, array($sl['label'], $sl['total'], $sl['Pending'], $sl['Contacted'], $sl['Active'], $sl['Completed'], $sl['Rejected'], $sl['Cancelled'], number_format($sl['revenue'], 2), $sl_conv . '%'));
        foreach (array('total','Pending','Contacted','Active','Completed','Rejected','Cancelled') as $k) $sl_csv_grand[$k] += $sl[$k];
        $sl_csv_grand['revenue'] += $sl['revenue'];
        $sl_csv_grand['won']     += $sl_won;
    }
    $sl_csv_grand_conv = $sl_csv_grand['total'] > 0 ? round(($sl_csv_grand['won'] / $sl_csv_grand['total']) * 100, 1) : 0;
    fputcsv($out, array('ALL SPACES', $sl_csv_grand['total'], $sl_csv_grand['Pending'], $sl_csv_grand['Contacted'], $sl_csv_grand['Active'], $sl_csv_grand['Completed'], $sl_csv_grand['Rejected'], $sl_csv_grand['Cancelled'], number_format($sl_csv_grand['revenue'], 2), $sl_csv_grand_conv . '%'));

    // ── SECTION 3: Quotes ───────────────────────────────────────────────────
    fputcsv($out, array(''));
    fputcsv($out, array('=== QUOTE LEADS — TEAM BUILDER ==='));
    fputcsv($out, array($display_period, 'Total Quote Requests',              $quotes_all_count));
    fputcsv($out, array($display_period, 'Successful Quotes (Closed)',        $total_quotes_won));
    fputcsv($out, array($display_period, 'Conversion Rate',                   $quotes_conversion . '%'));
    fputcsv($out, array($display_period, 'Est. Recurring Revenue / mo (Php)', number_format($total_quotes_revenue, 2)));
    fputcsv($out, array(''));
    fputcsv($out, array('--- Pipeline Breakdown ---'));
    foreach ($quotes_by_status as $st => $cnt) {
        fputcsv($out, array($display_period, 'Quotes — ' . $st, $cnt));
    }

    // ── SECTION 3b: Quote Client Records ───────────────────────────────────
    fputcsv($out, array(''));
    fputcsv($out, array('--- Quote Client Records ---'));
    fputcsv($out, array('Client Name', 'Email', 'Phone', 'Address', 'Date Submitted', 'Status', 'Currency', 'Est. Total', 'Team Roles', 'Team Breakdown'));
    $qt_rec_query = new WP_Query(array('post_type' => 'kg_quote_lead', 'posts_per_page' => -1, 'orderby' => 'date', 'order' => 'DESC', 'fields' => 'ids'));
    if (!empty($qt_rec_query->posts)) {
        foreach ($qt_rec_query->posts as $qid) {
            $qt_fn       = get_post_meta($qid, 'first_name',  true);
            $qt_mn       = get_post_meta($qid, 'middle_name', true);
            $qt_ln       = get_post_meta($qid, 'last_name',   true);
            $qt_name     = trim($qt_fn . ($qt_mn ? ' ' . $qt_mn : '') . ' ' . $qt_ln);
            $qt_team_raw = get_post_meta($qid, 'team_json', true);
            $qt_team     = $qt_team_raw ? json_decode($qt_team_raw, true) : array();
            $qt_team_str = '—';
            $qt_roles    = 0;
            if (is_array($qt_team) && !empty($qt_team)) {
                $qt_roles = count($qt_team);
                $parts    = array();
                foreach ($qt_team as $m) {
                    $role  = $m['title']     ?? $m['role'] ?? 'Unknown';
                    $level = $m['level']     ?? '';
                    $count = $m['headcount'] ?? $m['count'] ?? 1;
                    $rate  = $m['monthly']   ?? $m['rate']  ?? '';
                    $part  = $role . ($level ? ' — ' . $level : '') . ' x' . $count;
                    if ($rate) $part .= ' (' . $rate . '/mo)';
                    $parts[] = $part;
                }
                $qt_team_str = implode(' | ', $parts);
            }
            fputcsv($out, array(
                $qt_name,
                get_post_meta($qid, 'email',         true),
                get_post_meta($qid, 'phone',         true),
                get_post_meta($qid, 'address',       true),
                get_the_date('Y-m-d', $qid),
                get_post_meta($qid, 'lead_status',   true) ?: 'Pending',
                get_post_meta($qid, 'currency_used', true) ?: 'PHP',
                get_post_meta($qid, 'total_est',     true),
                $qt_roles,
                $qt_team_str,
            ));
        }
    } else {
        fputcsv($out, array('No quote request records found.'));
    }

    // ── SECTION 4: Members ──────────────────────────────────────────────────
    fputcsv($out, array(''));
    fputcsv($out, array('=== MEMBERS — ALL-TIME ==='));
    fputcsv($out, array('All Time', 'Active Members',          $mem_active));
    fputcsv($out, array('All Time', 'Expiring Within 30 Days', $mem_expiring));
    fputcsv($out, array('All Time', 'Expired Members',         $mem_expired));
    fputcsv($out, array('All Time', 'No Membership (N/A)',     $mem_none));

    // ── SECTION 5: Mailing List ─────────────────────────────────────────────
    fputcsv($out, array(''));
    fputcsv($out, array('=== MAILING LIST — ALL-TIME ==='));
    fputcsv($out, array('All Time', 'Total Subscribers',   $ml_total));
    fputcsv($out, array('All Time', 'Active Subscribers',  $ml_active));
    fputcsv($out, array('All Time', 'Pending Subscribers', $ml_pending));
    fputcsv($out, array('All Time', 'Unsubscribed',        $ml_unsub));
    fputcsv($out, array(''));
    fputcsv($out, array('--- Mailing List Records ---'));
    fputcsv($out, array('Email', 'Status', 'Subscribed At'));
    $ml_records = $wpdb->get_results("SELECT email, status, subscribed_at FROM {$ml_table} ORDER BY id DESC", ARRAY_A);
    if (!empty($ml_records)) {
        foreach ($ml_records as $row) {
            fputcsv($out, array($row['email'], ucfirst($row['status']), $row['subscribed_at']));
        }
    } else {
        fputcsv($out, array('No subscribers found.'));
    }

    // ── SECTION 6: Monthly Analytics (last 12 months) ──────────────────────
    fputcsv($out, array(''));
    fputcsv($out, array('=== MONTHLY ANALYTICS — LAST 12 MONTHS ==='));
    fputcsv($out, array('Month', 'Space Bookings', 'Bookings Revenue Collected (Php)', 'Day Pass', 'Weekly Pass', 'Monthly Pass', 'Annual Pass', 'Quote Requests', 'Quote Est. Revenue (Php)'));
    foreach ($csv_months as $mk) {
        fputcsv($out, array(
            date('M Y', strtotime($mk . '-01')),
            $csv_bk_monthly[$mk],
            number_format($csv_rev_monthly[$mk], 2),
            $csv_pass_monthly['Day Pass'][$mk],
            $csv_pass_monthly['Weekly Pass'][$mk],
            $csv_pass_monthly['Monthly Pass'][$mk],
            $csv_pass_monthly['Annual Pass'][$mk],
            $csv_qt_monthly[$mk],
            number_format($csv_qt_rev_monthly[$mk], 2),
        ));
    }

    fclose($out);
    exit;
}
add_action('admin_post_kc_export_kpi_csv', 'kc_export_kpi_csv');


function kc_render_kpi_dashboard() {
    global $wpdb;

    $selected_month = isset($_GET['kpi_month']) ? sanitize_text_field($_GET['kpi_month']) : date('Y-m');

    $date_query     = array();
    $display_period = 'All Time';
    if (!empty($selected_month)) {
        $year  = substr($selected_month, 0, 4);
        $month = substr($selected_month, 5, 2);
        $date_query     = array(array('year' => $year, 'month' => $month));
        $display_period = date('F Y', strtotime($selected_month . '-01'));
    }

    // --- Bookings: all statuses for pipeline breakdown ---
    $booking_statuses = array('Pending', 'Contacted', 'Active', 'Completed', 'Rejected', 'Cancelled');
    $bookings_by_status = array_fill_keys($booking_statuses, 0);

    $bookings_all_args = array('post_type' => 'kc_booking', 'posts_per_page' => -1, 'fields' => 'ids');
    if (!empty($date_query)) $bookings_all_args['date_query'] = $date_query;
    $bookings_all_query = new WP_Query($bookings_all_args);
    $bookings_all_count = $bookings_all_query->found_posts;

    $total_bookings_revenue = 0;
    $revenue_by_space       = array();
    $total_bookings_won     = 0;

    foreach ($bookings_all_query->posts as $post_id) {
        $status = get_post_meta($post_id, 'kc_status', true) ?: 'Pending';
        if (isset($bookings_by_status[$status])) $bookings_by_status[$status]++;
        if ($status === 'Active' || $status === 'Completed') {
            $space    = get_post_meta($post_id, 'kc_space_type', true) ?: 'Unknown';
            $log_raw  = get_post_meta($post_id, 'kc_payment_log', true);
            $log      = is_array($log_raw) ? $log_raw : array();
            $collected = array_sum(array_column($log, 'amount'));
            $total_bookings_revenue += $collected;
            $revenue_by_space[$space] = ($revenue_by_space[$space] ?? 0) + $collected;
            $total_bookings_won++;
        }
    }
    arsort($revenue_by_space);
    $bookings_conversion = $bookings_all_count > 0 ? round(($total_bookings_won / $bookings_all_count) * 100, 1) : 0;
    $bookings_pending_action = $bookings_by_status['Pending'] + $bookings_by_status['Contacted'];

    // --- Space Leads: requests, pipeline counts, and conversion per space ---
    $space_leads_posts = get_posts(array(
        'post_type'      => 'kc_space',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'orderby'        => 'menu_order',
        'order'          => 'ASC',
    ));
    $space_leads = array(); // keyed by booking_key
    foreach ($space_leads_posts as $sl_sp) {
        $sl_key   = get_field('kc_space_booking_key', $sl_sp->ID);
        $sl_label = get_field('kc_space_heading', $sl_sp->ID) ?: $sl_sp->post_title;
        if (!$sl_key) continue;
        $space_leads[$sl_key] = array(
            'label'     => $sl_label,
            'total'     => 0,
            'Pending'   => 0,
            'Contacted' => 0,
            'Active'    => 0,
            'Completed' => 0,
            'Rejected'  => 0,
            'Cancelled' => 0,
        );
    }
    // Tally from the already-queried bookings
    foreach ($bookings_all_query->posts as $post_id) {
        $sl_space  = get_post_meta($post_id, 'kc_space_type', true);
        $sl_status = get_post_meta($post_id, 'kc_status', true) ?: 'Pending';
        if (!$sl_space || !isset($space_leads[$sl_space])) continue;
        $space_leads[$sl_space]['total']++;
        if (isset($space_leads[$sl_space][$sl_status])) {
            $space_leads[$sl_space][$sl_status]++;
        }
    }

    // --- Quotes: all statuses for pipeline breakdown ---
    $quote_statuses = array('Pending', 'Contacted', 'Closed', 'Rejected');
    $quotes_by_status = array_fill_keys($quote_statuses, 0);

    $quotes_all_args = array('post_type' => 'kg_quote_lead', 'posts_per_page' => -1, 'fields' => 'ids');
    if (!empty($date_query)) $quotes_all_args['date_query'] = $date_query;
    $quotes_all_query = new WP_Query($quotes_all_args);
    $quotes_all_count = $quotes_all_query->found_posts;

    $total_quotes_revenue = 0;
    $total_quotes_won     = 0;

    foreach ($quotes_all_query->posts as $post_id) {
        $status = get_post_meta($post_id, 'lead_status', true) ?: 'Pending';
        if (isset($quotes_by_status[$status])) $quotes_by_status[$status]++;
        if ($status === 'Closed') {
            $total_quotes_revenue += kc_parse_revenue_val(get_post_meta($post_id, 'total_est', true));
            $total_quotes_won++;
        }
    }
    $quotes_conversion = $quotes_all_count > 0 ? round(($total_quotes_won / $quotes_all_count) * 100, 1) : 0;
    $quotes_pending_action = $quotes_by_status['Pending'] + $quotes_by_status['Contacted'];

    // --- Mailing list snapshot (not date-filtered — always all-time) ---
    $ml_table   = $wpdb->prefix . 'kc_mailing_list';
    $ml_total   = (int) $wpdb->get_var("SELECT COUNT(*) FROM {$ml_table}");
    $ml_active  = (int) $wpdb->get_var("SELECT COUNT(*) FROM {$ml_table} WHERE status = 'active'");
    $ml_pending = (int) $wpdb->get_var("SELECT COUNT(*) FROM {$ml_table} WHERE status = 'pending'");
    $ml_unsub   = (int) $wpdb->get_var("SELECT COUNT(*) FROM {$ml_table} WHERE status = 'unsubscribed'");

    // --- Members snapshot (not date-filtered — always all-time, deduplicated by email) ---
    $mem_all_args = array('post_type' => 'kc_booking', 'posts_per_page' => -1, 'fields' => 'ids');
    $mem_all_ids  = (new WP_Query($mem_all_args))->posts;
    $mem_active   = 0;
    $mem_expiring = 0;
    $mem_expired  = 0;
    $mem_none     = 0;
    $seen_emails  = array();
    $today        = date('Y-m-d');
    $in_30_days   = date('Y-m-d', strtotime('+30 days'));
    foreach ($mem_all_ids as $pid) {
        $email = get_post_meta($pid, 'kc_email', true);
        if ($email && in_array($email, $seen_emails, true)) continue;
        if ($email) $seen_emails[] = $email;
        $ms  = get_post_meta($pid, 'kc_membership_status', true);
        $exp = get_post_meta($pid, 'kc_membership_expiry', true);
        if ($ms === 'Active') {
            $mem_active++;
            if ($exp && $exp >= $today && $exp <= $in_30_days) $mem_expiring++;
        } elseif ($ms === 'Expired') {
            $mem_expired++;
        } else {
            $mem_none++;
        }
    }

    // --- Summary tile values ---
    $total_pending_items = $bookings_pending_action + $quotes_pending_action;

    // --- Analytics: monthly bookings + revenue for last 12 months (always all-time, ignores period filter) ---
    $chart_months       = array();
    $chart_bk_counts    = array();
    $chart_bk_revenue   = array();
    $chart_pass_types   = array('Day Pass' => array(), 'Weekly Pass' => array(), 'Monthly Pass' => array(), 'Annual Pass' => array());

    for ($i = 11; $i >= 0; $i--) {
        $m_ts    = strtotime("-{$i} months");
        $m_label = date('M Y', $m_ts);
        $m_key   = date('Y-m', $m_ts);
        $chart_months[]       = $m_label;
        $chart_bk_counts[$m_key]  = 0;
        $chart_bk_revenue[$m_key] = 0;
        foreach ($chart_pass_types as $pt => $arr) $chart_pass_types[$pt][$m_key] = 0;
    }

    $all_bk_chart = new WP_Query(array(
        'post_type'      => 'kc_booking',
        'posts_per_page' => -1,
        'fields'         => 'ids',
        'date_query'     => array(array('after' => date('Y-m-d', strtotime('-12 months')))),
    ));
    foreach ($all_bk_chart->posts as $pid) {
        $bk_post_date = get_post_field('post_date', $pid);
        $bk_mkey      = substr($bk_post_date, 0, 7);
        if (isset($chart_bk_counts[$bk_mkey])) {
            $chart_bk_counts[$bk_mkey]++;
            $bk_status = get_post_meta($pid, 'kc_status', true);
            if ($bk_status === 'Active' || $bk_status === 'Completed') {
                $bk_log_raw = get_post_meta($pid, 'kc_payment_log', true);
                $bk_log     = is_array($bk_log_raw) ? $bk_log_raw : array();
                $chart_bk_revenue[$bk_mkey] += array_sum(array_column($bk_log, 'amount'));
            }
            $bk_dur = get_post_meta($pid, 'kc_duration', true);
            foreach ($chart_pass_types as $pt => $arr) {
                if ($bk_dur === $pt) $chart_pass_types[$pt][$bk_mkey]++;
            }
        }
    }

    // Donut data: bookings by space (all-time)
    $donut_space_labels = array();
    $donut_space_counts = array();
    foreach ($space_leads as $sl_key => $sl) {
        if ($sl['total'] > 0) {
            $donut_space_labels[] = $sl['label'];
            $donut_space_counts[] = $sl['total'];
        }
    }

    // Donut data: pass type split (all-time, Active+Completed only)
    $donut_pass_labels = array();
    $donut_pass_counts = array();
    $pass_type_totals  = array('Day Pass' => 0, 'Weekly Pass' => 0, 'Monthly Pass' => 0, 'Annual Pass' => 0);
    $all_bk_pass = new WP_Query(array('post_type' => 'kc_booking', 'posts_per_page' => -1, 'fields' => 'ids'));
    foreach ($all_bk_pass->posts as $pid) {
        $dur = get_post_meta($pid, 'kc_duration', true);
        if (isset($pass_type_totals[$dur])) $pass_type_totals[$dur]++;
    }
    foreach ($pass_type_totals as $pt => $cnt) {
        if ($cnt > 0) { $donut_pass_labels[] = $pt; $donut_pass_counts[] = $cnt; }
    }

    // Donut data: pipeline status (all-time)
    $donut_status_labels = array();
    $donut_status_counts = array();
    foreach ($bookings_by_status as $st => $cnt) {
        if ($cnt > 0) { $donut_status_labels[] = $st; $donut_status_counts[] = $cnt; }
    }

    // --- Analytics: quotes monthly (last 12 months) ---
    $chart_qt_counts  = array();
    $chart_qt_revenue = array();
    foreach ($chart_months as $i => $m_label) {
        $m_key = date('Y-m', strtotime('-' . (11 - $i) . ' months'));
        $chart_qt_counts[$m_key]  = 0;
        $chart_qt_revenue[$m_key] = 0;
    }
    $all_qt_chart = new WP_Query(array(
        'post_type'      => 'kg_quote_lead',
        'posts_per_page' => -1,
        'fields'         => 'ids',
        'date_query'     => array(array('after' => date('Y-m-d', strtotime('-12 months')))),
    ));
    foreach ($all_qt_chart->posts as $qid) {
        $qt_mkey = substr(get_post_field('post_date', $qid), 0, 7);
        if (isset($chart_qt_counts[$qt_mkey])) {
            $chart_qt_counts[$qt_mkey]++;
            if (get_post_meta($qid, 'lead_status', true) === 'Closed') {
                $chart_qt_revenue[$qt_mkey] += kc_parse_revenue_val(get_post_meta($qid, 'total_est', true));
            }
        }
    }

    // Donut data: quote pipeline status (all-time)
    $donut_qt_status_labels = array();
    $donut_qt_status_counts = array();
    foreach ($quotes_by_status as $st => $cnt) {
        if ($cnt > 0) { $donut_qt_status_labels[] = $st; $donut_qt_status_counts[] = $cnt; }
    }

    // Pipeline status badge colours
    $status_colors = array(
        'Pending'   => array('#fef9c3', '#854d0e'),
        'Contacted' => array('#dbeafe', '#1e40af'),
        'Active'    => array('#dcfce7', '#166534'),
        'Completed' => array('#d1fae5', '#064e3b'),
        'Closed'    => array('#dcfce7', '#166534'),
        'Rejected'  => array('#fee2e2', '#991b1b'),
        'Cancelled' => array('#f1f5f9', '#475569'),
    );
    ?>
    <style>
        :root {
            --kc-terracotta: #BD451F;
            --kc-deep-red:   #AC201A;
            --kc-gold:       #FBCB77;
            --kc-blush:      #FFBFBF;
            --kc-ivory:      #FFF9EF;
        }
        .kc-kpi-wrap { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif; margin: 20px; background: #f1f5f9; padding-bottom: 48px; display: flex; flex-direction: column; }

        /* Header */
        .kc-kpi-header { background: var(--kc-terracotta); color: #fff; padding: 28px 30px; border-radius: 8px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 4px 12px rgba(0,0,0,0.12); margin-bottom: 24px; order: 1; }
        .kc-kpi-header h1 { color: #fff; margin: 0; font-size: 22px; font-weight: 800; letter-spacing: .5px; }
        .kc-kpi-header p  { margin: 4px 0 0; color: var(--kc-ivory); opacity: .85; font-size: 13px; }
        .kc-kpi-controls  { display: flex; align-items: center; gap: 12px; }
        .kc-kpi-controls input[type="month"] { padding: 5px 10px; border-radius: 4px; border: none; background: rgba(255,255,255,.9); color: #333; font-weight: 700; cursor: pointer; height: 32px; }
        .kc-btn-csv { background: var(--kc-gold); color: #854d0e; border: none; font-weight: 700; padding: 6px 16px; border-radius: 4px; cursor: pointer; text-decoration: none; display: inline-block; line-height: 20px; font-size: 13px; }
        .kc-btn-csv:hover { background: #fde68a; color: #854d0e; }

        /* Summary tiles row */
        .kc-kpi-tiles { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 24px; }
        .kc-tile { background: #fff; border-radius: 8px; padding: 20px 22px; box-shadow: 0 1px 4px rgba(0,0,0,.07); border-top: 4px solid transparent; }
        .kc-tile--revenue  { border-top-color: var(--kc-deep-red); }
        .kc-tile--audience { border-top-color: var(--kc-gold); }
        .kc-tile--action   { border-top-color: #f59e0b; }
        .kc-tile--rate     { border-top-color: #10b981; }
        .kc-tile__label { font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: .5px; color: #64748b; margin-bottom: 8px; }
        .kc-tile__value { font-size: 28px; font-weight: 800; color: #1e293b; line-height: 1; }
        .kc-tile__sub   { font-size: 12px; color: #94a3b8; margin-top: 6px; }
        .kc-tile--revenue  .kc-tile__value { color: var(--kc-deep-red); }
        .kc-tile--audience .kc-tile__value { color: #b45309; }
        .kc-tile--action   .kc-tile__value { color: #d97706; }
        .kc-tile--rate     .kc-tile__value { color: #059669; }

        /* Two-col grid */
        .kc-kpi-grid  { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .kc-kpi-full  { grid-column: 1 / -1; }

        /* Cards */
        .kc-kpi-card { background: #fff; border-radius: 8px; padding: 24px; box-shadow: 0 1px 4px rgba(0,0,0,.07); }
        .kc-card-title { font-size: 13px; font-weight: 800; text-transform: uppercase; letter-spacing: .5px; padding-bottom: 10px; margin-bottom: 18px; border-bottom: 2px solid #f1f5f9; }
        .kc-card-title--bookings { color: var(--kc-deep-red);  border-bottom-color: var(--kc-blush); }
        .kc-card-title--quotes   { color: #b45309;             border-bottom-color: var(--kc-gold);  }
        .kc-card-title--funnel   { color: var(--kc-terracotta);}
        .kc-card-title--spaces   { color: var(--kc-terracotta);}
        .kc-card-title--mail     { color: #0369a1; border-bottom-color: #bae6fd; }

        /* Stat rows */
        .kc-stat-row { display: flex; justify-content: space-between; align-items: center; padding: 9px 0; border-bottom: 1px solid #f8fafc; }
        .kc-stat-row:last-child { border-bottom: none; }
        .kc-stat-label { color: #64748b; font-size: 13px; font-weight: 500; }
        .kc-stat-value { font-weight: 700; font-size: 17px; color: #1e293b; }
        .kc-stat-revenue { font-size: 30px; font-weight: 800; }
        .kc-revenue-bookings { color: var(--kc-deep-red); }
        .kc-revenue-quotes   { color: #b45309; }

        /* Pipeline status badges */
        .kc-pipeline { display: flex; flex-wrap: wrap; gap: 10px; margin-top: 16px; }
        .kc-pipeline-badge { display: flex; flex-direction: column; align-items: center; padding: 10px 16px; border-radius: 6px; min-width: 72px; }
        .kc-pipeline-badge__count { font-size: 22px; font-weight: 800; line-height: 1; }
        .kc-pipeline-badge__label { font-size: 11px; font-weight: 600; margin-top: 4px; text-transform: uppercase; letter-spacing: .3px; }

        /* Funnel bars */
        .kc-bar-wrap  { margin-bottom: 20px; }
        .kc-bar-wrap:last-child { margin-bottom: 0; }
        .kc-bar-header { display: flex; justify-content: space-between; font-size: 13px; font-weight: 600; color: #475569; margin-bottom: 6px; }
        .kc-bar-track  { background: #e2e8f0; height: 12px; border-radius: 6px; overflow: hidden; }
        .kc-bar-fill-b { background: var(--kc-deep-red); height: 100%; border-radius: 6px; transition: width .6s ease; }
        .kc-bar-fill-q { background: var(--kc-gold);     height: 100%; border-radius: 6px; transition: width .6s ease; }

        /* Space bars */
        .kc-space-row  { display: flex; align-items: center; margin-bottom: 12px; font-size: 13px; }
        .kc-space-name { width: 160px; font-weight: 600; color: #334155; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .kc-space-bar  { flex: 1; background: #f1f5f9; height: 10px; border-radius: 5px; margin: 0 14px; overflow: hidden; }
        .kc-space-bar-fill { background: var(--kc-terracotta); height: 100%; border-radius: 5px; }
        .kc-space-val  { width: 90px; text-align: right; font-weight: 700; color: #475569; }

        /* Mailing list tiles */
        .kc-ml-tiles { display: grid; grid-template-columns: repeat(4,1fr); gap: 12px; }
        .kc-ml-tile  { border-radius: 6px; padding: 16px; text-align: center; }
        .kc-ml-tile__num { font-size: 30px; font-weight: 800; line-height: 1; }
        .kc-ml-tile__lbl { font-size: 11px; text-transform: uppercase; letter-spacing: .4px; color: #64748b; margin-top: 5px; font-weight: 600; }
        .kc-ml-tile--total   { background: #e0f2fe; } .kc-ml-tile--total   .kc-ml-tile__num { color: #0369a1; }
        .kc-ml-tile--active  { background: #dcfce7; } .kc-ml-tile--active  .kc-ml-tile__num { color: #166534; }
        .kc-ml-tile--pending { background: #fef9c3; } .kc-ml-tile--pending .kc-ml-tile__num { color: #854d0e; }
        .kc-ml-tile--unsub   { background: #fee2e2; } .kc-ml-tile--unsub   .kc-ml-tile__num { color: #991b1b; }

        /* Members tiles */
        .kc-card-title--members { color: #b45309; border-bottom-color: #fde68a; }
        .kc-mem-tiles { display: grid; grid-template-columns: repeat(4,1fr); gap: 12px; }
        .kc-mem-tile  { border-radius: 6px; padding: 16px; text-align: center; }
        .kc-mem-tile__num { font-size: 30px; font-weight: 800; line-height: 1; }
        .kc-mem-tile__lbl { font-size: 11px; text-transform: uppercase; letter-spacing: .4px; color: #64748b; margin-top: 5px; font-weight: 600; }
        .kc-mem-tile--active   { background: #dcfce7; } .kc-mem-tile--active   .kc-mem-tile__num { color: #166534; }
        .kc-mem-tile--expiring { background: #fef9c3; } .kc-mem-tile--expiring .kc-mem-tile__num { color: #854d0e; }
        .kc-mem-tile--expired  { background: #fee2e2; } .kc-mem-tile--expired  .kc-mem-tile__num { color: #991b1b; }
        .kc-mem-tile--none     { background: #f1f5f9; } .kc-mem-tile--none     .kc-mem-tile__num { color: #475569; }

        .kc-section-divider { grid-column: 1/-1; border: none; border-top: 1px solid #e2e8f0; margin: 4px 0; }

        /* Sticky header on scrollable overview tables */
        .kc-kpi-card div[style*="max-height"] .kc-records-table thead th { position: sticky; top: 0; z-index: 2; background: var(--kc-terracotta); }
    </style>

    <div class="wrap kc-kpi-wrap">

        <!-- Header -->
        <div class="kc-kpi-header">
            <div>
                <h1>Kings City KPI Dashboard</h1>
                <p>Live performance metrics — <?php echo esc_html($display_period); ?></p>
            </div>
            <div class="kc-kpi-controls">
                <form method="GET" action="admin.php" style="margin:0;display:flex;align-items:center;gap:10px;">
                    <input type="hidden" name="page" value="kc-kpi-dashboard">
                    <span style="color:var(--kc-ivory);font-size:13px;">Reporting Period:</span>
                    <input type="month" name="kpi_month" value="<?php echo esc_attr($selected_month); ?>" onchange="this.form.submit()">
                </form>
                <a href="<?php echo esc_url(wp_nonce_url(admin_url('admin-post.php?action=kc_export_kpi_csv&kpi_month=' . rawurlencode($selected_month)), 'kc_export_kpi_csv')); ?>" class="kc-btn-csv">&#8595; Export CSV</a>
            </div>
        </div>

        <!-- Overview Tab Panel -->
        <div id="kc-tab-overview" class="kc-tab-panel kc-tab-panel-active" style="background:transparent;border:none;box-shadow:none;padding:0;">

        <!-- Row 1: Summary Tiles -->
        <div class="kc-kpi-tiles">
            <div class="kc-tile kc-tile--revenue">
                <div class="kc-tile__label">Bookings Revenue Collected</div>
                <div class="kc-tile__value">Php <?php echo number_format($total_bookings_revenue, 2); ?></div>
                <div class="kc-tile__sub">Cash received from space bookings</div>
            </div>
            <div class="kc-tile kc-tile--audience" style="border-top-color:#b45309;">
                <div class="kc-tile__label">Team Builder Est. Revenue</div>
                <div class="kc-tile__value" style="color:#b45309;">Php <?php echo number_format($total_quotes_revenue, 2); ?>/mo</div>
                <div class="kc-tile__sub">From closed quote leads</div>
            </div>
            <div class="kc-tile kc-tile--action">
                <div class="kc-tile__label">Needs Action</div>
                <div class="kc-tile__value"><?php echo esc_html($total_pending_items); ?></div>
                <div class="kc-tile__sub"><?php echo esc_html($bookings_pending_action); ?> bookings · <?php echo esc_html($quotes_pending_action); ?> quotes</div>
            </div>
            <div class="kc-tile kc-tile--audience">
                <div class="kc-tile__label">Active Subscribers</div>
                <div class="kc-tile__value"><?php echo esc_html($ml_active); ?></div>
                <div class="kc-tile__sub"><?php echo esc_html($ml_total); ?> total on mailing list</div>
            </div>
        </div>

        <!-- Client Overview: Bookings + Quotes side-by-side -->
        <div class="kc-kpi-grid" style="margin-bottom:20px;">

            <!-- Booking Clients -->
            <div class="kc-kpi-card" style="padding-bottom:16px;">
                <div class="kc-card-title kc-card-title--bookings">Booking Clients</div>
                <div style="overflow-x:auto;max-height:340px;overflow-y:auto;">
                    <table class="kc-records-table">
                        <thead><tr>
                            <th>Client</th><th>Space</th><th>Duration</th><th>Date</th><th>Paid / Balance</th><th>Status</th>
                        </tr></thead>
                        <tbody>
                        <?php
                        $ov_bk_ids = $bookings_all_query->posts;
                        if (!empty($ov_bk_ids)):
                            foreach ($ov_bk_ids as $pid):
                                $ov_fname   = get_post_meta($pid, 'kc_first_name', true);
                                $ov_lname   = get_post_meta($pid, 'kc_last_name',  true);
                                $ov_bname   = trim($ov_fname . ' ' . $ov_lname) ?: '(no name)';
                                $ov_space   = get_post_meta($pid, 'kc_space_type', true) ?: '—';
                                $ov_dur     = get_post_meta($pid, 'kc_duration',   true) ?: '—';
                                $ov_date    = get_post_meta($pid, 'kc_start_date', true) ?: '—';
                                $ov_status  = get_post_meta($pid, 'kc_status',     true) ?: 'Pending';
                                $ov_price   = (float) get_post_meta($pid, 'kc_price', true);
                                $ov_log     = get_post_meta($pid, 'kc_payment_log', true);
                                $ov_log     = is_array($ov_log) ? $ov_log : array();
                                $ov_paid    = array_sum(array_column($ov_log, 'amount'));
                                $ov_balance = max(0, $ov_price - $ov_paid);
                                $ov_col     = $status_colors[$ov_status] ?? array('#f1f5f9', '#475569');
                        ?>
                        <tr>
                            <td><a href="<?php echo esc_url(get_edit_post_link($pid)); ?>" style="color:var(--kc-terracotta);font-weight:700;"><?php echo esc_html($ov_bname); ?></a></td>
                            <td><?php echo esc_html($ov_space); ?></td>
                            <td><?php echo esc_html($ov_dur); ?></td>
                            <td><?php echo esc_html($ov_date); ?></td>
                            <td>
                                <?php if ($ov_paid > 0): ?>
                                    <span style="color:#166534;font-weight:700;">Php <?php echo number_format($ov_paid, 2); ?></span>
                                    <?php if ($ov_balance > 0): ?>
                                    <div style="font-size:10px;color:#d97706;font-weight:600;margin-top:2px;">Balance: Php <?php echo number_format($ov_balance, 2); ?></div>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <span style="color:#94a3b8;">—</span>
                                <?php endif; ?>
                            </td>
                            <td><span class="kc-badge" style="background:<?php echo esc_attr($ov_col[0]); ?>;color:<?php echo esc_attr($ov_col[1]); ?>;"><?php echo esc_html($ov_status); ?></span></td>
                        </tr>
                        <?php endforeach; else: ?>
                        <tr><td colspan="6" class="kc-no-results">No bookings for this period.</td></tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Quote Request Clients -->
            <div class="kc-kpi-card" style="padding-bottom:16px;">
                <div class="kc-card-title kc-card-title--quotes">Quote Request Clients</div>
                <div style="overflow-x:auto;max-height:340px;overflow-y:auto;">
                    <table class="kc-records-table">
                        <thead><tr>
                            <th>Client</th><th>Team Roles</th><th>Est. Total</th><th>Date</th><th>Status</th>
                        </tr></thead>
                        <tbody>
                        <?php
                        $ov_qt_ids = $quotes_all_query->posts;
                        if (!empty($ov_qt_ids)):
                            foreach ($ov_qt_ids as $qid):
                                $ov_qfn      = get_post_meta($qid, 'first_name', true);
                                $ov_qln      = get_post_meta($qid, 'last_name',  true);
                                $ov_qname    = trim($ov_qfn . ' ' . $ov_qln) ?: '(no name)';
                                $ov_team_raw = get_post_meta($qid, 'team_json', true);
                                $ov_team     = ($ov_team_raw) ? json_decode($ov_team_raw, true) : array();
                                $ov_tcount   = is_array($ov_team) ? count($ov_team) : 0;
                                $ov_total    = get_post_meta($qid, 'total_est',    true);
                                $ov_cur      = get_post_meta($qid, 'currency_used', true) ?: 'PHP';
                                $ov_qstatus  = get_post_meta($qid, 'lead_status',  true) ?: 'Pending';
                                $ov_qdate    = get_the_date('Y-m-d', $qid);
                                $ov_qcol     = $status_colors[$ov_qstatus] ?? array('#f1f5f9', '#475569');
                        ?>
                        <tr>
                            <td><a href="<?php echo esc_url(get_edit_post_link($qid)); ?>" style="color:#b45309;font-weight:700;"><?php echo esc_html($ov_qname); ?></a></td>
                            <td><?php echo $ov_tcount > 0 ? esc_html($ov_tcount) . ' role' . ($ov_tcount !== 1 ? 's' : '') : '—'; ?></td>
                            <td><?php echo $ov_total ? esc_html($ov_cur) . ' ' . esc_html($ov_total) : '—'; ?></td>
                            <td><?php echo esc_html($ov_qdate); ?></td>
                            <td><span class="kc-badge" style="background:<?php echo esc_attr($ov_qcol[0]); ?>;color:<?php echo esc_attr($ov_qcol[1]); ?>;"><?php echo esc_html($ov_qstatus); ?></span></td>
                        </tr>
                        <?php endforeach; else: ?>
                        <tr><td colspan="5" class="kc-no-results">No quote requests for this period.</td></tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div><!-- /.client overview grid -->

        <!-- Row 2: Mailing List + Members side-by-side -->
        <div class="kc-kpi-grid" style="margin-bottom:20px;">

            <!-- Mailing List Snapshot -->
            <div class="kc-kpi-card">
                <div class="kc-card-title kc-card-title--mail">
                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:-1px;margin-right:5px;"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>Mailing List — All-Time Audience
                </div>
                <div class="kc-ml-tiles">
                    <div class="kc-ml-tile kc-ml-tile--total">
                        <div class="kc-ml-tile__num"><?php echo esc_html($ml_total); ?></div>
                        <div class="kc-ml-tile__lbl">Total</div>
                    </div>
                    <div class="kc-ml-tile kc-ml-tile--active">
                        <div class="kc-ml-tile__num"><?php echo esc_html($ml_active); ?></div>
                        <div class="kc-ml-tile__lbl">Active</div>
                    </div>
                    <div class="kc-ml-tile kc-ml-tile--pending">
                        <div class="kc-ml-tile__num"><?php echo esc_html($ml_pending); ?></div>
                        <div class="kc-ml-tile__lbl">Pending</div>
                    </div>
                    <div class="kc-ml-tile kc-ml-tile--unsub">
                        <div class="kc-ml-tile__num"><?php echo esc_html($ml_unsub); ?></div>
                        <div class="kc-ml-tile__lbl">Unsubscribed</div>
                    </div>
                </div>
            </div>

            <!-- Members Snapshot -->
            <div class="kc-kpi-card">
                <div class="kc-card-title kc-card-title--members">
                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:-1px;margin-right:5px;"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>Members — All-Time Status
                </div>
                <div class="kc-mem-tiles">
                    <div class="kc-mem-tile kc-mem-tile--active">
                        <div class="kc-mem-tile__num"><?php echo esc_html($mem_active); ?></div>
                        <div class="kc-mem-tile__lbl">Active Members</div>
                    </div>
                    <div class="kc-mem-tile kc-mem-tile--expiring">
                        <div class="kc-mem-tile__num"><?php echo esc_html($mem_expiring); ?></div>
                        <div class="kc-mem-tile__lbl">Expiring in 30 Days</div>
                    </div>
                    <div class="kc-mem-tile kc-mem-tile--expired">
                        <div class="kc-mem-tile__num"><?php echo esc_html($mem_expired); ?></div>
                        <div class="kc-mem-tile__lbl">Expired</div>
                    </div>
                    <div class="kc-mem-tile kc-mem-tile--none">
                        <div class="kc-mem-tile__num"><?php echo esc_html($mem_none); ?></div>
                        <div class="kc-mem-tile__lbl">No Membership</div>
                    </div>
                </div>
                <?php if ($mem_expiring > 0): ?>
                <p style="margin:14px 0 0; font-size:12px; color:#854d0e; background:#fef9c3; padding:8px 12px; border-radius:4px; font-weight:600;">
                    &#9888; <?php echo esc_html($mem_expiring); ?> member<?php echo $mem_expiring > 1 ? 's' : ''; ?> expiring within 30 days.
                </p>
                <?php endif; ?>
            </div>

        </div>

        <!-- Row 3+: Pipeline cards, Funnel, Revenue by Space -->
        <div class="kc-kpi-grid">

            <!-- Bookings Pipeline -->
            <div class="kc-kpi-card">
                <div class="kc-card-title kc-card-title--bookings">Bookings — Spaces</div>
                <div class="kc-stat-row">
                    <span class="kc-stat-label">Total Requests</span>
                    <span class="kc-stat-value"><?php echo esc_html($bookings_all_count); ?></span>
                </div>
                <div class="kc-stat-row">
                    <span class="kc-stat-label">Active &amp; Completed</span>
                    <span class="kc-stat-value"><?php echo esc_html($total_bookings_won); ?></span>
                </div>
                <div class="kc-stat-row" style="margin-top:14px;padding-top:14px;border-top:2px dashed #f1f5f9;">
                    <span class="kc-stat-label">Total Revenue</span>
                    <span class="kc-stat-revenue kc-revenue-bookings">Php <?php echo number_format($total_bookings_revenue, 2); ?></span>
                </div>
                <!-- Pipeline breakdown -->
                <div class="kc-pipeline">
                    <?php foreach ($bookings_by_status as $st => $cnt):
                        $col = $status_colors[$st] ?? array('#f1f5f9','#475569'); ?>
                        <div class="kc-pipeline-badge" style="background:<?php echo esc_attr($col[0]); ?>;">
                            <span class="kc-pipeline-badge__count" style="color:<?php echo esc_attr($col[1]); ?>;"><?php echo esc_html($cnt); ?></span>
                            <span class="kc-pipeline-badge__label" style="color:<?php echo esc_attr($col[1]); ?>;"><?php echo esc_html($st); ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Quotes Pipeline -->
            <div class="kc-kpi-card">
                <div class="kc-card-title kc-card-title--quotes">Quote Leads — Team Builder</div>
                <div class="kc-stat-row">
                    <span class="kc-stat-label">Total Requests</span>
                    <span class="kc-stat-value"><?php echo esc_html($quotes_all_count); ?></span>
                </div>
                <div class="kc-stat-row">
                    <span class="kc-stat-label">Successful (Closed)</span>
                    <span class="kc-stat-value"><?php echo esc_html($total_quotes_won); ?></span>
                </div>
                <div class="kc-stat-row" style="margin-top:14px;padding-top:14px;border-top:2px dashed #f1f5f9;">
                    <span class="kc-stat-label">Est. Recurring Revenue</span>
                    <span class="kc-stat-revenue kc-revenue-quotes">Php <?php echo number_format($total_quotes_revenue, 2); ?>/mo</span>
                </div>
                <!-- Pipeline breakdown -->
                <div class="kc-pipeline">
                    <?php foreach ($quotes_by_status as $st => $cnt):
                        $col = $status_colors[$st] ?? array('#f1f5f9','#475569'); ?>
                        <div class="kc-pipeline-badge" style="background:<?php echo esc_attr($col[0]); ?>;">
                            <span class="kc-pipeline-badge__count" style="color:<?php echo esc_attr($col[1]); ?>;"><?php echo esc_html($cnt); ?></span>
                            <span class="kc-pipeline-badge__label" style="color:<?php echo esc_attr($col[1]); ?>;"><?php echo esc_html($st); ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Conversion Funnel -->
            <div class="kc-kpi-card kc-kpi-full">
                <div class="kc-card-title kc-card-title--funnel">Conversion Rates</div>
                <p style="font-size:12px;color:#64748b;margin:0 0 18px;">How many inquiries turned into confirmed bookings or closed deals.</p>

                <div class="kc-bar-wrap">
                    <div class="kc-bar-header">
                        <span>
                            Space Bookings
                            <span style="font-size:11px;font-weight:400;color:#94a3b8;margin-left:8px;"><?php echo esc_html($total_bookings_won); ?> Active/Completed out of <?php echo esc_html($bookings_all_count); ?> total requests</span>
                        </span>
                        <span><?php echo number_format($bookings_conversion, 1); ?>%</span>
                    </div>
                    <div class="kc-bar-track"><div class="kc-bar-fill-b" style="width:<?php echo esc_attr(min($bookings_conversion,100)); ?>%;"></div></div>
                </div>

                <div class="kc-bar-wrap">
                    <div class="kc-bar-header">
                        <span>
                            Team Builder Quotes
                            <span style="font-size:11px;font-weight:400;color:#94a3b8;margin-left:8px;"><?php echo esc_html($total_quotes_won); ?> Closed out of <?php echo esc_html($quotes_all_count); ?> total requests</span>
                        </span>
                        <span><?php echo number_format($quotes_conversion, 1); ?>%</span>
                    </div>
                    <div class="kc-bar-track"><div class="kc-bar-fill-q" style="width:<?php echo esc_attr(min($quotes_conversion,100)); ?>%;"></div></div>
                </div>
            </div>


        </div><!-- /.kc-kpi-grid -->

        <!-- Space Leads Overview (bottom) -->
        <div class="kc-kpi-card kc-kpi-full" style="margin-top:20px;">
            <div class="kc-card-title kc-card-title--spaces">Space Leads — Requests &amp; Conversion per Space</div>
            <p style="font-size:12px;color:#64748b;margin:0 0 16px;">How many inquiries each space received and how many turned into confirmed (Active or Completed) bookings.</p>
            <?php if (empty($space_leads)): ?>
                <p style="color:#94a3b8;font-style:italic;font-size:13px;">No spaces found.</p>
            <?php else: ?>
            <div style="overflow-x:auto;">
            <table style="width:100%;border-collapse:collapse;font-size:13px;">
                <thead>
                    <tr style="background:var(--kc-terracotta);">
                        <th style="color:#fff;font-size:11px;text-transform:uppercase;letter-spacing:.4px;padding:10px 14px;text-align:left;font-weight:700;white-space:nowrap;">Space</th>
                        <th style="color:#fff;font-size:11px;text-transform:uppercase;letter-spacing:.4px;padding:10px 10px;text-align:center;font-weight:700;">Total Requests</th>
                        <th style="color:#fff;font-size:11px;text-transform:uppercase;letter-spacing:.4px;padding:10px 10px;text-align:center;font-weight:700;">Pending</th>
                        <th style="color:#fff;font-size:11px;text-transform:uppercase;letter-spacing:.4px;padding:10px 10px;text-align:center;font-weight:700;">Contacted</th>
                        <th style="color:#fff;font-size:11px;text-transform:uppercase;letter-spacing:.4px;padding:10px 10px;text-align:center;font-weight:700;">Active</th>
                        <th style="color:#fff;font-size:11px;text-transform:uppercase;letter-spacing:.4px;padding:10px 10px;text-align:center;font-weight:700;">Completed</th>
                        <th style="color:#fff;font-size:11px;text-transform:uppercase;letter-spacing:.4px;padding:10px 10px;text-align:center;font-weight:700;">Rejected</th>
                        <th style="color:#fff;font-size:11px;text-transform:uppercase;letter-spacing:.4px;padding:10px 10px;text-align:center;font-weight:700;">Cancelled</th>
                        <th style="color:#fff;font-size:11px;text-transform:uppercase;letter-spacing:.4px;padding:10px 10px;text-align:center;font-weight:700;">Revenue Collected</th>
                        <th style="color:#fff;font-size:11px;text-transform:uppercase;letter-spacing:.4px;padding:10px 14px;text-align:center;font-weight:700;">Conversion</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $sl_grand_total = 0;
                $sl_grand_won   = 0;
                $sl_grand_rev   = 0;
                $sl_grand_cols  = array('Pending' => 0, 'Contacted' => 0, 'Active' => 0, 'Completed' => 0, 'Rejected' => 0, 'Cancelled' => 0);
                foreach ($space_leads as $sl_key => $sl):
                    $sl_won  = $sl['Active'] + $sl['Completed'];
                    $sl_conv = $sl['total'] > 0 ? round(($sl_won / $sl['total']) * 100, 1) : 0;
                    $sl_rev  = $revenue_by_space[$sl_key] ?? 0;
                    $sl_grand_total += $sl['total'];
                    $sl_grand_won   += $sl_won;
                    $sl_grand_rev   += $sl_rev;
                    foreach ($sl_grand_cols as $k => $v) $sl_grand_cols[$k] += $sl[$k];
                    $sl_conv_color = $sl_conv >= 70 ? '#166534' : ($sl_conv >= 40 ? '#854d0e' : '#991b1b');
                    $sl_conv_bg    = $sl['total'] === 0 ? '#f1f5f9' : ($sl_conv >= 70 ? '#dcfce7' : ($sl_conv >= 40 ? '#fef9c3' : '#fee2e2'));
                ?>
                <tr style="border-bottom:1px solid #f1f5f9;">
                    <td style="padding:10px 14px;font-weight:700;color:#334155;"><?php echo esc_html($sl['label']); ?></td>
                    <td style="padding:10px 10px;text-align:center;font-weight:800;color:#1e293b;"><?php echo esc_html($sl['total']); ?></td>
                    <td style="padding:10px 10px;text-align:center;<?php echo $sl['Pending']   > 0 ? 'color:#854d0e;font-weight:700;' : 'color:#cbd5e1;'; ?>"><?php echo $sl['Pending']   ?: '—'; ?></td>
                    <td style="padding:10px 10px;text-align:center;<?php echo $sl['Contacted'] > 0 ? 'color:#1e40af;font-weight:700;' : 'color:#cbd5e1;'; ?>"><?php echo $sl['Contacted'] ?: '—'; ?></td>
                    <td style="padding:10px 10px;text-align:center;<?php echo $sl['Active']    > 0 ? 'color:#166534;font-weight:700;' : 'color:#cbd5e1;'; ?>"><?php echo $sl['Active']    ?: '—'; ?></td>
                    <td style="padding:10px 10px;text-align:center;<?php echo $sl['Completed'] > 0 ? 'color:#064e3b;font-weight:700;' : 'color:#cbd5e1;'; ?>"><?php echo $sl['Completed'] ?: '—'; ?></td>
                    <td style="padding:10px 10px;text-align:center;<?php echo $sl['Rejected']  > 0 ? 'color:#991b1b;font-weight:700;' : 'color:#cbd5e1;'; ?>"><?php echo $sl['Rejected']  ?: '—'; ?></td>
                    <td style="padding:10px 10px;text-align:center;<?php echo $sl['Cancelled'] > 0 ? 'color:#475569;font-weight:700;' : 'color:#cbd5e1;'; ?>"><?php echo $sl['Cancelled'] ?: '—'; ?></td>
                    <td style="padding:10px 10px;text-align:center;font-weight:700;<?php echo $sl_rev > 0 ? 'color:#166534;' : 'color:#cbd5e1;'; ?>">
                        <?php echo $sl_rev > 0 ? 'Php ' . number_format($sl_rev, 2) : '—'; ?>
                    </td>
                    <td style="padding:10px 14px;text-align:center;">
                        <?php if ($sl['total'] > 0): ?>
                        <span style="display:inline-block;padding:3px 12px;border-radius:20px;font-size:12px;font-weight:800;background:<?php echo esc_attr($sl_conv_bg); ?>;color:<?php echo esc_attr($sl_conv_color); ?>;">
                            <?php echo esc_html($sl_conv); ?>%
                        </span>
                        <?php else: ?>
                        <span style="color:#cbd5e1;font-size:12px;">—</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach;
                $sl_grand_conv = $sl_grand_total > 0 ? round(($sl_grand_won / $sl_grand_total) * 100, 1) : 0;
                ?>
                <tr style="background:rgba(189,69,31,0.05);border-top:2px solid rgba(189,69,31,0.2);">
                    <td style="padding:10px 14px;font-weight:800;color:var(--kc-deep-red);text-transform:uppercase;font-size:11px;letter-spacing:.4px;">All Spaces</td>
                    <td style="padding:10px 10px;text-align:center;font-weight:800;color:var(--kc-deep-red);"><?php echo esc_html($sl_grand_total); ?></td>
                    <?php foreach ($sl_grand_cols as $k => $v): ?>
                    <td style="padding:10px 10px;text-align:center;font-weight:700;color:var(--kc-deep-red);"><?php echo $v ?: '—'; ?></td>
                    <?php endforeach; ?>
                    <td style="padding:10px 10px;text-align:center;font-weight:800;color:var(--kc-deep-red);">
                        <?php echo $sl_grand_rev > 0 ? 'Php ' . number_format($sl_grand_rev, 2) : '—'; ?>
                    </td>
                    <td style="padding:10px 14px;text-align:center;">
                        <?php if ($sl_grand_total > 0): ?>
                        <span style="display:inline-block;padding:3px 12px;border-radius:20px;font-size:12px;font-weight:800;background:rgba(189,69,31,0.1);color:var(--kc-deep-red);">
                            <?php echo esc_html($sl_grand_conv); ?>%
                        </span>
                        <?php else: ?>
                        <span style="color:#cbd5e1;font-size:12px;">—</span>
                        <?php endif; ?>
                    </td>
                </tr>
                </tbody>
            </table>
            </div>
            <?php endif; ?>
        </div>

        <!-- Analytics Charts -->
        <?php
        $c_months      = wp_json_encode(array_values($chart_months));
        $c_bk_counts   = wp_json_encode(array_values($chart_bk_counts));
        $c_bk_revenue  = wp_json_encode(array_values($chart_bk_revenue));
        $c_pass_series = array();
        foreach ($chart_pass_types as $pt => $arr) {
            $c_pass_series[$pt] = array_values($arr);
        }
        $c_pass_json = wp_json_encode($c_pass_series);
        ?>
        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
        <style>
            .kc-charts-section { margin-top: 20px; }
            .kc-charts-row     { display: grid; gap: 20px; margin-bottom: 20px; }
            .kc-charts-row--2  { grid-template-columns: 1fr 1fr; }
            .kc-charts-row--3  { grid-template-columns: 1fr 1fr 1fr; }
            .kc-chart-card     { background: #fff; border-radius: 8px; padding: 22px 24px; box-shadow: 0 1px 4px rgba(0,0,0,.07); }
            .kc-chart-title    { font-size: 12px; font-weight: 800; text-transform: uppercase; letter-spacing: .5px; color: var(--kc-deep-red); margin-bottom: 4px; }
            .kc-chart-sub      { font-size: 11px; color: #94a3b8; margin-bottom: 16px; }
            .kc-chart-canvas   { width: 100% !important; }
        </style>

        <div class="kc-charts-section">

            <!-- Row 1: 2x2 — Bookings bar charts top, Quote bar charts bottom -->
            <div class="kc-charts-row kc-charts-row--2">
                <div class="kc-chart-card">
                    <div class="kc-chart-title">Space Bookings per Month</div>
                    <div class="kc-chart-sub">Total space booking requests — last 12 months</div>
                    <canvas id="kc-chart-bk-monthly" class="kc-chart-canvas" height="220"></canvas>
                </div>
                <div class="kc-chart-card">
                    <div class="kc-chart-title">Bookings Revenue Collected per Month</div>
                    <div class="kc-chart-sub">Cash received from Active &amp; Completed bookings — last 12 months</div>
                    <canvas id="kc-chart-rev-monthly" class="kc-chart-canvas" height="220"></canvas>
                </div>
                <div class="kc-chart-card">
                    <div class="kc-chart-title">Quote Requests per Month</div>
                    <div class="kc-chart-sub">Team Builder enquiries submitted — last 12 months</div>
                    <canvas id="kc-chart-qt-monthly" class="kc-chart-canvas" height="220"></canvas>
                </div>
                <div class="kc-chart-card">
                    <div class="kc-chart-title">Quote Est. Revenue per Month</div>
                    <div class="kc-chart-sub">Est. recurring revenue from Closed quotes — last 12 months</div>
                    <canvas id="kc-chart-qt-rev-monthly" class="kc-chart-canvas" height="220"></canvas>
                </div>
            </div>

            <!-- Row 2: Stacked bar — pass type per month -->
            <div class="kc-charts-row" style="grid-template-columns:1fr;">
                <div class="kc-chart-card">
                    <div class="kc-chart-title">Bookings by Pass Type per Month</div>
                    <div class="kc-chart-sub">Day / Weekly / Monthly / Annual split — last 12 months</div>
                    <canvas id="kc-chart-pass-monthly" class="kc-chart-canvas" height="160"></canvas>
                </div>
            </div>

            <!-- Row 3: Four donuts -->
            <div class="kc-charts-row kc-charts-row--2" style="grid-template-columns:repeat(4,1fr);">
                <div class="kc-chart-card">
                    <div class="kc-chart-title">Bookings by Space</div>
                    <div class="kc-chart-sub">All-time requests per space</div>
                    <canvas id="kc-chart-donut-space" class="kc-chart-canvas" height="220"></canvas>
                </div>
                <div class="kc-chart-card">
                    <div class="kc-chart-title">Bookings by Pass Type</div>
                    <div class="kc-chart-sub">All-time pass type breakdown</div>
                    <canvas id="kc-chart-donut-pass" class="kc-chart-canvas" height="220"></canvas>
                </div>
                <div class="kc-chart-card">
                    <div class="kc-chart-title">Booking Pipeline</div>
                    <div class="kc-chart-sub">All-time booking status split</div>
                    <canvas id="kc-chart-donut-status" class="kc-chart-canvas" height="220"></canvas>
                </div>
                <div class="kc-chart-card">
                    <div class="kc-chart-title">Quote Pipeline</div>
                    <div class="kc-chart-sub">All-time quote lead status split</div>
                    <canvas id="kc-chart-donut-qt-status" class="kc-chart-canvas" height="220"></canvas>
                </div>
            </div>

        </div><!-- /.kc-charts-section -->

        <script>
        (function() {
            var MONTHS      = <?php echo $c_months; ?>;
            var BK_CNT      = <?php echo $c_bk_counts; ?>;
            var BK_REV      = <?php echo $c_bk_revenue; ?>;
            var PASS_SER    = <?php echo $c_pass_json; ?>;
            var QT_CNT      = <?php echo wp_json_encode(array_values($chart_qt_counts)); ?>;
            var QT_REV      = <?php echo wp_json_encode(array_values($chart_qt_revenue)); ?>;

            var TERRACOTTA = '#BD451F';
            var DEEP_RED   = '#AC201A';
            var GOLD       = '#FBCB77';
            var TEAL       = '#0369a1';
            var TEAL_DARK  = '#075985';

            var DONUT_SPACE_LABELS     = <?php echo wp_json_encode($donut_space_labels); ?>;
            var DONUT_SPACE_COUNTS     = <?php echo wp_json_encode($donut_space_counts); ?>;
            var DONUT_PASS_LABELS      = <?php echo wp_json_encode($donut_pass_labels); ?>;
            var DONUT_PASS_COUNTS      = <?php echo wp_json_encode($donut_pass_counts); ?>;
            var DONUT_STATUS_LABELS    = <?php echo wp_json_encode($donut_status_labels); ?>;
            var DONUT_STATUS_COUNTS    = <?php echo wp_json_encode($donut_status_counts); ?>;
            var DONUT_QT_STATUS_LABELS = <?php echo wp_json_encode($donut_qt_status_labels); ?>;
            var DONUT_QT_STATUS_COUNTS = <?php echo wp_json_encode($donut_qt_status_counts); ?>;

            var PALETTE    = ['#BD451F','#AC201A','#FBCB77','#FFBFBF','#94a3b8','#475569','#1e40af','#166534'];
            var QT_PALETTE = ['#0369a1','#075985','#bae6fd','#94a3b8'];

            var baseOpts = {
                responsive: true,
                plugins: { legend: { display: false }, tooltip: { callbacks: {} } },
                scales: {
                    x: { grid: { display: false }, ticks: { font: { size: 10 }, color: '#94a3b8' } },
                    y: { grid: { color: '#f1f5f9' }, ticks: { font: { size: 10 }, color: '#94a3b8' }, beginAtZero: true }
                }
            };

            function phpTooltip(ctx) {
                return ' Php ' + ctx.raw.toLocaleString(undefined, {minimumFractionDigits:2, maximumFractionDigits:2});
            }
            function phpAxisTick(v) { return 'Php ' + v.toLocaleString(); }

            // 1. Space Bookings per month
            new Chart(document.getElementById('kc-chart-bk-monthly'), {
                type: 'bar',
                data: { labels: MONTHS, datasets: [{ label: 'Bookings', data: BK_CNT, backgroundColor: TERRACOTTA, borderRadius: 4, borderSkipped: false }] },
                options: Object.assign({}, baseOpts)
            });

            // 2. Bookings Revenue per month
            new Chart(document.getElementById('kc-chart-rev-monthly'), {
                type: 'bar',
                data: { labels: MONTHS, datasets: [{ label: 'Revenue (Php)', data: BK_REV, backgroundColor: DEEP_RED, borderRadius: 4, borderSkipped: false }] },
                options: Object.assign({}, baseOpts, {
                    plugins: { legend: { display: false }, tooltip: { callbacks: { label: phpTooltip } } },
                    scales: { x: baseOpts.scales.x, y: Object.assign({}, baseOpts.scales.y, { ticks: { font:{size:10}, color:'#94a3b8', callback: phpAxisTick } }) }
                })
            });

            // 3. Quote Requests per month
            new Chart(document.getElementById('kc-chart-qt-monthly'), {
                type: 'bar',
                data: { labels: MONTHS, datasets: [{ label: 'Quote Requests', data: QT_CNT, backgroundColor: TEAL, borderRadius: 4, borderSkipped: false }] },
                options: Object.assign({}, baseOpts)
            });

            // 4. Quote Est. Revenue per month
            new Chart(document.getElementById('kc-chart-qt-rev-monthly'), {
                type: 'bar',
                data: { labels: MONTHS, datasets: [{ label: 'Est. Revenue (Php)', data: QT_REV, backgroundColor: TEAL_DARK, borderRadius: 4, borderSkipped: false }] },
                options: Object.assign({}, baseOpts, {
                    plugins: { legend: { display: false }, tooltip: { callbacks: { label: phpTooltip } } },
                    scales: { x: baseOpts.scales.x, y: Object.assign({}, baseOpts.scales.y, { ticks: { font:{size:10}, color:'#94a3b8', callback: phpAxisTick } }) }
                })
            });

            // 5. Pass type stacked bar per month
            var passColors = { 'Day Pass': '#BD451F', 'Weekly Pass': '#FBCB77', 'Monthly Pass': '#AC201A', 'Annual Pass': '#475569' };
            var passDatasets = Object.keys(PASS_SER).map(function(pt) {
                return { label: pt, data: PASS_SER[pt], backgroundColor: passColors[pt] || '#94a3b8', borderRadius: 3, borderSkipped: false };
            });
            new Chart(document.getElementById('kc-chart-pass-monthly'), {
                type: 'bar',
                data: { labels: MONTHS, datasets: passDatasets },
                options: {
                    responsive: true,
                    plugins: { legend: { display: true, position: 'bottom', labels: { font: { size: 11 }, padding: 16 } } },
                    scales: {
                        x: { stacked: true, grid: { display: false }, ticks: { font: { size: 10 }, color: '#94a3b8' } },
                        y: { stacked: true, grid: { color: '#f1f5f9' }, beginAtZero: true, ticks: { font: { size: 10 }, color: '#94a3b8' } }
                    }
                }
            });

            // Helper: donut chart
            function makeDonut(canvasId, labels, data, palette) {
                if (!labels.length) {
                    var el = document.getElementById(canvasId);
                    if (el) {
                        el.parentNode.insertAdjacentHTML('beforeend',
                            '<p style="text-align:center;color:#94a3b8;font-size:12px;font-style:italic;margin:32px 0;">No data yet.</p>');
                        el.style.display = 'none';
                    }
                    return;
                }
                var colors = labels.map(function(l, i) { return palette[i % palette.length]; });
                new Chart(document.getElementById(canvasId), {
                    type: 'doughnut',
                    data: { labels: labels, datasets: [{ data: data, backgroundColor: colors, borderWidth: 2, borderColor: '#fff', hoverOffset: 6 }] },
                    options: {
                        responsive: true,
                        cutout: '62%',
                        plugins: {
                            legend: { display: true, position: 'bottom', labels: { font: { size: 11 }, padding: 14 } },
                            tooltip: { callbacks: {
                                label: function(ctx) {
                                    var total = ctx.dataset.data.reduce(function(a,b){return a+b;},0);
                                    var pct = total > 0 ? Math.round(ctx.raw / total * 100) : 0;
                                    return ' ' + ctx.label + ': ' + ctx.raw + ' (' + pct + '%)';
                                }
                            }}
                        }
                    }
                });
            }

            // 6–9. Donuts
            makeDonut('kc-chart-donut-space',     DONUT_SPACE_LABELS,     DONUT_SPACE_COUNTS,     PALETTE);
            makeDonut('kc-chart-donut-pass',      DONUT_PASS_LABELS,      DONUT_PASS_COUNTS,      PALETTE);
            makeDonut('kc-chart-donut-status',    DONUT_STATUS_LABELS,    DONUT_STATUS_COUNTS,    PALETTE);
            makeDonut('kc-chart-donut-qt-status', DONUT_QT_STATUS_LABELS, DONUT_QT_STATUS_COUNTS, QT_PALETTE);

        })();
        </script>

        </div><!-- /#kc-tab-overview -->

        <!-- =============================================
             RECORDS TABS
             ============================================= -->
        <div class="kc-tabs-wrap">

            <style>
                .kc-tabs-wrap { margin-top: 0; margin-bottom: 0; order: 2; }
                #kc-tab-overview { order: 3; margin-top: 20px; margin-bottom: 24px; }

                /* Tab nav */
                .kc-tab-nav { display: flex; gap: 0; border-bottom: 3px solid transparent; margin-bottom: 0; }
                .kc-tab-btn { background: #fff; border: 1px solid #e2e8f0; border-bottom: none; color: #475569; font-size: 13px; font-weight: 700; padding: 10px 24px; cursor: pointer; margin-right: 4px; border-radius: 6px 6px 0 0; text-transform: uppercase; letter-spacing: .4px; transition: background .15s, color .15s; }
                .kc-tab-btn:hover { background: #fff9ef; color: var(--kc-terracotta); }
                .kc-tab-btn.kc-tab-active { background: var(--kc-terracotta); color: #fff; border-color: var(--kc-terracotta); }
                .kc-tab-btn svg { pointer-events: none; }

                /* Tab panels */
                .kc-tab-panel { display: none; background: #fff; border: 1px solid #e2e8f0; border-top: none; border-radius: 0 0 8px 8px; padding: 24px; box-shadow: 0 2px 6px rgba(0,0,0,.05); }
                .kc-tab-panel.kc-tab-panel-active { display: block; }

                /* Filter bar */
                .kc-filter-bar { display: flex; flex-wrap: wrap; gap: 10px; align-items: flex-end; margin-bottom: 20px; background: #f8fafc; padding: 14px 16px; border-radius: 6px; border: 1px solid #e2e8f0; }
                .kc-filter-bar label { font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: .4px; color: #64748b; display: block; margin-bottom: 4px; }
                .kc-filter-bar input[type="text"] { padding: 7px 10px; border: 1px solid #d1d5db; border-radius: 4px; font-size: 13px; line-height: 1.4; color: #1e293b; background: #fff; min-width: 160px; box-sizing: border-box; }
                .kc-filter-bar select { padding: 8px 32px 8px 10px; border: 1px solid #d1d5db; border-radius: 4px; font-size: 13px; line-height: 1.4; color: #1e293b; background-color: #fff; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%2364748b' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 10px center; min-width: 160px; appearance: none; -webkit-appearance: none; -moz-appearance: none; cursor: pointer; box-sizing: border-box; vertical-align: middle; }
                .kc-filter-bar input[type="text"]:focus,
                .kc-filter-bar select:focus { border-color: var(--kc-terracotta); outline: none; }
                .kc-filter-apply { background: var(--kc-terracotta); color: #fff; border: none; padding: 8px 18px; font-size: 13px; line-height: 1.4; font-weight: 700; border-radius: 4px; cursor: pointer; }
                .kc-filter-apply:hover { background: var(--kc-deep-red); }
                .kc-filter-clear  { background: #fff; color: var(--kc-terracotta); border: 1px solid var(--kc-terracotta); padding: 8px 14px; font-size: 13px; line-height: 1.4; font-weight: 700; border-radius: 4px; cursor: pointer; }
                .kc-filter-clear:hover { background: #fff9ef; }

                /* Records table */
                .kc-records-table { width: 100%; border-collapse: collapse; font-size: 13px; }
                .kc-records-table thead tr { background: var(--kc-terracotta); }
                .kc-records-table thead th { color: #fff; font-size: 11px; text-transform: uppercase; letter-spacing: .4px; padding: 10px 12px; text-align: left; font-weight: 700; white-space: nowrap; }
                .kc-records-table tbody tr { border-bottom: 1px solid #f1f5f9; }
                .kc-records-table tbody tr:hover td { background: #fffaf7; }
                .kc-records-table tbody td { padding: 10px 12px; color: #334155; vertical-align: middle; }
                .kc-records-table tbody td.kc-num { color: #94a3b8; font-size: 11px; }
                .kc-no-results { text-align: center; color: #94a3b8; font-style: italic; padding: 24px !important; }

                /* Status badge */
                .kc-badge { display: inline-block; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: .3px; }

                /* View Details button */
                .kc-view-btn { background: #fff; border: 1px solid var(--kc-terracotta); color: var(--kc-terracotta); padding: 5px 12px; font-size: 12px; font-weight: 700; border-radius: 4px; cursor: pointer; white-space: nowrap; }
                .kc-view-btn:hover { background: var(--kc-terracotta); color: #fff; }

                /* Modal */
                .kc-kpi-modal-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,.55); z-index: 99999; align-items: center; justify-content: center; }
                .kc-kpi-modal-overlay.kc-modal-open { display: flex; }
                .kc-kpi-modal { background: #fff; border-radius: 8px; width: 560px; max-width: 96vw; max-height: 88vh; overflow-y: auto; box-shadow: 0 12px 40px rgba(0,0,0,.2); }
                .kc-modal-header { background: var(--kc-terracotta); padding: 16px 22px; display: flex; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 1; }
                .kc-modal-header h2 { margin: 0; color: #fff; font-size: 15px; font-weight: 800; }
                .kc-modal-close { background: none; border: none; color: #fff; font-size: 22px; cursor: pointer; line-height: 1; padding: 0; opacity: .85; }
                .kc-modal-close:hover { opacity: 1; }
                .kc-modal-body { padding: 22px; }
                .kc-modal-section { margin-bottom: 20px; }
                .kc-modal-section h3 { font-size: 11px; text-transform: uppercase; letter-spacing: .5px; color: var(--kc-terracotta); font-weight: 800; margin: 0 0 10px; border-bottom: 1px solid #f1f5f9; padding-bottom: 6px; }
                .kc-modal-row { display: flex; gap: 8px; padding: 6px 0; border-bottom: 1px solid #f8fafc; font-size: 13px; }
                .kc-modal-row:last-child { border-bottom: none; }
                .kc-modal-lbl { width: 160px; flex-shrink: 0; color: #64748b; font-weight: 600; }
                .kc-modal-val { color: #1e293b; font-weight: 500; word-break: break-word; }
                .kc-modal-team-table { width: 100%; border-collapse: collapse; font-size: 12px; margin-top: 6px; }
                .kc-modal-team-table th { background: var(--kc-terracotta); color: #fff; padding: 7px 10px; text-align: left; font-size: 11px; text-transform: uppercase; letter-spacing: .3px; }
                .kc-modal-team-table td { padding: 7px 10px; border-bottom: 1px solid #f1f5f9; color: #334155; }
                .kc-modal-team-table tr:nth-child(even) td { background: #fffaf7; }
            </style>

            <!-- Tab Navigation -->
            <div class="kc-tab-nav">
                <button class="kc-tab-btn kc-tab-active" data-tab="kc-tab-overview">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:-2px;margin-right:6px;"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>Overview
                </button>
                <button class="kc-tab-btn" data-tab="kc-tab-bookings">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:-2px;margin-right:6px;"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>Bookings
                </button>
                <button class="kc-tab-btn" data-tab="kc-tab-quotes">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:-2px;margin-right:6px;"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><line x1="10" y1="9" x2="8" y2="9"/></svg>Quote Requests
                </button>
                <button class="kc-tab-btn" data-tab="kc-tab-mailing">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:-2px;margin-right:6px;"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>Mailing List
                </button>
            </div>

            <!-- Tab panels -->
            <?php
            /* ---- BOOKINGS TAB DATA ---- */
            // Build space list from kc_space posts — same source as the booking form
            // value = kc_space_booking_key (what's stored on the booking), label = kc_space_heading (what admin sees in Space Add)
            $bk_spaces = array();
            $bk_space_posts = get_posts(array(
                'post_type'      => 'kc_space',
                'posts_per_page' => -1,
                'post_status'    => 'publish',
                'orderby'        => 'menu_order',
                'order'          => 'ASC',
            ));
            foreach ($bk_space_posts as $bk_sp) {
                $bk_key   = get_field('kc_space_booking_key', $bk_sp->ID);
                $bk_label = get_field('kc_space_heading', $bk_sp->ID) ?: $bk_sp->post_title;
                if ($bk_key) $bk_spaces[] = array('value' => $bk_key, 'label' => $bk_label);
            }

            $bk_q = new WP_Query(array('post_type'=>'kc_booking','posts_per_page'=>-1,'orderby'=>'date','order'=>'DESC'));
            $bk_rows = array();
            while ($bk_q->have_posts()) {
                $bk_q->the_post(); $pid = get_the_ID();
                $space  = get_post_meta($pid,'kc_space_type',true);
                $status = get_post_meta($pid,'kc_status',true) ?: 'Pending';
                $bk_rows[] = array(
                    'id'         => $pid,
                    'name'       => trim(get_post_meta($pid,'kc_first_name',true).' '.get_post_meta($pid,'kc_last_name',true)),
                    'email'      => get_post_meta($pid,'kc_email',true),
                    'phone'      => get_post_meta($pid,'kc_phone',true),
                    'space'      => $space,
                    'date'       => get_post_meta($pid,'kc_start_date',true),
                    'duration'   => get_post_meta($pid,'kc_duration',true),
                    'price'      => get_post_meta($pid,'kc_price',true),
                    'status'     => $status,
                    'mem_status' => get_post_meta($pid,'kc_membership_status',true),
                    'mem_expiry' => get_post_meta($pid,'kc_membership_expiry',true),
                    'note'       => get_post_meta($pid,'kc_admin_note',true),
                );
            }
            wp_reset_postdata();
            ?>
            <div id="kc-tab-bookings" class="kc-tab-panel">

                <div class="kc-filter-bar">
                    <div>
                        <label for="kc-bk-search">Client Name</label>
                        <input type="text" id="kc-bk-search" placeholder="Search name…" />
                    </div>
                    <div>
                        <label for="kc-bk-space">Space</label>
                        <select id="kc-bk-space">
                            <option value="">All Spaces</option>
                            <?php foreach ($bk_spaces as $sp): ?>
                            <option value="<?php echo esc_attr($sp['value']); ?>"><?php echo esc_html($sp['label']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label for="kc-bk-status">Status</label>
                        <select id="kc-bk-status">
                            <option value="">All Statuses</option>
                            <option value="Pending">Pending</option>
                            <option value="Contacted">Contacted</option>
                            <option value="Active">Active</option>
                            <option value="Completed">Completed</option>
                            <option value="Rejected">Rejected</option>
                            <option value="Cancelled">Cancelled</option>
                        </select>
                    </div>
                    <button class="kc-filter-apply" id="kc-bk-apply">Apply Filters</button>
                    <button class="kc-filter-clear"  id="kc-bk-clear">Clear</button>
                </div>

                <div style="overflow-x:auto;">
                    <table class="kc-records-table">
                        <thead><tr>
                            <th>#</th><th>Client</th><th>Space</th><th>Date</th>
                            <th>Duration</th><th>Price</th><th>Status</th><th></th>
                        </tr></thead>
                        <tbody id="kc-bk-tbody"></tbody>
                    </table>
                </div>

                <script>
                (function() {
                    var BK = <?php echo wp_json_encode($bk_rows, JSON_HEX_TAG | JSON_HEX_AMP); ?>;
                    var BADGE = {
                        Pending:   'background:#fef9c3;color:#854d0e',
                        Contacted: 'background:#dbeafe;color:#1e40af',
                        Active:    'background:#dcfce7;color:#166534',
                        Completed: 'background:#d1fae5;color:#064e3b',
                        Rejected:  'background:#fee2e2;color:#991b1b',
                        Cancelled: 'background:#f1f5f9;color:#475569'
                    };
                    function esc(v) {
                        if (v === null || v === undefined || v === '') return '—';
                        return String(v).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
                    }
                    function mrow(lbl, val) {
                        return '<div class="kc-modal-row"><span class="kc-modal-lbl">'+lbl+'</span><span class="kc-modal-val">'+esc(val)+'</span></div>';
                    }
                    function modalHtml(b) {
                        var h = '<div class="kc-modal-section"><h3>Client Info</h3>';
                        h += mrow('Full Name',b.name)+mrow('Email',b.email)+mrow('Phone',b.phone);
                        h += '</div><div class="kc-modal-section"><h3>Booking Details</h3>';
                        h += mrow('Space',b.space)+mrow('Start Date',b.date)+mrow('Duration',b.duration);
                        h += mrow('Price', b.price ? '₱ '+esc(b.price) : null)+mrow('Status',b.status);
                        h += '</div>';
                        if (b.mem_status) {
                            h += '<div class="kc-modal-section"><h3>Membership</h3>';
                            h += mrow('Status',b.mem_status);
                            if (b.mem_expiry) h += mrow('Expiry',b.mem_expiry);
                            h += '</div>';
                        }
                        if (b.note) {
                            h += '<div class="kc-modal-section"><h3>Admin Note</h3>';
                            h += '<p style="font-size:13px;color:#334155;margin:0">'+esc(b.note)+'</p></div>';
                        }
                        return h;
                    }
                    function render(list) {
                        var tbody = document.getElementById('kc-bk-tbody');
                        if (!list.length) {
                            tbody.innerHTML = '<tr><td colspan="8" class="kc-no-results">No bookings found.</td></tr>';
                            return;
                        }
                        var rows = '';
                        list.forEach(function(b, i) {
                            var bs = BADGE[b.status] || 'background:#f1f5f9;color:#475569';
                            rows += '<tr>';
                            rows += '<td class="kc-num">'+(i+1)+'</td>';
                            rows += '<td><strong>'+esc(b.name)+'</strong><div style="font-size:11px;color:#94a3b8">'+esc(b.email)+'</div></td>';
                            rows += '<td>'+esc(b.space)+'</td>';
                            rows += '<td>'+esc(b.date)+'</td>';
                            rows += '<td>'+esc(b.duration)+'</td>';
                            rows += '<td>'+(b.price ? '₱ '+esc(b.price) : '—')+'</td>';
                            rows += '<td><span class="kc-badge" style="'+bs+'">'+esc(b.status)+'</span></td>';
                            rows += '<td><button class="kc-view-btn" data-idx="'+i+'">View Details</button></td>';
                            rows += '</tr>';
                        });
                        tbody.innerHTML = rows;
                        tbody.querySelectorAll('.kc-view-btn').forEach(function(btn) {
                            var b = list[parseInt(btn.dataset.idx, 10)];
                            btn.setAttribute('data-modal-title', b.name || 'Booking Details');
                            btn.setAttribute('data-modal-body',  modalHtml(b));
                        });
                    }
                    function applyFilters() {
                        var q  = document.getElementById('kc-bk-search').value.trim().toLowerCase();
                        var sp = document.getElementById('kc-bk-space').value;
                        var st = document.getElementById('kc-bk-status').value;
                        render(BK.filter(function(b) {
                            if (q  && b.name.toLowerCase().indexOf(q) === -1) return false;
                            if (sp && b.space  !== sp) return false;
                            if (st && b.status !== st) return false;
                            return true;
                        }));
                    }
                    document.getElementById('kc-bk-apply').addEventListener('click', applyFilters);
                    document.getElementById('kc-bk-clear').addEventListener('click', function() {
                        document.getElementById('kc-bk-search').value = '';
                        document.getElementById('kc-bk-space').value  = '';
                        document.getElementById('kc-bk-status').value = '';
                        render(BK);
                    });
                    document.getElementById('kc-bk-search').addEventListener('keydown', function(ev) {
                        if (ev.key === 'Enter') applyFilters();
                    });
                    render(BK);
                })();
                </script>
            </div>
            <?php
            /* ---- QUOTES TAB DATA ---- */
            $qt_q = new WP_Query(array('post_type'=>'kg_quote_lead','posts_per_page'=>-1,'orderby'=>'date','order'=>'DESC'));
            $qt_rows = array();
            while ($qt_q->have_posts()) {
                $qt_q->the_post(); $qid = get_the_ID();
                $fn   = get_post_meta($qid,'first_name',true);
                $mn   = get_post_meta($qid,'middle_name',true);
                $ln   = get_post_meta($qid,'last_name',true);
                $name = trim($fn . ($mn?' '.$mn:'') . ' ' . $ln);
                $team_raw = get_post_meta($qid,'team_json',true);
                $team = $team_raw ? json_decode($team_raw, true) : array();
                $qt_rows[] = array(
                    'id'       => $qid,
                    'name'     => $name,
                    'email'    => get_post_meta($qid,'email',true),
                    'phone'    => get_post_meta($qid,'phone',true),
                    'address'  => get_post_meta($qid,'address',true),
                    'total'    => get_post_meta($qid,'total_est',true),
                    'currency' => get_post_meta($qid,'currency_used',true) ?: 'PHP',
                    'status'   => get_post_meta($qid,'lead_status',true) ?: 'Pending',
                    'team'     => is_array($team) ? $team : array(),
                    'created'  => get_the_date('Y-m-d'),
                );
            }
            wp_reset_postdata();
            ?>
            <div id="kc-tab-quotes" class="kc-tab-panel">

                <div class="kc-filter-bar">
                    <div>
                        <label for="kc-qt-search">Client Name</label>
                        <input type="text" id="kc-qt-search" placeholder="Search name…" />
                    </div>
                    <div>
                        <label for="kc-qt-status">Status</label>
                        <select id="kc-qt-status">
                            <option value="">All Statuses</option>
                            <option value="Pending">Pending</option>
                            <option value="Contacted">Contacted</option>
                            <option value="Closed">Closed</option>
                            <option value="Rejected">Rejected</option>
                        </select>
                    </div>
                    <button class="kc-filter-apply" id="kc-qt-apply">Apply Filters</button>
                    <button class="kc-filter-clear"  id="kc-qt-clear">Clear</button>
                </div>

                <div style="overflow-x:auto;">
                    <table class="kc-records-table">
                        <thead><tr>
                            <th>#</th><th>Client</th><th>Team Size</th>
                            <th>Est. Total</th><th>Date</th><th>Status</th><th></th>
                        </tr></thead>
                        <tbody id="kc-qt-tbody"></tbody>
                    </table>
                </div>

                <script>
                (function() {
                    var QT = <?php echo wp_json_encode($qt_rows, JSON_HEX_TAG | JSON_HEX_AMP); ?>;
                    var BADGE = {
                        Pending:   'background:#fef9c3;color:#854d0e',
                        Contacted: 'background:#dbeafe;color:#1e40af',
                        Closed:    'background:#dcfce7;color:#166534',
                        Rejected:  'background:#fee2e2;color:#991b1b'
                    };
                    function esc(v) {
                        if (v === null || v === undefined || v === '' || (Array.isArray(v) && !v.length)) return '—';
                        return String(v).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
                    }
                    function mrow(lbl, val) {
                        return '<div class="kc-modal-row"><span class="kc-modal-lbl">'+lbl+'</span><span class="kc-modal-val">'+esc(val)+'</span></div>';
                    }
                    function teamTable(team) {
                        if (!team || !team.length) return '<p style="color:#94a3b8;font-style:italic;font-size:13px">No team members added.</p>';
                        var rows = team.map(function(m) {
                            var role  = m.title     || m.role || m.name || '—';
                            var level = m.level     || '—';
                            var count = m.headcount || m.count || m.qty || 1;
                            var rate  = m.monthly   || m.rate  || '—';
                            return '<tr><td>'+esc(role)+'</td><td>'+esc(level)+'</td><td>'+esc(count)+'</td><td>'+esc(rate)+'</td></tr>';
                        }).join('');
                        return '<table class="kc-modal-team-table"><thead><tr><th>Role</th><th>Level</th><th>Headcount</th><th>Monthly Rate</th></tr></thead><tbody>'+rows+'</tbody></table>';
                    }
                    function modalHtml(q) {
                        var h = '<div class="kc-modal-section"><h3>Client Info</h3>';
                        h += mrow('Full Name',q.name)+mrow('Email',q.email)+mrow('Phone',q.phone);
                        h += mrow('Address',q.address);
                        h += '</div><div class="kc-modal-section"><h3>Quote Details</h3>';
                        h += mrow('Date Submitted',q.created)+mrow('Status',q.status);
                        h += mrow('Currency',q.currency);
                        h += mrow('Est. Total', q.total ? q.currency+' '+esc(q.total) : null);
                        h += '</div>';
                        if (q.team && q.team.length) {
                            h += '<div class="kc-modal-section"><h3>Team Breakdown ('+q.team.length+' role'+(q.team.length!==1?'s':'')+')</h3>';
                            h += teamTable(q.team);
                            h += '</div>';
                        }
                        return h;
                    }
                    function render(list) {
                        var tbody = document.getElementById('kc-qt-tbody');
                        if (!list.length) {
                            tbody.innerHTML = '<tr><td colspan="7" class="kc-no-results">No quote requests found.</td></tr>';
                            return;
                        }
                        var rows = '';
                        list.forEach(function(q, i) {
                            var bs = BADGE[q.status] || 'background:#f1f5f9;color:#475569';
                            rows += '<tr>';
                            rows += '<td class="kc-num">'+(i+1)+'</td>';
                            rows += '<td><strong>'+esc(q.name)+'</strong><div style="font-size:11px;color:#94a3b8">'+esc(q.email)+'</div></td>';
                            rows += '<td>'+(q.team&&q.team.length ? q.team.length+' role'+(q.team.length!==1?'s':'') : '—')+'</td>';
                            rows += '<td>'+(q.total ? esc(q.currency)+' '+esc(q.total) : '—')+'</td>';
                            rows += '<td>'+esc(q.created)+'</td>';
                            rows += '<td><span class="kc-badge" style="'+bs+'">'+esc(q.status)+'</span></td>';
                            rows += '<td><button class="kc-view-btn" data-idx="'+i+'">View Details</button></td>';
                            rows += '</tr>';
                        });
                        tbody.innerHTML = rows;
                        tbody.querySelectorAll('.kc-view-btn').forEach(function(btn) {
                            var q = list[parseInt(btn.dataset.idx, 10)];
                            btn.setAttribute('data-modal-title', q.name || 'Quote Details');
                            btn.setAttribute('data-modal-body',  modalHtml(q));
                        });
                    }
                    function applyFilters() {
                        var qv = document.getElementById('kc-qt-search').value.trim().toLowerCase();
                        var st = document.getElementById('kc-qt-status').value;
                        render(QT.filter(function(q) {
                            if (qv && q.name.toLowerCase().indexOf(qv) === -1) return false;
                            if (st && q.status !== st) return false;
                            return true;
                        }));
                    }
                    document.getElementById('kc-qt-apply').addEventListener('click', applyFilters);
                    document.getElementById('kc-qt-clear').addEventListener('click', function() {
                        document.getElementById('kc-qt-search').value = '';
                        document.getElementById('kc-qt-status').value = '';
                        render(QT);
                    });
                    document.getElementById('kc-qt-search').addEventListener('keydown', function(ev) {
                        if (ev.key === 'Enter') applyFilters();
                    });
                    render(QT);
                })();
                </script>
            </div>
            <?php
            /* ---- MAILING LIST TAB DATA ---- */
            global $wpdb;
            $ml_table = $wpdb->prefix . 'kc_mailing_list';
            $ml_rows  = $wpdb->get_results("SELECT id, email, status, subscribed_at FROM {$ml_table} ORDER BY id DESC", ARRAY_A);
            if (!$ml_rows) $ml_rows = array();
            ?>
            <div id="kc-tab-mailing" class="kc-tab-panel">

                <div class="kc-filter-bar">
                    <div>
                        <label for="kc-ml-search">Email</label>
                        <input type="text" id="kc-ml-search" placeholder="Search email…" />
                    </div>
                    <div>
                        <label for="kc-ml-status">Status</label>
                        <select id="kc-ml-status">
                            <option value="">All Statuses</option>
                            <option value="active">Active</option>
                            <option value="pending">Pending</option>
                            <option value="unsubscribed">Unsubscribed</option>
                        </select>
                    </div>
                    <button class="kc-filter-apply" id="kc-ml-apply">Apply Filters</button>
                    <button class="kc-filter-clear"  id="kc-ml-clear">Clear</button>
                </div>

                <div style="overflow-x:auto;">
                    <table class="kc-records-table">
                        <thead><tr>
                            <th>#</th><th>Email</th><th>Status</th><th>Subscribed</th><th></th>
                        </tr></thead>
                        <tbody id="kc-ml-tbody"></tbody>
                    </table>
                </div>

                <script>
                (function() {
                    var ML = <?php echo wp_json_encode($ml_rows, JSON_HEX_TAG | JSON_HEX_AMP); ?>;
                    var BADGE = {
                        active:       'background:#dcfce7;color:#166534',
                        pending:      'background:#fef9c3;color:#854d0e',
                        unsubscribed: 'background:#f1f5f9;color:#475569'
                    };
                    function esc(v) {
                        if (v === null || v === undefined || v === '') return '—';
                        return String(v).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
                    }
                    function mrow(lbl, val) {
                        return '<div class="kc-modal-row"><span class="kc-modal-lbl">'+lbl+'</span><span class="kc-modal-val">'+esc(val)+'</span></div>';
                    }
                    function modalHtml(m) {
                        var h = '<div class="kc-modal-section"><h3>Subscriber Info</h3>';
                        h += mrow('Email',m.email);
                        h += mrow('Status', m.status ? m.status.charAt(0).toUpperCase()+m.status.slice(1) : null);
                        h += mrow('Subscribed At', m.subscribed_at);
                        h += mrow('Record ID', '#'+m.id);
                        h += '</div>';
                        return h;
                    }
                    function render(list) {
                        var tbody = document.getElementById('kc-ml-tbody');
                        if (!list.length) {
                            tbody.innerHTML = '<tr><td colspan="5" class="kc-no-results">No subscribers found.</td></tr>';
                            return;
                        }
                        var rows = '';
                        list.forEach(function(m, i) {
                            var st  = (m.status || 'pending').toLowerCase();
                            var bs  = BADGE[st] || 'background:#f1f5f9;color:#475569';
                            var lbl = st.charAt(0).toUpperCase() + st.slice(1);
                            rows += '<tr>';
                            rows += '<td class="kc-num">'+(i+1)+'</td>';
                            rows += '<td>'+esc(m.email)+'</td>';
                            rows += '<td><span class="kc-badge" style="'+bs+'">'+lbl+'</span></td>';
                            rows += '<td>'+esc(m.subscribed_at)+'</td>';
                            rows += '<td><button class="kc-view-btn" data-idx="'+i+'">View Details</button></td>';
                            rows += '</tr>';
                        });
                        tbody.innerHTML = rows;
                        tbody.querySelectorAll('.kc-view-btn').forEach(function(btn) {
                            var m = list[parseInt(btn.dataset.idx, 10)];
                            btn.setAttribute('data-modal-title', m.email || 'Subscriber Details');
                            btn.setAttribute('data-modal-body',  modalHtml(m));
                        });
                    }
                    function applyFilters() {
                        var q  = document.getElementById('kc-ml-search').value.trim().toLowerCase();
                        var st = document.getElementById('kc-ml-status').value;
                        render(ML.filter(function(m) {
                            if (q  && m.email.toLowerCase().indexOf(q) === -1) return false;
                            if (st && (m.status||'pending').toLowerCase() !== st) return false;
                            return true;
                        }));
                    }
                    document.getElementById('kc-ml-apply').addEventListener('click', applyFilters);
                    document.getElementById('kc-ml-clear').addEventListener('click', function() {
                        document.getElementById('kc-ml-search').value  = '';
                        document.getElementById('kc-ml-status').value  = '';
                        render(ML);
                    });
                    document.getElementById('kc-ml-search').addEventListener('keydown', function(ev) {
                        if (ev.key === 'Enter') applyFilters();
                    });
                    render(ML);
                })();
                </script>
            </div>

            <!-- Shared Modal -->
            <div class="kc-kpi-modal-overlay" id="kc-kpi-modal-overlay">
                <div class="kc-kpi-modal">
                    <div class="kc-modal-header">
                        <h2 id="kc-modal-title">Details</h2>
                        <button class="kc-modal-close" id="kc-modal-close">&times;</button>
                    </div>
                    <div class="kc-modal-body" id="kc-modal-body"></div>
                </div>
            </div>

        </div><!-- /.kc-tabs-wrap -->

        <script>
        jQuery(document).ready(function($) {
            // Tab switching
            $('.kc-tab-btn').on('click', function() {
                var target = $(this).data('tab');
                $('.kc-tab-btn').removeClass('kc-tab-active');
                $('.kc-tab-panel').removeClass('kc-tab-panel-active');
                $('[data-tab="' + target + '"]').addClass('kc-tab-active');
                $('#' + target).addClass('kc-tab-panel-active');
            });

            // Modal open/close
            $(document).on('click', '.kc-view-btn', function() {
                var title = $(this).data('modal-title') || 'Details';
                var body  = $(this).data('modal-body')  || '';
                $('#kc-modal-title').text(title);
                $('#kc-modal-body').html(body);
                $('#kc-kpi-modal-overlay').addClass('kc-modal-open');
            });
            $('#kc-modal-close, #kc-kpi-modal-overlay').on('click', function(e) {
                if (e.target === this) $('#kc-kpi-modal-overlay').removeClass('kc-modal-open');
            });
            $(document).on('keydown', function(e) {
                if (e.key === 'Escape') $('#kc-kpi-modal-overlay').removeClass('kc-modal-open');
            });
        });
        </script>

    </div>
    <?php
}
