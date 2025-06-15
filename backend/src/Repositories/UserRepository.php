<?php 

namespace App\Repositories;
use App\Config\Database;
use PDO;

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
      
      $pdo = self::getConection();
      $stmt = $pdo->prepare(
         'SELECT * FROM `users` WHERE `email` = :email'
      );
      $stmt->bindValue(':email', $credentials['email']);
      $stmt->execute();
      $user = $stmt->fetch(PDO::FETCH_ASSOC);

      if(!$user) return false;
      if(!password_verify($credentials['password'], $user['password'])) return false;

      return [
         'user_id' => $user['id'],
         'name' => $user['name'],
         'email' => $user['email']
      ];

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