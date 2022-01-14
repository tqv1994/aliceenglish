<?php

class BetsShell extends MvcShell
{

    public function init()
    {
        $this->load_model('Bet');
    }

    // This updates the sort_name values of all venues; it can be run using "wpmvc venues update_all_sort_names"
    public function get_data_from_api()
    {
        $apiKey = get_option('api_football_key', false);
        $apiUrl = get_option('api_football_url', false);
        $url = "https://$apiUrl/odds/bets";
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
                $bet = $this->Bet->find_one_by_bet_id($item->id);
                $this->out(json_encode($bet));
                if (is_null($bet)) {
                    $this->Bet->create(['bet_id' => $item->id, 'name' => $item->name]);
                }
            }
        }
        $this->out('Successfully get data from api');
    }
}