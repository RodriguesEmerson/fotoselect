<?php 

namespace App\Repositories;

use App\Config\Database;
use App\Models\GaleryModels\FetchGaleryDataModel;
use App\Models\GaleryModels\FetchGaleryImagesModel;
use PDO;
use PDOException;

class GaleryRepository extends Database{

   /**
    * Create a new Galery in the Database
    * @param array $data Containing the new galery information
    * @return bool True on success and False on failure.
    * @throws PDOException If somethig goes wrong.
    */
   public function create(array $data):bool{
      $pdo = self::getConection();

      $stmt = $pdo->prepare(
         'INSERT INTO 
         `galeries` 
         (`user_foreign_key`, `galery_name`, `galery_cover`, `cdl_id`, `deadline`, `private`,`watermark`, `status`, `password`)
         VALUES 
         (:user_foreign_key, :galery_name, :galery_cover, :cdl_id, :deadline, :private, :watermark, :status, :password)'
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

   /**
    * 
    *
    */
   public function createAccess(array $data):bool{
      $pdo = self::getConection();

      //This function access another TABLE: galery_access
      $stmt = $pdo->prepare(
         'INSERT INTO 
         `galery_access` 
         (`user_foreign_key`, `galery_foreign_key`, `client_foreign_key`)
         VALUES 
         (:user_id, :galery_id, :client_id)'
      );
      $stmt->bindValue(':user_id', $data['user_id'], PDO::PARAM_INT);
      $stmt->bindValue(':galery_id', $data['galery_id'], PDO::PARAM_INT);
      $stmt->bindValue(':client_id', $data['client_id'], PDO::PARAM_INT);
      
      return $stmt->execute();
   }

   /**
    * 
    *
    */
   public function deleteAccess(array $data):bool{
      $pdo = self::getConection();

      //This function access another TABLE: galery_access
      $stmt = $pdo->prepare(
         'DELETE FROM `galery_access` 
         WHERE `galery_foreign_key` = :galery_id
         AND `client_foreign_key` = :client_id
         AND `user_foreign_key` = :user_id'
      );
      $stmt->bindValue(':galery_id', $data['galery_id'], PDO::PARAM_INT);
      $stmt->bindValue(':client_id', $data['client_id'], PDO::PARAM_INT);
      $stmt->bindValue(':user_id', $data['user_id'], PDO::PARAM_INT);
      
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

   public function getGaleryData(array $data){
      $pdo = self::getConection();
      $stmt = $pdo->prepare(
         'SELECT * FROM `galeries`
         WHERE `user_foreign_key` = :user_id
         AND `id` = :id'
      );
      
      $stmt->bindValue(':user_id', $data['user_id']);
      $stmt->bindValue(':id', $data['galery_id']);
      $stmt->execute();
      $stmt->setFetchMode(\PDO::FETCH_CLASS, FetchGaleryDataModel::class);
      return $stmt->fetch();
   }

   public function getGaleryImages(array $data){
      $pdo = self::getConection();
      $stmt = $pdo->prepare(
         'SELECT * FROM `images`
         WHERE `user_foreign_key` = :user_id
         AND `galery_foreign_key` = :galery_id'
      );
      
      $stmt->bindValue(':user_id', $data['user_id']);
      $stmt->bindValue(':galery_id', $data['galery_id']);
      $stmt->execute();
      return $stmt->fetchAll(PDO::FETCH_CLASS, FetchGaleryImagesModel::class);
      
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

   public function deleteGalery(array $data){
      $pdo = self::getConection();
     
      $stmt = $pdo->prepare(
         'DELETE FROM `galeries`
         WHERE `user_foreign_key` = :user_id
         AND `id` = :galery_id'
      );
      $stmt->bindValue(':user_id', $data['user_id'], PDO::PARAM_INT);
      $stmt->bindValue(':galery_id', $data['galery_id'], PDO::PARAM_INT);
     
      return $stmt->execute();
   }

   public function deleteImagesFromGalery(array $data):bool{
      $pdo = self::getConection();

      $params = [':user_id' => $data['user_id'], ':galery_id' => $data['galery_id']];
      foreach($data['imagesId'] AS $imageId){
         $imagesPlaceholders[] = ":image" . $imageId;
         $params[':image' . $imageId] = (int) $imageId;
      }

      $query = 'DELETE FROM `images` 
         WHERE `user_foreign_key` = :user_id 
         AND `galery_foreign_key` = :galery_id
         AND `id` IN (' . implode(',', $imagesPlaceholders) . ')';

      $stmt = $pdo->prepare($query);
      return $stmt->execute($params);
   }

   public function deleteOneImageFromGalery(array $data):bool{
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

   /**
    * return $stmt->fetchAll(\PDO::FETCH_CLASS, PageModel::class) ?: null;
    *
    * $stmt->setFetchMode(\PDO::FETCH_CLASS, PageModel::class);
    * return $stmt->fetch() ?: null;
    */

}