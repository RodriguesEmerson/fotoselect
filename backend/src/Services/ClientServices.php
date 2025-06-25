<?php 

namespace App\Services;

use App\CloudinaryHandle\CloudinaryHandleImage;
use App\DTOs\ClientsDTOs\ClientDTO;
use App\Exceptions\UnauthorizedException;
use App\JWT\JWT;
use App\Repositories\ClientRepository;

class ClientServices{

   private int $userId;
   private ClientRepository $clientRepository;     

   public function __construct(){
      $this->userId = (int) JWT::getUserId();
      if(!$this->userId){
         throw new UnauthorizedException('Please login to continue.', 401);
      } 
      $this->clientRepository = new ClientRepository();
   }
   
   /**
    * Register a new client.
    * @param array $data Containing the galery data.
    * @return array{error: string, status: int} on Failure.
    * @return array{message: string} on Success.
    */
   public function register(array $data){
      try{
         $data['user_id'] = $this->userId;
         $data = ClientDTO::toArray($data);

         if($data['profile_image']){
            $wasImageUploaded = CloudinaryHandleImage::upload($data['tmp_profile_image'], $data['profile_image']);
            if(isset($wasImageUploaded['error'])){
               return ['error' => 'We could not upload the client image.', 'status' => 500];
            }
            $data['profile_image'] = $wasImageUploaded['url'];
         }

         $wasClientRegistered = $this->clientRepository->register($data);
         if(!$wasClientRegistered){
            return ['error' => 'We could not complete the client registration.', 'status' => 500];
         }

         return ['message' => 'New client resgistered successfuly.'];
      } catch (\InvalidArgumentException $e) {

         return ['error' => $e->getMessage(), 'status' => 400]; 
      }catch (\PDOException $e) {
         
         return ['error' => $e->getMessage(), 'status' => 500]; 
      }catch(\Exception $e){

         return ['error' => $e->getMessage(), 'status' => 500];
      }
   }

   public function update(array $data){
      $data['user_id'] = $this->userId;
      $data = ClientDTO::toArray($data);

      echo json_encode($data);exit;
   }
}