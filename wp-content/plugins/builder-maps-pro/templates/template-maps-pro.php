<?php
if (!defined('ABSPATH'))
    exit; // Exit if accessed directly
/**
 * Template Maps Pro
 * 
 * Access original fields: $args['mod_settings']
 * @author Themify
 */
$fields_default = array(
    'mod_title' => '',
    'map_link' => '',
    'map_center' => '',
    'zoom_map' => 4,
    'w_map' => '', 
    'w_map_unit' => '',
    'h_map' => '', 
    'type_map' => 'ROADMAP',
    'scrollwheel_map' => 'disable',
    'draggable_map' => 'enable',
    'disable_map_ui' => 'no',
    'map_polyline' => 'no',
    'map_polyline_geodesic' => 'yes',
    'map_polyline_stroke' => 2,
    'map_polyline_color' => 'ff0000_1',
    'map_display_type' => 'dynamic',
    'w_map_static' => 500,
    'animation_effect' => '',
    'style_map' => '',
    'display' => 'text',
    'trigger' => 'click',
    'css_class' => '',
);
$marker_defaults = array(
    'title' => '', 
    'address' => '',
    'image' => ''
);
$fields_args = wp_parse_args($args['mod_settings'], $fields_default);
if($fields_args['w_map_unit']===''){
    $fields_args['w_map_unit'] = isset($args['mod_settings']['unit_w'])?$args['mod_settings']['unit_w']:'px';
}
if ( empty( $fields_args['w_map'] ) ) {
	$fields_args['w_map'] = 100;
	$fields_args['w_map_unit'] = '%';
}
unset($args['mod_settings']);
$fields_default=null;
$container_class =  apply_filters('themify_builder_module_classes', array(
    'module', 'module-' . $args['mod_name'], $args['module_ID'], $fields_args['css_class']
		), $args['mod_name'], $args['module_ID'], $fields_args);
if(Themify_Builder::$frontedit_active===false){
    if(!empty($fields_args['global_styles'])){
	$container_class[] = $fields_args['global_styles'];
    }
    $container_class[] = 'tf_lazy';
}
if ('' !== $fields_args['style_map'] && $fields_args['map_display_type'] === 'dynamic') {
echo '
<script>
	map_pro_styles = window.map_pro_styles || [];
	map_pro_styles["' . $fields_args['style_map']  . '"] = ' . json_encode(Builder_Maps_Pro::get_map_style($fields_args['style_map']  )) . ';
</script>';
}
$container_props = apply_filters('themify_builder_module_container_props', self::parse_animation_effect($fields_args, array(
	'id' => $args['module_ID'],
	'class' => implode(' ',$container_class),
	'data-zoom' =>$fields_args['zoom_map'],
	'data-type' => $fields_args['type_map'],
	'data-address' => $fields_args['map_center'],
	'data-width' => $fields_args['w_map'],
	'data-height' => $fields_args['h_map'],
	'data-style_map' => $fields_args['style_map'] ,
	'data-scrollwheel' => $fields_args['scrollwheel_map'],
	'data-draggable' => ( 'enable' ===$fields_args['draggable_map']  || ( 'desktop_only' === $fields_args['draggable_map'] && !themify_is_touch() ) ) ? 'enable' : 'disable',
	'data-disable_map_ui' => $fields_args['disable_map_ui'],
	'data-polyline' => $fields_args['map_polyline'],
	'data-geodesic' => $fields_args['map_polyline_geodesic'],
	'data-polylineStroke' => $fields_args['map_polyline_stroke'],
	'data-polylineColor' => $fields_args['map_polyline_color'],
	'data-trigger' => $fields_args['trigger'],
)), $fields_args, $args['mod_name'], $args['module_ID']);

$markers = array();
if ( $instance = Maps_Pro_Data_Provider::get_providers( $fields_args['display'] ) ) {
	$markers = $instance->get_items( $fields_args );
}

