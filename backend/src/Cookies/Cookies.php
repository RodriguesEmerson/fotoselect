<?php 

namespace App\Cookies;

class Cookies{

   /**
    * Set Cookie
    * @param string $name Name of the Cookie that will be seted.
    * @param string $value The value to be seted (token).
    * @param int $expiryInSeconds The Cookie expiration time in sencods.
    * @return bool True wheather the cookie was seted correctly o False if not.
    */
   public static function set(string $name, string $value, int $expiryInSeconds = 3600):bool{
      try{

         setcookie(
            $name,
            $value,
            [
               'expires' => time() + $expiryInSeconds,
               'path' => '/',
               'secure' => true,
               'httponly' => true,
               'samesite' => 'Strict'
            ]
            );
         
         return true;
      }catch(\Throwable $e) {
        return false;
      }
   }

   /**
    * Delete Cookie: Set the expires time to -31 days.
    * @param string $name The name of the cookie to be deleted.
    * @return bool True on succes and False on failure.
    */
   public static function delete(string $name):bool{
      try{
         setcookie($name,'', ['expires' => time() - (3600 * 24 * 31)]);
         return true;
      }catch(\Throwable $e){
         return false;
      }
   }
}