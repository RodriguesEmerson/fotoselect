<?php 

namespace App\Config;
use PDO;
use PDOException;

class Database{
   private static $pdo;

   private static function getConection(){
      if(self::$pdo) return self::$pdo;

      return 'Conneted';
      try{
         $db = $_ENV['DB_NAME'] ?? '';
         $host = $_ENV['DB_HOST'] ?? '';
         $user = $_ENV['DB_USER'] ?? '';
         $password = $_ENV['DB_PASS'] ?? '';

         self::$pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", "$user", "$password");
         self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      }catch(PDOException $e){
         return null;
      }
   }
}