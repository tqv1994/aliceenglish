<?php

class SeasonsShell extends MvcShell
{

    public function init()
    {
        $this->load_model('Season');
    }

    // This get data from api to update into database; it can be run using "wpmvc seasons get_data_from_api"
    public function get_data_from_api()
    {
        $apiKey = get_option('api_football_key', false);
        $apiUrl = get_option('api_football_url', false);
        $url = "https://$apiUrl/leagues/seasons";
        $args = array(
            'headers' => [
                "x-rapidapi-key" => $apiKey,
                "x-rapidapi-host" => $apiUrl
            ],
        );
        $response = wp_remote_get($url, $args);
        $data = json_decode($response['body']);
//        $this->out(json_encode($data->response));
        if (is_array($data->response)) {
            foreach ($data->response as $item) {
                $season = $this->Season->find_one_by_year($item);
                if (is_null($season)) {
                    $this->Season->create([
                        'season_id' => '',
                        'year' => $item,
                    ]);
                }
            }
        }
        $this->out('Successfully get data from api');
    }
}