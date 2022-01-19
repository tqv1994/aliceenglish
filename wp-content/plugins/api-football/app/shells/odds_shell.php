<?php

class OddsShell extends MvcShell
{

    public function init()
    {
        $this->load_model('Odd');
        $this->load_model('Fixture');
        $this->load_model('OddBet');
    }

    // This get data from api to update into database; it can be run using "wpmvc odds get_data_from_api"
    public function get_data_from_api($args)
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
                $urlFixture = "https://$apiUrl/fixtures?id=".$item->fixture_id;
                $responseFixture = wp_remote_get($urlFixture, $args);
                $fitureRes = null;
                if(is_array($responseFixture)){
                    $fitureRes = $responseFixture[0];
                }
                if($fitureRes){
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
                            ]),
                            'active' => 0
                        ]);
                    }else{
                        $this->Fixture->update($fixture->__id,[
                            'timezone' => $item->fixture->timezone,
                            'date' => $item->fixture->date,
                            'timestamp' => $item->fixture->timestamp,
                            'data' => serialize([
                                'fixture' => $item->fixture,
                                'league' => $item->league,
                                'teams' => $item->teams,
                                'goals' => $item->goals,
                                'score' => $item->score
                            ]),
                            'active' => 0
                        ]);
                    }
                }

                $odd = $this->Odd->find_one_by_fixture_id($item->fixture->id);
                if (is_null($odd)) {
                    $odd = $this->Odd->create([
                        'fixture_id' => $item->fixture->id,
                        'data' => serialize(['fixture'=>$item->fixture]),
                    ]);
                    if(is_array($item->bookmakers)){
                        foreach ($item->bookmakers as $bookmaker){
                            foreach ($bookmaker->bets as $bet){
                                $this->OddBet->create([
                                    'bookmaker_id' => $bookmaker->id,
                                    'name' => $bookmaker->name,
                                    'bet_id' => $bet->id,
                                    'data' => serialize($bet->values),
                                    'odd_id' => $this->Odd->insert_id
                                ]);
                            }

                        }
                    }
                }else{
                    $this->Odd->update($odd->__id,[
                        'fixture_id' => $item->fixture->id,
                        'data' => serialize(['fixture'=>$item->fixture]),
                    ]);
                    if(is_array($item->bookmakers)){
                        foreach ($item->bookmakers as $bookmaker){
                            foreach ($bookmaker->bets as $bet){
                                $oddBet = $this->OddBet->find_one(
                                    [
                                        'bookmaker_id'=>$bookmaker->id,
                                        'bet_id' => $bet->id,
                                        'odd_id' => $odd->__id
                                    ]
                                );
                                if($oddBet){
                                    $this->OddBet->update($oddBet->__id,[
                                        'data' => serialize($bet->values),
                                    ]);
                                }
                            }
                        }
                    }
                }
            }
        }
        $this->out('Successfully get data from api');
    }
}