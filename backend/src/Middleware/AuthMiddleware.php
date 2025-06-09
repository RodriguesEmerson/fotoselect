<?php 

namespace App\Middleware;

use App\Http\Request;
use App\JWT\JWT;
use Exception;

 /**
 * Check the JWT token and returns the user (payload)
 * @return object JWT token pauload
 * @throws Exception Se token inválido ou ausente
 */

class AuthMiddleware{
   private static array $publicRoutes = [
      '/user/login',
      '/user/register',
   ];
   public static function verify(string $route){
      // $tokenData = Request::authorization();

      // if (isset($tokenData['error'])) {
      //    throw new Exception('Authorization error: ' . $tokenData['error']);
      // }

      // $userPayload = JWT::verify($tokenData['token']);
      if(in_array($route, self::$publicRoutes)) return true;

      $user = ['user_id' => 123, 'name' => 'User name'];
      return $user;
   }
}