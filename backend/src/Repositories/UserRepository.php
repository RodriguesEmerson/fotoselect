<?php 

namespace App\Repositories;
use App\Config\Database;
use PDO;

class UserRepository extends Database{

    public static function register(array $data):bool{
      $pdo = self::getConection();
      $stmt = $pdo->prepare(
         'INSERT INTO `users` (`name`, `lastname`, `email`, `password`)
                       VALUES (:name, :lastname, :email, :password, :start_date)'
      );
      $stmt->bindValue(':name', $data['name']);
      $stmt->bindValue(':lastname', $data['lastname']);
      $stmt->bindValue(':email', $data['email']);
      $stmt->bindValue(':password', $data['password']);

      return $stmt->execute();
   }
   
   public static function fetch(string $userId):bool|array{
      $pdo = self::getConection();
      $stmt = $pdo->prepare(
         'SELECT `name`, `lastname`, `email` FROM `users` WHERE `id` = :id'
      );
      $stmt->bindValue(':id', $userId);
      $stmt->execute();
      return $stmt->fetch(PDO::FETCH_ASSOC);
   }

   public static function login(array $credentials):bool|array{
      
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

  
}