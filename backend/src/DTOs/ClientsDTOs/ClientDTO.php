<?php 

namespace App\DTOs\ClientsDTOs;

use App\DTOs\DTOsInterface;
use App\Utils\Validators;
use InvalidArgumentException;

class ClientDTO implements DTOsInterface{

   private int $user_id;
   private string $name;
   private string $email;
   private ?string $phone = null;
   private ?string $profile_image = null;
   private ?string $tmp_profile_image = null;
   private string $password;

   private $requiredFields = ['name', 'email', 'password'];

   private function __construct(array $data){
      foreach ($this->requiredFields AS $field) {
         if(!isset($data[$field])){
            throw new InvalidArgumentException("The field ($field) was not sent.");
         };
      }

      Validators::validateString('name', $data['name'], 1, 100);
      Validators::validateEmail($data['email']);
      Validators::validatePasswordFormat($data['password']);

      if(isset($data['phone'])){
         Validators::validatePhone($data['phone']);
         $this->phone = $data['phone'];
      }
      if(isset($data['files']['profile_image'])){
         Validators::validateImage(['png', 'jpg', 'jpeg'], $data['files']['profile_image']);
         $this->profile_image = uniqid(str_replace(' ', '', trim($data['files']['profile_image']['name'])) . '_');
         $this->tmp_profile_image = $data['files']['profile_image']['tmp_name'];
      }

      $this->user_id = $data['user_id'];
      $this->name = $data['name'];
      $this->email = $data['email'];
      $this->password = $data['password'];
      // $this->password = password_hash($data['password'], PASSWORD_DEFAULT);

   }

   public static function toArray(array $data):array{

      $instace = new self($data);
      return [
         'user_foreign_key' => $instace->user_id,
         'name' => $instace->name,
         'email' => $instace->email,
         'phone' => $instace->phone,
         'profile_image' => $instace->profile_image,
         'password' => $instace->password,
         'tmp_profile_image' => $instace->tmp_profile_image
      ];
   }
}