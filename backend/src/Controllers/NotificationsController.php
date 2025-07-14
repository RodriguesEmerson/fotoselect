<?php

namespace App\Controllers;

use App\Http\Request;
use App\Http\Response;
use App\Services\NotificationsServices;
use App\Utils\Validators;

class NotificationsController{
   /**
    * fetchNotifications: Fetch the user notifications.
    * @param Request $request Object representing the HTTP request.
    * @param Response $response Object used to return the HTTP response.
    *
    * @return array Returns a array containing success message on success,
    *               or an error message on failure with the appropriate HTTP status code.
    */
   public function fetch(Request $request, Response $response):array{
      try{
       
         $notificationsServices = new NotificationsServices();
         $serviceResponse = $notificationsServices->fetch();

         if(isset($serviceResponse['error'])){
            return $response::json(['message' => $serviceResponse['error']], $serviceResponse['status'], 'error');
         }


         return $response::json($serviceResponse, 200, 'success');
      }catch(\InvalidArgumentException $e){

         $response::json(['message' => $e->getMessage()], 400, 'error');
      }catch(\Exception $e){
         $response::json(['message' => 'Internal server error | Controller login-user'], 500, 'error');
      }
   }

   /**
    * Read: Mark the notification  as read by id.
    * @param Request $request Object representing the HTTP request.
    * @param Response $response Object used to return the HTTP response.
    *
    * @return array Returns a array containing success message on success,
    *               or an error message on failure with the appropriate HTTP status code.
    */
   public function read(Request $request, Response $response):array{
      try{
         $body = $request::body();
         Validators::checkEmptyField($body);
         $notificationsServices = new NotificationsServices();
         $serviceResponse = $notificationsServices->read($body);

         if(isset($serviceResponse['error'])){
            return $response::json(['message' => $serviceResponse['error']], $serviceResponse['status'], 'error');
         }


         return $response::json($serviceResponse, 200, 'success');
      }catch(\InvalidArgumentException $e){

         $response::json(['message' => $e->getMessage()], 400, 'error');
      }catch(\Exception $e){
         $response::json(['message' => 'Internal server error | Controller login-user'], 500, 'error');
      }
   }
}