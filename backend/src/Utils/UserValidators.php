<?php

namespace App\Utils;

use InvalidArgumentException;

class UserValidators{
   /**
    * Check if the array has some empty field.
    * @param array $data The array with the data to check.
    * @throws InvalidArgumentException if any field is empty.
    * @return void 
    */
   public static function checkEmptyField(array $data){
      foreach($data AS $field => $value){
         if(!isset($value)){
            throw new InvalidArgumentException("The field ($field) is required.");
         }
      }
   }
}