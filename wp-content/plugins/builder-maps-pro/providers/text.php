<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Maps_Pro_Data_Provider_Text extends Maps_Pro_Data_Provider {

	function get_id() {
		return 'text';
	}

	function get_label() {
		return __( 'Text', 'builder-maps-pro' );
	}

	function get_options() {
		return array(
			array(
			    'type' => 'map_pro',
			    'options' => array(
					'id' => 'markers',
					'type' => 'builder',
					'options' => array(
						array(
							'id' => 'address',
							'type' => 'textarea',
							'label' => __('Address (or Lat/Lng)', 'builder-maps-pro'),
							'wrap_class' => 'tb_disable_dc',
						),
						array(
							'id' => 'latlng',
							'type' => 'textarea',
							'class' => 'latlng'
						),
						array(
							'id' => 'title',
							'type' => 'textarea',
							'label' => __('Tooltip Text', 'builder-maps-pro'),
							'wrap_class' => 'tb_disable_dc'
						),
						array(
							'id' => 'image',
							'type' => 'image',
							'label' => __('Icon', 'builder-maps-pro'),
							'wrap_class' => 'tb_disable_dc',
						)
					),
					'new_row'=>__('Add Location Marker', 'builder-maps-pro')
			    ),
			    'help'=>__( 'In static mode, Google allows up to 5 custom icons, though each unique icons may be used multiple times. Icons are limited to sizes of 4096 pixels (64x64 for square images), and also the API does not support custom icon URLs that use HTTPS.', 'builder-maps-pro' )
			),
		);
	}

	function get_items( $settings ) {
		return isset($settings['markers'])?$settings['markers']:array();
	}
}