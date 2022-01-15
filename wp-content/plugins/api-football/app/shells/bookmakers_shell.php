<?php

class BookmakersShell extends MvcShell
{

    public function init()
    {
        $this->load_model('Bookmaker');
    }

    // This get data from api to update into database; it can be run using "wpmvc bookmakers get_data_from_api"
    public function get_data_from_api()
    {
        $apiKey = get_option('api_football_key', false);
        $apiUrl = get_option('api_football_url', false);
        $url = "https://$apiUrl/odds/bookmakers";
        $args = array(
            'headers' => [
                "x-rapidapi-key" => $apiKey,
                "x-rapidapi-host" => $apiUrl
            ],
        );
        $response = wp_remote_get($url, $args);
        $data = json_decode($response['body']);
        if (is_array($data->response)) {
            foreach ($data->response as $item) {
                $bookmaker = $this->Bookmaker->find_one_by_bookmaker_id($item->id);
                $this->out(json_encode($bookmaker));
                if (is_null($bookmaker)) {
                    $this->Bookmaker->create(['bookmaker_id' => $item->id, 'name' => $item->name]);
                }
            }
        }
        $this->out('Successfully get data from api');
    }
}