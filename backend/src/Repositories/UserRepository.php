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

   public static function login(array $credentials){
      
      return null;
      $pdo = self::getConection();
      $stmt = $pdo->prepare(
         ''
      );
   }

   public static function register(array $data):bool{
      $pdo = self::getConection();
      $stmt = $pdo->prepare(
         'INSERT INTO `users` (`name`, `lastname`, `email`, `password`, `start_date`)
                       VALUES (:name, :lastname, :email, :password, :start_date)'
      );
      $stmt->bindValue(':name', $data['name']);
      $stmt->bindValue(':lastname', $data['lastname']);
      $stmt->bindValue(':email', $data['email']);
      $stmt->bindValue(':password', $data['password']);
      $stmt->bindValue(':start_date', $data['start_date']);

      return $stmt->execute();
   }
}