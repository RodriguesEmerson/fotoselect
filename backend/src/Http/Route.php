<?php

namespace App\Http;
/**
 * This class is responsible for registering and managing the application routes.   
 * It suports HTTP methods: GET, POST, PUT and DELETE.
 * 
 * Each route is composed by:
 * - Path (path).
 * - Action (controller@method ou collable).
 * - HTTP methods (GET, POST, PUT and DELETE).
 * 
 * Duplicated routes is going to be overwritten.
 * 
 * All functions returns :void.
 */
class Route{
   private static $routes = [];

   public static function get(string $path, string $action):void{
      self::registerRoute('GET', $path, $action);
   }
   public static function post(string $path, string $action):void{
      self::registerRoute('POST', $path, $action);
   }
   public static function put(string $path, string $action):void{
      self::registerRoute('PUT', $path, $action);
   }
   public static function delete(string $path, string $action):void{
      self::registerRoute('DELETE', $path, $action);
   }

   /**
    * Registrate a new route or replaces an existing route whith the same method and path.
    * @param string $method HTTP method.
    * @param string $path   Route path.
    * @param string $action Action to be executed.
    * @return void
    */
   private static function registerRoute(string $method, string $path, string $action):void{
      //Removes the Route if it already exists.
      self::$routes = array_filter(self::$routes, fn($route) => 
         !($route['path'] === $path && $route['method'] === $method)
      );

      //Add the Route.
      self::$routes[] = [
         'path' => rtrim($path, '/'),
         'action' => $action,
         'method' => $method
      ];
   }

   public function routes(){
      return self::$routes;
   }
}