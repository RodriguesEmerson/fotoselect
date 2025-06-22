<?php 

namespace App\Models;

/**
 * This class is necessary to maintain the models patterns.
 */
interface ModelInterface{
   //
   public static function toArray(array $data):array;
}