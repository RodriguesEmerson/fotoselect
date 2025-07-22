<?php 

namespace App\Utils;

use DateTime;
use DateTimeZone;

class Utilitaries{
   /**
    * Returns the current date and time formatted according to the specified timezone.
    * @param string $timezone The timezone to use (default: 'America/Sao_Paulo').
    *                         Must be a valid PHP timezone identifier.
    * @return string The current date and time in the format 'Y-m-d H:i:s'.
    */
   public static function getDateTime(string $timezone = 'America/Sao_Paulo'){
      $timeZone = new DateTimeZone($timezone);
      $date = new DateTime('now', $timeZone);
      return $date->format('Y-m-d H:i:s');
   }

   /**
    * Increases the current date by a given number of days.
    * @param string $daysToIncrease The number of days to add. Can be a numeric string (e.g., "5").
    * @return string The resulting date in the format 'Y-m-d'.
    */
   public static function increaseDate(string $daysToIncrease):string{
      $today = new DateTime(self::getDateTime());

      $increasedDate = $today->modify("+$daysToIncrease day")->format('Y-m-d');
      return $increasedDate;
   }
}