<?php
class DatetimeHelper extends MvcHelper {

    public static function convertDateTime($date, $format = 'Y-m-d H:i:s',$timeZone="UTC")
    {
        $tz1 = $timeZone;
        $tz2 = 'Asia/Ho_Chi_Minh'; // UTC +7

        $d = new DateTime($date, new DateTimeZone($tz1));
        $d->setTimeZone(new DateTimeZone($tz2));

        return $d->format($format);
    }

}