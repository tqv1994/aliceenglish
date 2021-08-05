<?php
/**
 * Template to display Event Post widget
 *
 * To override this file copy it to <your_theme>/themify-event-post/themify-event-posts.php
 *
 * @var $mod_settings
 * @var $mod_name
 * @var $module_ID
 *
 * @package Themify Event Post
 */

$fields_args = wp_parse_args( $args['mod_settings'], array(
	'mod_title' => '',
	'show' => 'upcoming',
	'layout' => 'grid3',
	'category' => '0',
	'limit' => 3,
	'offset' => '',
	'order' => 'desc',
	'orderby' => 'date',
	'display' => 'excerpt',
	'image' => 'yes',
	'image_size' => '',
	'img_width' => '',
	'img_height' => '',
	'unlink_image' => 'no',
	'title' => 'yes',
	'unlink_title' => 'no',
	'hide_event_date' => 'no',
	'hide_event_organizer' => 'no',
	'hide_event_performer' => 'no',
	'hide_event_meta' => 'no',
	'hide_event_location' => 'no',
	'hide_page_nav' => 'no',
	'animation_effect' => '',
	'css' => ''
) );
 unset($args['mod_settings']);
$animation_effect = self::parse_animation_effect( $fields_args['animation_effect'] );
$container_class = apply_filters( 'themify_builder_module_classes', array(
		'module', 'module-' . $args['mod_name'], $args['module_ID'], $animation_effect, $fields_args['css']
	), $args['mod_name'], $args['module_ID'], $fields_args);
if(!empty($args['element_id'])){
	$container_class[] = 'tb_'.$args['element_id'];
    }
$container_props = apply_filters( 'themify_builder_module_container_props', array(
	'id' => $args['module_ID'],
	'class' => implode(' ', $container_class)
), $fields_args, $args['mod_name'], $args['module_ID'] );
?>
<div <?php echo self::get_element_attributes( $container_props ); ?>>

	<?php if ( $fields_args['mod_title'] !== '' ) : ?>
		<?php echo $fields_args['before_title'] . apply_filters( 'themify_builder_module_title', $fields_args['mod_title'], $fields_args ) . $fields_args['after_title']; ?>
	<?php endif; ?>

	<?php do_action( 'themify_builder_before_template_content_render' ); ?>

	<?php echo Themify_Event_Post::get_instance()->shortcode( $fields_args ); ?>

	<?php do_action( 'themify_builder_after_template_content_render' ); ?>
</div>