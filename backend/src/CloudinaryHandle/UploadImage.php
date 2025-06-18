<?php 

namespace App\CloudinaryHandle;
use Cloudinary\Configuration\Configuration;
use Cloudinary\Cloudinary;
use Exception;

class UploadImage{

   
   public static function upload(string $imagePath, string $imageId){
      
      $config = new Configuration($_ENV['CLOUDINARY_URL']);
      $cloudinary = new Cloudinary($config);

      try{
         $result = $cloudinary->uploadApi()->upload($imagePath, ['public_id' => 'fotoselect/' .$imageId]);
         return true;

      }catch (\Exception $e) {
         return false;
      }
   }

   public static function delete(string $imageId){
      $config = new Configuration($_ENV['CLOUDINARY_URL']);
      $cloudinary = new Cloudinary($config);
        try {
            $cloudinary->uploadApi()->destroy($imageId);
            return true;
        } catch (Exception $e) {
            return false;
        }
   }
}