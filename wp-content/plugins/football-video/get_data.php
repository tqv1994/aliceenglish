<?php
$footballVideoModel = mvc_model('FootballVideo');
$apiKey = get_option('api_football_key', false);
$apiUrl = get_option('api_football_url', false);
$url = "https://www.scorebat.com/video-api/v3/";
$response = wp_remote_get($url);
$data = json_decode($response['body']);
if (isset($data->response) && is_array($data->response)) {
    foreach ($data->response as $item) {
        $video = $footballVideoModel->find_one_by_matchviewUrl($item->matchviewUrl);
        if (is_null($video) || empty($video)) {
            $footballVideoModel->create(
                [
                    'title' => $item->title,
                    'competition' => $item->competition,
                    'competitionUrl' => $item->competitionUrl,
                    'thumbnail' => $item->thumbnail,
                    'data_date' => date('Y-m-d H:i:s',strtotime($item->date)),
                    'videos' => serialize($item->videos),
                    'matchviewUrl' => $item->matchviewUrl
                ]
            );
        }
    }
}
?>