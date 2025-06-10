<?php 

namespace App\Repositories;
use App\Config\Database;

class UserRepository extends Database{
   
   public static function fetch(string $userId){
      $connection = self::getConection();
      $user = ['user_id' => '123', 'name' => 'Emerson', 'email' => 'emerson@teste.com'];

      if($userId == $user['user_id']){
         return ['user_id' => '123', 'name' => 'Emerson', 'email' => 'emerson@teste.com'];
      }

      return null;
   }
}