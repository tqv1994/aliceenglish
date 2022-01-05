<?php
function my_addon_tabs__widgets_init() {
    register_sidebar( array(
        'name' => 'My Addon Tabs Area',
        'id' => 'my-addon-tabs-area',
        'description' => 'Hiển thị tabs',
        'before_widget' => '<div class="wrap-my-addon-tabs">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>'
    ));
}
add_action( 'widgets_init', 'my_addon_tabs__widgets_init' );

/**
 * Empty widget title
 *
 * @param string $widget_title
 * @return
 */
function empty_widget_title($widget_title) {
    return;
}

/**
 * Get first X widgets from a defined widget area (sidebar) and reorganize their content using tabs
 *
 * @global array $wp_registered_widgets
 * @param string $sidebar_id
 */
function my_addon_dynamic_sidebar($sidebar_id, $widgets_no = 3) {
    global $wp_registered_widgets;

    $sidebars_widgets = wp_get_sidebars_widgets();
    if (empty($sidebars_widgets[$sidebar_id])) {
        return;
    }

    $tabs = array();
    $tabs_content = array();

    add_filter('widget_title', 'empty_widget_title'); // add filter to remove widget titles

    foreach ($sidebars_widgets[$sidebar_id] as $key => $id) {
        if ($widgets_no < $key + 1) {
            break;
        }

        if (empty($wp_registered_widgets[$id]['callback'][0]->id_base)) {
            continue;
        }

        $instance = get_option('widget_' . $wp_registered_widgets[$id]['callback'][0]->id_base);
        $instance = $instance[$wp_registered_widgets[$id]['params'][0]['number']];
        $class_name = get_class($wp_registered_widgets[$id]['callback'][0]);

        $tabs[$key] = sprintf('<li class="%s" data-key="%d"><a href="%s"><h4>%s</h4></a></li>', ($key === 0 ? 'active' : ''), $key,isset($instance['url']) ? $instance['url'] : '', $instance['title']);
        ob_start();
        the_widget($class_name, $instance, array('before_widget' => '', 'after_widget' => '', 'widget_id' => $wp_registered_widgets[$id]['id']));
        $tabs_content[$key] = ob_get_clean();
    }

    remove_filter('widget_title', 'empty_widget_title'); // remove previous filter

    $tabs_nav = sprintf('<ul class="tabs-nav clearfix">%s</ul> ', implode(' ', $tabs));

    echo sprintf('<section id="%s" class="widget">%s <div class="tabs-content">%s</div></section>', $sidebar_id, $tabs_nav, implode(' ', $tabs_content));
}

function handleMyAddonTabs($args){
    $countTabs = isset($args['tabs']) ? (int)$args['tabs'] : 2;
    my_addon_dynamic_sidebar('my-addon-tabs-area',$countTabs);
}

add_shortcode( 'myaddon_tabs', 'handleMyAddonTabs' );