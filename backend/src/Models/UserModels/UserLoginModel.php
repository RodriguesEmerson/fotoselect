<?php 

namespace App\Models\UserModels;

use InvalidArgumentException;

class UserLoginModel{
   
   private array $credentials = [];

   private function __construct(array $data){
      if(!filter_var($data['email'], FILTER_VALIDATE_EMAIL)){
         throw new InvalidArgumentException("Please, enter a valid email.");
      }

      $this->credentials['email'] = strtolower($data['email']);
      $this->credentials['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
   }

   public static function create(array $data):array{
      $instace = new self($data);
      return $instace->credentials;
   }

}