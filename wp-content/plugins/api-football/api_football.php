<?php
/*
Plugin Name: Api Football
Plugin URI:
Description:
Author:
Version:
Author URI:
*/

register_activation_hook(__FILE__, 'api_football_activate');
register_deactivation_hook(__FILE__, 'api_football_deactivate');

function api_football_activate() {
    global $wp_rewrite;
    require_once dirname(__FILE__).'/api_football_loader.php';
    $loader = new ApiFootballLoader();
    $loader->activate();
    $wp_rewrite->flush_rules( true );
}

function api_football_deactivate() {
    global $wp_rewrite;
    require_once dirname(__FILE__).'/api_football_loader.php';
    $loader = new ApiFootballLoader();
    $loader->deactivate();
    $wp_rewrite->flush_rules( true );
}
