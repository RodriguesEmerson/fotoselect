<?php 
namespace App\Services;

use App\Http\Response;
use App\JWT\JWT;
use App\Repositories\UserRepository;
use Exception;
use PDOException;

class UserServices{
   public static function fetch(){
      try{
         $userId = JWT::getUserId();
         $user = UserRepository::fetch($userId['user_id']);

         if(!$user) return ['error' => 'User not found.', 'status' => 404];

         return $user;

      }catch(PDOException $e){
         //TODO
         //Build a class with PDOExeption error by code;
         Response::json(['message' => 'Internal server error | Serverce fetch-user'], 500, 'error');
      }catch(Exception $e){
         Response::json(['message' => 'Internal server error | Serverce fetch-user'], 500, 'error');
      }
   }
}