<?php 

namespace App\Config;

class EnvLoader{
   public static function load(){
      $rootPath = dirname(__DIR__, 2);
      $file = $rootPath . '/.env';
      if(!file_exists($file)){
         die('Erro: File .env not found. Directory:' . realpath($file));
      }

      $lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES); //It ignores empty lines;

      foreach($lines AS $line){
         if(strpos(trim($line), '#') === 0) continue; //Ignores comments;

         list($key, $value) = explode('=', $line, 2);
         putenv("$key=$value");
         $_ENV[$key] = $value;
         $_SERVER[$key] = $value;
      }
   }
}