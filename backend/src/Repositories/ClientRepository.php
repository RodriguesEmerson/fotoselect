<?php

namespace App\Repositories;

use App\Config\Database;
use App\Models\ClientsModels\FetchClindModel;
use PDO;

class ClientRepository extends Database
{

   public function __construct()
   {
      self::getConection();
   }

   /**
    * Registers a new client in the database.
    *
    * @param array $data Associative array containing:
    *                    - user_id (int)
    *                    - name (string)
    *                    - email (string)
    *                    - phone (string)
    *                    - password (string)
    *                    - profile_image (string)
    *                    - cdl_id (string)
    * @return bool Returns true if the registration was successful, false otherwise.
    */
   public function register(array $data): bool
   {
      $stmt = self::$pdo->prepare(
         'INSERT INTO `clients`
         (`user_foreign_key`, `name`, `email`, `phone`, `password`, `profile_image`, `cdl_id`)
         VALUES
         (:user_foreign_key, :name, :email, :phone, :password, :profile_image, :cdl_id)'
      );

      $stmt->bindValue(':user_foreign_key', $data['user_id'], PDO::PARAM_INT);
      $stmt->bindValue(':name', $data['name'], PDO::PARAM_STR);
      $stmt->bindValue(':email', $data['email'], PDO::PARAM_STR);
      $stmt->bindValue(':phone', $data['phone']);
      $stmt->bindValue(':password', $data['password'], PDO::PARAM_STR);
      $stmt->bindValue(':profile_image', $data['profile_image']);
      $stmt->bindValue(':cdl_id', $data['cdl_id']);

      return $stmt->execute();
   }

   /**
    * Retrieves all clients associated with a specific user.
    *
    * @param int $user_id The ID of the user.
    * @return array|bool Returns an array of clients (as FetchClindModel objects) or false on failure.
    */
   public function getAllClients(int $user_id): array|bool
   {
      $stmt = self::$pdo->prepare(
         'SELECT * FROM `clients`
         WHERE `user_foreign_key` = :user_id'
      );
      $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
      $stmt->execute();
      return $stmt->fetchAll(\PDO::FETCH_CLASS, FetchClindModel::class);
   }

   /**
    * Retrieves a client by their ID.
    *
    * @param array $data Associative array containing:
    *                    - user_id (int)
    *                    - client_id (int)
    * @return object|bool Returns the client as a FetchClindModel object or false if not found.
    */
   public function getClientById(array $data): object|bool
   {
      $stmt = self::$pdo->prepare(
         'SELECT * FROM `clients`
         WHERE `user_foreign_key` = :user_id 
         AND `id` = :client_id'
      );
      $stmt->bindValue(':user_id', $data['user_id'], PDO::PARAM_INT);
      $stmt->bindValue(':client_id', $data['client_id'], PDO::PARAM_INT);
      $stmt->execute();
      $stmt->setFetchMode(\PDO::FETCH_CLASS, FetchClindModel::class);
      return $stmt->fetch();
   }

   /**
    * Retrieves a client by their email.
    *
    * @param array $data Associative array containing:
    *                    - user_id (int)
    *                    - email (string)
    * @return object|bool Returns the client as a FetchClindModel object or false if not found.
    */
   public function getClientByEmail(array $data): object|bool
   {
      $stmt = self::$pdo->prepare(
         'SELECT * FROM `clients`
         WHERE `user_foreign_key` = :user_id 
         AND `email` = :email'
      );
      $stmt->bindValue(':user_id', $data['user_id'], PDO::PARAM_INT);
      $stmt->bindValue(':email', $data['email'], PDO::PARAM_STR);
      $stmt->execute();
      $stmt->setFetchMode(\PDO::FETCH_CLASS, FetchClindModel::class);
      return $stmt->fetch();
   }

   /**
    * Updates a client's basic information.
    *
    * @param array $data Associative array containing:
    *                    - user_id (int)
    *                    - email (string)
    *                    - name (string)
    *                    - phone (string)
    *                    - password (string)
    * @return bool Returns true if the update was successful, false otherwise.
    */
   public function update(array $data): bool
   {
      $stmt = self::$pdo->prepare(
         'UPDATE `clients`
         SET `name` = :name, `email` = :email, `phone` = :phone, `password` = :password
         WHERE `user_foreign_key` = :user_id
         AND `email` = :email'
      );

      $stmt->bindValue(':user_id', $data['user_id'], PDO::PARAM_INT);
      $stmt->bindValue(':email', $data['email'], PDO::PARAM_STR);
      $stmt->bindValue(':name', $data['name'], PDO::PARAM_STR);
      $stmt->bindValue(':phone', $data['phone'], PDO::PARAM_STR);
      $stmt->bindValue(':password', $data['password'], PDO::PARAM_STR);

      return $stmt->execute();
   }

   /**
    * Updates a client's profile image and CDL ID.
    *
    * @param array $data Associative array containing:
    *                    - user_id (int)
    *                    - email (string)
    *                    - profile_image (string)
    *                    - cdl_id (string)
    * @return bool Returns true if the update was successful, false otherwise.
    */
   public function changeImage(array $data){
      $stmt = self::$pdo->prepare(
         'UPDATE `clients`
         SET `profile_image` = :profile_image, `cdl_id` = :cdl_id
         WHERE `user_foreign_key` = :user_id
         AND `email` = :email'
      );

      $stmt->bindValue(':user_id', $data['user_id'], PDO::PARAM_INT);
      $stmt->bindValue(':email', $data['email'], PDO::PARAM_STR);
      $stmt->bindValue(':profile_image', $data['profile_image'], PDO::PARAM_STR);
      $stmt->bindValue(':cdl_id', $data['cdl_id'], PDO::PARAM_STR);

      return $stmt->execute();
   }

   /**
    * Deletes a client from the database.
    *
    * @param array $data Associative array containing:
    *                    - user_id (int)
    *                    - client_id (int)
    * @return bool Returns true if the deletion was successful, false otherwise.
    */
   public function delete(array $data): bool{
      $stmtGalleryAccess = self::$pdo->prepare(
         'DELETE FROM `galery_access`
         WHERE `user_foreign_key` = :user_id
         and `client_foreign_key` = :client_id'
      );

      $stmtGalleryAccess->bindValue(':user_id', $data['user_id'], PDO::PARAM_INT);
      $stmtGalleryAccess->bindValue(':client_id', $data['client_id'], PDO::PARAM_INT);

      $stmtNotification = self::$pdo->prepare(
         'DELETE FROM `notifications`
         WHERE `user_foreign_key` = :user_id
         and `client_foreign_key` = :client_id'
      );

      $stmtNotification->bindValue(':user_id', $data['user_id'], PDO::PARAM_INT);
      $stmtNotification->bindValue(':client_id', $data['client_id'], PDO::PARAM_INT);

      $stmtClient = self::$pdo->prepare(
         'DELETE FROM `clients`
         WHERE `user_foreign_key` = :user_id
         and `id` = :client_id'
      );
      $stmtClient->bindValue(':user_id', $data['user_id'], PDO::PARAM_INT);
      $stmtClient->bindValue(':client_id', $data['client_id'], PDO::PARAM_INT);

      try {
         self::$pdo->beginTransaction();
            $stmtGalleryAccess->execute();
            $stmtNotification->execute();
            $stmtClient->execute();
         self::$pdo->commit();
         return true;
      } catch (\PDOException $e) {
         self::$pdo->rollback();
         throw $e;
         // echo json_encode([$stmtClient->errorInfo()]);exit;
         // echo json_encode([$stmtGalleryAccess->errorInfo()]);;
      }
   }
}
