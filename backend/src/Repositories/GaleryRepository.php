<?php 

namespace App\Repositories;

use App\Config\Database;
use PDO;

class GaleryRepository extends Database{

   public static function create(array $data):bool{
      $pdo = self::getConection();
      $stmt = $pdo->prepare(
         'INSERT INTO 
         `galeries` 
         (`user_foreign_key`, `galery_name`, `galery_cover`, `deadline`, `private`,`watermark`, `status`, `password`)
         VALUES 
         (:user_foreign_key, :galery_name, :galery_cover, :deadline, :private, :watermark, :status, :password)'
      );
      $stmt->bindValue(':user_foreign_key', $data['user_foreign_key'], PDO::PARAM_INT);
      $stmt->bindValue(':galery_name', $data['galery_name'], PDO::PARAM_STR);
      $stmt->bindValue(':galery_cover', $data['galery_cover'], PDO::PARAM_STR);
      $stmt->bindValue(':deadline', $data['deadline'], PDO::PARAM_STR);
      $stmt->bindValue(':private', $data['private'], PDO::PARAM_BOOL);
      $stmt->bindValue(':watermark', $data['watermark'], PDO::PARAM_BOOL);
      $stmt->bindValue(':status', $data['status'], PDO::PARAM_STR);
      $stmt->bindValue(':password', $data['password'], PDO::PARAM_STR);

      return $stmt->execute();
   }
}