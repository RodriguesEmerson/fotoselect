<?php 

namespace App\CloudinaryHandle;
use Cloudinary\Configuration\Configuration;
use Cloudinary\Cloudinary;
use Exception;

class CloudinaryHandleImage{
   
   /**
    * Upload image in Cloudinary.
    * @param string $imagePath The temporary image file.
    * @param string $imageId The image id will be used to access the image later.
    * @return array with the success data information or error.
    */
   public static function upload(string $imagePath, string $imageId){
      $config = new Configuration($_ENV['CLOUDINARY_URL']);
      $cloudinary = new Cloudinary($config);

      try{
         $result = $cloudinary->uploadApi()->upload($imagePath, ['public_id' => 'fotoselect/' .$imageId]);
         return $result;
      }catch (\Exception $e) {
         return ['error' => $e->getMessage()];
      }
   }

   /**
    * Delete image from Cloudinary.
    * @param string $imagePath The temporary image file.
    * @param string $imageId The image id that is going to be deleted.
    * @return object|array with the success message or error.
    */
   public static function delete(string $imageId):object|array{
      $config = new Configuration($_ENV['CLOUDINARY_URL']);
      $cloudinary = new Cloudinary($config);
      try {
         $result = $cloudinary->uploadApi()->destroy('fotoselect/' . $imageId);
         return $result;
      } catch (Exception $e) {
         return ['error' => $e->getMessage()];
      }
   }
}