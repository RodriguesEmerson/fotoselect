<?php 

namespace App\Utils;

use DateTime;
use Exception;
use InvalidArgumentException;

class Validators{

   /**
    * Validate date format Year-month-day.
    * @param string $date The date to check.
    * @return bool True if is valid or False if is a invalid date.
    */
   public static function validateDateYMD(string $date):bool{
      $formatedDate = DateTime::createFromFormat('Y-m-d', $date);
      return $formatedDate && $formatedDate->format('Y-m-d') === $date;
   }

   /**
    * Validate the email format.
    * @param string $email The email to be checked.
    * @throws InvalidArgumentException if is a invalid amail.
    * @return bool True if is a valid amail.
    */
   public static function validateEmail(string $email):bool{
      if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
         throw new InvalidArgumentException("Invalid email");
      }
      return true;
   }

   /**
    * Validate Password format. Checks if it is a string and if it has at least 8 characters long.
    * @param mixed $password Password to check.
    * @throws InvalidArgumentException if the password isn't a string or has less the 8 characters long.
    * @return bool True if the password has a valid format.
    */
   public static function validatePasswordFormat($password):bool{
      if(!is_string($password)){
         throw new InvalidArgumentException("Invalid password format.");
      }
      if(strlen($password) < 8){
         throw new InvalidArgumentException("Password must be at least 8 characters long.");
      }

      return true;
   }

   /**
    * Validate if is a string and if it is between the min and the max params sent.
    * @param mixed $string The string to be cheked.
    * @param int $min The min length the string must to be.
    * @param int $max The max length the string must to be.
    * @return bool True wheather it meets the requirements or False if not.
    */
   public static function validateString($string, int $min, int $max):bool{
      if(!is_string($string))return false;

      if(strlen($string) < $min || strlen($string) > $max) return false;

      return true;
   }
}