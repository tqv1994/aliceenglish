<?php
/**
 * Base class for Builder_Data_Provider classes
 *
 * @package Themify
 */
if ( ! class_exists( 'Maps_Pro_Data_Provider' ) ){
	class Maps_Pro_Data_Provider {

		/* instances of data providers for this module */
		private static $providers=array();

		function is_available() {
			return true;
		}

		function get_id() {}

		function get_label() {}

		function get_options() {}
		function get_error() {}
		function get_items( $settings ) {}

		/**
		 * Initialize data providers for the module
		 *
		 * Other plugins or themes can extend or add to this list
		 * by using the "builder_tiled_posts_providers" filter.
		 */
		private static function init_providers($type='all') {
			$dir = trailingslashit( dirname( __FILE__ ) );
			$providers = apply_filters( 'tb_maps_pro_data_providers', array(
				'text' => 'Maps_Pro_Data_Provider_Text',
			) );
			if($type!=='all'){
				if(!isset($providers[$type])){
					return false;
				}
				$providers=array($type=>$providers[$type]);
			}
			foreach ( $providers as $id => $provider ) {
				if(!isset(self::$providers[ $id ])){
					if(is_file($dir . '/'.$id.'.php')){
						include_once( $dir . '/'.$id.'.php' );
						if ( class_exists( $provider ) ) {
							self::$providers[ $id ] = new $provider();
						}
					}
				}
			}
		}

		/**
		 * Helper function to retrieve a provider instance
		 *
		 * @return object
		 */
		public static function get_providers( $id='all' ) {
			if(!isset( self::$providers[ $id ] ) ){
				self::init_providers($id);
			}
			if($id==='all'){
				return self::$providers;
			}
			return isset( self::$providers[ $id ] ) ? self::$providers[ $id ] : false;
		}
	}
}