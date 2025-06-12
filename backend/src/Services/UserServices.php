<?php 
namespace App\Services;

use App\Http\Response;
use App\JWT\JWT;
use App\Repositories\UserRepository;
use Exception;
use InvalidArgumentException;
use PDOException;
use Throwable;

class UserServices{
   public static function fetch(){
      try{
         $userId = JWT::getUserId();
         $user = UserRepository::fetch($userId['user_id']);

         if(!$user) return ['error' => 'User not found.', 'status' => 404];

         return $user;

      }catch(PDOException $e){
         //TODO
         //Build a class with ERROR MESSAGE based on PDO code error;
         return['error' => 'Internal server error | Serverce fetch-user PDO', 'status' => 500];
      }catch(Throwable $e){
        return ['error' => 'Internal server error | Serverce fetch-user SERVER', 'status' => 500];
      }
   }

   public static function login(array $data){
      try{
         $wasUserCreated = UserRepository::login($data);

         if(!$wasUserCreated) return ['error' => 'It was not possible to create your account, try again.', 'status' => 500];

         return ['message' => 'User created successfuly.'];
      
      }catch(InvalidArgumentException $e){
         
         return ['error' => $e->getMessage() . 'Serverce login-user PDO', 'status' => 400];
      }catch(PDOException $e){
         //TODO
         //Build a class with ERROR MESSAGE based on PDO code error;
         return ['error' => 'Internal server error | Serverce login-user PDO', 'status' => 500];
      }catch(Throwable $e){
         return ['error' => 'Internal server error | Servirce fetch-user SERVER', 'status' => 500];
      }
   }
}