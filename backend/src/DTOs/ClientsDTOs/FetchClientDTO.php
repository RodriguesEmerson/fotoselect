<?php 

namespace App\DTOs\ClientsDTOs;

use App\DTOs\DTOsInterface;
use App\Utils\Validators;
use InvalidArgumentException;

class FetchClientDTO implements DTOsInterface{

   private int $user_id;
   private int $client_id;

   private function __construct(array $data){
      if(!isset($data['url'])){
         throw new InvalidArgumentException('Invalid URL provided.', 400);
      }

      $sentClientId = preg_match('/[^\/]+$/', $data['url'], $matches);
      if($sentClientId === 0){
         throw new InvalidArgumentException('Client id was not sent.', 400);
      }
      $sentClientId = ($matches[0]);

      Validators::validateNumeric('client_id', $sentClientId, 11);

      $this->user_id = $data['user_id'];
      $this->client_id = $sentClientId;
   }

   public static function toArray(array $data):array{
      $instance = new self($data);
      return[
         'user_id' => $instance->user_id,
         'client_id' => $instance->client_id
      ];
   }
}