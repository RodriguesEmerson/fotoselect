<?php 

namespace App\Utils;

abstract class PDOExeptionErrors{
   private static array $errosCodes = [
      '23000' => ['error' => "This email already exists.", 'status' => 400],
   ];

   /**
    * Based on a list of codes, returns the apropriate error message and code.
    * @param string $sentCode The error code.
    * @return array{message: string, status: int}
    */
   public static function getErrorBasedOnCode(string $sentCode){
      switch ($sentCode) {
         case '23000':
            return self::$errosCodes['23000'];
            break;
         default:
            return ['error' => 'Internal server error', 'status' => 500];
            break;
      }
   }
}