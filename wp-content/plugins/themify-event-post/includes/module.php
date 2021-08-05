<?php

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly
/**
 * Module Name: Event Posts
 * Description: Display Event Posts
 */

class TB_Event_Posts_Module extends Themify_Builder_Component_Module {

    function __construct() {
	parent::__construct(array(
	    'name' => __('Event Posts', 'themify-event-post'),
	    'slug' => 'event-posts'
	));
    }

	public function get_icon(){
		return 'layers';
	}

    public function get_options() {
	/* START temp solution when the addon is new,the FW is old 09.03.19 */
	if (version_compare(THEMIFY_VERSION, '4.5', '<')) {
	    return array();
	}
	return array(
	    array(
		'id' => 'mod_title',
		'type' => 'title'
	    ),
	    array(
		'id' => 'show',
		'type' => 'select',
		'label' => __('Show', 'themify-event-post'),
		'options' => array(
		    'upcoming' => __('Upcoming Events', 'themify-event-post'),
		    'past' => __('Past Events', 'themify-event-post'),
		    'mix' => __('Mix of Both', 'themify-event-post'),
		)
	    ),
	    array(
		'id' => 'style',
		'type' => 'layout',
		'label' => __('Post Layout', 'themify-event-post'),
		'mode' => 'sprite',
		'options' => array(
		    array('img' => 'list_post', 'value' => 'list-post', 'label' => __('List Post', 'themify-event-post')),
		    array('img' => 'grid2', 'value' => 'grid2', 'label' => __('Grid 2', 'themify-event-post')),
		    array('img' => 'grid3', 'value' => 'grid3', 'label' => __('Grid 3', 'themify-event-post')),
		    array('img' => 'grid4', 'value' => 'grid4', 'label' => __('Grid 4', 'themify-event-post')),
		    array('img' => 'grid2_thumb', 'value' => 'grid2-thumb', 'label' => __('Grid 2 Thumb', 'themify-event-post')),
		),
	    ),
	    array(
		'type' => 'query_posts',
		'term_id' => 'category',
		'taxonomy'=>'event-category',
		'help' => sprintf(__('Add more <a href="%s" target="_blank">event posts</a>', 'themify-event-post'), admin_url('post-new.php?post_type=event'))
	    ),
	    array(
		'id' => 'limit',
		'type' => 'text',
		'label' => __('Limit', 'themify-event-post'),
		'class' => 'xsmall',
		'help' => __('number of posts to show', 'themify-event-post')
	    ),
	    array(
		'id' => 'offset',
		'type' => 'text',
		'label' => __('Offset', 'themify-event-post'),
		'class' => 'xsmall',
		'help' => __('number of post to displace or pass over', 'themify-event-post')
	    ),
	    array(
		'id' => 'order',
		'type' => 'select',
		'label' => __('Order', 'themify-event-post'),
		'help' => __('Descending = show newer posts first', 'themify-event-post'),
		'options' => array(
		    'desc' => __('Descending', 'themify-event-post'),
		    'asc' => __('Ascending', 'themify-event-post')
		)
	    ),
	    array(
		'id' => 'orderby',
		'type' => 'select',
		'label' => __('Order By', 'themify-event-post'),
		'options' => array(
		    'event_date' => __('Event Date', 'themify-event-post'),
		    'date' => __('Date', 'themify-event-post'),
		    'id' => __('Id', 'themify-event-post'),
		    'author' => __('Author', 'themify-event-post'),
		    'title' => __('Title', 'themify-event-post'),
		    'name' => __('Name', 'themify-event-post'),
		    'modified' => __('Modified', 'themify-event-post'),
		    'rand' => __('Random', 'themify-event-post'),
		    'comment_count' => __('Comment Count', 'themify-event-post'),
		),
	    ),
	    array(
		'id' => 'display',
		'type' => 'select',
		'label' => __('Display', 'themify-event-post'),
		'options' => array(
		    'excerpt' => __('Excerpt', 'themify-event-post'),
		    'content' => __('Content', 'themify-event-post'),
		    'none' => __('None', 'themify-event-post')
		)
	    ),
	    array(
		'id' => 'image',
		'type' => 'select',
		'label' => __('Display Featured Image', 'themify-event-post'),
		'options' => array(
		    '' => '',
		    'yes' => __('Yes', 'themify-event-post'),
		    'no' => __('No', 'themify-event-post')
		)
	    ),
	    array(
		'id' => 'image_w',
		'type' => 'text',
		'label' => __('Image Width', 'themify-event-post'),
		'class' => 'xsmall'
	    ),
	    array(
		'id' => 'image_h',
		'type' => 'text',
		'label' => __('Image Height', 'themify-event-post'),
		'class' => 'xsmall'
	    ),
	    array(
		'id' => 'unlink_image',
		'type' => 'select',
		'label' => __('Unlink Featured Image', 'themify-event-post'),
		'options' => array(
		    '' => '',
		    'no' => __('No', 'themify-event-post'),
		    'yes' => __('Yes', 'themify-event-post'),
		)
	    ),
	    array(
		'id' => 'title',
		'type' => 'select',
		'label' => __('Show Post Title', 'themify-event-post'),
		'options' => array(
		    '' => '',
		    'yes' => __('Yes', 'themify-event-post'),
		    'no' => __('No', 'themify-event-post'),
		)
	    ),
	    array(
		'id' => 'unlink_title',
		'type' => 'select',
		'label' => __('Unlink Post Title', 'themify-event-post'),
		'options' => array(
		    '' => '',
		    'no' => __('No', 'themify-event-post'),
		    'yes' => __('Yes', 'themify-event-post'),
		)
	    ),
	    array(
		'id' => 'hide_event_date',
		'type' => 'select',
		'label' => __('Hide Event Date', 'themify-event-post'),
		'options' => array(
		    '' => '',
		    'no' => __('No', 'themify-event-post'),
		    'yes' => __('Yes', 'themify-event-post'),
		)
	    ),
        array(
            'id' => 'hide_event_organizer',
            'type' => 'select',
            'label' => __('Hide Event Organizer', 'themify-event-post'),
            'options' => array(
                '' => '',
                'no' => __('No', 'themify-event-post'),
                'yes' => __('Yes', 'themify-event-post'),
            )
        ),
		array(
            'id' => 'hide_event_performer',
            'type' => 'select',
            'label' => __('Hide Event Performer', 'themify-event-post'),
            'options' => array(
                '' => '',
                'no' => __('No', 'themify-event-post'),
                'yes' => __('Yes', 'themify-event-post'),
            )
        ),
	    array(
		'id' => 'hide_event_meta',
		'type' => 'select',
		'label' => __('Hide Post Meta', 'themify-event-post'),
		'options' => array(
		    '' => '',
		    'no' => __('No', 'themify-event-post'),
		    'yes' => __('Yes', 'themify-event-post'),
		)
	    ),
	    array(
		'id' => 'hide_event_location',
		'type' => 'select',
		'label' => __('Hide Event Location', 'themify-event-post'),
		'options' => array(
		    '' => '',
		    'no' => __('No', 'themify-event-post'),
		    'yes' => __('Yes', 'themify-event-post'),
		)
	    ),
	    array(
		'id' => 'hide_page_nav',
		'type' => 'select',
		'label' => __('Hide Page Navigation', 'themify-event-post'),
		'options' => array(
		    '' => '',
		    'no' => __('No', 'themify-event-post'),
		    'yes' => __('Yes', 'themify-event-post'),
		)
	    ),
	    array(
		'id' => 'css',
		'type' => 'custom_css'
	    ),
	    array('type' => 'custom_css_id')
	);
    }

