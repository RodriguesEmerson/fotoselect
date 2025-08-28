<?php 

namespace App\DTOs\GaleryDTOs;

use App\DTOs\DTOsInterface;
use App\Utils\Validators;
use InvalidArgumentException;

class FetchGalleryImagesDTO implements DTOsInterface{

   private int $user_id;
   private int $galery_id;

    private function __construct(array $data){
      $galleryId = preg_match('/[\d]+/', $data['url'], $matches);
      if(count($matches) !== 1){
         throw new InvalidArgumentException('Galery information was not sent.', 400);
      }
      $galleryId = $matches[0];
      Validators::validateNumeric('galery_id', $galleryId, 11);

      $this->user_id = $data['user_id'];
      $this->galery_id = $galleryId;
   }

   public static function toArray(array $data):array{
      $instance = new self($data);
      return[
         'user_id' => $instance->user_id,
         'galery_id' => $instance->galery_id
      ];
   }
}