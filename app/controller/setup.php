<?php defined('ABSPATH') || exit('No direct script access allowed');

// REGISTER SETTINGS PAGE
// ===================================
add_action('admin_menu', function () {
    add_menu_page(
        'LeadsZapp',
        'LeadsZapp',
        'manage_options',
        'leadszapp',
        'getLeadsZappAdminPage',
        'dashicons-buddicons-community'
    );
});

// REGISTER CRON JOB
// ===================================
add_action('wp', function () {
    if (!wp_next_scheduled('leadszapp_send_bday_messages')) :
        wp_schedule_event( strtotime('12:00:00'), 'daily', 'leadszapp_send_bday_messages');
    endif;
});

// DO CRON JOB
// ===================================
add_action('leadszapp_send_bday_messages', function(){
    $users = getTodaysBirthdayUsers();
    $api   = new LeadsZapp\API();

    foreach ($users as $user) : 
        $name       = get_user_meta($user->ID, 'billing_first_name', true);
        $name      .= ' ' . get_user_meta($user->ID, 'billing_last_name', true);
        $cellphone  = get_user_meta($user->ID, 'billing_cellphone', true);
        $phone      = $cellphone ? $cellphone : get_user_meta($user->ID, 'billing_phone', true);

        if ($name && $phone) : 
            $contact    = new LeadsZapp\Contact( $name, $phone );
            $api->setContact( $contact );
            $api->sendMessage();
        endif;
    endforeach;
});
