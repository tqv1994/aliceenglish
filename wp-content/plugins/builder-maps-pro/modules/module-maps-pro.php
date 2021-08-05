<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Module Name: Maps Pro
 */
class TB_Maps_Pro_Module extends Themify_Builder_Component_Module {
	public function __construct() {
		parent::__construct(array(
			'name' => __( 'Maps Pro', 'builder-maps-pro' ),
			'slug' => 'maps-pro',
			'category' => array('addon')
		));
	}

	/**
	 * Filter the marker texts
	 */
	public static function sanitize_text( $text ) {
		return preg_replace( '/<script\b[^>]*>(.*?)<\/script>/is', '', $text );
	}

	function get_assets() {
		return array(
			'css'=>themify_enque(Builder_Maps_Pro::$url.'assets/style.css'),
			'js'=>themify_enque(Builder_Maps_Pro::$url.'assets/scripts.js'),
			'async'=>true,
			'ver'=>Builder_Maps_Pro::$version,
		);
	}
	
	public function get_icon(){
	    return 'world';
	}

	public function get_options() {
        $providers = Maps_Pro_Data_Provider::get_providers();
		$providers_settings = $providers_list = $bindings = array();
		$providers_keys = array_keys( $providers );
		foreach ( $providers as $id => $instance ) {
			$providers_list[ $id ] = $instance->get_label();

			$providers_settings[ $id ] = array(
				'type' => 'group',
				'options' => $instance->get_options(),
				'wrap_class' => $id,
			);

			$bindings[ $id ] = array(
				'hide' => array_values( array_diff( $providers_keys, array( $id ) ) ), // hide all other items except $id, also reset the array keys
				'show' => $id
			);
		}
		$map_styles = array(''=>'');
		$styles = Builder_Maps_Pro::get_map_styles();
		foreach( $styles as $key => $st ) {
			$name = str_replace( '.json', '', $key );
			$map_styles[$name] = $name;
		}
		unset($providers_keys,$styles);
		$range = range( 1, 20 );
		return array(
			array(
				'id' => 'mod_title',
				'type' => 'title'
			),
			array(
				'id' => 'map_display_type',
				'type' => 'radio',
				'label' => __('Type', 'builder-maps-pro'),
				'options' => array(
				    array('value'=>'dynamic','name' => __( 'Dynamic', 'builder-maps-pro' )),
				    array('value'=>'static','name' => __( 'Static image', 'builder-maps-pro' ))
				),
				'option_js' => true
			),
			array(
				'id' => 'w_map',
				'type' => 'range',
				'class' => 'xsmall',
				'label' =>'w',
				'units' => array(
					'px' => array(
						'max' => 3500
					),
					'%' =>''
				),
				'wrap_class' => 'tb_group_element_dynamic'
			),
			array(
				'id' => 'w_map_static',
				'type' => 'range',
				'class' => 'xsmall',
				'label' =>'w',
				'wrap_class' => 'tb_group_element_static',
				'units' => array(
					'px' => array(
						'max' => 3500
					)
				)
			),
			array(
				'id' => 'h_map',
				'type' => 'range',
				'label' => 'ht',
				'class' => 'xsmall',
				'units' => array(
					'px' => array(
						'max' => 3500
					)
				)
			),
			array(
				'id' => 'type_map',
				'type' => 'select',
				'label' => __('Type', 'builder-maps-pro'),
				'options' => array(
					'ROADMAP' => __( 'Road Map', 'builder-maps-pro' ),
					'SATELLITE' => __( 'Satellite', 'builder-maps-pro' ),
					'HYBRID' => __( 'Hybrid', 'builder-maps-pro' ),
					'TERRAIN' => __( 'Terrain', 'builder-maps-pro' )
				)
			),
			array(
				'id' => 'style_map',
				'type' => 'select',
				'label' => __('Style', 'builder-maps-pro'),
				'options' =>  $map_styles
			),
			array(
				'id' => 'draggable_map',
				'type' => 'select',
				'label' => __( 'Draggable', 'builder-maps-pro' ),
				'options' => array(
					'enable' => __( 'Enable', 'builder-maps-pro' ),
					'desktop_only' => __( 'Enable on desktop only', 'builder-maps-pro' ),
					'disable' => __( 'Disable', 'builder-maps-pro' )
				),
				'wrap_class' => 'tb_group_element_dynamic'
			),
			array(
				'id' => 'map_link',
				'type' => 'checkbox',
				'label' => __( 'Map link', 'builder-maps-pro' ),
				'options' => array(
					array( 'name' => 'gmaps', 'value' => __('Open Google Maps', 'builder-maps-pro'))
				),
				'wrap_class' => 'tb_group_element_static'
			),
			array(
				'id' => 'zoom_map',
				'type' => 'select',
				'label' => __('Zoom', 'builder-maps-pro'),
				'options' => array_combine($range,$range)
			),
				array(
					'id' => 'disable_map_ui',
					'type' => 'toggle_switch',
					'label' => __( 'Map Controls', 'builder-maps-pro' ),
					'wrap_class' => 'tb_group_element_dynamic'
				),
				array(
					'id' => 'scrollwheel_map',
					'type' => 'toggle_switch',
					'label' => __( 'Scrollwheel', 'builder-maps-pro' ),
					'options' => array(
					    'on' => array('name'=>'enable', 'value' =>'en'),
					    'off' => array('name'=>'disable', 'value' =>'dis')
					),
					'wrap_class' => 'tb_group_element_dynamic'
				),
			array(
				'id' => 'map_polyline',
				'type' => 'toggle_switch',
				'label' => __( 'Use Polyline', 'themify' ),
				'options' => 'simple',
				'binding' => array(
					'yes' => array( 'show' => 'map_polyline_options' ),
					'no' => array( 'hide' => 'map_polyline_options' ) 
				),
				'wrap_class' => 'tb_group_element_dynamic'
			),
			array(
				'type' => 'multi',
				'label' => '',
				'options' => array(
					array(
						'id' => 'map_polyline_geodesic',
						'type' => 'select',
						'label' => __( 'Geodesic', 'themify' ),
						'rchoose' => true
					),
					array(
						'id' => 'map_polyline_stroke',
						'type' => 'number',
						'label' => __( 'Stroke Weight', 'themify' ),
						'after' => 'px',
						'control'=>array(
							'event'=>'change'
						)
					),
					array(
						'id' => 'map_polyline_color',
						'type' => 'color',
						'label' => __( 'Stroke Color', 'themify' )
					)
				),
				'wrap_class' => 'tb_group_element_dynamic map_polyline_options'
			),
			array(
				'id' => 'map_center',
				'type' => 'textarea',
				'class' => 'fullwidth',
				'label' => __('Base Map Address', 'builder-maps-pro')
			),
			array(
				'id' => 'display',
				'type' => 'select',
				'label' => __( 'Map Markers', 'builder-maps-pro' ),
				'options' => $providers_list,
				'binding' => $bindings,
				'wrap_class' => count( $providers ) > 1 ? '' : '_tb_hide_binding', // hide this option if it only contains 1 item
			),
			array(
				'type' => 'group',
				'options' => $providers_settings
			),
			array(
				'id' => 'trigger',
				'type' => 'select',
				'label' => __( 'Show Marker On', 'builder-maps-pro' ),
				'options' => array(
					'click' => __( 'Click', 'builder-maps-pro' ),
					'hover' => __( 'Hover', 'builder-maps-pro' ),
				),
			),
			array(
			    'id' => 'css_class',
			    'type' => 'custom_css'
			),
			array('type'=>'custom_css_id')
		);
	}

