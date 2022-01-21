<?php
/**
 * @param $args [menuId]
 */
function handleFootballPlayList($atts){
    $title = '';
    $attr = shortcode_atts( array(
        'title' => '',
    ), $atts );
    $footballVideo = mvc_model('FootballVideo');
    $data = $footballVideo->find([
        'conditions' => [
            'data_date >=' => date('Y-m-d 00:00:00'),
            'data_date <=' => date('Y-m-d 23:59:59')
        ]
    ]);
    $results = [];
    $embeds = [];
    foreach ($data as $item){
        $videos = unserialize($item->videos);
        foreach ($videos as $key => $video){
            preg_match('/(?<=src=\').*?(?=[\?\'])/',$video->embed, $match);
            $url = $match[0];
            $results[] = [
                'title' => $item->title.' '.(count($videos) > 1 ? $key+1 : ''),
                'competition' => $video->competition,
                'thumbnail' => $video->thumbnail,
                'embed' => $url
            ];
            $embeds[] = $url;
        }

    }
    ob_start(); ?>
    <div class="vid-main-wrapper clearfix">
        <!-- THE YOUTUBE PLAYER -->
        <div class="vid-container">
            <iframe id="vid_frame" src="<?=$results[0]['embed']?>" frameborder="0" width="560" height="315"></iframe>
        </div>

        <!-- THE PLAYLIST -->
        <div class="vid-list-container">
            <ol id="vid-list">
                <?php foreach ($results as $video): ?>
                <li>
                    <a href="javascript:void();" onClick="document.getElementById('vid_frame').src='<?=$video['embed']?>'">
                        <span class="vid-thumb"><img width=72 src="<?=$video['thumbnail']?>" /></span>
                        <div class="desc"><?=$video['title']?></div>
                    </a>
                </li>
                <?php endforeach; ?>
                </ol>
        </div>

    </div>
    <?php
    $html = ob_get_clean();
    echo $html;
    wp_register_style('mvc_football_video', mvc_css_url('football-video', 'style'),10);
    wp_enqueue_style('mvc_football_video');
    wp_register_script('mvc_football_video_js', mvc_js_url('football-video', 'script'),array( 'jquery' ));
    wp_enqueue_script('mvc_football_video_js');
    wp_register_script('jquery_nicescroll','https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.6.8-fix/jquery.nicescroll.min.js',array( 'jquery' ));
    wp_enqueue_script('jquery_nicescroll');
}
add_shortcode( 'football_play_list', 'handleFootballPlayList' );