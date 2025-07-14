<?php 

namespace App\Repositories;
use App\Config\Database;
use App\Models\UserModels\FetchNotificationsModel;
use PDO;

use function PHPSTORM_META\type;

class NotificationsRepository extends Database{
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
   public static function create(array $data):bool{
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
    * Fetches user notifications by user ID.
    *
    * @param string $userId The ID of the user.
    * @return array|bool Returns an associative array with keys `id`, `client_name`, `gallery_name`, `code`, `criated_at`, `read_at`
    *                    or false if the user is not found.
    */
   public static function fetch(int $userId){
      $pdo = self::getConection();
      $stmt = $pdo->prepare(
         'SELECT `id`, `client_name`, `gallery_name`, `code`, `created_at`, `read_at`
         FROM `notifications`
         WHERE `user_foreign_key` = :id
          ORDER BY `created_at` DESC'
      ); 
      $stmt->bindValue(':id', $userId, PDO::PARAM_INT);
      $stmt->execute();
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
   }

   /**
    * Mark a notification as Read by ID.
    *
    * @param array $data containing the `id` and `user_id`.
    * @return bool False on failure or True on success.
    */
   public static function read(array $data){
      $pdo = self::getConection();
      $stmt = $pdo->prepare(
         'UPDATE `notifications`
         SET `read_at` = :date
         WHERE `id` = :id AND  `user_foreign_key` = :user_id'
      ); 
      $stmt->bindValue(':id', $data['id'], PDO::PARAM_INT);
      $stmt->bindValue(':user_id', $data['user_id'], PDO::PARAM_INT);
      $stmt->bindValue(':date', $data['date'], PDO::PARAM_STR);
      return $stmt->execute();
   }
}