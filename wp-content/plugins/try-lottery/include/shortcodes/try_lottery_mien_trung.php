<?php
function handleQuayThuXoSoMienTrung($args){
    $prizes = [
        [[0], [1]],
        [[2], [3]],
        [[4, 5, 6],[7, 8, 9]],
        [[10], [11]],
        [[12, 13, 14, 15, 16, 17, 18],[19, 20, 21, 22, 23, 24, 25]],
        [[26, 27],[28, 29]],
        [[30], [31]],
        [[32], [33]],
        [[34], [35]],
    ];
    ob_start(); ?>
    <section id="bangkq_xsmt">
        <div class="click-test">
            <a href="javascript:void(0)" id="turn"><span class="change-color">NHẤP QUAY THỬ XSMT</span></a>
        </div>
        <header>
            <h2 class="title-header color-h2">Kết quả quay thử xổ số Miền Trung <span class="color-black"> <?=date('d/m/Y')?></span></h2>
        </header>
        <div class="block-main-content">
            <table class="table table-striped table-xsmn" id="table-xsmt">
                <thead>
                <tr>
                    <th class="text-center" style="font-weight: normal;">Giải</th>

                    <th class="text-center col2">
                        <a href="javascript:void(0);">Đắk Lắk</a>
                    </th>

                    <th class="text-center col2">
                        <a href="javascript:void(0)">Quảng Nam</a>
                    </th>

                </tr>
                </thead>
                <tbody>
                <?php foreach ($prizes as $key => $cols): ?>
                    <tr>
                        <td>G.<?=(count($prizes)-$key - 1) > 0 ? count($prizes)-$key - 1 : 'ĐB'?></td>
                        <?php foreach ($cols as $col => $items): ?>
                            <td>
                                <?php foreach($items as $item): ?>
                                    <span class="col-xs-12 <?= $key == 0 || $key == 8 ? 'special-prize-mn' : 'number-black-bold'?> div-horizontal" id="mt_prize_<?=$item?>"  data="0">
                                <img src="<?=TRY_LOTTERY_DIR_ASSETS_URL ?>/images/load.gif" class="img-loading" alt="loading"/>
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
                                <input type="radio" onclick="xsdp.choice(2, 0)" name="select-option" checked>
                                <label for="full">Đầy đủ </label>
                            </div>
                            <div class="radio-stick">
                                <input type="radio" onclick="xsdp.choice(2, 2)" name="select-option">
                                <label for="2so">2 số </label>
                            </div>
                            <div class="radio-stick">
                                <input type="radio" onclick="xsdp.choice(2, 3)" name="select-option">
                                <label for="3so">3 số </label>
                            </div>
                        </form>
                    </td>
                </tr>
                <tr class="bg-tr" id="hover-number" data="xsmt">
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
add_shortcode( 'sc_quay_thu_xsmt', 'handleQuayThuXoSoMienTrung' );