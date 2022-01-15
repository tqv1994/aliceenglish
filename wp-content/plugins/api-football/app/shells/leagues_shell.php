<?php

class LeaguesShell extends MvcShell
{

    public function init()
    {
        $this->load_model('League');
    }

    // This get data from api to update into database; it can be run using "wpmvc leagues get_data_from_api"
    public function get_data_from_api()
    {
        $apiKey = get_option('api_football_key', false);
        $apiUrl = get_option('api_football_url', false);
        $url = "https://$apiUrl/leagues";
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
                $league = $this->League->find_one_by_league_id($item->league->id);
                $this->out(json_encode($league));
                if (is_null($league)) {
                    $this->League->create([
                        'league_id' => $item->league->id,
                        'name' => $item->league->name,
                        'type' => $item->league->type,
                        'logo' => $item->league->logo,
                        'data' => serialize([
                            'country' => $item->country,
                            'seasons' => $item->seasons
                        ])
                    ]);
                }
            }
        }
        $this->out('Successfully get data from api');
    }
}