    public function get_default_settings() {
	return array(
	    'layout' => 'grid3',
	    'limit' => 3,
	    'display' => 'excerpt'
	);
    }

    public function get_visual_type() {
	return 'ajax';
    }

    public function get_styling() {
	$general = array(
	    // Background
	    self::get_expand('bg', array(
		self::get_tab(array(
		    'n' => array(
			'options' => array(
			    self::get_color('', 'background_color_general', 'bg_c', 'background-color')
			)
		    ),
		    'h' => array(
			'options' => array(
			    self::get_color('', 'b_c_g', 'bg_c', 'background-color', 'h')
			)
		    )
		))
	    )),
	    // Font
	    self::get_expand('f', array(
		self::get_tab(array(
		    'n' => array(
			'options' => array(
			    self::get_font_family('', 'font_family_general'),
			    self::get_color(array('', ' a'), 'font_color_general'),
			    self::get_font_size('', 'font_size_general'),
			    self::get_line_height('', 'line_height_general'),
			    self::get_letter_spacing('','letterspacing_general'),
			    self::get_text_align('', 'text_align_general'),
			    self::get_text_transform('', 'text_transform_general'),
			    self::get_font_style('', 'font_general', 'font_bold'),
			    self::get_text_shadow()
			)
		    ),
		    'h' => array(
			'options' => array(
			    self::get_font_family('', 'f_f_g', 'h'),
			    self::get_color(array('', ' a'),'f_c_g',null,null, 'h'),
			    self::get_font_size('', 'f_s_g', '', 'h'),
			    self::get_line_height('', 'l_h_g', 'h'),
			    self::get_letter_spacing('', 'l_s', 'h'),
			    self::get_text_align('', 't_a_g', 'h'),
			    self::get_text_transform('', 't_t_g', 'h'),
			    self::get_font_style('', 'f_g', 'f_b', 'h'),
			    self::get_text_shadow('','t_sh','h')
			)
		    )
		))
	    )),
	    // Padding
	    self::get_expand('p', array(
		self::get_tab(array(
		    'n' => array(
			'options' => array(
			    self::get_padding('', 'general_padding')
			)
		    ),
		    'h' => array(
			'options' => array(
			    self::get_padding('', 'g_p', 'h')
			)
		    )
		))
	    )),
	    // Margin
	    self::get_expand('m', array(
		self::get_tab(array(
		    'n' => array(
			'options' => array(
			    self::get_margin('', 'general_margin')
			)
		    ),
		    'h' => array(
			'options' => array(
			    self::get_margin('', 'g_m', 'h')
			)
		    )
		)),
	    )),// Border
	    self::get_expand('b', array(
		self::get_tab(array(
		    'n' => array(
			'options' => array(
			    self::get_border('', 'general_border')
			)
		    ),
		    'h' => array(
			'options' => array(
			    self::get_border('', 'g_b', 'h')
			)
		    )
		))
	    )),
	    // Filter
	    self::get_expand('f_l', array(self::get_blend())),
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
	    )
	);

