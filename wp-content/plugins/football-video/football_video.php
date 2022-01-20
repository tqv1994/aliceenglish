<?php
/*
Plugin Name: Football Video
Plugin URI:
Description:
Author:
Version:
Author URI:
*/

register_activation_hook(__FILE__, 'football_video_activate');
register_deactivation_hook(__FILE__, 'football_video_deactivate');

function football_video_activate() {
    global $wp_rewrite;
    require_once dirname(__FILE__).'/football_video_loader.php';
    $loader = new FootballVideoLoader();
    $loader->activate();
    $wp_rewrite->flush_rules( true );
}

function football_video_deactivate() {
    global $wp_rewrite;
    require_once dirname(__FILE__).'/football_video_loader.php';
    $loader = new FootballVideoLoader();
    $loader->deactivate();
    $wp_rewrite->flush_rules( true );
}
