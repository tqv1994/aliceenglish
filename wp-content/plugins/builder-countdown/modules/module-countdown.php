<?php
if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

/**
 * Module Name: Countdown
 */

class TB_Countdown_Module extends Themify_Builder_Component_Module {

    function __construct() {
        parent::__construct(array(
            'name' => __('Countdown', 'builder-countdown'),
            'slug' => 'countdown',
			'category' => array('addon')
        ));
    }

    function get_assets() {
        return array(
			'async'=>true,
            'css' => themify_enque(Builder_Countdown::$url . 'assets/style.css'),
            'js' => themify_enque(Builder_Countdown::$url . 'assets/script.js'),
            'ver' => Builder_Countdown::$version
        );
    }
    
    public function get_icon(){
	return 'alarm-clock';
    }

    public function get_options() {
        $data =   apply_filters('builder_stopwatch_admin_script_vars', array(
                'data-dateformat' => 'yy-mm-dd',
                'data-timeformat' => 'HH:mm:ss',
                'data-separator' => ' ',
        ));
        return array(
            array(
                'id' => 'mod_title_countdown',
                'type' => 'title'
            ),
            array(
                'id' => 'mod_date_countdown',
                'type' => 'date',
                'label' => __('Date', 'builder-countdown'),
                'class' => 'large',
                'wrap_class' => 'builder-countdown-datepicker',
                'picker'=>$data
            ),
            array(
                'id' => 'color_countdown',
                'type' => 'layout',
                'mode' => 'sprite',
                'class' => 'tb_colors',
                'label' => __('Color', 'builder-countdown'),
                'color' => true,
                'transparent' => true
            ),
            array(
                'id' => 'counter_background_color',
                'type' => 'color',
                'label' => __('Custom Color', 'builder-countdown')
            ),
            array(
                'id' => 'done_action_countdown',
                'type' => 'radio',
                'label' => __('Finish Action', 'builder-countdown'),
                'options' => array(
		    array('value'=>'nothing','name'=>__('Do nothing', 'builder-countdown')),
		    array('value'=>'redirect','name'=>__('External Link', 'builder-countdown')),
		    array('value'=>'revealo','name'=>__('Show content', 'builder-countdown'))
                ),
	            'wrap_class' => 'tb_compact_radios',
                'option_js' => true
            ),
			array(
                'id' => 'hide_after_finish',
                'type' => 'checkbox',
                'label' => '',
                'options' => array(
                    array('name' => 'y', 'value' => __('Keep expired countdown visible', 'builder-countdown'))
                ),
				'wrap_class' => 'tb_group_element_nothing'
            ),
            array(
                'id' => 'content_countdown',
                'type' => 'wp_editor',
                'wrap_class' => 'tb_group_element_revealo'
            ),
            array(
                'id' => 'redirect_countdown',
                'type' => 'url',
                'label' => __('External Link', 'builder-countdown'),
                'class' => 'fullwidth',
                'help' => __('Note: the redirect will not occur for website administrators.', 'builder-countdown'),
                'wrap_class' => 'tb_group_element_redirect'
            ),
            array(
                'type' => 'multi',
                'label' => __('Labels', 'builder-countdown'),
                'options' => array(
                     array(
                        'id' => 'label_years',
                        'type' => 'text',
                        'label' => __('Years', 'themify'),
                        'control' => array(
                            'selector'=>'.years .date-label'
                        )
                    ),
                    array(
                        'id' => 'label_days',
                        'type' => 'text',
                        'label' => __('Days', 'themify'),
                        'control' => array(
                            'selector'=>'.days .date-label'
                        )
                    ),
                    array(
                        'id' => 'label_hours',
                        'type' => 'text',
                        'label' => __('Hours', 'themify'),
                        'control' => array(
                            'selector'=>'.hours  .date-label'
                        )
                    ),
                    array(
                        'id' => 'label_minutes',
                        'type' => 'text',
                        'label' => __('Minutes', 'themify'),
                        'control' => array(
                            'selector'=>'.minutes  .date-label'
                        )
                    ),
                    array(
                        'id' => 'label_seconds',
                        'type' => 'text',
                        'label' => __('Seconds', 'themify'),
                        'control' => array(
                            'selector'=>'.seconds .date-label'
                        )
                    ),
                )
            ),
	    array(
                'id' => 'add_css_countdown',
                'type' => 'custom_css'
            ),
            array('type'=>'custom_css_id')
        );
    }

