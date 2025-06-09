<?php 

namespace App\Controllers;
Use App\Http\Response;

/**
 * In the case an Incorrect Route is called, this class will be called;
 * @param class Response $response -> Class responsilbe for giving the response to fronend.
 * @return void
 */
class NotFoundController{
   public function index(Response $response):void{
      $response::json(['message' => 'Route not found.'], 404, 'error');
      return;
   }
}