	$post_container = array(
	     // Background
	    self::get_expand('bg', array(
		self::get_tab(array(
		    'n' => array(
			'options' => array(
			    self::get_color(' .post', 'background_color', 'bg_c', 'background-color')
			)
		    ),
		    'h' => array(
			'options' => array(
			    self::get_color(' .post', 'bg_c', 'bg_c', 'background-color', 'h')
			)
		    )
		))
	    )),
	    self::get_expand('f', array(
		self::get_tab(array(
		    'n' => array(
			'options' => array(
			    self::get_font_family(' .post'),
			    self::get_color(' .post', 'font_color'),
			    self::get_font_size(' .post'),
			    self::get_line_height(' .post'),
			    self::get_letter_spacing(' .post'),
			    self::get_text_align(' .post'),
			    self::get_text_transform(' .post'),
			    self::get_font_style(' .post'),
			    self::get_text_decoration(' .post', 'text_decoration_regular'),
			    self::get_text_shadow(' .post','t_sh_p_c')
			)
		    ),
		    'h' => array(
			'options' => array(
			    self::get_font_family(' .post', 'f_f', 'h'),
			    self::get_color(' .post', 'f_c', null,null, 'h'),
			    self::get_font_size(' .post', 'f_s', '', 'h'),
			    self::get_line_height(' .post', 'l_h', 'h'),
			    self::get_letter_spacing(' .post', 'l_s', 'h'),
			    self::get_text_align(' .post', 't_a', 'h'),
			    self::get_text_transform(' .post', 't_t', 'h'),
			    self::get_font_style(' .post', 'f_st', 'f_w', 'h'),
			    self::get_text_decoration(' .post', 't_d_r', 'h'),
			    self::get_text_shadow(' .post','t_sh_p_c','h')
			)
		    )
		))
	    )),
	    // Link
	    self::get_expand('l', array(
		self::get_tab(array(
		    'n' => array(
			'options' => array(
			    self::get_color(' a', 'link_color'),
			    self::get_text_decoration(' a')
			)
		    ),
		    'h' => array(
			'options' => array(
			    self::get_color(' a', 'link_color',null, null, 'hover'),
			    self::get_text_decoration(' a', 't_d', 'h')
			)
		    )
		))
	    )),
	    // Padding
	    self::get_expand('p', array(
		self::get_tab(array(
		    'n' => array(
			'options' => array(
			    self::get_padding(' .post')
			)
		    ),
		    'h' => array(
			'options' => array(
			    self::get_padding(' .post', 'p', 'h')
			)
		    )
		))
	    )),
	    // Margin
	    self::get_expand('m', array(
		self::get_tab(array(
		    'n' => array(
			'options' => array(
			    self::get_heading_margin_multi_field(' .post', '', 'top','', 'post'),
			    self::get_heading_margin_multi_field(' .post', '', 'bottom','', 'post')
			)
		    ),
		    'h' => array(
			'options' => array(
			    self::get_heading_margin_multi_field(' .post', '', 'top', 'h', 'p'),
			    self::get_heading_margin_multi_field(' .post', '', 'bottom', 'h', 'p')
			)
		    )
		))
	    )),
	    // Border
	    self::get_expand('b', array(
		self::get_tab(array(
		    'n' => array(
			'options' => array(
			    self::get_border(' .post')
			)
		    ),
		    'h' => array(
			'options' => array(
			    self::get_border(' .post', 'b', 'h')
			)
		    )
		))
	    ))
	);

