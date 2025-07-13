<?php 

namespace App\Models\UserModels;

class FetchUserModel{
   public $name;
   public $email;
   public $profile_image;
   public $cdl_id;
   public $credits;
   private $id;
   private $user_foreign_key;
   private $password;
   private $created_at;
}