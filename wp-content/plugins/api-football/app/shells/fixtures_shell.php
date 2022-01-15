<?php

class FixturesShell extends MvcShell
{

    public function init()
    {
        $this->load_model('Fixture');
    }

    // This get data from api to update into database; it can be run using "wpmvc bookmakers get_data_from_api"
    public function get_data_from_api()
    {
        $apiKey = get_option('api_football_key', false);
        $apiUrl = get_option('api_football_url', false);
        $url = "https://$apiUrl/fixtures?live=all";
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
                $fixture = $this->Fixture->find_one_by_fixture_id($item->fixture->id);
                if (is_null($fixture)) {
                    $this->Fixture->create([
                        'fixture_id' => $item->fixture->id,
                        'timezone' => $item->fixture->timezone,
                        'date' => $item->fixture->date,
                        'timestamp' => $item->fixture->timestamp,
                        'data' => serialize([
                            'fixture' => $item->fixture,
                            'league' => $item->league,
                            'teams' => $item->teams,
                            'goals' => $item->goals,
                            'score' => $item->score
                        ])
                    ]);
                }
            }
        }
        $this->out('Successfully get data from api');
    }
}