<?php 

namespace App\Services;

abstract class PDOExeptionErrors{
   private static array $errosCodes = [
      '23000' => ['error' => "This email already exists.", 'status' => 400],
      '23000GALERYCREATE' => ['error' => "The galery name already exists.", 'status' => 400],
   ];

   protected static function getErrorBasedOnCode(string $sentCode){
      switch ($sentCode) {
         case '23000':
            return self::$errosCodes['23000'];
            break;
         case '23000GALERYCREATE':
            return self::$errosCodes['23000GALERYCREATE'];
            break;
         default:
            return ['error' => 'Internal server error', 'status' => 500];
            break;
      }
   }
}