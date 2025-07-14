<?php 

namespace App\DTOs\NotificationsDTOs;

use App\DTOs\DTOsInterface;
use App\Utils\Utilitaries;
use App\Utils\Validators;
use InvalidArgumentException;

class ReadNotificationDTO implements DTOsInterface{
   
   private int $id;
   private int $user_id;
   private string $date;

   private function __construct(array $data){

      if(!isset($data['id'])){
         throw new InvalidArgumentException("The notification id was not provided.");
      }

      Validators::validateNumeric('id', $data['id'], 11);

      $this->id = $data['id'];
      $this->user_id = $data['user_id'];
      $this->date = Utilitaries::getDateTime();
   }

   public static function toArray(array $data):array{
      $instace = new self($data);
      return [
         'id' => $instace->id,
         'user_id' => $instace->user_id,
         'date' => $instace->date
      ];
   }
}