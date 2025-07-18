<?php 
namespace App\Utils;

class ImagesHandle{
   /**
    * Separate the valid and invalid images by validating each image.
    * @param array $folder Array with images to verify.
    * @param string $folderName Name of the index where are the images.
    * @return array{validImages: array, invalidImages: array}
    */
   public static function getValidAndInvalidImages(array $folder, string $folderName):array{
      $validImages = [];
      $invalidImages = [];
      $images = [];

      if(count($folder[$folderName]['name']) === 0) return [];
      
      for($i = 0; $i < count($folder[$folderName]['name']); $i++){
         $images[] = [
            'name'      => $folder[$folderName]['name'][$i],
            'full_path' => $folder[$folderName]['full_path'][$i],
            'type'      => $folder[$folderName]['type'][$i],
            'tmp_name'  => $folder[$folderName]['tmp_name'][$i],      
            'error'     => $folder[$folderName]['error'][$i],
            'size'      => $folder[$folderName]['size'][$i],
            'cdl_id'    => str_replace(' ', '', uniqid(pathinfo($folder[$folderName]['name'][$i], PATHINFO_FILENAME) . "_"))
         ];
      };
      
      foreach($images AS $image){
         if(Validators::validateImage(['png', 'jpg', 'jpeg'], $image, true)){
            $validImages[] = $image; 
            continue;
         };
         $invalidImages[] = $image;
      }

      return [
         'validImages' => $validImages,
         'invalidImages' => $invalidImages
      ];
   }
}