<?php
if (!defined('ABSPATH'))
    exit; // Exit if accessed directly
/**
 * Template Countdown
 * 
 * Access original fields: $args['mod_settings']
 */
$fields_default = array(
    'mod_title_countdown' => '',
    'mod_date_countdown' => '',
    'done_action_countdown' => '',
    'content_countdown' => '',
    'redirect_countdown' => '',
    'color_countdown' => '',
    'label_years' => '',
    'label_days' => '',
    'label_hours' => '',
    'label_minutes' => '',
    'label_seconds' => '',
    'add_css_countdown' => '',
    'counter_background_color' => '',
    'animation_effect' => '',
    'hide_after_finish' => 'n'
);

$fields_args = wp_parse_args($args['mod_settings'], $fields_default);
unset($args['mod_settings']);
$fields_default=null;
$container_class =  apply_filters('themify_builder_module_classes', array(
    'module','module-'.$args['mod_name'], $args['module_ID'], $fields_args['add_css_countdown'])
    , $args['mod_name'], $args['module_ID'], $fields_args);
if(!empty($fields_args['global_styles']) && Themify_Builder::$frontedit_active===false){
    $container_class[] = $fields_args['global_styles'];
}
// get target date based on user timezone
$epoch = strtotime(get_gmt_from_date($fields_args['mod_date_countdown']));
$is_expired = $epoch <= time();
if($is_expired && 'nothing'===$fields_args['done_action_countdown']){
    $container_class[] = 'tf_hide';
}
$next_year = strtotime('+1 year');
    $container_props = apply_filters('themify_builder_module_container_props', self::parse_animation_effect($fields_args, array(
	    'id' => $args['module_ID'],
	    'class' => implode(' ',$container_class),
    )), $fields_args, $args['mod_name'], $args['module_ID']);

if(Themify_Builder::$frontedit_active===false){
    $container_props['data-lazy']=1;
}
if($fields_args['color_countdown'] !== '' && method_exists('Themify_Builder_Model','load_color_css')){
    Themify_Builder_Model::load_color_css($fields_args['color_countdown']);
}
$is_inline_edit_supported=method_exists('Themify_Builder_Component_Base','add_inline_edit_fields')
?>
<!-- module countdown -->
<div <?php echo self::get_element_attributes(self::sticky_element_props($container_props,$fields_args)); ?>>
    <?php $container_props=$container_class=null;?>
    <?php if ('' !== $fields_args['counter_background_color']) : ?>
	<style>#<?php echo $args['module_ID']; ?> .ui {background-color:<?php echo Themify_Builder_Stylesheet::get_rgba_color($fields_args['counter_background_color']); ?>}</style>
    <?php endif; ?>

    <?php do_action('themify_builder_before_template_content_render'); ?>

    <?php if ($is_expired): ?>
	<?php if ($fields_args['done_action_countdown'] === 'revealo') :
	    ?>

	    <div class="countdown-finished ui <?php echo $fields_args['color_countdown']; ?>">
		<?php echo apply_filters('themify_builder_module_content', $fields_args['content_countdown']); ?>
	    </div>

	<?php elseif ($fields_args['done_action_countdown'] === 'redirect' && Themify_Builder::$frontedit_active!==true) : ?>

	    <script>
			window.location = '<?php echo esc_url($fields_args['redirect_countdown']); ?>';
	    </script>

	<?php endif; ?>
    <?php else: ?>
		<?php if($is_inline_edit_supported===true){
			echo Themify_Builder_Component_Module::get_module_title($fields_args,'mod_title_countdown');
		}
		elseif ($fields_args['mod_title_bar_chart'] !== ''){
			echo $fields_args['before_title'] , apply_filters('themify_builder_module_title', $fields_args['mod_title_contact'], $fields_args) , $fields_args['after_title'];
		}
		?>
		<div class="builder-countdown-holder" data-target-date="<?php echo $epoch; ?>" data-target-refresh="<?php echo $fields_args['hide_after_finish']; ?>">

			<?php if ($next_year < $epoch) : ?>
			<div class="years ui <?php echo $fields_args['color_countdown']; ?>">
				<span class="date-counter"></span>
				<span class="date-label"<?php if($is_inline_edit_supported===true){ self::add_inline_edit_fields('label_years'); }?>><?php echo $fields_args['label_years'] ?></span>
			</div>
			<?php endif; ?>

			<div class="days ui <?php echo $fields_args['color_countdown']; ?> tf_textc">
				<span class="date-counter"></span>
				<span class="date-label"<?php if($is_inline_edit_supported===true){ self::add_inline_edit_fields('label_days'); }?>><?php echo $fields_args['label_days']; ?></span>
			</div>
				<div class="hours ui <?php echo $fields_args['color_countdown']; ?> tf_textc">
				<span class="date-counter"></span>
				<span class="date-label"<?php if($is_inline_edit_supported===true){ self::add_inline_edit_fields('label_hours'); }?>><?php echo $fields_args['label_hours']; ?></span>
			</div>
				<div class="minutes ui <?php echo $fields_args['color_countdown']; ?> tf_textc">
				<span class="date-counter"></span>
				<span class="date-label"<?php if($is_inline_edit_supported===true){ self::add_inline_edit_fields('label_minutes'); }?>><?php echo $fields_args['label_minutes']; ?></span>
			</div>
			<div class="seconds ui <?php echo $fields_args['color_countdown']; ?> tf_textc">
				<span class="date-counter"></span>
				<span class="date-label"<?php if($is_inline_edit_supported===true){ self::add_inline_edit_fields('label_seconds'); }?>><?php echo $fields_args['label_seconds']; ?></span>
			</div>
		</div>

    <?php endif; ?>

    <?php do_action('themify_builder_after_template_content_render'); ?>
</div>
<!-- /module countdown -->
