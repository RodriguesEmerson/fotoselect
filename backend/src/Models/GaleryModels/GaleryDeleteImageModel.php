<?php 

namespace App\Models\GaleryModels;

use App\Models\ModelInterface;
use App\Utils\Validators;
use InvalidArgumentException;

class GaleryDeleteImageModel implements ModelInterface{

   private int $user_id;
   private int $galery_id;
   private int $image_id;

   public function __construct(array $data){
      if(!isset($data['galery_id']) || !isset($data['image_id'])){
         throw new InvalidArgumentException('The galery id or image id was not sent.');
      }

      Validators::validateNumeric('galery_id', $data['galery_id'], 11);
      Validators::validateNumeric('image_id', $data['image_id'], 11);

      $this->user_id = $data['user_id'];
      $this->galery_id = $data['galery_id'];
      $this->image_id = $data['image_id'];
   }

   public static function toArray(array $data):array{
      $instance = new self($data);
      return [
         'user_id' => $instance->user_id,
         'galery_id' => $instance->galery_id,
         'image_id' => $instance->image_id
      ];
   }
}