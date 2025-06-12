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

   public static function verify(?string $token):?object{
      if(!$token) return null;
      try{
         return JWTHandler::decode($token, new Key(self::getSecretKey(), 'HS256'));
      }catch(Exception $e){
         return null;
      }
   }

   public static function getUserId(): ?array{

      $token = Request::authorization()['token'] ?? null;
      $decoded = self::verify($token);

      if (!$decoded) return null;

      return ['userId' => $decoded->sub ?? $decoded->user_id ?? null];
   }
}