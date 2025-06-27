<?php 

namespace App\Services;

use App\CloudinaryHandle\CloudinaryHandleImage;
use App\DTOs\ClientsDTOs\ClientDTO;
use App\DTOs\ClientsDTOs\DelteClientDTO;
use App\DTOs\ClientsDTOs\UpdateClientImageDTO;
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
    * @param array $data client data.
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
            $data['cdl_id'] = $data['profile_image'];
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

   /**
    * Update the client data except the profile_image.
    * @param array $data Wiith the client data.
    * @return array{error: string, status: int} on Failure.
    * @return array{message: string} on Success.
    */
   public function update(array $data){
      try{

         $data['user_id'] = $this->userId;
         $data = ClientDTO::toArray($data);

         $client = $this->clientRepository->getClientByEmail($data);
         if(!$client) return ['error' => 'Does not exists a client with this email.', 'status' => 400];

         $wasClientUpdated = $this->clientRepository->update($data);
         if(!$wasClientUpdated) return ['error' => 'Something went wrong!', 'status' => 500];

         return ['message' => 'Client updated'];

         // echo json_encode($wasClientUpdated);exit;
      } catch (\InvalidArgumentException $e) {

         return ['error' => $e->getMessage(), 'status' => 400]; 
      }catch (\PDOException $e) {
         
         return ['error' => $e->getMessage(), 'status' => 500]; 
      }catch(\Exception $e){

         return ['error' => $e->getMessage(), 'status' => 500];
      }
   }

   /**
    * Update the client profile image.
    * @param array $data client image.
    * @return array{error: string, status: int} on Failure.
    * @return array{message: string} on Success.
    */
   public function changeImage(array $data){
      try{
         $data['user_id'] = $this->userId;
         $data = UpdateClientImageDTO::toArray($data);
         
         $client = $this->clientRepository->getClientByEmail($data);
         if(!$client) return ['error' => 'Does not exists a client with this email.', 'status' => 400];

         //Try to delete the old client image.
         $wasImageDeleted = CloudinaryHandleImage::delete($client->cdl_id);
         if(isset($wasImageDeleted['error'])){
            return ['error' => 'We could not change the client image.', 'status' => 500];
         }

         //Try to upload the new client image.
         $wasImageUploaded = CloudinaryHandleImage::upload($data['tmp_profile_image'], $data['profile_image']);
         if(isset($wasImageUploaded['error'])){
            return ['error' => 'We could not upload the client image.', 'status' => 500];
         }
         $data['cdl_id'] = $data['profile_image'];
         $data['profile_image'] = $wasImageUploaded['url'];


         $wasImageDataSeved = $this->clientRepository->changeImage($data);
         if(!$wasImageDataSeved){
            return ['error' => 'We could not complete the client registration.', 'status' => 500];
         }

         return ['message' => 'The client image has been updated.'];
      } catch (\InvalidArgumentException $e) {

         return ['error' => $e->getMessage(), 'status' => 400]; 
      }catch (\PDOException $e) {
         
         return ['error' => $e->getMessage(), 'status' => 500]; 
      }catch(\Exception $e){

         return ['error' => $e->getMessage(), 'status' => 500];
      }
   }

   /**
    * Delete client data.
    * @param array $data with client id.
    * @return array{error: string, status: int} on Failure.
    * @return array{message: string} on Success.
    */
   public function delete(array $data){
      try{
         $data['user_id'] = $this->userId;
         $data = DelteClientDTO::toArray($data);

         $client = $this->clientRepository->getClientById($data);
         if(!$client) return ['error' => 'Client not found.', 'status' => 400];

         //Try to delete the old client image.
         $wasImageDeleted = CloudinaryHandleImage::delete($client->cdl_id);
         if(isset($wasImageDeleted['error'])){
            return ['error' => 'It was not possible delete the client image.', 'status' => 500];
         }

         $wasClinetDeleted = $this->clientRepository->delete($data);
         if(!$wasClinetDeleted){
            return ['error' => 'Error trying to delete client in bd.', 'status' => 500];
         }

         return ['message' => 'Client deleted successfuly'];

      } catch (\InvalidArgumentException $e) {

         return ['error' => $e->getMessage(), 'status' => 400]; 
      }catch (\PDOException $e) {
         
         return ['error' => $e->getMessage(), 'status' => 500]; 
      }catch(\Exception $e){

         return ['error' => $e->getMessage(), 'status' => 500];
      }
   }
}