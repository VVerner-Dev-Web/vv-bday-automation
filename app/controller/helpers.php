<?php defined('ABSPATH') || exit('No direct script access allowed');

function getTodaysBirthdayUsers(): array
{
    global $wpdb;

    $customers   = [];
    $currentTime = current_time('d/m/');
    $query       = "SELECT ID FROM `{$wpdb->posts}` WHERE `post_status` = 'wc-completed' AND `post_type` = 'shop_order' AND `ID` IN (
        SELECT `post_id` FROM `{$wpdb->postmeta}` WHERE `meta_key` = '_billing_birthdate' AND `meta_value` LIKE '" . $currentTime . "%'
    )";

    $ordersID = (array) $wpdb->get_col($query);

    $orders = array_map('wc_get_order', $ordersID);
    foreach ($orders as $order) : 
        $uid = $order->get_customer_id();

        if (!isset($customers[$uid ])) : 
            $customers[ $uid ] = get_userdata( $uid );
        endif;
    endforeach;

    return $customers;
}

function getLeadsZappAdminPage(): void
{
    require_once VVBA_APP . '/views/admin/settings.php';
}
