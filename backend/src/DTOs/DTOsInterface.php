<?php 

namespace App\DTOs;

/**
 * This class maintains the models patterns.
 */
interface DTOsInterface{

   /**
    * To array: Responsible for verifying each data sent and giving an array with all data validated.
    * @param array $data Contining the data to validate.
    */
   public static function toArray(array $data):array;
}