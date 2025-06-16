<?php 

namespace App\Middleware;
use App\Http\Request;
use App\Http\Response;
use App\JWT\JWT;
use App\Utils\Url;

class AuthMiddleware{
   private static array $publicRoutes = [
      '/user/login',
      '/user/register'
   ];

   /**
    * Checks wheather the acessed route is public, case not, verify if the user is authenticated.
    * - If the user is acessing a strict route and doesn't send a valid token, returns a response and stops the code execution.
    * @return array{message: string, int: status, responseType: string} on failure.
    */
   public static function verify():mixed{
      $route = Url::sanitizeRouteUrl();

      //If is a public route, doesn't need to ferify it.
      if(in_array($route, self::$publicRoutes)) return true;

      $tokenData = Request::authorization();
      $token = $tokenData['token'] ?? null;
      if (isset($tokenData['error'])) {
         return Response::json(['message' => 'Authorization error: ' . $tokenData['error']], 401, 'error');
         die();
      }

      $userPayload = JWT::verify($token);
      if(!$userPayload){
         return Response::json(['message' => 'Please login to continue.'], 401, 'error');
         die();
      }
      
      return $userPayload;
   }
}