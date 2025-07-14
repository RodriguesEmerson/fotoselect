<?php 

namespace App\Services;

use App\DTOs\NotificationsDTOs\ReadNotificationDTO;
use App\Exceptions\UnauthorizedException;
use App\JWT\JWT;
use App\Repositories\NotificationsRepository;
use DateTime;
use Exception;
use InvalidArgumentException;
use PDOException;
use Throwable;

class NotificationsServices{

   private int $userId;
   private NotificationsRepository $notificationsRepository;

   public function __construct(){
      $this->userId = (int) JWT::getUserId();
      if(!$this->userId){
         throw new UnauthorizedException('Please login to continue.', 401);
      } 
      $this->notificationsRepository = new NotificationsRepository();
   }
   
   /**
    * Create new galery.
    * @param array $data Containing the galery data.
    * @return array{error: string, status: int} on Failure.
    * @return array{message: string} on Success.
    */
   public function create(array $data):array{
      try {
         $data['user_id'] = $this->userId;

        

         return ['message' => 'Galery has been created successfuly.'];
      } catch (InvalidArgumentException $e) {

         return ['error' => $e->getMessage(), 'status' => 400]; 
      }catch (\PDOException $e) {
         
         return ['error' => $e->getMessage(), 'status' => 400]; 
      }catch(Exception $e){

         return ['error' => $e->getMessage(), 'status' => $e->getCode()];
      }
   }

   /**
    * Fetch the user notifications.
    * @param array $data Containing the notifications data.
    * @return array{error: string, status: int} on Failure.
    * @return array{notifications: array} on Success.
    */
   public function fetch():array{
      try {
         $notifications = $this->notificationsRepository->fetch($this->userId);
         if(!$notifications) return ['error' => 'Notifications not found.', 'status' => 500];
         
         return ['notifications' => $notifications];
      } catch (InvalidArgumentException $e) {

         return ['error' => $e->getMessage(), 'status' => 400]; 
      }catch (\PDOException $e) {
         
         return ['error' => $e->getMessage(), 'status' => 400]; 
      }catch(Exception $e){
         return ['error' => $e->getMessage(), 'status' => $e->getCode()];
      }catch(Throwable $e){
         return ['error' => $e->getMessage(), 'status' => $e->getCode()];
      }
   }

   /**
    * Fetch the galery data with its all images.
    * @param array $data Containing the galery data.
    * @return array{error: string, status: int} on Failure.
    * @return array{galery: array, images: array} on Success.
    */
   public function read(array $data):array{
      try {
         $data['user_id'] = $this->userId;
         $data = ReadNotificationDTO::toArray($data);

         $wasNotificationMarkedAsRead = $this->notificationsRepository->read($data);

         if(!$wasNotificationMarkedAsRead){
            
         } 
         
         return ['message' => 'Notification marked as read successfuly.'];  
      } catch (InvalidArgumentException $e) {

         return ['error' => $e->getMessage(), 'status' => 400]; 
      }catch (\PDOException $e) {
         
         return ['error' => $e->getMessage(), 'status' => 400]; 
      }catch(Exception $e){
         return ['error' => $e->getMessage(), 'status' => $e->getCode()];
      }catch(Throwable $e){
         return ['error' => $e->getMessage(), 'status' => $e->getCode()];
      }
   }

   
   /**
    * Delete a galery with its all images.
    * @param array $data With the galery information.
    * @return array{error: string, status: int} on Failure.
    * @return array{message: string} on Success. 
    */
   public function delete(array $data):array{
      try{
         

         return ['message' => 'Galery successfuly deleted.'];
      
      }catch(PDOException $e){
         return ['error' => $e->getMessage(), 'status' => 500];
      }catch(Exception $e){
         
         return ['error' => $e->getMessage(), 'status' => $e->getCode()];
      }catch(Throwable $e){
         return ['error' => 'Internal server error: ' . $e->getMessage(), 'status' => 500];
      }
   }
}