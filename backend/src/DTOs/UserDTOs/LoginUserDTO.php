<?php 

namespace App\DTOs\UserDTOs;

use App\DTOs\DTOsInterface;
use App\Utils\Validators;
use InvalidArgumentException;

class LoginUserDTO implements DTOsInterface{
   
   private array $credentials = [];
   private $requiredFields = ['email', 'password', 'keeploged'];

   private function __construct(array $data){

      foreach ($this->requiredFields AS $field) {
         if(!isset($data[$field])){
            throw new InvalidArgumentException("The field ($field) was not sent.");
         };
      }

      if(!filter_var($data['email'], FILTER_VALIDATE_EMAIL)){
         throw new InvalidArgumentException("Please, enter a valid email.");
      }

      $this->credentials['email'] = strtolower(trim($data['email']));
      $this->credentials['password'] = trim($data['password']);
      $this->credentials['keeploged'] = Validators::validateAndConvertToBool('keeploged',$data['keeploged']);
   }

   public static function toArray(array $data):array{
      $instace = new self($data);
      return $instace->credentials;
   }
}