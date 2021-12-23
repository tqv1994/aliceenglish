<?php
function handleQuayThuXoSoMienNam($args){
    $date = isset($args['date']) ? $args['date'] : date('Y-m-d');
    $tryLottery = new TryLottery();
    $prizes = [];
    $prizesDongNai = $tryLottery->getQuayThuXSTDByDate('DN',$date);
    $prizesCanTho = $tryLottery->getQuayThuXSTDByDate('CT',$date);
    $prizesSocTrang = $tryLottery->getQuayThuXSTDByDate('ST',$date);
    $positionPrize = 0;
    for($i = 0; $i <= 8; $i++){
        foreach ($prizesDongNai as $numberPrize) {
            $prizes[$i][0][$positionPrize] = $numberPrize;
            $positionPrize++;
        }
        foreach ($prizesCanTho as $numberPrize){
            $prizes[$i][1][$positionPrize] = $numberPrize;
            $positionPrize++;
        }
        foreach ($prizesSocTrang as $numberPrize){
            $prizes[$i][2][$positionPrize] = $numberPrize;
            $positionPrize++;
        }
    }

//    $prizes = [
//        [[0], [1], [2]],
//        [[3], [4], [5]],
//        [[6, 7, 8],[9, 10, 11],[12, 13, 14]],
//        [[15], [16], [17]],
//        [[18, 19, 20, 21, 22, 23, 24],[25, 26, 27, 28, 29, 30, 31],[32, 33, 34, 35, 36, 37, 38]],
//        [[39, 40],[41, 42],[43, 44]],
//        [[45], [46], [47]],
//        [[48], [49], [50]],
//        [[51], [52], [53]],
//    ];
    ob_start(); ?>
    <section id="bangkq_xsmn">
        <div class="click-test">
            <a href="javascript:void(0)" id="turn"><span class="change-color">NHẤP QUAY THỬ XSMN</span></a>
        </div>
        <header>
            <h2 class="title-header color-h2">Kết quả quay thử xổ số Miền Nam <span class="color-black"> <?=date('d/m/Y')?></span></h2>
        </header>
        <div class="block-main-content">
            <table class="table table-striped table-xsmn" id="table-xsmn">
                <thead>
                <tr>
                    <th class="text-center" style="font-weight: normal;">Giải</th>

                    <th class="text-center col3">
                        <a href="/quay-thu-xsvt.html">Vũng Tàu</a>
                    </th>

                    <th class="text-center col3">
                        <a href="/quay-thu-xsbtr.html">Bến Tre</a>
                    </th>

                    <th class="text-center col3">
                        <a href="/quay-thu-xsbl.html">Bạc Liêu</a>
                    </th>

                </tr>
                </thead>
                <tbody>
                <?php foreach ($prizes as $key => $cols): ?>
                <tr>
                    <td>G.<?=(count($prizes)-$key - 1) > 0 ? count($prizes)-$key - 1 : 'ĐB'?></td>
                    <?php foreach ($cols as $col => $items): ?>
                        <td>
                            <?php foreach($items as $item => $value): ?>
                            <span class="col-xs-12 <?= $key == 0 || $key == 8 ? 'special-prize-mn' : 'number-black-bold'?> div-horizontal" id="mn_prize_<?=$item?>"  data="0">
                                <?=$value?>
                            </span>
                            <?php endforeach; ?>
                        </td>
                    <?php endforeach; ?>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <table class="table table-number text-center mar-top">
                <tbody>
                <tr>
                    <td class="text-center" colspan="10">
                        <form>
                            <div class="radio-stick">
                                <input type="radio" onclick="xsdp.choice(1, 0)" name="select-option" checked>
                                <label for="full">Đầy đủ </label>
                            </div>
                            <div class="radio-stick">
                                <input type="radio" onclick="xsdp.choice(1, 2)" name="select-option">
                                <label for="2so">2 số </label>
                            </div>
                            <div class="radio-stick">
                                <input type="radio" onclick="xsdp.choice(1, 3)" name="select-option">
                                <label for="3so">3 số </label>
                            </div>
                        </form>
                    </td>
                </tr>
                <tr class="bg-tr" id="hover-number" data="xsmn">
                    <td>0</td>
                    <td>1</td>
                    <td>2</td>
                    <td>3</td>
                    <td>4</td>
                    <td>5</td>
                    <td>6</td>
                    <td>7</td>
                    <td>8</td>
                    <td>9</td>
                </tr>
                </tbody>
            </table>
        </div>
    </section>
    <?php
    $html = ob_get_clean();
    echo $html;
}
add_shortcode( 'sc_quay_thu_xsmn', 'handleQuayThuXoSoMienNam' );