	public function get_live_default() {
		return array(
			'display' => 'text',
			'type_map' => 'ROADMAP',
			'scrollwheel_map' => 'disable',
			'draggable_map' => 'enable',
			'disable_map_ui' => 'no',
			'w_map_unit' => '%',
			'w_map' => '100',
			'h_map' => '350',
			'zoom_map' => '4',
			'style_map' => 'pale-dawn',
			'map_polyline' => 'no',
			'map_polyline_geodesic' => 'yes',
			'map_polyline_stroke' => '2',
			'map_polyline_color' => '#ff0000_1',
			'map_display_type' => 'dynamic',
			'w_map_static' => '500',
			'markers' => array( array(
				'address' => '3 Bedford Road, Toronto, ON, Canada',
				'title' => 'Our Shop'
			) )
		);
	}

	public function get_styling() {
		$general = array(
		    // Background
		   self::get_expand('bg', array(
		       self::get_tab(array(
			   'n' => array(
			       'options' => array(
				   self::get_color('', 'background_color','bg_c','background-color')
			       )
			   ),
			   'h' => array(
			       'options' => array(
				   self::get_color('', 'bg_c','bg_c','background-color','h')
			       )
			   )
		       ))
		   )),
		   // Padding
		   self::get_expand('p', array(
		       self::get_tab(array(
			   'n' => array(
			       'options' => array(
				   self::get_padding()
			       )
			   ),
			   'h' => array(
			       'options' => array(
				   self::get_padding('', 'p', 'h')
			       )
			   )
		       ))
		   )),
		   // Margin
		   self::get_expand('m', array(
		       self::get_tab(array(
			   'n' => array(
			       'options' => array(
				   self::get_margin()
			       )
			   ),
			   'h' => array(
			       'options' => array(
				   self::get_margin('', 'm', 'h')
			       )
			   )
		       ))
		   )),
		   // Border
		   self::get_expand('b', array(
		       self::get_tab(array(
			   'n' => array(
			       'options' => array(
				   self::get_border()
			       )
			   ),
			   'h' => array(
			       'options' => array(
				   self::get_border('', 'b', 'h')
			       )
			   )
		       ))
		   )),
			// Width
			self::get_expand('w', array(
				self::get_tab(array(
					'n' => array(
						'options' => array(
							self::get_width('', 'w')
						)
					),
					'h' => array(
						'options' => array(
							self::get_width('', 'w', 'h')
						)
					)
				))
			)),
				// Height & Min Height
				self::get_expand('ht', array(
						self::get_height(),
						self::get_min_height(),
						self::get_max_height()
					)
				),
			// Rounded Corners
			self::get_expand('r_c', array(
					self::get_tab(array(
						'n' => array(
							'options' => array(
								self::get_border_radius()
							)
						),
						'h' => array(
							'options' => array(
								self::get_border_radius('', 'r_c', 'h')
							)
						)
					))
				)
			),
			// Shadow
			self::get_expand('sh', array(
					self::get_tab(array(
						'n' => array(
							'options' => array(
								self::get_box_shadow()
							)
						),
						'h' => array(
							'options' => array(
								self::get_box_shadow('', 'sh', 'h')
							)
						)
					))
				)
			),
			// Display
			self::get_expand('disp', self::get_display())
	    );

		$marker = array(
			self::get_tab(array(
				'n' =>array(
					'options' => array(
						self::get_font_family(' .maps-pro-content', 'f_f_m'),
						self::get_color(' .maps-pro-content', 'f_c_m'),
						self::get_font_size(' .maps-pro-content', 'f_s_m'),
						self::get_line_height(' .maps-pro-content', 'l_h_m'),
						self::get_text_shadow(' .maps-pro-content', 't_s_m'),
					)
				),
				'h' => array(
					'options' => array(
						self::get_font_family(' .maps-pro-content', 'f_f_m', 'h'),
						self::get_color(' .maps-pro-content', 'f_c_m', null, null, 'h'),
						self::get_font_size(' .maps-pro-content', 'f_s_m', '', 'h'),
						self::get_line_height(' .maps-pro-content', 'l_h_m', 'h'),                        
						self::get_text_shadow(' .maps-pro-content', 't_s_m', 'h'),
					)
				)
			))
	    );

		return array(
			'type' => 'tabs',
			'options' => array(
				'g' => array(
					'options' => $general
				),
				'm_t' => array(
					'options' => $this->module_title_custom_style()
				),
				'ma' => array(
					'label' => __( 'Markers', 'builder-maps-pro' ),
					'options' => $marker,
				),
			)
		);
	}