	$post_title = array(
	    // Font
	    self::get_expand('f', array(
		self::get_tab(array(
		    'n' => array(
			'options' => array(
			    self::get_font_family(array(' .tep_post_title', ' .tep_post_title a'), 'font_family_title'),
			    self::get_color(array(' .tep_post_title', ' .tep_post_title a'), 'font_color_title'),
			    self::get_font_size(' .tep_post_title', 'font_size_title'),
			    self::get_line_height(' .tep_post_title', 'line_height_title'),
			    self::get_letter_spacing(' .tep_post_title', 'letter_spacing_title'),
			    self::get_text_transform(' .tep_post_title', 'text_transform_title'),
			    self::get_font_style(' .tep_post_title', 'font_title', 'font_weight_title'),
			    self::get_text_decoration(' .tep_post_title', 'text_decoration_regular_title'),
			    self::get_text_shadow(array(' .tep_post_title', ' .tep_post_title a'), 't_sh_t'),
			)
		    ),
		    'h' => array(
			'options' => array(
			    self::get_font_family(array(' .tep_post_title', ' .tep_post_title a'), 'f_f_t', 'h'),
			    self::get_color(array(' .tep_post_title', ' .tep_post_title a'), 'font_color_title', null, null, 'hover'),
			    self::get_font_size(' .tep_post_title', 'f_s_t', '', 'h'),
			    self::get_line_height(' .tep_post_title', 'l_h_t', 'h'),
			    self::get_letter_spacing(' .tep_post_title', 'l_s_t', 'h'),
			    self::get_text_transform(' .tep_post_title', 't_t_t', 'h'),
			    self::get_font_style(' .tep_post_title', 'f_t', 'f_w_t', 'h'),
			    self::get_text_decoration(' .tep_post_title', 't_d_r_t', 'h'),
			    self::get_text_shadow(array(' .tep_post_title', ' .tep_post_title a'), 't_sh_t','h'),
			)
		    )
		))
	    )),
	    // Padding
	    self::get_expand('p', array(
		self::get_tab(array(
		    'n' => array(
			'options' => array(
			    self::get_padding(' .tep_post_title', 'p_t')
			)
		    ),
		    'h' => array(
			'options' => array(
			    self::get_padding(' .tep_post_title', 'p_t', 'h')
			)
		    )
		))
	    )),
	    // Margin
	    self::get_expand('m', array(
		self::get_tab(array(
		    'n' => array(
			'options' => array(
			    self::get_margin(' .tep_post_title', 'm_t'),
			)
		    ),
		    'h' => array(
			'options' => array(
			    self::get_margin(' .tep_post_title', 'm_t', 'h'),
			)
		    )
		))
	    )),
	    // Border
	    self::get_expand('b', array(
		self::get_tab(array(
		    'n' => array(
			'options' => array(
			    self::get_border(' .tep_post_title', 'b_t')
			)
		    ),
		    'h' => array(
			'options' => array(
			    self::get_border(' .tep_post_title', 'b_t', 'h')
			)
		    )
		))
	    ))
	);

