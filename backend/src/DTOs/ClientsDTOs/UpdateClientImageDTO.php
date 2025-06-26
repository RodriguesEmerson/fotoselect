<?php 

namespace App\DTOs\ClientsDTOs;

use App\DTOs\DTOsInterface;
use App\Utils\Validators;
use InvalidArgumentException;

class UpdateClientImageDTO implements DTOsInterface{

   private int $user_id;
   private string $email;
   private ?string $profile_image = null;
   private ?string $tmp_profile_image = null;

   private function __construct(array $data){
      if(!isset($data['files']['profile_image'])){
         throw new InvalidArgumentException("The client image is required.");
      }
      Validators::validateImage(['png', 'jpg', 'jpeg'], $data['files']['profile_image']);
      Validators::validateEmail($data['email']);

      $this->profile_image = uniqid(str_replace(' ', '', trim($data['files']['profile_image']['name'])) . '_');
      $this->tmp_profile_image = $data['files']['profile_image']['tmp_name'];
      $this->user_id = $data['user_id'];
      $this->email = $data['email'];
   }

   public static function toArray(array $data):array{

      $instace = new self($data);
      return [
         'user_id' => $instace->user_id,
         'email' => $instace->email,
         'profile_image' => $instace->profile_image,
         'tmp_profile_image' => $instace->tmp_profile_image
      ];
   }
}