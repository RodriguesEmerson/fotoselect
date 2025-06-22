<?php 

namespace App\Models\GaleryModels;

use App\Models\ModelInterface;
use App\Utils\Validators;
use InvalidArgumentException;

class GaleryCreateModel implements ModelInterface{

   private int $user_id;
   private string $galery_name;
   private string $cdl_id;
   private string $deadline;
   private bool $private;
   private bool $watermark;
   private string $status;
   private string $password;
   private string $tmp_cover;

   private array $requiredFields = [
      'user_id', 'galery_name', 'deadline', 'private','watermark', 'status', 'password'
   ];
   private array $allowedGaleryCoverExtention = ['png', 'jpg', 'jpeg'];
   private array $validsStatus = ['pending'];

   private function __construct(array $data){

      if(isset($data['files']['galery_cover'])){
         Validators::validateImage($this->allowedGaleryCoverExtention, $data['files']['galery_cover']);
         $this->tmp_cover = $data['files']['galery_cover']['tmp_name'];
         $this->cdl_id = uniqid(str_replace(' ', '', trim($data['files']['galery_cover']['name'])));
      }

      //Verify if all required fields was sent.
      foreach ($this->requiredFields AS $field) {
         if($field === 'user_id') continue;
         if(!isset($data[$field])){
            throw new InvalidArgumentException("The field ($field) was not sent.");
         };
      }

      Validators::validateString('galery_name' ,$data['galery_name'], 1, 100);
      Validators::validateString('cdl_id' ,$this->cdl_id, 1, 50);
      Validators::validateDateYMD('deadline',$data['deadline']);
      $data['private'] = Validators::validateAndConvertToBool('private', $data['private']);
      $data['watermark'] = Validators::validateAndConvertToBool('watermark', $data['watermark']);
      Validators::validateString('password' ,$data['password'], 4, 100);
      if(!in_array($data['status'], $this->validsStatus)){
         throw new InvalidArgumentException("The field status does not meets the requirements.");
      }

      $this->user_id = trim($data['user_id']);
      $this->galery_name = strip_tags(trim($data['galery_name']));
      $this->deadline = $data['deadline'];
      $this->private = $data['private'];
      $this->watermark = $data['watermark'];
      $this->status = $data['status'];
      $this->password = password_hash($data['password'], PASSWORD_DEFAULT);
   }

   
   public static function toArray(array $data):array{
      $instance = new self($data);

      return [
         'user_id' => $instance->user_id, 
         'galery_name' => $instance->galery_name, 
         'cdl_id' => $instance->cdl_id, 
         'tmp_cover' => $instance->tmp_cover, 
         'deadline' => $instance->deadline, 
         'private' => $instance->private,
         'watermark' => $instance-> watermark, 
         'status' => $instance->status, 
         'password' => $instance->password
      ];
   }
}