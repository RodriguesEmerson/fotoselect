<?php 

namespace App\Models\UserModels;

use InvalidArgumentException;

class UserLoginModel{
   
   private array $credentials = [];

   private function __construct(array $data){
      if(!filter_var($data['email'], FILTER_VALIDATE_EMAIL)){
         throw new InvalidArgumentException("Please, enter a valid email.");
      }

      $this->credentials['email'] = strtolower(trim($data['email']));
      $this->credentials['password'] = trim($data['password']);
   }

   public static function create(array $data):array{
      $instace = new self($data);
      return $instace->credentials;
   }

}