<?php 

namespace App\DTOs;

/**
 * This class is necessary to maintain the models patterns.
 */
interface DTOsInterface{
   //
   public static function toArray(array $data):array;
}