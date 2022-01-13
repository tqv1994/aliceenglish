<?php
/**
 * @public $tryLottery TryLottery
 */
function handleQuayThuXoSoMienBac($args){
//    $prizes = ['ĐB' => [26],
//        'G.1' => [0],
//        'G.2' => [1,2],
//        'G.3' => [3,4,5,6,7,8],
//        'G.4' => [9,10,11,12],
//        'G.5' => [13,14,15,16,17,18],
//        'G.6' => [19,20,21],
//        'G.7' => [22,23,24,25]
//    ];
    $date = isset($args['date']) ? $args['date'] : date('Y-m-d');
    $tryLottery = new TryLottery();
    $prizes = $tryLottery->getQuayThuXSMB();
    ob_start(); ?>
    <section id="bangkq_xsmb">
        <div class="click-test">
            <a href="javascript:void(0)" id="turn"><span class="change-color">NHẤP QUAY THỬ XSMB</span></a>
        </div>
        <header>
            <h2 class="title-header color-h2">Kết quả quay thử xổ số Miền Bắc <span class="color-black"> <?=date('d/m/Y',strtotime($date))?></span></h2>
        </header>
        <div class="block-main-content">
            <table class="table table-striped table-xsmb" id="table-xsmb">
                <tbody>
                <?php foreach ($prizes as $key => $prizeItems): ?>
                    <tr>
                        <td><?=$key ?></td>
                        <td class="text-center">
                            <?php foreach ($prizeItems as $item => $value): ?>
                                <span class="col-xs-<?= count($prizeItems) == 3 || count($prizeItems) > 4 ? 12 / 3 : 12 / count($prizeItems)   ?> <?= $key == "ĐB" ? 'special-prize-lg no-bor' : 'number-black-bold-mb no-bor-b' ?> div-horizontal" id="mb_prize_<?=$item?>" data="0">
                                <img src="<?=TRY_LOTTERY_DIR_ASSETS_URL?>/images/load.gif" class="img-loading"
                                     alt="loading" />
                            </span>
                            <?php endforeach; ?>
                        </td>
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
                                <input type="radio" onclick="xsdp.choice(0, 0)" name="select-option"
                                       checked>
                                <label for="full">Đầy đủ </label>
                            </div>
                            <div class="radio-stick">
                                <input type="radio" onclick="xsdp.choice(0, 2)" name="select-option">
                                <label for="2so">2 số </label>
                            </div>
                            <div class="radio-stick">
                                <input type="radio" onclick="xsdp.choice(0, 3)" name="select-option">
                                <label for="3so">3 số </label>
                            </div>
                        </form>
                    </td>
                </tr>
                <tr class="bg-tr" id="hover-number" data="xsmb">
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
            <div class="row" style="margin-top: 15px;">
                <div class="col-md-6 col-xs-12">
                    <table class="table firstlast fl text-center mar-top">
                        <thead>
                            <tr class="header">
                                <th >Đầu</th>
                                <th >Đuôi</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php for($i = 0; $i <= 9; $i++): ?>
                            <tr>
                                <td class="clnote"><?=$i?></td>
                                <td style="padding-left: 15px" class=" text-left v-loto-dau-<?=$i?>"></td>
                            </tr>
                        <?php endfor; ?>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-6 col-xs-12">
                    <table class="table firstlast fr text-center mar-top">
                        <thead>
                        <tr class="header">
                            <th >Đầu</th>
                            <th >Đuôi</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php for($i = 0; $i <= 9; $i++): ?>
                            <tr>
                                <td style="padding-right: 15px" class=" text-right v-loto-duoi-<?=$i?>"></td>
                                <td class="clnote"><?=$i?></td>
                            </tr>
                        <?php endfor; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </section>
    <?php
    $html = ob_get_clean();
    echo $html;
}
add_shortcode( 'sc_quay_thu_xsmb', 'handleQuayThuXoSoMienBac' );