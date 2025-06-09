<?php

namespace App\Http;

/**
 * Request->method: Gets the request method -[GET, POST, PUT, DELETE];
 *    @return string The method taken;
 * Request->body: Gets the body of the request.
 *    @return array If the method is different from 'GET', returns the request's body, else returns the GET method.
 * Request->authorization: Gets the sent token.
 *    @return array|string Returns an error, if the token hasn't the correctly formart or not be provided, or the token.
 * 
 */
class Request{
   public static function method(){
      return $_SERVER['REQUEST_METHOD'];
   }

   public static function body(){
      $method = self::method();

      if ($method === 'GET') return $_GET;

      $contentType = $_SERVER['CONTENT_TYPE'] ?? '';
      if(str_contains($contentType, 'application/json')){
         $body = json_decode(file_get_contents('php://input'), true) ?? [];
         return is_array($body) ? $body : [];
      }

      return [];
   }

   public static function authorization(){
      //Gets the corretly header regardelles of the server;
      $headers = array_change_key_case(getallheaders(), CASE_LOWER);

      if(!isset($headers['authorization'])) return ['error' => 'Not authorization header provided.'];
      
      $authorizationPartials = explode(' ', $headers['authorization']);

      if(count($authorizationPartials) !== 2 || strtolower($authorizationPartials[0]) !== 'bearer'){   
         return ['error' => 'Invalid Authorization header.'];
      } 

      return ['token' => $authorizationPartials[1]];
   }
}