<?php 

namespace App\Models\GaleryModels;

use App\Models\ModelInterface;
use App\Utils\Validators;
use InvalidArgumentException;

class GaleryCreateModel implements ModelInterface{

   private int $user_foreign_key;
   private string $galery_name;
   private string $galery_cover;
   private string $deadline;
   private bool $private;
   private bool $watermark;
   private string $status;
   private string $password;
   private string $tmp_cover;

   private array $requiredFields = [
      'user_foreign_key', 'galery_name', 'galery_cover', 'deadline', 'private','watermark', 'status', 'password'
   ];
   private array $allowedGaleryCoverExtention = ['png', 'jpg', 'jpeg'];
   private array $validsStatus = ['pending'];

   private function __construct(array $data){

      if(isset($data['files']['galery_cover'])){
         Validators::validateImage($this->allowedGaleryCoverExtention, $data['files']['galery_cover']);
         $data['galery_cover'] = $data['files']['galery_cover']['name'];
         $this->tmp_cover = $data['files']['galery_cover']['tmp_name'];
      }

      //Verify if all required fields was sent.
      foreach ($this->requiredFields AS $field) {
         if($field === 'user_foreign_key') continue;
         if(!isset($data[$field])){
            throw new InvalidArgumentException("The field ($field) was not sent.");
         };
      }

      Validators::validateString('albun_name' ,$data['galery_name'], 1, 100);
      Validators::validateDateYMD('deadline',$data['deadline']);
      $data['private'] = Validators::validateAndConvertToBool('private', $data['private']);
      $data['watermark'] = Validators::validateAndConvertToBool('watermark', $data['watermark']);
      Validators::validateString('password' ,$data['password'], 4, 100);
      if(!in_array($data['status'], $this->validsStatus)){
         throw new InvalidArgumentException("The field status does not meets the requirements.");
      }

      $this->user_foreign_key = trim($data['user_foreign_key']);
      $this->galery_name = trim($data['galery_name']);
      $this->galery_cover = trim($data['galery_cover']. '-' . time() . '-' . rand(1000000, 12340563934));
      $this->deadline = $data['deadline'];
      $this->private = $data['private'];
      $this->watermark = $data['watermark'];
      $this->status = $data['status'];
      $this->password = password_hash($data['password'], PASSWORD_DEFAULT);
   }

   
   public static function create(array $data):array{
      $instance = new self($data);

      return [
         'user_foreign_key' => $instance->user_foreign_key, 
         'galery_name' => $instance->galery_name, 
         'galery_cover' => $instance->galery_cover, 
         'tmp_cover' => $instance->tmp_cover, 
         'deadline' => $instance->deadline, 
         'private' => $instance->private,
         'watermark' => $instance-> watermark, 
         'status' => $instance->status, 
         'password' => $instance->password
      ];
   }
}