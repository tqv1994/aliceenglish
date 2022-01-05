<?php
class MyAddon_Tabs_Widget extends WP_Widget {
    /**
     * Thiết lập widget: đặt tên, base ID
     */
    function __construct() {
        parent::__construct (
            'my_addon_tabs_widget', // id của widget
            'My Addon Tabs Widget', // tên của widget
      array(
          'description' => 'Hiển thị thành các tab' // mô tả
      )
    );
    }
    /**
     * Tạo form option cho widget
     */
    function form( $instance ) {
        //Biến tạo các giá trị mặc định trong form
        $default = array(
            "title" => "Tiêu đề tab",
            "url" => '',
            "content" => ""
        );
        $instance = wp_parse_args( (array) $instance, $default);
        $title = esc_attr( $instance["title"] );
        $url = esc_attr( $instance["url"] );
        $content = esc_attr( $instance["content"] );
        //Hiển thị form trong option của widget
        echo '<p>Nhập tiêu đề <input class="widefat" type="text" name="'.$this->get_field_name('title').'" value="'.$title.'" /></p>';
        echo '<p>Nhập URL Tab <input class="widefat" type="text" name="'.$this->get_field_name('url').'" value="'.$url.'" /></p>';
        echo '<p>Nhập Nội dung <textarea class="widefat" name="'.$this->get_field_name('content').'">'.$content.'</textarea></p>';
    }

    /**
     * save widget form
     */


    function update( $new_instance, $old_instance ) {
        parent::update( $new_instance, $old_instance );
        $instance = $old_instance;
        $instance["title"] = strip_tags($new_instance["title"]);
        $instance["url"] = strip_tags($new_instance["url"]);
        $instance["content"] = $new_instance["content"];
        return $instance;
    }

    /**
     * Show widget
     */

    function widget( $args, $instance ) {
        extract( $args );
        $title = apply_filters( "widget_title", $instance["title"] );
        $content = $instance['content'];
        $url = $instance['url'];

        echo $before_widget;
        //In tiêu đề widget
        echo $before_title."<a href='$url'>".$title."</a>".$after_title;
        if(strpos(get_permalink(),$url)!== false){
            // Nội dung trong widget
            echo "<div>$content</div>";
        }

        // Kết thúc nội dung trong widget
        echo $after_widget;
    }

}

add_action( 'widgets_init', 'create_my_addon_tabs_widget' );
function create_my_addon_tabs_widget() {
    register_widget('MyAddon_Tabs_Widget');
}