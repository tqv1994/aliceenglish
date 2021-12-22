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
        for($i = 3; $i <= 6; $i++){
            $result[2][$i] = $this->getRandomString(4);
        }
        $result[3] = [7=>$this->getRandomString(4)];
        $result[4] = [];
        for ($i = 8; $i<=15;$i++){
            $result[4][$i] = $this->getRandomString(5);
        }
        $result[5] = [];
        for ($i = 16; $i<=17;$i++){
            $result[5][$i] = $this->getRandomString(5);
        }
        $result[6] = [18 => $this->getRandomString(5)];
        $result[7] = [19 => $this->getRandomString(5)];
        $result[8] = [20 => $this->getRandomString(6)];
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
     * @param $lotteryCode string // Mã Đài: DN | CT | ST | KH | DNA
     * @param $date string //format: Y-m-d
     */
    public function getQuayThuXSTDByDate($lotteryCode,$date){
        $result = get_option("tryLottery{$lotteryCode}_{$date}",null);
        if(is_null($result)){
            $result = serialize($this->getRandomXSMB());
            add_option("tryLottery{$lotteryCode}_{$date}",$result);
        }
        return unserialize($result);
    }
}