<?php 
namespace App\Services;

use App\JWT\JWT;
use App\Models\UserModels\UserLoginModel;
use App\Models\UserModels\UserRegisterModel;
use App\Repositories\UserRepository;
use InvalidArgumentException;
use PDOException;
use Throwable;

class UserServices extends PDOExeptionErrors{

   /**
    * Resgiter a new user account.
    * @param array $data An array containing the user data.
    * @return array{error: string, status: int} on failure.
    * @return array{message: string} on success.
   */
   public static function register(array $data){
      try{
         $sentData = UserRegisterModel::create($data);
         $wasUserCreated = UserRepository::register($sentData);

         if(!$wasUserCreated) return ['error' => 'It was not possible to create your account, try again.', 'status' => 500];

         return ['message' => 'User created successfuly.'];
      
      }catch(InvalidArgumentException $e){
         
         return ['error' => $e->getMessage() . 'Serverce register-user InvalidArgumentExeption', 'status' => 400];
      }catch(PDOException $e){
   
         return self::getErrorBasedOnCode($e->getCode());
      }catch(Throwable $e){
         return ['error' => $e->getMessage() .  'Internal server error | Servirce register-user SERVER', 'status' => 500];
      }
   }


   /**
    * Fetch the loged user data.
    * @return array{error: string, status: int} on failure.
    * @return array{id: int, name: string, lastname: string, email: string} on success.
    */
   public static function fetch(){
      try{
         $userId = JWT::getUserId();
         $user = UserRepository::fetch($userId['user_id']);

         echo json_encode($user);exit;

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

   /**
    * Log in the user.
    * @param array $data An array containing the crendentials.
    * @return array{error: string, status: int} on failure.
    * @return array{token: string} on success.
    *
   */
   public static function login(array $data){
      try{
         $credentials = UserLoginModel::create($data);
         $userData = UserRepository::login($credentials);
         
         if(!$userData) return ['error' => 'Email or password is incorrect.', 'status' => 400];

         $token = JWT::generate($userData, 3600);

         if(!$token) return ['error' => 'It was not passoble complete login, try again.', 'status' => 500];

         return ['token' => $token];
      
      }catch(InvalidArgumentException $e){
         
         return ['error' => $e->getMessage() . 'Serverce login-user PDO', 'status' => 400];
      }catch(PDOException $e){
         //TODO
         //Build a class with ERROR MESSAGE based on PDO code error;
         return ['error' => 'Internal server error | Serverce login-user PDO', 'status' => 500];
      }catch(Throwable $e){
         return ['error' => 'It was not passoble complete login, try again. | Servirce fetch-user SERVER', 'status' => 500];
      }
   }

   
}