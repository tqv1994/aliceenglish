<?php

MvcConfiguration::set(array(
    'Debug' => false
));

MvcConfiguration::append(array(
    'AdminPages' => array(
        'api_option' => array(
            'custom' => array('in_menu'=>false)
        ),
        'bets' => array(
            'add' => array('in_menu'=>false)
        ),
    )
));

add_action('mvc_admin_init', 'api_football_on_mvc_admin_init');

function api_football_on_mvc_admin_init($options) {
    wp_register_style('mvc_admin_form', mvc_css_url('api-football', 'admin'),10);
    wp_enqueue_style('mvc_admin_form');
}

?>