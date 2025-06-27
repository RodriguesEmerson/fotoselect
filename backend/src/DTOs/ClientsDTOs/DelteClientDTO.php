<?php 

namespace App\DTOs\ClientsDTOs;

use App\DTOs\DTOsInterface;
use App\Utils\Validators;
use InvalidArgumentException;

class DelteClientDTO implements DTOsInterface{

   private int $user_id;
   private int $client_id;

   private function __construct(array $data){
      if(!isset($data['client_id'])){
         throw new InvalidArgumentException('Client information was not sent.', 400);
      } 

      Validators::validateNumeric('Client id', $data['client_id'], 11);

      $this->user_id = $data['user_id'];
      $this->client_id = $data['client_id'];
   }

   public static function toArray(array $data):array{
      $instance = new self($data);
      return [
         'user_id' => $instance->user_id,
         'client_id' => $instance->client_id
      ];
   }
}