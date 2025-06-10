<?php 
namespace App\Controllers;
use App\Http\Request;
use App\Http\Response;
use App\Services\UserServices;
use Exception;

class UserController{

   public static function fetch(Request $request, Response $response){
      try{
         $userData = UserServices::fetch();

         if(isset($userData['error'])){
            return $response::json(['message' => $userData['error']], $userData['status'], 'error');
         }

         $response::json($userData, 200, 'success');       
      }catch(Exception $e){
         $response::json(['message' => 'Internal server error | Controller fetch-user'], 500, 'error');
      }
   }
}