	protected function _visual_template() {
		$module_args = self::get_module_args('mod_title');?>
		<#	
		const draggable = 'enable' == data.draggable_map ||  'desktop_only' == data.draggable_map  ? 'enable' : 'disable';
		#>
		<div class="module module-<?php echo $this->slug; ?> {{ data.css_class }}"
			data-zoom="{{ data.zoom_map }}"
			data-type="{{ data.type_map }}"
			data-address="{{ data.map_center }}"
			data-width="{{ data.w_map }}"
			data-height="{{ data.h_map }}"
			data-style_map="{{ data.style_map }}"
			data-scrollwheel="{{ data.scrollwheel_map }}"
			data-polyline="{{ data.map_polyline }}"
			data-geodesic="{{ data.map_polyline_geodesic }}"
			data-polylineStroke="{{ data.map_polyline_stroke }}"
			data-polylineColor="{{ data.map_polyline_color }}"
			data-draggable="{{ draggable }}"
			data-disable_map_ui="{{ data.disable_map_ui }}"
			data-trigger="{{ data.trigger }}"
		>
			<# if( data.mod_title ) { #>
				<?php echo $module_args['before_title']; ?>
				{{{ data.mod_title }}}
				<?php echo $module_args['after_title']; ?>
			<# } #>
			
			<# if( data.map_display_type == 'dynamic' ) { #>

				<div class="maps-pro-canvas-container">
					<div class="maps-pro-canvas map-container" style="width:{{ data.w_map }}{{ data.w_map_unit }};height:{{ data.h_map }}px">
					</div>
				</div>

				<div class="maps-pro-markers" style="display:none">

					<# _.each( data.markers, function( marker ) { #>
						<div class="maps-pro-marker" data-address="{{{ typeof marker.latlng !== 'undefined' && marker.latlng!==''?marker.latlng:marker.address }}}" data-image="{{ marker.image }}">
							<# marker.title && print( marker.title ) #>
						</div>
					<# } ) #>
				</div>

			<# } else {
				let args = data.map_center ? 'center=' + data.map_center : '';
				args += data.zoom_map ? '&zoom=' + data.zoom_map : '';
				args += data.type_map ? '&maptype=' + data.type_map.toLowerCase() : '';
				args += data.w_map_static ? '&size=' + data.w_map_static.toString().replace( /[^0-9]/, '' ) + 'x' + data.h_map.toString().replace( /[^0-9]/, '' ) : '';
				<?php echo "args += '&key=" . Themify_Builder_Model::getMapKey() . '\';'; ?>

				if( data.markers ) {
					_.each( data.markers, function( marker ) {
						args += marker.image 
							? '&markers=icon:' + encodeURI( marker.image ) + '%7C' + encodeURI( marker.address )
							: '&markers=' + encodeURI( marker.address );
					} );
				}

				if( data.map_link == 'gmaps' && data.map_center ) { #>
					<a href="http://maps.google.com/?q={{ data.map_center }}" target="_blank" rel="nofollow" title="Google Maps">
				<# } #>
			
				<img src="//maps.googleapis.com/maps/api/staticmap?{{ args }}">

				<# if( data.map_link == 'gmaps' && data.map_center ) { #>
					</a>
				<# } #>

			<# } #>
		</div>
	<?php
	}
}

Themify_Builder_Model::register_module( 'TB_Maps_Pro_Module' );
