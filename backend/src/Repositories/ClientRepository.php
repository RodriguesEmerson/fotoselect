<?php 

namespace App\Repositories;
use App\Config\Database;
use App\Models\ClientsModels\FetchClindModel;

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

      $stmt->bindValue(':user_foreign_key', $data['user_id']);
      $stmt->bindValue(':name', $data['name']);
      $stmt->bindValue(':email', $data['email']);
      $stmt->bindValue(':phone', $data['phone']);
      $stmt->bindValue(':password', $data['password']);
      $stmt->bindValue(':profile_image', $data['profile_image']);
      $stmt->bindValue(':cdl_id', $data['cdl_id']);

      return $stmt->execute();
   }

   public function getClientById(array $data):bool|array{

      $stmt = self::$pdo->prepare(
         'SELECT * FROM `clients`
         WHERE `user_foreign_key` = :user_id 
         AND `id` = :id'
      );
      //BindValues
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
      $stmt->bindValue(':user_id', $data['user_id']);
      $stmt->bindValue(':email', $data['email']);
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

      $stmt->bindValue(':user_id', $data['user_id']);
      $stmt->bindValue(':email', $data['email']);
      $stmt->bindValue(':name', $data['name']);
      $stmt->bindValue(':phone', $data['phone']);
      $stmt->bindValue(':password', $data['password']);

      return $stmt->execute();
   }

   public function changeImage(array $data){
      $stmt = self::$pdo->prepare(
         'UPDATE `clients`
         SET `profile_image` = :profile_image, `cdl_id` = :cdl_id
         WHERE `user_foreign_key` = :user_id
         AND `email` = :email'
      );

      $stmt->bindValue(':user_id', $data['user_id']);
      $stmt->bindValue(':email', $data['email']);
      $stmt->bindValue(':profile_image', $data['profile_image']);
      $stmt->bindValue(':cdl_id', $data['cdl_id']);

      return $stmt->execute();
   }
}