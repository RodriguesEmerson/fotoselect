<?php

namespace App\Core;
Use App\Http\Request;
Use App\Http\Response;
use App\Middleware\AuthMiddleware;

class Core{

   public static function dispatch(array $routes){
      $urlParam = filter_input(INPUT_GET, 'url', FILTER_SANITIZE_URL);  
      $url = self::sanitizeRouteUrl($urlParam);

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
            
            //Verify is the Controller and the Method called really exists.
            if(!class_exists($controller) || !method_exists($controller, $action)){
               Response::json(['message' => 'Invalid controller or method.'], 403, 'error');
               return;
            }
            
            if(!AuthMiddleware::verify($url)){
               Response::json(['message' => 'Please login to continue.'], 401, 'error');
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
   private static function sanitizeRouteUrl(?string $url): string {
      if (!$url) return '/';

      // Remove all characters except letters, numbers, slashes, hyphens, and underscores
      $url = preg_replace('/[^a-zA-Z0-9\/_-]/', '', $url);

      // Replace multiple slashes with a single slash
      $url = preg_replace('/\/+/', '/', $url);

      // Remove trailing slash (unless it's the root '/')
      if ($url !== '/') {
         $url = rtrim($url, '/');
      }

      // Ensure the URL always starts with a slash
      return '/' . ltrim($url, '/');
   }
}
