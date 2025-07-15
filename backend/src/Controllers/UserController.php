<?php 
namespace App\Controllers;

use App\Cookies\Cookies;
use App\Http\Request;
use App\Http\Response;
use App\Services\UserServices;
use App\Utils\Validators;
use Exception;
use InvalidArgumentException;
use Throwable;

class UserController{

   /**
    * @param Request $request Object representing the HTTP request.
    * @param Response $response Object used to return the HTTP response.
    *
    * @return mixed Returns a JSON response containing login data on success,
    *               or an error message with the appropriate HTTP status code on failure.
    */
   public static function register(Request $request, Response $response){
      try{
         $body = $request::body();
         Validators::checkEmptyField($body);

         $serviceResponse = UserServices::register($body);

         if(isset($serviceResponse['error'])){
            return $response::json(['message' => $serviceResponse['error']], $serviceResponse['status'], 'error');
         }

         return $response::json($serviceResponse, 200, 'success');

      }catch(InvalidArgumentException $e){
          $response::json(['message' => $e->getMessage()], 400, 'error');
      }catch (Exception $e) {
          $response::json(['message' => 'Internal server error | Controller login-user'], 500, 'error');
      }
   }

   /**
    * @param Request $request Object representing the HTTP request.
    * @param Response $response Object used to return the HTTP response.
    *
    * @return array Returns a array containing the user data on success,
    *               or an error message on failure with the appropriate HTTP status code.
    */
   public static function fetch(Request $request, Response $response):array{
      try{
         $userData = UserServices::fetch();

         if(isset($userData['error'])){
            return $response::json(['message' => $userData['error']], $userData['status'], 'error');
         }

         return $response::json($userData, 200, 'success');       
      }catch(Exception $e){
         $response::json(['message' => 'Internal server error | Controller fetch-user'], 500, 'error');
      }
   }

   /**
    * @param Request $request Object representing the HTTP request.
    * @param Response $response Object used to return the HTTP response.
    *
    * @return array Returns a array containing the user data on success,
    *               or an error message on failure with the appropriate HTTP status code.
    */
   public static function fetchDashData(Request $request, Response $response):array{
      try{
         $dashData = UserServices::fetchDashData();

         if(isset($dashData['error'])){
            return $response::json(['message' => $dashData['error']], $dashData['status'], 'error');
         }

         return $response::json($dashData, 200, 'success');       
      }catch(Exception $e){
         $response::json(['message' => 'Internal server error | Controller fetch-dashdata'], 500, 'error');
      }
   }
   

   /**
    * @param Request $request Object representing the HTTP request.
    * @param Response $response Object used to return the HTTP response.
    *
    * @return array Returns a array containing success message on success,
    *               or an error message on failure with the appropriate HTTP status code.
    */
   public static function login(Request $request, Response $response):array{
      try{
         $body = $request::body();
         $serviceResponse = UserServices::login($body);

         if(isset($serviceResponse['error'])){
            return $response::json(['message' => $serviceResponse['error']], $serviceResponse['status'], 'error');
         }

         //Set the token
         if(!Cookies::set('FSJWTToken', $serviceResponse['token'], $serviceResponse['tokenExpirationTime'])){
            return $response::json(['message' => 'Internal server error'], 500, 'error');
         }

         return $response::json(['message' => 'Loged successfuly', 'redirect' => $serviceResponse['redirect']], 200, 'success');
      }catch(InvalidArgumentException $e){

         $response::json(['message' => $e->getMessage()], 400, 'error');
      }catch(Exception $e){
         $response::json(['message' => 'Internal server error | Controller login-user'], 500, 'error');
      }
   }


   /**
    * Logout: Delete cookie with the auth token.
    * @param Request $request Object representing the HTTP request.
    * @param Response $response Object used to return the HTTP response.
    *
    * @return array Returns a array containing success message on success,
    *               or an error message on failure with the appropriate HTTP status code.
    */
   public static function logout(Request $request, Response $response):array{
      try{

         $wasCookieDeleted = Cookies::delete('FSJWTToken');
         if(!$wasCookieDeleted){
            return $response::json(['message' => 'Somethig went wrong, try again.'], 500, 'error');
         }


         return $response::json(['message' => 'Loged out successfuly', 'route' => 'site/login'], 200, 'success');
      
      }catch(Throwable $e){
         $response::json(['message' => 'Internal server error | Controller logout-user'], 500, 'error');
      }
   }

   
}