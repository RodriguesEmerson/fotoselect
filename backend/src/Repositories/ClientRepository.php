<?php 

namespace App\Repositories;
use App\Config\Database;
use App\Models\ClientsModels\FetchClindModel;

class ClientRepository extends Database{

   public function __construct(){
      self::getConection();
   }

   public function register(array $data){
      $stmt = self::$pdo->prepare(
         'INSERT INTO `clients`
         (`user_foreign_key`, `name`, `email`, `phone`, `password`, `profile_image`)
         VALUES
         (:user_foreign_key, :name, :email, :phone, :password, :profile_image)'
      );

      $stmt->bindValue(':user_foreign_key', $data['user_foreign_key']);
      $stmt->bindValue(':name', $data['name']);
      $stmt->bindValue(':email', $data['email']);
      $stmt->bindValue(':phone', $data['phone']);
      $stmt->bindValue(':password', $data['password']);
      $stmt->bindValue(':profile_image', $data['profile_image']);

      return $stmt->execute();
   }

   public function getClientById(array $data){

      $stmt = self::$pdo->prepare(
         'SELECT * FROM `clients
         WHERE `user_foreign_key` = :user_foreign_key 
         AND `email` = :email'
      );

      $stmt->execute();
      $stmt->setFetchMode(\PDO::FETCH_CLASS, FetchClindModel::class);
      return $stmt->fetch() ?: null;
   }
}