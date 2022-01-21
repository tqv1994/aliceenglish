<?php

class FootballVideosShell extends MvcShell
{

    public function init()
    {
        $this->load_model('FootballVideo');
    }

    // This updates the sort_name values of all venues; it can be run using "wpmvc football_videos get_data_from_api"
    public function get_data_from_api()
    {
        $apiKey = get_option('api_football_key', false);
        $apiUrl = get_option('api_football_url', false);
        $url = "https://www.scorebat.com/video-api/v3/";
        $response = wp_remote_get($url);
        $data = json_decode($response['body']);
        if (isset($data->response) && is_array($data->response)) {
            foreach ($data->response as $item) {
                $video = $this->FootballVideo->find_one_by_matchviewUrl($item->matchviewUrl);
                if (is_null($video) || empty($video)) {
                    $this->FootballVideo->create(
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
        $this->out('Successfully get data from api');
    }
}