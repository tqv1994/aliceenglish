<?php

class OddsShell extends MvcShell
{

    public function init()
    {
        $this->load_model('Odd');
    }

    // This get data from api to update into database; it can be run using "wpmvc odds get_data_from_api"
    public function get_data_from_api()
    {
        $apiKey = get_option('api_football_key', false);
        $apiUrl = get_option('api_football_url', false);
        $url = "https://$apiUrl/odds?date=".date('Y-m-d');
        $args = array(
            'headers' => [
                "x-rapidapi-key" => $apiKey,
                "x-rapidapi-host" => $apiUrl
            ],
        );
        $response = wp_remote_get($url, $args);
        //$this->out($response['body']);
        $data = json_decode($response['body']);
        if (is_array($data->response)) {
            foreach ($data->response as $item) {
                $odd = $this->Odd->find_one_by_fixture_id($item->fixture->id);
                if (is_null($odd)) {
                    $this->Odd->create([
                        'fixture_id' => $item->fixture->id,
                        'data' => serialize($item),
                    ]);
                }
            }
        }
        $this->out('Successfully get data from api');
    }
}