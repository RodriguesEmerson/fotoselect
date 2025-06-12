<?php 

namespace App\Model;

use InvalidArgumentException;

class UserModel{

   private string $name;
   private string $email;
   private string $lastname;
   private string $password;

   public function userLoginModel(array $data){
      if(!filter_var($data['email'], FILTER_VALIDATE_EMAIL)){
         throw new InvalidArgumentException("Invalid email.");
      }
   }
}