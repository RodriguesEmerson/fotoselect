<?php 

namespace App\Models\UserModels;

use App\Models\ModelInterface;
use App\Utils\Validators;
use InvalidArgumentException;

class UserRegisterModel implements ModelInterface{

   private string $name;
   private string $lastname;
   private string $email;
   private string $password;

   private array $requiredFields = ['name', 'lastname', 'email', 'password'];

   private function __construct(array $data){
      foreach ($this->requiredFields AS $field) {
         if(!isset($data[$field])){
            throw new InvalidArgumentException("The field ($field) was not sent.");
         };
      }

      Validators::validateString('name', $data['name'], 2, 100);
      Validators::validateString('lastname', $data['lastname'], 2, 100);
      Validators::validateEmail(strtolower($data['email']));
      Validators::validatePasswordFormat($data['password']);
      
      $this->name = trim($data['name']);
      $this->lastname = trim($data['lastname']);
      $this->email = strtolower(trim($data['email']));
      $this->password = password_hash(trim($data['password']), PASSWORD_DEFAULT);
   }

   public static function toArray(array $data):array{
      $instace = new self($data);
      
      return [
         'name' => $instace->name,
         'lastname' => $instace->lastname,
         'email' => $instace->email,
         'password' => $instace->password,
      ];
   }
}