    public function get_live_default() {
        return array(
            'mod_date_countdown' => '2030-12-31 16:00:00',
            'color_countdown' => 'transparent',
            'label_years' => __('Years', 'builder-countdown'),
            'label_days' => __('Days', 'builder-countdown'),
            'label_hours' => __('Hours', 'builder-countdown'),
            'label_minutes' => __('Minutes', 'builder-countdown'),
            'label_seconds' => __('Seconds', 'builder-countdown'),
			'text_align' => 'center',
        );
    }

    public function get_styling() {
        $general = array(
            //bacground
	    self::get_expand('bg', array(
	       self::get_tab(array(
		   'n' => array(
		       'options' => array(
			   self::get_color('', 'background_color', 'bg_c', 'background-color'),
		       )
		   ),
		   'h' => array(
		       'options' => array(
			   self::get_color('', 'bg_c', 'bg_c', 'background-color', 'h')
		       )
		   )
	       ))
	   )),
	    self::get_expand('f', array(
		self::get_tab(array(
		    'n' => array(
			'options' => array(
			    self::get_font_family(' .ui'),
			    self::get_color_type(array('.module .ui .date-counter','.module .ui .date-label')),
			    self::get_font_size(),
			    self::get_line_height(),
			    self::get_text_align(),
				self::get_text_shadow(' .ui'),
			)
		    ),
		    'h' => array(
			'options' => array(
			    self::get_font_family(' .ui', 'f_f', 'h'),
			    self::get_color_type(array('.module .ui .date-counter','.module .ui .date-label'),'h'),
			    self::get_font_size('', 'f_s', '', 'h'),
			    self::get_line_height('','l_h','h'),
			    self::get_text_align('', 't_a', 'h'),
				self::get_text_shadow(' .ui','t_sh','h'),
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

        $badge = array(
            //bacground
			self::get_expand('bg', array(
			   self::get_tab(array(
			   'n' => array(
				   'options' => array(
				   self::get_color('.module .ui', 'background_color_badge','bg_c', 'background-color')
				   )
			   ),
			   'h' => array(
				   'options' => array(
				   self::get_color('.module .ui', 'b_c_b','bg_c', 'background-color', 'h'),
				   )
			   )
			   ))
		   )),
			self::get_expand('p', array(
				self::get_tab(array(
					'n' => array(
					'options' => array(
						self::get_padding('.module .ui', 'p_b', '')
					)
					),
					'h' => array(
					'options' => array(
						self::get_padding('.module .ui', 'p_b', 'h')
					)
					)
				))
			)),
			// Margin
			self::get_expand('m', array(
				self::get_tab(array(
					'n' => array(
					'options' => array(
						self::get_margin('.module .ui', 'm_b', '')
					)
					),
					'h' => array(
					'options' => array(
						self::get_margin('.module .ui', 'm_b', 'h')
					)
					)
				))
			)),
			// Border
			self::get_expand('b', array(
				self::get_tab(array(
					'n' => array(
					'options' => array(
						self::get_border('.module .ui', 'b_b', '')
					)
					),
					'h' => array(
					'options' => array(
						self::get_border('.module .ui', 'b', 'h')
					)
					)
				))
			)),
			// Rounded Corners
			self::get_expand('r_c', array(
				self::get_tab(array(
					'n' => array(
						'options' => array(
							self::get_border_radius('.module .ui', 'b_r_c')
						)
					),
					'h' => array(
						'options' => array(
							self::get_border_radius('.module .ui', 'b_r_c', 'h')
						)
					)
				))
			)),
			// Shadow
			self::get_expand('sh', array(
				self::get_tab(array(
					'n' => array(
						'options' => array(
							self::get_box_shadow('.module .ui', 'b_b_sh')
						)
					),
					'h' => array(
						'options' => array(
							self::get_box_shadow('.module .ui', 'b_b_sh', 'h')
						)
					)
				))
			))
        );

        $labels = array(
			self::get_expand('f', array(
			self::get_tab(array(
				'n' => array(
				'options' => array(
					self::get_font_family( ' .date-label', 'l_f' ),
					self::get_color_type( ' .date-label', 'l_c' ),
					self::get_font_size( ' .date-label', 'l_s' ),
					self::get_line_height( ' .date-label', 'l_h' ),
					self::get_text_align( ' .date-label', 'l_a' ),
					self::get_text_transform( ' .date-label', 'l_t' ),
					self::get_text_shadow( ' .date-label', 'l_sh' ),
				)
				),
				'h' => array(
				'options' => array(
					self::get_font_family( ' .date-label', 'l_f_h' ),
					self::get_color_type( ' .date-label', 'l_c_h' ),
					self::get_font_size( ' .date-label', 'l_s_h' ),
					self::get_line_height( ' .date-label', 'l_h_h' ),
					self::get_text_align( ' .date-label', 'l_a_h' ),
					self::get_text_transform( ' .date-label', 'l_t_h' ),
					self::get_text_shadow( ' .date-label', 'l_sh_h' ),
				)
				)
			))
			)),
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
				'cd_badge' => array(
					'label' => __('Badge', 'builder-countdown'),
					'options' => $badge
				),
				'cd_label' => array(
					'label' => __('Labels', 'builder-countdown'),
					'options' => $labels
				),
			)
		);
		
    }

    protected function _visual_template() {
        $module_args = self::get_module_args('mod_title_countdown');
        ?>
        <#
        const epoch = Date.parse( data.mod_date_countdown ) / 1000,
        nextYear = new Date().setFullYear(new Date().getFullYear() + 1) / 1000,
        counterBg = data.counter_background_color 
        ? 'style="background-color:' + tb_app.Utils.toRGBA( data.counter_background_color ) + '"' : '';
        #>
        <div class="module module-<?php echo $this->slug; ?> {{ data.add_css_countdown }}">
            <# if( epoch <= Date.now() / 1000 && data.done_action_countdown == 'revealo' && data.content_countdown) { #>
                <div class="countdown-finished ui {{ data.color_countdown }}" {{{ counterBg }}}>
                    {{{ data.content_countdown }}}
                </div>
            <# } else { 
            if( data.mod_title_countdown ) { #>
            <?php echo $module_args['before_title']; ?>
            {{{ data.mod_title_countdown }}}
            <?php echo $module_args['after_title']; ?>
            <# } #>

            <div class="builder-countdown-holder" data-target-date="{{ epoch }}">

                <# if( nextYear < epoch ) { #>
					<div class="years ui {{ data.color_countdown }} tf_textc" {{{ counterBg }}}>
						<span class="date-counter"></span>
						<span class="date-label" contenteditable="false" data-name="label_years">{{{ data.label_years }}}</span>
					</div>
                <# } #>

                <div class="days ui {{ data.color_countdown }} tf_textc" {{{ counterBg }}}>
					<span class="date-counter"></span>
                    <span class="date-label" contenteditable="false" data-name="label_days">{{{ data.label_days }}}</span>
                </div>
                <div class="hours ui {{ data.color_countdown }} tf_textc" {{{ counterBg }}}>
					<span class="date-counter"></span>
                    <span class="date-label" contenteditable="false" data-name="label_hours">{{{ data.label_hours }}}</span>
                </div>
                <div class="minutes ui {{ data.color_countdown }} tf_textc" {{{ counterBg }}}>
					<span class="date-counter"></span>
                    <span class="date-label" contenteditable="false" data-name="label_minutes">{{{ data.label_minutes }}}</span>
                </div>
                <div class="seconds ui {{ data.color_countdown }} tf_textc" {{{ counterBg }}}>
					<span class="date-counter"></span>
                    <span class="date-label" contenteditable="false" data-name="label_seconds">{{{ data.label_seconds }}}</span>
                </div>
            </div>
            <# } #>
        </div>
        <?php
    }

}

Themify_Builder_Model::register_module('TB_Countdown_Module');
