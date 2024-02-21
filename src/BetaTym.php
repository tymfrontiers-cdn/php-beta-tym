<?php
namespace TymFrontiers{

  class BetaTym{
    # default tym format strings
    const MYSQL_DATETYM_STRING    = "Y-m-d H:i:s"; # MySQL tym format
    const MYSQL_DATETIME_STRING    = "Y-m-d H:i:s"; # MySQL tym format
    const SHORT_WEEK_DAY          =	"D"; # Sun through Sat
    const FULL_WEEK_DAY           =	"l"; # Sunday through Saturday
    const DAY_LEADING_ZERO        =	"d"; # 01 to 31
    const DAY                     =	"j"; # 1 to 31
    const DAY_OF_YEAR_WITH        = "z"; # 001 to 366
    const WEEK_DAY_NUMBER         = "N"; # 1 (for Monday) though 7 (for Sunday)
    const WEEK_OF_YEAR            = "W"; # 13 (for the 13th full week of the year)
    const SHORT_MONTH_NAME        = "M"; # Jan through Dec
    const MONTH_NAME              = "F"; # January through December
    const MONTH_NUMBER            = "m"; # 01 (for January) through 12 (for December)
    const YEAR                    = "Y"; # Example: 2038
    const SHORT_YEAR_NUMBER       = "y"; # Example: 09 for 2009, 79 for 1979
    const FULL_HOUR               = "H"; # 00 through 23
    const HALF_HOUR               = "g"; # 1 through 12
    const MINUTE                  = "i"; # 00 through 59
    const AM_PM                   = "A"; # Example: AM for 00:31, PM for 22:23
    const SECOND                  = "s"; # 00 through 59
    # for more options reffer to PHP website >> http://php.net/manual/en/function.date.php

    public static function now () {
      return \date(self::MYSQL_DATETYM_STRING,\time());
    }
    public static function get (string $format,$tym=''){
      # get datetym format from given datetym string.
      $unix = !empty($tym) ? self::seconds($tym) : \time();
      return \date( $format, \strtotime($unix)  );
    }
    public static function day($dateTym=""){
      # nice day writing format e.g 21st
      $unix = !empty($dateTym) ? self::seconds($dateTym) : \time();
      $day = \date(self::DAY, $unix);
      if( \in_array($day,['1','21','31']) ){
        $day = $day.'st';
      }elseif( \in_array($day,['3','23']) ){
        $day = $day.'rd';
      }elseif( \in_array($day,['2','22']) ){
        $day = $day.'nd';
      }else{
        $day = $day.'th';
      }
      return $day;
    }
    public static function month($dateTym="", bool $short_form=false){
      # e.g January
      $filter = $short_form ? self::SHORT_MONTH_NAME : self::MONTH_NAME;
      $unix = !empty($dateTym) ? self::seconds($dateTym) : \time();
      return \date($filter, $unix);
    }
    public static function year($dateTym="", bool $short_form=false){
      # e.g 2018
      $unix = !empty($dateTym) ? self::seconds($dateTym) : \time();
      $filter = $short_form ? self::SHORT_YEAR_NUMBER : self::YEAR;
      return \date($filter, $unix);
    }
    public static function hour( string $dateTym="", bool $hour_12=false){
      $unix = !empty($dateTym) ? self::seconds($dateTym) : \time();
      $hour = (bool)$hour_12 ?
      \date(self::HALF_HOUR, $unix) :
      \date(self::FULL_HOUR, $unix);
      return $hour;
    }

    public static function monthDay( string $dateTym='', bool $short_form=false){
      # e.g April 7th
      return self::month($dateTym,$short_form).' '.self::day($dateTym);
    }
    public static function MDY(string $dateTym='', bool $short_form=false){
      return self::monthDay($dateTym,$short_form).', '.self::year($dateTym,$short_form);
    }
    public static function  HMS(string $dateTym=""){
      $unix = !empty($dateTym) ? self::seconds($dateTym) : \time();
      return self::hour($dateTym).':'.\date(self::MINUTE.':'.self::SECOND, $unix);
    }
    public static function dateTym($dateTym=""){
      return self::MDY($dateTym).' at '.self::HMS($dateTym);
    }
    public static function week($dateTym=""){
      $unix = !empty($dateTym) ? self::seconds($dateTym) : \time();
      return \date(self::WEEK_OF_YEAR, $unix);
    }
    public static function weekDay($dateTym="",bool $short_form=false){
      $unix = !empty($dateTym) ? self::seconds($dateTym) : \time();
      $filter = !$short_form ? self::FULL_WEEK_DAY : self::SHORT_WEEK_DAY;
      return \date($filter, $unix);
    }
    public static function weekDateTym($dateTym="", bool $short_form=false){
      return self::weekDay($dateTym,$short_form).', '.self::day($dateTym).' '.self::month($dateTym,$short_form).' '.self::year($dateTym);
    }
    public static function seconds ($tym) {
      $return;
      if ($return = \strtotime($tym)) {
        return $return;
      } else if ((int)$tym > 0) {
        return $tym;
      } else {
        throw new \Exception("Invalid time argument parsed.", 1);
      }
    }
  }

}
namespace{
  function tym() {
    return \time();
  }
}
