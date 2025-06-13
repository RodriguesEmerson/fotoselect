<?php 

namespace App\Models\UserModels;

use App\Utils\Validators;
use InvalidArgumentException;

class UserRegisterModel{

   private string $name;
   private string $lastname;
   private string $email;
   private string $password;
   private string $start_date;

   private array $requiredField = ['name', 'lastname', 'email', 'password', 'start_date'];

   private function __construct(array $data){

      foreach ($this->requiredField AS $field) {
         if(!isset($data[$field])){
            throw new InvalidArgumentException("The field ($field) was not sent.");
         };
      }

      if(!Validators::validateString($data['name'], 2, 100)){
         throw new InvalidArgumentException("The field (name) sent doesn't meets the requirements.");
      };

      if(!Validators::validateString($data['lastname'], 2, 100)){
         throw new InvalidArgumentException("The field (lastname) sent doesn't meets the requirements.");         
      };
     
      Validators::validateEmail(strtolower($data['email']));
      Validators::validateDateYMD($data['start_date']);
      Validators::validatePasswordFormat($data['password']);
      
      $this->name = $data['name'];
      $this->lastname = $data['lastname'];
      $this->email = strtolower($data['email']);
      $this->password = password_hash($data['password'], PASSWORD_DEFAULT);
      $this->start_date = $data['start_date'];
   }

   public static function create(array $data):array{
      $instace = new self($data);
      
      return [
         'name' => $instace->name,
         'lastname' => $instace->lastname,
         'email' => $instace->email,
         'password' => $instace->password,
         'start_date' => $instace->start_date
      ];
   }
}