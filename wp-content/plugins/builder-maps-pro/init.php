<?php

/*
Plugin Name:  Builder Maps Pro
Plugin URI:   https://themify.me/addons/maps-pro
Version:      2.0.2
Author:       Themify
Author URI:   https://themify.me
Description:  Maps Pro module allows you to insert Google Maps with multiple location markers with custom icons, tooltip text, and various map styles. It requires to use with the latest version of any Themify theme or the Themify Builder plugin.
Text Domain:  builder-maps-pro
Domain Path:  /languages
Compatibility: 5.0.0
*/

defined('ABSPATH') or die('-1');

class Builder_Maps_Pro {

    public static $url;
	private static $dir;
	public static $version;

    /**
     * Init Builder Maps Pro
     */
    public static function init() {
        self::constants();
        add_action( 'init', array( __CLASS__, 'i18n' ) );
        add_action('themify_builder_setup_modules', array(__CLASS__, 'register_module'));
        if (is_admin()) {
			add_filter( 'plugin_row_meta', array( __CLASS__, 'themify_plugin_meta'), 10, 2 );
			add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), array( __CLASS__, 'action_links') );
            add_action( 'themify_builder_admin_enqueue', array(__CLASS__, 'admin_enqueue'));
            add_action( 'wp_ajax_tb_get_maps_pro_styles', array( __CLASS__, 'ajax_get_styles' ) );
        } else {
            add_action('themify_builder_frontend_enqueue', array(__CLASS__, 'admin_enqueue'), 15);
        }
		include self::$dir . 'providers/base.php';
    }

    public static function constants() {
        $data = get_file_data(__FILE__, array('Version'));
        self::$version = $data[0];
        self::$url = trailingslashit(plugin_dir_url(__FILE__));
        self::$dir = trailingslashit(plugin_dir_path(__FILE__));
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
    public static function i18n() {
        load_plugin_textdomain( 'builder-maps-pro', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
    }

    private static function localization() {
        return array(
            'key' => Themify_Builder_Model::getMapKey(),
			'admin_css'=>themify_enque(self::$url . 'assets/admin.css'),
			'v'=>self::$version
		);
    }

    public static function admin_enqueue() {
        wp_enqueue_script('themify-builder-maps-pro-admin', themify_enque(self::$url . 'assets/admin.js'), array('themify-builder-app-js'), self::$version, true);
        wp_localize_script('themify-builder-maps-pro-admin', 'builderMapsPro',self::localization());
    }


    public static function register_module() {
		Themify_Builder_Model::register_directory('templates', self::$dir . 'templates');
		Themify_Builder_Model::register_directory('modules', self::$dir . 'modules');
    }

    public static function get_map_styles() {
        $dir = get_stylesheet_directory() . '/builder-maps-pro/styles/';
        $theme_styles = is_dir($dir) ? self::list_dir($dir) : array();

        return array_merge(self::list_dir(self::$dir. 'styles/'), $theme_styles);
    }

    private static function list_dir($path) {
        $dh = opendir($path);
        $files = array();
        while (false !== ( $filename = readdir($dh) )) {
            if ($filename !== '.' && $filename !== '..' && '.json'===substr($filename,-5,5)) {
                $files[$filename] = $filename;
            }
        }

        return $files;
    }

    public static function get_map_style($name) {
        $file = get_stylesheet_directory() . '/builder-maps-pro/styles/' . $name . '.json';
        if(!is_file($file)){
            $file =  self::$dir . 'styles/' . $name . '.json';
            if (!is_file($file)) {
                return '';
            }
        }
        ob_start();
        include $file;
        return json_decode(ob_get_clean());
    }

	/**
	 * Send the list of map styles to Builder editor
	 *
	 * @hooked to "wp_ajax_tb_get_maps_pro_styles"
	 */
	public static function  ajax_get_styles() {
		check_ajax_referer('tb_load_nonce', 'tb_load_nonce');
		$map_styles = array();
		$data=self::get_map_styles();
        foreach ($data as $key => $v) {
            $name = str_replace('.json', '', $key);
            $map_styles[$name] = self::get_map_style($name);
        }
		die(json_encode( $map_styles ));
	}
}
Builder_Maps_Pro::init();