<?php 

namespace App\CloudinaryHandle;

use App\Utils\Validators;
use Cloudinary\Configuration\Configuration;
use Cloudinary\Cloudinary;
use Exception;

class CloudinaryHandleImage{
   
   /**
    * Upload image in Cloudinary.
    * @param string $imagePath The temporary image file.
    * @param string $imageId The image id will be used to access the image later.
    * @return array With the success or failure data.
    */
   public static function upload(string $imagePath, string $imageId){
      $config = new Configuration($_ENV['CLOUDINARY_URL']);
      $cloudinary = new Cloudinary($config);

      if(!Validators::validateString('Image name', $imageId, 1, 100, true)){
         return ['error' => 'The image name does not meets the requirements.'];
      }

      try{
         $result = $cloudinary->uploadApi()->upload($imagePath, ['public_id' => 'fotoselect/' . $imageId]);
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

   /**
    * Upload an array of images.
    * @param array $images Containing the images.
    * @return array{seccesfulyUpdloadedImages: array, failedUploadImages: array}
    */
   public static function updloadLots(array $images):array{
      $failedUploadImages = [];
      $seccesfulyUpdloadedImages = [];

      if(count($images) > 0){
         foreach ($images as $image) {
            $wasImageUploaded = self::upload($image['tmp_name'], $image['cdl_id']);

            if(!isset($wasImageUploaded['error'])){
               $imgURL = str_replace('http://', 'https://', $wasImageUploaded['url']);
               $image['src'] = $imgURL; //Set the Cloudinary url into the image.
               $seccesfulyUpdloadedImages[] = $image;
               continue;
            }

            $imagesFailedUpload[] = $image;
         }
      }

      return [
         'seccesfulyUpdloadedImages' => $seccesfulyUpdloadedImages,
         'failedUploadImages' => $failedUploadImages
      ];
   }

   /**
    * Delete an array of images.
    * @param array $images Containing the images to be deleted.
    * @return array{RealyFailedDeleteImages: array}
    */
   public static function deleteLots(array $images):array{
      $failedDeleteImages = [];
      $RealyFailedDeleteImages = [];
      $deletedImagesId = [];

      foreach($images AS $image){
         $wasImageDeleted = self::delete($image->cdl_id);

         if(!isset($wasImageDeleted['error'])){
            $deletedImagesId[] = $image->id;
            continue;
         } 
         $failedDeleteImages[] = $image;
      }
      
      //Retry to delete
      if(count($failedDeleteImages) > 0){
         foreach($failedDeleteImages AS $image){
            $wasImageDeleted = self::delete($image->cdl_id);

            if(!isset($wasImageDeleted['error'])){
               $deletedImagesId[] = $image->id;
               continue;
            } 
            $RealyFailedDeleteImages[] = $image;
         }
      }

      return[
         'realyFailedDeleteImages' => $RealyFailedDeleteImages,
         'deletedImagesId' => $deletedImagesId
      ];
   }
}