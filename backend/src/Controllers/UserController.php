<?php 
namespace App\Controllers;
use App\Config\Database;
use App\Http\Request;
use App\Http\Response;
use Exception;

class UserController extends Database{

   public function __construct(){
      self::$pdo = self::getConection();
   }

   public static function fetch(Request $request, Response $response){
      try{
         $response::json(['pdo' => self::$pdo], 200, 'success');

         
      }catch(Exception $e){
         $response::json(['message' => 'Internal server error'], 500, 'error');
      }
   }
}