<?php 
namespace App\Services;

use App\DTOs\UserDTOs\LoginUserDTO;
use App\DTOs\UserDTOs\RegisterUserDTO;
use App\JWT\JWT;
use App\Repositories\UserRepository;
use App\Utils\PDOExeptionErrors;
use InvalidArgumentException;
use PDOException;
use Throwable;

class UserServices{

   /**
    * Resgiter a new user account.
    * @param array $data An array containing the user data.
    * @return array{error: string, status: int} on failure.
    * @return array{message: string} on success.
   */
   public static function register(array $data){
      try{
         $sentData = RegisterUserDTO::toArray($data);
         $wasUserCreated = UserRepository::register($sentData);

         if(!$wasUserCreated) return ['error' => 'It was not possible to create your account, try again.', 'status' => 500];

         return ['message' => 'User created successfuly.'];
      
      }catch(InvalidArgumentException $e){
         return ['error' => $e->getMessage() . 'Serverce register-user InvalidArgumentExeption', 'status' => 400];
      }catch(PDOException $e){
         return PDOExeptionErrors::getErrorBasedOnCode($e->getCode());
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
         $userId = (int) JWT::getUserId();
         $user = UserRepository::fetch($userId);

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
         $credentials = LoginUserDTO::toArray($data);
         $userData = UserRepository::login($credentials);

         if(!$userData) return ['error' => 'Incorrect email or password.', 'status' => 400];

         $tokenExpirationTime = $credentials['keeploged'] ? 2592000 : 3600;
         $token = JWT::generate($userData, $tokenExpirationTime);

         if(!$token) return ['error' => 'It was not passoble complete your login, try again.', 'status' => 500];

         return ['token' => $token, 'tokenExpirationTime' => $tokenExpirationTime, 'redirect'=> 'http://localhost:3000/dashboard'];
      
      }catch(InvalidArgumentException $e){
         
         return ['error' => $e->getMessage() . 'Serverce login-user PDO', 'status' => 400];
      }catch(PDOException $e){
         //TODO
         //Build a class with ERROR MESSAGE based on PDO code error;
         return ['error' => 'Internal server error | Serverce login-user PDO', 'status' => 500];
      }catch(Throwable $e){
         return ['error' => 'It was not passoble complete login, try again. | Servirce login-user SERVER' . $e->getMessage(), 'status' => 500];
      }
   }
}