if(Themify_Builder::$frontedit_active===false){
    $container_props['data-lazy']=1;
}
?>
<!-- module maps pro -->
<div <?php echo self::get_element_attributes(self::sticky_element_props($container_props,$fields_args)); ?>>
    <?php 
		$map_options=$container_props=$container_class=null;
	
		if(method_exists('Themify_Builder_Component_Base','add_inline_edit_fields')){
			echo Themify_Builder_Component_Module::get_module_title($fields_args,'mod_title');
		}
		elseif ($fields_args['mod_title'] !== ''){
			echo $fields_args['before_title'] , apply_filters('themify_builder_module_title', $fields_args['mod_title'], $fields_args) , $fields_args['after_title'];
		}
		 do_action('themify_builder_before_template_content_render'); 
	?>

    <?php if ($fields_args['map_display_type'] === 'dynamic') : ?>
	<div class="maps-pro-canvas-container">
	    <div class="maps-pro-canvas map-container" style="width:<?php echo $fields_args['w_map'] ,$fields_args['w_map_unit'] ; ?>;height:<?php echo $fields_args['h_map']?>px">
	    </div>
	</div>

	<div class="maps-pro-markers tf_hide">
	    <?php
	    foreach ( $markers as $marker) :
		$marker = wp_parse_args( $marker, $marker_defaults );
		?>
		<div class="maps-pro-marker" data-address="<?php echo !empty($marker['latlng']) ? $marker['latlng'] : $marker['address'] ?>" data-image="<?php echo $marker['image']; ?>">
		    <?php echo TB_Maps_Pro_Module::sanitize_text( $marker['title'] ); ?>
		</div>
	    <?php endforeach; ?>
	</div>

    <?php
    else :

	$args = '';
	if ($fields_args['map_center']!=='') {
	    $args = 'center=' . $fields_args['map_center'];
	}
	$args .= '&zoom=' .$fields_args['zoom_map'] ;
	$args .= '&maptype=' . strtolower($fields_args['type_map']);
	$args .= '&size=' . preg_replace('/[^0-9]/', '',$fields_args['w_map_static'] ) . 'x' . preg_replace('/[^0-9]/', '', $fields_args['h_map']);
	$args .= '&key=' . Themify_Builder_Model::getMapKey();

	/* markers */
	if ( ! empty( $markers ) ) {
	   foreach ( $markers as $marker ) {
		$marker = wp_parse_args($marker, $marker_defaults);
		if (empty($marker['image'])) {
		    $args .= '&markers=' . urlencode($marker['address']);
		} else {
		    $args .= '&markers=icon:' . urlencode($marker['image']) . '%7C' . urlencode($marker['address']);
		}
	    }
	}
	$marker_defaults=null;
	/* Map style */
	if ('' !== $fields_args['style_map']) {
	    $style = Builder_Maps_Pro::get_map_style($fields_args['style_map']);
	    foreach ($style as $rule) {
		$args .= '&style=';
		if (isset($rule->featureType)) {
		    $args .= 'feature:' . $rule->featureType . '%7C';
		}
		if (isset($rule->elementType)) {
		    $args .= 'element:' . $rule->elementType . '%7C';
		}
		if (isset($rule->stylers)) {
		    foreach ($rule->stylers as $styler) {
				foreach ($styler as $prop => $value) {
					$value = str_replace('#', '0x', $value);
					$args .= $prop . ':' . $value . '%7C';
				}
		    }
		}
	    }
	}

	if ('gmaps' ===$fields_args['map_link']  && !empty($fields_args['map_center']))
	    echo '<a href="http://maps.google.com/?q=' . esc_attr($fields_args['map_center']) . '" target="_blank" rel="nofollow" title="Google Maps">';
	?>
	    <img src="//maps.googleapis.com/maps/api/staticmap?<?php echo $args; ?>">
	<?php
	if ('gmaps' === $fields_args['map_link']  && !empty($fields_args['map_center'] ))
	    echo '</a>';
	?>

<?php endif; ?>

<?php do_action('themify_builder_after_template_content_render'); ?>
</div>
<!-- /module maps pro -->