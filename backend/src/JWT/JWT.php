<?php

namespace App\JWT;

use App\Http\Request;
use Exception;
use Firebase\JWT\JWT as JWTHandler;
use Firebase\JWT\Key;

class JWT{
   private static string $secret_key;

   private static function getSecretKey(): string {
      return self::$secret_key ?? getenv('JWT_SECRET_KEY');
   }

   /**
    * Generate a JWT token.
    * @param array $userData The token's payload.
    * @param int $tokenExpiresTime The time the token will be expired/invalid.
    * @return null|string The generated JWT Token.
    */
   public static function generate(array $userData, int $tokenExpiresTime): ?string{
      try{
         $payload = [
            ...$userData,
            'iss' => 'localhost',
            'iat' => time(),
            'exp' => time() + $tokenExpiresTime
         ];
         return JWTHandler::encode($payload, self::getSecretKey(), 'HS256');
      }catch(Exception $e){
         return null;
      }
   }

   /**
    * Verify wheather the token sent in the headers is valid.
    * @param null|string $token Token to verify.
    * @return null|object containing the user data.
    */
   public static function verify(?string $token):?object{
      if(!$token) return null;
      try{
         return JWTHandler::decode($token, new Key(self::getSecretKey(), 'HS256'));
      }catch(Exception $e){
         return null;
      }
   }

   /**
    * Gets the loged user ID if the token is valid.
    * @return null|array{userId: string}
    */
   public static function getUserId(): ?int{
      $token = Request::authorization()['token'] ?? null;
      $decoded = self::verify($token);

      if (!$decoded) return null;

      $userId = ['user_id' => $decoded->sub ?? $decoded->user_id ?? null];
      return $userId['user_id'];
   }
}