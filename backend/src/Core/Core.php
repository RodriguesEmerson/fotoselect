<?php

namespace App\Core;
Use App\Http\Request;
Use App\Http\Response;
use App\Middleware\AuthMiddleware;
use App\Utils\Url;

class Core{
   public static function dispatch(array $routes){
      $url = Url::sanitizeRouteUrl();

      $prefixController = 'App\\Controllers\\';
      $routeFound = false;

      foreach ($routes as $route) {
         $pattern = '#^' . preg_replace('/{id}/', '([\w-]+)', $route['path']) . '$#';

         if(preg_match($pattern, $url, $matches)){
            array_shift($matches);

            $routeFound = true;
            if($route['method'] !== Request::method()){
               Response::json(['message' => 'Method not allowed.'], 405, 'error');
               return;
            }

            [$controller, $action] = explode('@', $route['action']); 
            $controller = $prefixController . $controller; 
            
            //Verify if the Controller and the Method called really exists.
            if(!class_exists($controller) || !method_exists($controller, $action)){
               Response::json(['message' => 'Invalid controller or method.'], 403, 'error');
               return;
            }
            
            $extendController = new $controller();
            try{
               $extendController->$action(new Request, new Response, $matches);
            }catch(\Throwable $e){
               Response::json(['message' => 'Internal server error.'], 500, 'error');
            }
         }
      }

      if(!$routeFound){
         $controller = $prefixController . 'NotFoundController';
         $extendController = new $controller();
         $extendController->index(new Response);
      }
   }
}
