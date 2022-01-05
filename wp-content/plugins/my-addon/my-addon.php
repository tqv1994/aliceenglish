<?php
/**
 * @package MyAddon
 */
/*

Plugin Name: My Addon
Plugin URI: /
Description:
Version: 0.0.1
Author: VuongTQ
Author URI: /
License: GPLv2 or later
*/

// Khai báo hằng số
define('MY_ADDON_DIR_URL',plugin_dir_url( __FILE__ ));
define('MY_ADDON_DIR_ASSETS_URL',MY_ADDON_DIR_URL.'assets');
define('MY_ADDON_DIR_STYLES_URL',MY_ADDON_DIR_URL.'styles');
define('MY_ADDON_DIR_SCRIPTS_URL',MY_ADDON_DIR_URL.'scripts');
define('MY_ADDON_DIR_PATH',plugin_dir_path( __FILE__ ));
define('MY_ADDON_INCLUDE_PATH',MY_ADDON_DIR_PATH.'include');
define('MY_ADDON_SHORTCODE_PATH',MY_ADDON_INCLUDE_PATH.'/shortcodes');
define('MY_ADDON_WIDGET_PATH',MY_ADDON_INCLUDE_PATH.'/widgets');

// Khai báo css
function my_addon_styles() {

    wp_enqueue_style( 'materialdesignicons',  'https://cdn.materialdesignicons.com/2.1.99/css/materialdesignicons.min.css','','1' );
    wp_enqueue_style( 'my_addon_sidebar_menu',  MY_ADDON_DIR_STYLES_URL . '/my-addon-sidebar-menu.css','','1' );
    wp_enqueue_style( 'my_addon_tabs',  MY_ADDON_DIR_STYLES_URL . '/my-addon-tabs.css','','1' );
}
// Khai báo js
function my_addon_scripts(){
    wp_enqueue_script('my_addon_sidebar_menu_script',MY_ADDON_DIR_SCRIPTS_URL.'/my-addon-sidebar-menu.js','','4.9');
}
add_action('wp_enqueue_scripts','my_addon_scripts',20);
add_action( 'wp_enqueue_scripts', 'my_addon_styles' );
include(MY_ADDON_SHORTCODE_PATH.'/my_addon_sidebar_menu.php');
include(MY_ADDON_WIDGET_PATH.'/my_addon_tabs_widget.php');
include(MY_ADDON_SHORTCODE_PATH.'/my_addon_tabs.php');