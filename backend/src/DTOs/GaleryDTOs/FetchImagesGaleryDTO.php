<?php 

namespace App\DTOs\GaleryDTOs;

use App\DTOs\DTOsInterface;
use App\Utils\Validators;
use InvalidArgumentException;

class FetchImagesGaleryDTO implements DTOsInterface{

   private int $user_id;
   private int $galery_id;

    private function __construct(array $data){
      if(!isset($data['galery_id'])){
         throw new InvalidArgumentException('Galery information was not sent.', 400);
      } 

      Validators::validateNumeric('galery_id', $data['galery_id'], 11);

      $this->user_id = $data['user_id'];
      $this->galery_id = $data['galery_id'];
   }

   public static function toArray(array $data):array{
      $instance = new self($data);
      return[
         'user_id' => $instance->user_id,
         'galery_id' => $instance->galery_id
      ];
   }
}