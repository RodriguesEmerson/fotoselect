<?php 

namespace App\Services;

abstract class PDOExeptionErrors{
   private static array $errosCodes = ['23000'];

   protected static function getErrorBasedOnCode(string $code){
      foreach(self::$errosCodes AS $code){
         switch ($code) {
            case '23000':
               return ['error' => "This email already exists.", 'status' => 401];
               break;
            
            default:
               return ['error' => 'Internal server error', 'status' => 500];
               break;
         }
      }
   }
}