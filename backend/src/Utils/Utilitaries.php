<?php 

namespace App\Utils;

use DateTime;
use DateTimeZone;

class Utilitaries{

   public static function getDateTime(string $timezone = 'America/Sao_Paulo'){
      $timeZone = new DateTimeZone($timezone);
      $date = new DateTime('now', $timeZone);
      return $date->format('Y-m-d H:i:s');
   }
}