	$post_meta = array(
	    self::get_seperator('f'),
	    self::get_tab(array(
		'n' => array(
		    'options' => array(
			self::get_font_family(array(' .tep_meta', ' .tep_meta a'), 'font_family_meta'),
			self::get_color(array(' .tep_meta', ' .tep_meta a'), 'font_color_meta'),
			self::get_font_size(' .tep_meta', 'font_size_meta'),
			self::get_line_height(' .tep_meta', 'line_height_meta'),
			self::get_text_decoration(' .tep_meta', 't_d_m'),
			self::get_text_shadow(array(' .tep_meta', ' .tep_meta a'), 't_sh_m'),
		    )
		),
		'h' => array(
		    'options' => array(
			self::get_font_family(array(' .tep_meta', ' .tep_meta a'), 'f_f_m', 'h'),
			self::get_color(array(' .tep_meta', ' .tep_meta a'), 'font_color_meta',null,null,'hover'),
			self::get_font_size(' .tep_meta', 'f_s_m', '', 'h'),
			self::get_line_height(' .tep_meta', 'l_h_m', 'h'),
			self::get_text_decoration(' .tep_meta', 't_d_m', 'h'),
			self::get_text_shadow(array(' .tep_meta', ' .tep_meta a'), 't_sh_m','h')
		    )
		)
	    ))
	);

	$post_date = array(
	    // Background
	    self::get_expand('bg', array(
		self::get_tab(array(
		    'n' => array(
			'options' => array(
			    self::get_color(' .tep_date', 'b_c_d', 'bg_c', 'background-color')
			)
		    ),
		    'h' => array(
			'options' => array(
			    self::get_color(' .tep_date', 'b_c_d', 'bg_c', 'background-color', 'h')
			)
		    )
		))
	    )),
	    // Font
	    self::get_expand('f', array(
		self::get_tab(array(
		    'n' => array(
			'options' => array(
			    self::get_font_family(array(' .tep_date', ' .tep_date a'), 'font_family_date'),
			    self::get_color(array(' .tep_date', ' .tep_date a'), 'font_color_date'),
			    self::get_font_size(' .tep_date', 'font_size_date'),
			    self::get_line_height(' .tep_date', 'line_height_date'),
			    self::get_text_shadow(array(' .tep_date', ' .tep_date a'), 't_sh_d')
			)
		    ),
		    'h' => array(
			'options' => array(
			    self::get_font_family(array(' .tep_date', ' .tep_date a'), 'f_f_d', 'h'),
			    self::get_color(array(' .tep_date', ' .tep_date a'), 'f_c_d',null,null,'h'),
			    self::get_font_size(' .tep_date', 'f_s_d', '', 'h'),
			    self::get_line_height(' .tep_date', 'l_h_d', 'h'),
			    self::get_text_shadow(array(' .tep_date', ' .tep_date a'), 't_sh_d','h')
			)
		    )
		))
	    )),
	    
	    // Padding
	    self::get_expand('p', array(
		self::get_tab(array(
		    'n' => array(
			'options' => array(
			    self::get_padding(' .tep_date', 'p_d')
			)
		    ),
		    'h' => array(
			'options' => array(
			    self::get_padding(' .tep_date', 'p_d', 'h')
			)
		    )
		))
	    )),
	    // Margin
	    self::get_expand('m', array(
		self::get_tab(array(
		    'n' => array(
			'options' => array(
			    self::get_margin(' .tep_date', 'm_d'),
			)
		    ),
		    'h' => array(
			'options' => array(
			    self::get_margin(' .tep_date', 'm_d', 'h'),
			)
		    )
		))
	    )),
	    // Border
	    self::get_expand('b', array(
		self::get_tab(array(
		    'n' => array(
			'options' => array(
			    self::get_border(' .tep_date', 'b_d')
			)
		    ),
		    'h' => array(
			'options' => array(
			    self::get_border(' .tep_date', 'b_d', 'h')
			)
		    )
		))
	    ))
	);

