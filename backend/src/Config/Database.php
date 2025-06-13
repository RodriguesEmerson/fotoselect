<?php 

namespace App\Config;
use PDO;
use PDOException;

abstract class Database{
   protected static $pdo;

   protected static function getConection(){
      if(self::$pdo) return self::$pdo;

      try{
         $db = $_ENV['DB_NAME'] ?? '';
         $host = $_ENV['DB_HOST'] ?? '';
         $user = $_ENV['DB_USER'] ?? '';
         $password = $_ENV['DB_PASS'] ?? '';

         self::$pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", "$user", "$password");
         self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
         return self::$pdo;
      }catch(PDOException $e){
         return null;
      }
   }
}