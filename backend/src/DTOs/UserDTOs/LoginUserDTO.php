<?php 

namespace App\DTOs\UserDTOs;

use App\DTOs\DTOsInterface;
use InvalidArgumentException;

class LoginUserDTO implements DTOsInterface{
   
   private array $credentials = [];

   private function __construct(array $data){
      if(!filter_var($data['email'], FILTER_VALIDATE_EMAIL)){
         throw new InvalidArgumentException("Please, enter a valid email.");
      }

      $this->credentials['email'] = strtolower(trim($data['email']));
      $this->credentials['password'] = trim($data['password']);
   }

   public static function toArray(array $data):array{
      $instace = new self($data);
      return $instace->credentials;
   }
}