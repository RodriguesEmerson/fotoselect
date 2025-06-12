<?php 
namespace App\Controllers;
use App\Http\Request;
use App\Http\Response;
use App\Services\UserServices;
use App\Utils\UserValidators;
use Exception;
use InvalidArgumentException;
use Throwable;

class UserController{

   public static function fetch(Request $request, Response $response){
      try{
         $serviceResponse = UserServices::fetch();

         if(isset($serviceResponse['error'])){
            return $response::json(['message' => $serviceResponse['error']], $serviceResponse['status'], 'error');
         }

         return $response::json($serviceResponse, 200, 'success');       
      }catch(Exception $e){
         $response::json(['message' => 'Internal server error | Controller fetch-user'], 500, 'error');
      }
   }
   

   /**
    *
    * @param Request $request Object representing the HTTP request.
    * @param Response $response Object used to return the HTTP response.
    *
    * @return mixed Returns a JSON response containing login data on success,
    *               or an error message with the appropriate HTTP status code on failure.
    */
   public static function login(Request $request, Response $response){
      try{
         $body = $request::body();
         UserValidators::checkEmptyField($body);

         $serviceResponse = UserServices::login($body);

         if(isset($serviceResponse['error'])){
            return $response::json(['message' => $serviceResponse['error']], $serviceResponse['status'], 'error');
         }

         return $response::json($serviceResponse, 200, 'success');
      }catch(InvalidArgumentException $e){

         $response::json(['message' => $e->getMessage()], 400, 'error');
      }catch(Exception $e){
         $response::json(['message' => 'Internal server error | Controller login-user'], 500, 'error');
      }
   }

   /**
    *
    * @param Request $request Object representing the HTTP request.
    * @param Response $response Object used to return the HTTP response.
    *
    * @return mixed Returns a JSON response containing login data on success,
    *               or an error message with the appropriate HTTP status code on failure.
    */
   public static function register(Request $request, Response $response){
      try{
         $body = $request::body();
         UserValidators::checkEmptyField($body);


      }catch(InvalidArgumentException $e){

      }
      catch (Exception $e) {

      }
   }
}