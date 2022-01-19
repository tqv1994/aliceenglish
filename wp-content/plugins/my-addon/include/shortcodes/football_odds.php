<?php
/**
 * @param $args [menuId]
 */
function handleFootballOdds($args){
    $fixture_model =  mvc_model('Fixture');
    $odd_model = mvc_model('Odd');
    $result = [];
    $odds = $odd_model->find();
    foreach ($odds as $odd) {
        $dataOdd = unserialize($odd->data);
        var_dump($odd->data);
        break;
    }
    $fixtures = $fixture_model->find(['conditions'=>['active'=>1]]);
    foreach ($fixtures as $fixture){
        $data = unserialize($fixture->data);
        $odd = $odd_model->find_one_by_fixture_id($fixture->fixture_id);
        if($odd){
            $dataOdd = unserialize($odd->data);
            $bookmakers = $dataOdd->bookmakers;
        }
        $item = [
            'fixture_id' => $fixture->fixture_id,
            'time' => convertDateTime(date('Y-m-d H:i:s',$fixture->timestamp),'Y-m-d H:i:s',$fixture->timezone),
            'teams' => $data['teams'],
            'score' => $data['score'],
            'season' => $data['league'],
            'bookmakers' => $bookmakers
        ];
        $result[$data['league']->name][] = $item;
    }
    ob_start(); ?>
    <div class="my-addon-football-odds">
        <?php foreach ($result as $key => $fixtures): ?>
        <div class="season-wrap">
            <h3><?=$key?></h3>
            <div class="tabs">
                <?php foreach($fixtures as $keyFix => $fixture): ?>
                <div class="tab">
                    <input type="checkbox" id="footbal-odd-<?=$key?>-<?=$keyFix?>">
                    <label class="tab-label" for="footbal-odd-<?=$key?>-<?=$keyFix?>">
                        <span><?=$fixture['time']?></span>
                        <span>
                            <?=$fixture['teams']->home->name?><br/>
                            <?=$fixture['teams']->away->name?>
                        </span>
                    </label>
                    <div class="tab-content">
                        <pre>
                        </pre>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endforeach;?>
    </div>
    <?php
    $html = ob_get_clean();
    echo $html;
}

function convertDateTime($date, $format = 'Y-m-d H:i:s',$timeZone="UTC")
{
    $tz1 = $timeZone;
    $tz2 = 'Asia/Ho_Chi_Minh'; // UTC +7

    $d = new DateTime($date, new DateTimeZone($tz1));
    $d->setTimeZone(new DateTimeZone($tz2));

    return $d->format($format);
}
add_shortcode( 'myaddon_football_odds', 'handleFootballOdds' );