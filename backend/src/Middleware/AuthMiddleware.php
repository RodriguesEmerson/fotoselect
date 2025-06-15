<?php 

namespace App\Middleware;

use App\Http\Request;
use App\Http\Response;
use App\JWT\JWT;
use App\Utils\Url;

 /**
 * Check the JWT token and returns the user (payload).
 * @return object JWT token payload.
 * @return array If the token is invalid.
 */

class AuthMiddleware{
   private static array $publicRoutes = [
      '/user/login',
      '/user/register',
   ];
   public static function verify(){
      $route = Url::sanitizeRouteUrl();

      //If the route is a public route, doesn't need to ferify.
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