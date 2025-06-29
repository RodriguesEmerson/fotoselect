<?php 

namespace App\DTOs\GaleryDTOs;

use App\DTOs\DTOsInterface;
use App\Utils\Validators;
use InvalidArgumentException;

class CreateGaleryAccessDTO implements DTOsInterface{

   private int $user_id;
   private int $galery_id;
   private string $email; //client email

   private function __construct(array $data){
      if(!isset($data['email'])){
         throw new InvalidArgumentException('Invalid client email', 400);
      }
      if(!isset($data['galery_id'])){
         throw new InvalidArgumentException('Gallery does not exists.', 400);
      }

      Validators::validateEmail($data['email']);
      Validators::validateNumeric('galery_id',$data['galery_id'], 11);

      $this->user_id = $data['user_id'];
      $this->galery_id = $data['galery_id'];
      $this->email = $data['email'];
   }

   public static function toArray(array $data):array{
      $instance = new self($data);

      return[
         'user_id' => $instance->user_id,
         'galery_id' => $instance->galery_id,
         'email' => $instance->email
      ];
   }
}