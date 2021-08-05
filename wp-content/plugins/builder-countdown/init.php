<?php

/*
Plugin Name:  Builder Countdown
Plugin URI:   https://themify.me/addons/countdown
Version:      2.0.3
Author:       Themify
Author URI:   https://themify.me
Description:  It requires to use with the latest version of any Themify theme or the Themify Builder plugin.
Text Domain:  builder-countdown
Domain Path:  /languages
Compatibility: 5.0.0
*/

defined('ABSPATH') or die('-1');

class Builder_Countdown {

    public static $url;
    public static $version;

    /**
     * Init Builder Countdown
     */
    public static function init() {
        self::constants();
        add_action( 'init', array( __CLASS__, 'i18n' ) );
        add_action('themify_builder_setup_modules', array(__CLASS__, 'register_module'));
        if (is_admin()) {
			add_filter( 'plugin_row_meta', array( __CLASS__, 'themify_plugin_meta'), 10, 2 );
			add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), array( __CLASS__, 'action_links') );
        } 
    }

    private static function constants() {
        $data = get_file_data(__FILE__, array('Version'));
        self::$version = $data[0];
        self::$url = trailingslashit(plugin_dir_url(__FILE__));
    }

    public static function i18n() {
        load_plugin_textdomain( 'builder-countdown', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
    }
	
	public static function themify_plugin_meta( $links, $file ) {
		if ( plugin_basename( __FILE__ ) === $file ) {
			$row_meta = array(
			  'changelogs'    => '<a href="' . esc_url( 'https://themify.me/changelogs/' ) . basename( dirname( $file ) ) .'.txt" target="_blank" aria-label="' . esc_attr__( 'Plugin Changelogs', 'themify' ) . '">' . esc_html__( 'View Changelogs', 'themify' ) . '</a>'
			);
	 
			return array_merge( $links, $row_meta );
		}
		return (array) $links;
	}
	
	public static function action_links( $links ) {
		if ( is_plugin_active( 'themify-updater/themify-updater.php' ) ) {
			$tlinks = array(
			 '<a href="' . admin_url( 'index.php?page=themify-license' ) . '">'.__('Themify License', 'themify') .'</a>',
			 );
		} else {
			$tlinks = array(
			 '<a href="' . esc_url('https://themify.me/docs/themify-updater-documentation') . '">'. __('Themify Updater', 'themify') .'</a>',
			 );
		}
		return array_merge( $links, $tlinks );
	}

    public static function register_module() {
		
		$dir = trailingslashit(plugin_dir_path(__FILE__));
		Themify_Builder_Model::register_directory('templates', $dir . 'templates');
		Themify_Builder_Model::register_directory('modules', $dir . 'modules');
      
    }
}

Builder_Countdown::init();
