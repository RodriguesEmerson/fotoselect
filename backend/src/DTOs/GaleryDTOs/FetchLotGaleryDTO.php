<?php 
namespace App\DTOs\GaleryDTOs;

use App\DTOs\DTOsInterface;
use App\Utils\Validators;
use InvalidArgumentException;

class FetchLotGaleryDTO implements DTOsInterface{

   private int $user_id;
   private int $limit;
   private int $offset;

   private function __construct(array $data){
      if(!isset($data['url'])){
         throw new InvalidArgumentException('Invalid URL provided.', 400);
      }

      $limit = preg_match('/\/[0-9]+\//', $data['url'], $matches);
      if($limit === 0){
         throw new InvalidArgumentException('The limit was not sent.', 400);
      }
      $limit = (int) str_replace('/', '', $matches[0]);

      $offset = preg_match('/\/[0-9]+$/', $data['url'], $matches);
      if($offset === 0){
         throw new InvalidArgumentException('The offset was not sent.', 400);
      }
      $offset = (int) str_replace('/', '', $matches[0]);

      Validators::validateNumeric('limit', $limit, 2);
      Validators::validateNumeric('offset', $offset, 2);

      $this->user_id = $data['user_id'];
      $this->limit = $limit;
      $this->offset = $offset;
   }

   public static function toArray(array $data):array{
      $instance = new self($data);
      return[
         'user_id' => $instance->user_id,
         'limit' => $instance->limit,
         'offset' => $instance->offset
      ];
   }
}