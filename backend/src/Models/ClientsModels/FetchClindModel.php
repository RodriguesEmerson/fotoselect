<?php 

namespace App\Models\ClientsModels;

class FetchClindModel{
   public $id;
   public $name;
   public $email;
   public $phone;
   public $password;
   public $profile_image;
   public $cdl_id;
   private $created_at;
   private $user_foreign_key;
}