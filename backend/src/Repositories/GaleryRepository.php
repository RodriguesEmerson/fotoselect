<?php 

namespace App\Repositories;

use App\Config\Database;
use PDO;

class GaleryRepository extends Database{

   public function create(array $data):bool{
      $pdo = self::getConection();
      $stmt = $pdo->prepare(
         'INSERT INTO 
         `galeries` 
         (`user_foreign_key`, `galery_name`, `galery_cover`, `cdl_id, `deadline`, `private`,`watermark`, `status`, `password`)
         VALUES 
         (:user_foreign_key, :galery_name, :galery_cover, :deadline, :private, :watermark, :status, :password)'
      );
      $stmt->bindValue(':user_foreign_key', $data['user_id'], PDO::PARAM_INT);
      $stmt->bindValue(':galery_name', $data['galery_name'], PDO::PARAM_STR);
      $stmt->bindValue(':galery_cover', $data['galery_cover'], PDO::PARAM_STR);
      $stmt->bindValue(':cdl_id', $data['cdl_id'], PDO::PARAM_STR);
      $stmt->bindValue(':deadline', $data['deadline'], PDO::PARAM_STR);
      $stmt->bindValue(':private', $data['private'], PDO::PARAM_BOOL);
      $stmt->bindValue(':watermark', $data['watermark'], PDO::PARAM_BOOL);
      $stmt->bindValue(':status', $data['status'], PDO::PARAM_STR);
      $stmt->bindValue(':password', $data['password'], PDO::PARAM_STR);

      return $stmt->execute();
   }

   public function upload(array $data):bool{
      $colunms = [
         '`user_foreign_key`', '`galery_foreign_key`', '`name`', '`src`', '`cdl_id`'
      ];
      $placeholders = [];
      $params = [];

      for($i = 0; $i < count($data['images']); $i++){
         $currentPlaceholders = [
            ':user_foreign_key_' . $i,
            ':galery_foreign_key_' . $i,
            ':name_' . $i,
            ':src_' . $i,
            ':cdl_id_' . $i
         ];

         $params[":user_foreign_key_" . $i] = $data['user_id']; 
         $params[":galery_foreign_key_" . $i] = $data['galery_id']; 
         $params[":name_" . $i] = $data['images'][$i]['name']; 
         $params[":src_" . $i] = $data['images'][$i]['src']; 
         $params[":cdl_id_" . $i] = $data['images'][$i]['cdl_id']; 

         $placeholders[] = '(' . implode(',', $currentPlaceholders) . ')';
      };

      $query = (
         "INSERT INTO `images` (" . implode(',', $colunms) . ") VALUES " . implode(',', $placeholders)
      );
   
      $pdo = self::getConection();
      $stmt = $pdo->prepare($query);
      return $stmt->execute($params);
   }


   public function getImageUrlAndCdlIdById(array $data):bool|array{
      $pdo = self::getConection();
      $stmt = $pdo->prepare(
         'SELECT `src`, `cdl_id` FROM `images` 
         WHERE `user_foreign_key` = :user_id 
         AND `galery_foreign_key` = :galery_id
         AND `id` = :image_id'
      );

      $stmt->bindValue(':user_id', $data['user_id'], PDO::PARAM_INT);
      $stmt->bindValue(':galery_id', $data['galery_id'], PDO::PARAM_INT);
      $stmt->bindValue(':image_id', $data['image_id'], PDO::PARAM_INT);

      $stmt->execute();
      return $stmt->fetch(PDO::FETCH_ASSOC);
   }

   public function deleteImage(array $data):bool{
      $pdo = self::getConection();
      $stmt = $pdo->prepare(
         'DELETE FROM `images`
         WHERE `user_foreign_key` = :user_id 
         AND `galery_foreign_key` = :galery_id
         AND `id` = :image_id'
      );

      $stmt->bindValue(':user_id', $data['user_id'], PDO::PARAM_INT);
      $stmt->bindValue(':galery_id', $data['galery_id'], PDO::PARAM_INT);
      $stmt->bindValue(':image_id', $data['image_id'], PDO::PARAM_INT);

      return $stmt->execute();
   }

}