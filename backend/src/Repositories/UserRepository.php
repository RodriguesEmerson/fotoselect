<?php 

namespace App\Repositories;
use App\Config\Database;
use PDO;

class UserRepository extends Database{
   /**
    * Registers a new user in the database.
    *
    * @param array $data Associative array containing:
    *                    - name (string)
    *                    - lastname (string)
    *                    - email (string)
    *                    - password (string)
    * @return bool Returns true on successful insertion, false otherwise.
    */
   public static function register(array $data):bool{
      $pdo = self::getConection();
      $stmt = $pdo->prepare(
         'INSERT INTO `users` (`name`, `lastname`, `email`, `password`)
                       VALUES (:name, :lastname, :email, :password)'
      );
      $stmt->bindValue(':name', $data['name']);
      $stmt->bindValue(':lastname', $data['lastname']);
      $stmt->bindValue(':email', $data['email']);
      $stmt->bindValue(':password', $data['password']);

      return $stmt->execute();
   }
   
   /**
    * Fetches basic user information by user ID.
    *
    * @param string $userId The ID of the user.
    * @return array|bool Returns an associative array with keys `name`, `lastname`, and `email`,
    *                    or false if the user is not found.
    */
   public static function fetch(string $userId):bool|array{
      $pdo = self::getConection();
      $stmt = $pdo->prepare(
         'SELECT u.name, u.lastname, u.email, ui.profile_image, ui.cdl_id, ui.credits 
         FROM `users` AS u
         INNER JOIN `userinfo` AS ui 
            ON ui.user_foreign_key = u.id
         WHERE u.id = :id'
      ); 
      $stmt->bindValue(':id', $userId);
      $stmt->execute();
      return $stmt->fetch(PDO::FETCH_ASSOC);
   }

   /**
    * Authenticates a user using email and password.
    *
    * @param array $credentials Associative array containing:
    *                           - email (string)
    *                           - password (string)
    * @return array|bool Returns an associative array with `user_id`, `name`, and `email` if login is successful,
    *                    or false if authentication fails.
    */
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