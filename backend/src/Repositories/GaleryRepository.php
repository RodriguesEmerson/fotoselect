<?php 

namespace App\Repositories;

use App\CloudinaryHandle\UploadImage;
use App\Config\Database;
use Exception;
use PDO;

class GaleryRepository extends Database{

   public static function create(array $data){
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

      try{
         $pdo->beginTransaction();

         //Try to save the galery_cover on Cloudinary
         $wasImageUploaded = UploadImage::upload($data['tmp_cover'], $data['galery_cover']);
         if(isset($wasImageUploaded['error'])){
            // throw new Exception($wasImageUploaded['error']);
            throw new Exception('Error trying to save the image on Cloudinary.');
         }

         $stmt->execute();

         $pdo->commit();
         return true;
       
      }catch(Exception $e){
         // Rollback at Database.
         $pdo->rollBack();

         //Delete image from Cloudinary.
         UploadImage::delete($data['galery_cover']);

         //Throws PDO errors.
         if(str_contains($e->getMessage(), 'SQL')){
            throw new \PDOException($e->getMessage(), $e->getCode());
         }

         //Throws Cloudinary errors.
         throw new Exception($e->getMessage());
      }

   }
}