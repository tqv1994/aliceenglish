<?php
/**
 * @package TryLottery
 */
/*

Plugin Name: Try the Lottery
Plugin URI: /
Description: Quay thử xổ số 3 miền
Version: 0.0.1
Author: VuongTQ
Author URI: /
License: GPLv2 or later
*/

// Khai báo hằng số
define('TRY_LOTTERY_DIR_URL',plugin_dir_url( __FILE__ ));
define('TRY_LOTTERY_DIR_ASSETS_URL',TRY_LOTTERY_DIR_URL.'assets');
define('TRY_LOTTERY_DIR_STYLES_URL',TRY_LOTTERY_DIR_URL.'styles');
define('TRY_LOTTERY_DIR_SCRIPTS_URL',TRY_LOTTERY_DIR_URL.'scripts');
define('TRY_LOTTERY_DIR_PATH',plugin_dir_path( __FILE__ ));
define('TRY_LOTTERY_INCLUDE_PATH',TRY_LOTTERY_DIR_PATH.'include');
define('TRY_LOTTERY_SHORTCODE_PATH',TRY_LOTTERY_INCLUDE_PATH.'/shortcodes');

// Khai báo css
function try_lottery_styles() {
    wp_enqueue_style( 'try-lottery-bootstrap',  plugin_dir_url( __FILE__ ) . '/assets/libs/bootstrap/bootstrap.min.css' );
    wp_enqueue_style( 'try-lottery-main',  TRY_LOTTERY_DIR_STYLES_URL . '/try-lottery.css','','4' );
}
add_action( 'wp_enqueue_scripts', 'try_lottery_styles' );
// Khai báo js
function try_lottery_scripts(){
    wp_enqueue_script('try-lottery-bootstrap',TRY_LOTTERY_DIR_ASSETS_URL.'/libs/bootstrap/bootstrap.min.js');
    wp_enqueue_script('try-lottery-main',TRY_LOTTERY_DIR_SCRIPTS_URL.'/try-lottery.js');
    wp_enqueue_script('try-lottery-custom',TRY_LOTTERY_DIR_SCRIPTS_URL.'/custom.js','','4.9');
}
add_action('wp_enqueue_scripts','try_lottery_scripts');

include(TRY_LOTTERY_SHORTCODE_PATH.'/try_lottery_mien_bac.php');