	$post_content = array(
	    // Background
	    self::get_expand('bg', array(
		self::get_tab(array(
		    'n' => array(
			'options' => array(
			    self::get_color(' .tep_content', 'tep_content', 'bg_c', 'background-color')
			)
		    ),
		    'h' => array(
			'options' => array(
			    self::get_color(' .tep_content', 'b_c_c', 'bg_c', 'background-color', 'h')
			)
		    )
		))
	    )),
	    // Font
	    self::get_expand('f', array(
		self::get_tab(array(
		    'n' => array(
			'options' => array(
			    self::get_font_family(' .tep_content', 'font_family_content'),
			    self::get_color(' .tep_content', 'font_color_content'),
			    self::get_font_size(' .tep_content', 'font_size_content'),
			    self::get_line_height(' .tep_content', 'line_height_content'),
			    self::get_text_align(' .tep_content', 't_a_c'),
				self::get_text_shadow(' .tep_content', 't_sh_c'),
			)
		    ),
		    'h' => array(
			'options' => array(
			    self::get_font_family(' .tep_content', 'f_f_c','h'),
			    self::get_color(' .tep_content', 'f_c_c', null,null, 'h'),
			    self::get_font_size(' .tep_content', 'f_s_c', '', 'h'),
			    self::get_line_height(' .tep_content', 'l_h_c', 'h'),
			    self::get_text_align(' .tep_content', 't_a_c', 'h'),
				self::get_text_shadow(' .tep_content', 't_sh_c','h'),
			)
		    )
		))
	    )),
	    // Padding
	    self::get_expand('p', array(
		self::get_tab(array(
		    'n' => array(
			'options' => array(
			    self::get_padding(' .tep_content', 'c_p')
			)
		    ),
		    'h' => array(
			'options' => array(
			    self::get_padding(' .tep_content', 'c_p', 'h')
			)
		    )
		))
	    )),
	    // Margin
	    self::get_expand('m', array(
		self::get_tab(array(
		    'n' => array(
			'options' => array(
			    self::get_margin(' .tep_content', 'c_m')
			)
		    ),
		    'h' => array(
			'options' => array(
			    self::get_margin(' .tep_content', 'c_m', 'h')
			)
		    )
		))
	    )),
	    // Border
	    self::get_expand('b', array(
		self::get_tab(array(
		    'n' => array(
			'options' => array(
			    self::get_border(' .tep_content', 'c_b')
			)
		    ),
		    'h' => array(
			'options' => array(
			    self::get_border(' .tep_content', 'c_b', 'h')
			)
		    )
		))
	    ))
	);

	$featured_image = array(
	    // Background
	    self::get_expand('bg', array(
		self::get_tab(array(
		    'n' => array(
			'options' => array(
			    self::get_color(' .tep_image', 'b_c_f_i', 'bg_c', 'background-color')
			)
		    ),
		    'h' => array(
			'options' => array(
			    self::get_color(' .tep_image', 'b_c_f_i', 'bg_c', 'background-color', 'h')
			)
		    )
		))
	    )),
	    // Padding
	    self::get_expand('p', array(
		self::get_tab(array(
		    'n' => array(
			'options' => array(
			    self::get_padding(' .tep_image', 'p_f_i')
			)
		    ),
		    'h' => array(
			'options' => array(
			    self::get_padding(' .tep_image', 'p_f_i', 'h')
			)
		    )
		))
	    )),
	    // Margin
	    self::get_expand('m', array(
		self::get_tab(array(
		    'n' => array(
			'options' => array(
			    self::get_margin(' .tep_image', 'm_f_i')
			)
		    ),
		    'h' => array(
			'options' => array(
			    self::get_margin(' .tep_image', 'm_f_i', 'h')
			)
		    )
		))
	    )),
	    // Border
	    self::get_expand('b', array(
		self::get_tab(array(
		    'n' => array(
			'options' => array(
			    self::get_border(' .tep_image', 'b_f_i')
			)
		    ),
		    'h' => array(
			'options' => array(
			    self::get_border(' .tep_image', 'b_f_i', 'h')
			)
		    )
		))
	    ))
	);

	return array('type' => 'tabs',
	    'options' => array(
		'g' => array(
		    'options' => $general
		),
		'm_t' => array(
		    'options' => $this->module_title_custom_style()
		),
		'c' => array(
		    'label' => __('Post Container', 'themify-event-post'),
		    'options' => $post_container
		),
		't' => array(
		    'label' => __('Post Title', 'themify-event-post'),
		    'options' => $post_title
		),
		'm' => array(
		    'label' => __('Post Meta', 'themify-event-post'),
		    'options' => $post_meta
		),
		'd' => array(
		    'label' => __('Post Date', 'themify-event-post'),
		    'options' => $post_date
		),
		'co' => array(
		    'label' => __('Post Content', 'themify-event-post'),
		    'options' => $post_content
		),
		'f' => array(
		    'label' => __('Featured Image', 'themify-event-post'),
		    'options' => $featured_image
		)
	    )
	);
    }

    /**
     * Render plain content for static content.
     * 
     * @param array $module 
     * @return string
     */
    public function get_plain_content($module) {
	return ''; // no static content for dynamic content
    }

}

Themify_Builder_Model::register_module('TB_Event_Posts_Module');
