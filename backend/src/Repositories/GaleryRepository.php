<?php 

namespace App\Repositories;

use App\Config\Database;
use App\Models\GaleryModels\FetchGaleryDataModel;
use App\Models\GaleryModels\FetchGaleryImagesModel;
use PDO;
use PDOException;

class GaleryRepository extends Database{

   /**
    * Creates a new gallery in the database.
    *
    * @param array $data Associative array containing:
    *                    - user_id (int)
    *                    - galery_name (string)
    *                    - galery_cover (string)
    *                    - cdl_id (string)
    *                    - deadline (string|datetime)
    *                    - private (bool)
    *                    - watermark (bool)
    *                    - status (string)
    *                    - password (string)
    * @return bool Returns true on success, false on failure.
    * @throws PDOException If something goes wrong during the query execution.
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
    * Grants access to a gallery for a specific client.
    *
    * @param array $data Associative array containing:
    *                    - user_id (int)
    *                    - galery_id (int)
    *                    - client_id (int)
    * @return bool Returns true on success, false on failure.
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
    * Revokes access to a gallery from a specific client.
    *
    * @param array $data Associative array containing:
    *                    - galery_id (int)
    *                    - client_id (int)
    *                    - user_id (int)
    * @return bool Returns true on success, false on failure.
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

   /**
    * Uploads multiple images to a gallery.
    *
    * @param array $data Associative array containing:
    *                    - user_id (int)
    *                    - galery_id (int)
    *                    - images (array of arrays with keys: name, src, cdl_id)
    * @return bool Returns true on success, false on failure.
    */
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

   /**
    * Retrieves gallery metadata by its ID and the user who owns it.
    *
    * @param array $data Associative array containing:
    *                    - user_id (int)
    *                    - galery_id (int)
    * @return object|false Returns a FetchGaleryDataModel object or false if not found.
    */
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

   /**
    * Retrieves the galleries by its ID and the user who owns it.
    *
    * @param array $data Associative array containing:
    *                    - user_id (int)
    *                    - limit (int)
    *                    - offset (int)
    * @return object|false Returns a FetchGaleryDataModel object or false if not found.
    */
   public function fetchlot(array $data){
      $pdo = self::getConection();
      $stmt = $pdo->prepare(
         'SELECT * FROM `galeries`
         WHERE `user_foreign_key` = :user_id
         ORDER BY `created_at` DESC 
         LIMIT :limit
         OFFSET :offset'
      );
      
      $stmt->bindValue(':user_id', $data['user_id']);
      $stmt->bindValue(':limit', $data['limit'], PDO::PARAM_INT);
      $stmt->bindValue(':offset', $data['offset'], PDO::PARAM_INT);
      $stmt->execute();
      return  $stmt->fetchAll(\PDO::FETCH_CLASS, FetchGaleryDataModel::class);
   }

   /**
    * Retrieves all images belonging to a gallery.
    *
    * @param array $data Associative array containing:
    *                    - user_id (int)
    *                    - galery_id (int)
    * @return array Returns an array of FetchGaleryImagesModel objects.
    */
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

   /**
    * Retrieves image URL and CDL ID by image ID and gallery.
    *
    * @param array $data Associative array containing:
    *                    - user_id (int)
    *                    - galery_id (int)
    *                    - image_id (int)
    * @return array|bool Returns an associative array with keys `src` and `cdl_id`, or false if not found.
    */
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

   /**
    * Deletes a gallery based on its ID and the user who owns it.
    *
    * @param array $data Associative array containing:
    *                    - user_id (int)
    *                    - galery_id (int)
    * @return bool Returns true on success, false on failure.
    */
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

   /**
    * Deletes multiple images from a gallery.
    *
    * @param array $data Associative array containing:
    *                    - user_id (int)
    *                    - galery_id (int)
    *                    - imagesId (int[]) Array of image IDs to be deleted.
    * @return bool Returns true on success, false on failure.
    */
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

   /**
    * Deletes a single image from a gallery.
    *
    * @param array $data Associative array containing:
    *                    - user_id (int)
    *                    - galery_id (int)
    *                    - image_id (int)
    * @return bool Returns true on success, false on failure.
    */
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
}