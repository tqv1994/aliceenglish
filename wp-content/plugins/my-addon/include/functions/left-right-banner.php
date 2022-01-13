<?php
    add_action('generate_after_footer_content','add_left_right_banner',10,5);
    function add_left_right_banner(){
        ob_start(); ?>
            <div class="left-right-banner fixed" style="top:0">
                <div class="container">
                    <div id="background-left" class="left">
                        <a href="#" target="_blank"><img src="https://foxbookies.com/vi-vn/wp-content/uploads/sites/4/2022/01/left-banner.jpg"></a>
                    </div>
                    <div id="background-right" class="right">
                        <a href="#" target="_blank"><img src="https://foxbookies.com/vi-vn/wp-content/uploads/sites/4/2022/01/right-banner.jpg"></a>
                    </div>
                </div>
            </div>
        <?php
        $html = ob_get_clean();
        echo $html;
    }
?>

