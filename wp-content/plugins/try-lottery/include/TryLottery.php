<?php
class TryLottery{
    private function getRandomString($len) {
    $number = '';
        for ($i = 0; $i < $len; $i++) {
            $number .= (string)rand(0,9);
        }
        return $number;
    }

    public function getRandomXSMB(){
        $result = [];
        $result['ĐB'] = [26 => $this->getRandomString(5)];
        $result['G1'] = [0 => $this->getRandomString(5)];
        $result['G2'] = [
            1 => $this->getRandomString(5),
            2 => $this->getRandomString(5)
        ];
        $result['G3'] = [];
        for ($i=3;$i<=8;$i++){
            $result['G3'][$i] = $this->getRandomString(5);
        }
        $result['G4'] = [];
        for ($i=9; $i<=12; $i++){
            $result['G4'][$i] = $this->getRandomString(4);
        }
        $result['G5'] = [];
        for ($i=13; $i<=18; $i++){
            $result['G5'][$i] = $this->getRandomString(4);
        }
        $result['G6'] = [];
        for ($i=19; $i<=21; $i++){
            $result['G6'][$i] = $this->getRandomString(3);
        }
        $result['G7'] = [];
        for ($i=22; $i<=25; $i++){
            $result['G7'][$i] = $this->getRandomString(2);
        }
        return $result;
    }

    // Lấy ngẫu nhiên kết quả xổ số theo đài
    public function getRandomXSTD(){
        $result = [];
        $result[0] = [0 => $this->getRandomString(2)];
        $result[1] = [1 => $this->getRandomString(3)];
        $result[2] = [];
        for($i = 3; $i < 6; $i++){
            $result[2][$i] = $this->getRandomString(4);
        }
        $result[3] = [6=>$this->getRandomString(4)];
        $result[4] = [];
        for ($i = 7; $i<14;$i++){
            $result[4][$i] = $this->getRandomString(5);
        }
        $result[5] = [];
        for ($i = 14; $i<=15;$i++){
            $result[5][$i] = $this->getRandomString(5);
        }
        $result[6] = [16 => $this->getRandomString(5)];
        $result[7] = [17 => $this->getRandomString(5)];
        $result[8] = [18 => $this->getRandomString(6)];
        return $result;
    }

    /**
     * @param $date string //format: Y-m-d
     * @return mixed
     */
    public function getQuayThuXSMBByDate($date){
        $result = get_option("tryLotteryMB_$date",null);
        if(is_null($result)){
            $result = serialize($this->getRandomXSMB());
            add_option("tryLotteryMB_$date",$result);
        }
        return unserialize($result);
    }

    /**
     * @param $lotteryCode string // Mã Đài: HCM | DT | CM | BT | VT | BL | DN | CT | ST |
     * // TN | AG | BTN | VL | BD | TV | LA | BP | HG
     * // TG | KG | DL
     * KH | DNA
     * @param $date string //format: Y-m-d
     */
    public function getQuayThuXSTDByDate($lotteryCode,$date){
        $result = get_option("tryLottery{$lotteryCode}_{$date}",null);
        if(is_null($result)){
            $result = serialize($this->getRandomXSTD());
            add_option("tryLottery{$lotteryCode}_{$date}",$result);
        }else{
            $result = serialize($this->getRandomXSTD());
            update_option("tryLottery{$lotteryCode}_{$date}",$result);
        }
        return unserialize($result);
    }

    public function getCacDaiMienNamByDate($date){
        $result = [
            ['HCM','DT','CM'],
            ['BT','VT','BL'],
            ['DN','CT','ST'],
            ['TN','AG','BTN'],
            ['VL','BD','TV'],
            ['HCM','LA','BP','HG'],
            ['TG','KG','DL']
        ];
        $dayNumber = date('N',strtotime($date)) - 1;
        return $result[$dayNumber];
    }

    public function getCacDaiMienTrungByDate($date){
        $result = [
            ['PY','TTH'],
            ['DLC','QN'],
            ['DNN','KH'],
            ['BDN','QB','QT'],
            ['GL','NT'],
            ['DNG','QNG','DNN'],
            ['KH','KT']
        ];
        $dayNumber = date('N',strtotime($date)) - 1;
        return $result[$dayNumber];
    }

    public function getTenDai($code){
        return [
            'HCM' => 'TP Hồ Chí Minh',
            'DT'  => 'Đồng Tháp',
            'CM'  => 'Cà Mau',
            'BT'  => 'Bến Tre',
            'VT'  => 'Vũng Tàu',
            'BL'  => 'Bạc Liêu',
            'DN'  => 'Đồng Nai',
            'CT'  => 'Cần Thơ',
            'ST'  => 'Sóc Trăng',
            'TN'  => 'Tây Ninh',
            'AG'  => 'An Giang',
            'BTN'  => 'Bình Thuận',
            'VL'  => 'Vĩnh Long',
            'BD'  => 'Bình Dương',
            'TV'  => 'Trà Vinh',
            'LA'  => 'Long An',
            'BP'  => 'Bình Phước',
            'HG'  => 'Hậu Giang',
            'TG'  => 'Tiền Giang',
            'KG'  => 'Kiên Giang',
            'DL'  => 'Đà Lạt',
            'PY'  => 'Phú Yên',
            'TTH' => 'Thừa Thiên Huế',
            'DLC'  => 'Đắc LẮc',
            'QN'  => 'Quảng Nam',
            'DNN' => 'Đà Nẵng',
            'KH'  => 'Khánh Hòa',
            'BDN'  => 'Bình Định',
            'QB'  => 'Quảng Bình',
            'QT'  => 'Quảng Trị',
            'GL'  => 'Gia Lai',
            'NT'  => 'Ninh Thuận',
            'DNG'  => 'Đắc Nông',
            'QNG'  => 'Quảng Ngãi',
            'KT'  => 'Kon Tum'
        ][$code] ?: '';
    }
}