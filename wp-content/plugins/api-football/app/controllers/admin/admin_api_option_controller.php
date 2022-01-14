<?php
class AdminApiOptionController extends MvcAdminController {
    public function index(){
        if($_POST['api_key']){
            update_option('api_football_key',$_POST['api_key']);
            update_option('api_football_url',$_POST['api_url']);
        }
        $apiKey = get_option('api_football_key',false);
        $apiUrl = get_option('api_football_url',false);
        $this->set(['apiKey'=>$apiKey,'apiUrl'=>$apiUrl]);
        $this->render_view('/admin/api_option/custom');
    }
    public function custom(){
        $apiKey = get_option('api_football_key',false);
        $apiUrl = get_option('api_football_url',false);
        $url = "https://$apiUrl/odds/bets";
        $args = array(
            'headers' => [
                "x-rapidapi-key" => $apiKey,
                "x-rapidapi-host" => $apiUrl
            ],
        );
        $response = wp_remote_get( $url, $args );
        echo $apiKey;
        var_dump(json_decode($response['body'])->response[0]->id);
        die();
    }
}