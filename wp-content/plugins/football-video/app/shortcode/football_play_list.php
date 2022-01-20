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
    $videos = $footballVideo->find([
        'conditions' => [
            'data_date <=' => date('Y-m-d 00:00:00'),
            'data_date >=' => date('Y-m-d 23:59:59')
        ]
    ]);
    ob_start(); ?>
    <div class="player-play-list">
        <div class="container">
            <div class="play-list">
                <div class="options">
                    <h4 class="name-play-list"><?=$title?>></h4>
                    <div class="option">
                        <div class="btn-option order">
                            <span class="title">Shuffle</span>
                            <i class="fa fa-random"></i>
                        </div>
                        <div class="btn-option repeat">
                            <span class="title">Repeat Playlist</span>
                            <i class="fa fa-retweet"></i>
                        </div>
                    </div>
                </div>
                <ul>
                    <?php foreach ($videos as $video): ?>
                    <?php $dataVideo = unserialize($video->data); ?>
                        <?php if(is_array($dataVideo)): ?>
                            <?php foreach ($dataVideo as $key => $item): ?>
                                <li>
                                    <div class="count"></div>
                                    <video class="video-list"></video>
                                    <div class="desc">
                                        <h4 class="video-title"><?=$video->title.' '.(count($dataVideo) > 1 ? $key + 1: '')?></h4>
                                        <p class="video-desc"><?=$video->competition?></p>
                                    </div>
                                    <div class="time"></div>
                                </li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    <?php endforeach; ?>

                </ul>
                <div class="clearfix"></div>
            </div>

            <div class="player">
                <div class="overlay-play">
                    <span><i class="fa fa-play"></i></span>
                </div>
                <div class="overlay-load">
                    <div class="loading">
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>
                <div class="viewEventNow"></div>
                <video class="player-video viewer" preload="auto"></video>

                <div class="show-title-video"></div>

                <div class="player-controls">
                    <div class="progress">
                        <div class="progress-load"></div>
                        <div class="progress-filled">
                            <div class="progress-ball"></div>
                        </div>
                    </div>
                    <div class="screen-move">
                        <video class="video-move"></video>
                        <div class="time-screen"></div>
                    </div>
                    <div class="btnPlay player-button"><i class="fa fa-play"></i></div>
                    <div class="backward player-button"><i class="fa fa-backward"></i></div>
                    <div class="forward player-button"><i class="fa fa-forward"></i></div>
                    <div class="view-next-prev">
                        <video></video>
                        <div class="desc">
                            <h4 class="video-title"></h4>
                            <p class="video-desc"></p>
                        </div>
                        <div class="time"></div>
                    </div>
                    <div class="volume toggle">
                    <span class="icon">
                        <i class="fa fa-volume-up"></i>
                        <i class="fa fa-close"></i>
                    </span>
                        <input type="range" tabindex="-1" name="volume" class="player-slider" min=0 max="1" step="0.05" value="0.5">
                    </div>
                    <div class="time"></div>

                    <div class="player-option">
                        <i class="fa fa-cog button-option"></i>
                        <div class="option-item">

                            <div class="autoplay row">
                                <div class="title">Autoplay</div>
                                <div class="func">
                                    <div class="range-auto"><span></span></div>
                                </div>
                            </div>

                            <div class="speed row">
                                <div class="title-auto title">Speed</div>
                                <div class="range-speed func">
                                    <div class="cover-speed">
                                        <input class="play-back-rate player-slider" type="range" tabindex="-1" name="playbackRate" min="0.5" max="2" step="0.5" value="1">
                                        <div class="show-play-back">0.5</div>
                                    </div>
                                </div>
                            </div>

                            <div class="quality row">
                                <div class="title">Quality</div>
                                <div class="func">
                                    <div class="range-quality"><span>HD</span></div>
                                    <div class="auto-quality"><span class="click-active active">Auto<span></span></span></div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="hide-controls">Hide</div>
                    <div class="button-full-screen player-button"><i class="fa fa-expand"></i></div>
                </div>
            </div>
        </div>
    </div>
    <?php
    $html = ob_end_clean();
}