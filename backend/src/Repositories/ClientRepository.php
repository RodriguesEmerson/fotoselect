<?php 

namespace App\Repositories;
use App\Config\Database;
use App\Models\ClientsModels\FetchClindModel;
use PDO;

class ClientRepository extends Database{

   public function __construct(){
      self::getConection();
   }

   public function register(array $data):bool{
      $stmt = self::$pdo->prepare(
         'INSERT INTO `clients`
         (`user_foreign_key`, `name`, `email`, `phone`, `password`, `profile_image`, `cdl_id`)
         VALUES
         (:user_foreign_key, :name, :email, :phone, :password, :profile_image, :cdl_id)'
      );

      $stmt->bindValue(':user_foreign_key', $data['user_id'], PDO::PARAM_INT);
      $stmt->bindValue(':name', $data['name'], PDO::PARAM_STR);
      $stmt->bindValue(':email', $data['email'], PDO::PARAM_STR);
      $stmt->bindValue(':phone', $data['phone'], PDO::PARAM_STR);
      $stmt->bindValue(':password', $data['password'], PDO::PARAM_STR);
      $stmt->bindValue(':profile_image', $data['profile_image'], PDO::PARAM_STR);
      $stmt->bindValue(':cdl_id', $data['cdl_id'], PDO::PARAM_STR);

      return $stmt->execute();
   }

   public function getClientById(array $data):object|bool{
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

   public function getClientByEmail(array $data):object|bool{
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


   public function update(array $data):bool{
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

   public function delete(array $data):bool{
      $stmt = self::$pdo->prepare(
         'DELETE FROM `clients`
         WHERE `user_foreign_key` = :user_id
         and `id` = :client_id'
      );

      $stmt->bindValue(':user_id', $data['user_id'], PDO::PARAM_INT);
      $stmt->bindValue(':client_id', $data['client_id'], PDO::PARAM_INT);

      return $stmt->execute();
   }
}