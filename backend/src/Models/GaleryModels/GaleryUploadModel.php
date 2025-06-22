<?php 

namespace App\Models\GaleryModels;

use App\Models\ModelInterface;
use App\Utils\Validators;
use InvalidArgumentException;

class GaleryUploadModel implements ModelInterface{

   private int $user_id;
   private int $galery_id;
   private array $images;

   private array $requiredFields = [
      'galery_id', 'images'
   ];

   private function __construct(array $data){
      //Verify if all required fields was sent.
      foreach ($this->requiredFields AS $field) {
         if(!isset($data[$field])){
            throw new InvalidArgumentException("The field ($field) was not sent.", 400);
         };
      }

      Validators::validateNumeric('galery id', $data['galery_id'], 11);

      $this->user_id = trim($data['user_id']);
      $this->galery_id = trim($data['galery_id']);
      $this->images = ($data['images']);
   }

   
   public static function toArray(array $data):array{
      $instance = new self($data);

      return [
         'user_id' => $instance->user_id, 
         'galery_id' => $instance->galery_id,
         'images' => $instance->images, 
      ];
   }
}