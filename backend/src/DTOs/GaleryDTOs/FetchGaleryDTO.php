<?php 

namespace App\DTOs\GaleryDTOs;

use App\DTOs\DTOsInterface;
use App\Utils\Validators;
use InvalidArgumentException;

class FetchGaleryDTO implements DTOsInterface{

   private int $user_id;
   private int $galery_id;

   private function __construct(array $data){
      if(!isset($data['url'])){
         throw new InvalidArgumentException('Invalid URL provided.', 400);
      }

      $sentGaleryId = preg_match('/[^\/]+$/', $data['url'], $matches);
      if($sentGaleryId === 0){
         throw new InvalidArgumentException('Galery information was not sent.', 400);
      }
      $sentGaleryId = ($matches[0]);

      Validators::validateNumeric('galery_id', $sentGaleryId, 11);

      $this->user_id = $data['user_id'];
      $this->galery_id = $sentGaleryId;
   }

   public static function toArray(array $data):array{
      $instance = new self($data);
      return[
         'user_id' => $instance->user_id,
         'galery_id' => $instance->galery_id
      ];
   }
}