<?php 

namespace App\Utils;

use DateTime;
use InvalidArgumentException;

class Validators{

   /**
    * Check if the array has some empty field.
    * @param array $data The array with the data to check.
    * @throws InvalidArgumentException if any field is empty.
    * @return void 
    */
   public static function checkEmptyField(array $data){
      foreach($data AS $field => $value){
         if(!isset($value) || empty($value)){
            throw new InvalidArgumentException("The field ($field) is required.");
         }
      }
   }

   /**
    * Validate date format Year-month-day.
    * @param string $fieldName The name of the field that will be validated.
    * @param string $date The date to check.
    * @return bool True if is valid or False if is a invalid date.
    */
   public static function validateDateYMD(string $fieldName, string $date):bool{
      $formatedDate = DateTime::createFromFormat('Y-m-d', $date);
      return $formatedDate && $formatedDate->format('Y-m-d') === $date;
   }

   /**
    * Validate the email format.
    * @param string $email The email to be checked.
    * @throws InvalidArgumentException if is a invalid amail.
    * @return bool True if is a valid amail.
    */
   public static function validateEmail(string $email):bool{
      if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
         throw new InvalidArgumentException("Invalid email");
      }
      return true;
   }

   /**
    * Validate Password format. Checks if it is a string and if it has at least 8 characters long.
    * @param mixed $password Password to check.
    * @throws InvalidArgumentException if the password isn't a string or has less the 8 characters long.
    * @return bool True if the password has a valid format.
    */
   public static function validatePasswordFormat($password):bool{
      if(!is_string($password)){
         throw new InvalidArgumentException("Invalid password format.");
      }
      if(strlen($password) < 8){
         throw new InvalidArgumentException("Password must be at least 8 characters long.");
      }

      return true;
   }

   /**
    * Validate if is a string and if it is between the min and the max params sent.
    * @param string $fieldName The name of the field that will be validated.
    * @param mixed $string The string to be cheked.
    * @param int $min The min length the string must to be.
    * @param int $max The max length the string must to be.
    * @return bool True wheather it meets the requirements or False if not.
    */
   public static function validateString(string $fieldName, $string, int $min, int $max):bool{
      if(!is_string($string) || strlen($string) < $min || strlen($string) > $max){
         throw new InvalidArgumentException("The field ($fieldName) sent doesn't meets the requirements.");
      };

      return true;
   }

   /**
    * Validates and converts a value to a boolean type.
    * Accepts the following values as valid booleans:
    * - true, false (boolean)
    * - 'true', 'false', '1', '0', 1, 0 (string or integer)
    * Throws an InvalidArgumentException if the value cannot be interpreted as a boolean.
    * @param string $fieldName The name of the field being validated (used for exception messages).
    * @param mixed $value The value to validate and convert.
    * @throws InvalidArgumentException If the value is not a recognizable boolean.
    * @return bool The corresponding boolean value.
    */
   public static function validateAndConvertToBool(string $fieldName ,$value):bool{
      if(is_bool($value)) return $value;
      if(in_array($value, ['true', '1', 1])) return true;
      if(in_array($value, ['false', '0', 0])) return false;

      throw new InvalidArgumentException("The field ($fieldName) is invalid. Expected a boolean value");
   }

   /**
    * Checks if the image has a valid format.
    * @param array $allowedExtensions Allowed extensions (e.g., ['jpg', 'jpeg', 'png']).
    * @param array $imageFile The complete image file.
    * @throws InvalidArgumentException Informing the image extension is invalid.
    * @return bool True if it is a valid image.
    */
   public static function validateImage(array $allowedExtensions, array $imageFile):bool{
      if(!isset($imageFile['tmp_name']) || $imageFile['error'] !== 0){ 
         throw new InvalidArgumentException("Upload failed or image not provided.");
      }
      
      if(!getimagesize($imageFile['tmp_name'])){
         throw new InvalidArgumentException( $imageFile['name']. ": Is not a valid image.");
      }
      
      // Gets the real MIME
      $mime = mime_content_type($imageFile['tmp_name']);

      // Map MIME to real extension
      $mimeToExt = [
         'image/jpeg' => 'jpg',
         'image/png' => 'png',
         'image/jpg' => 'jpg'
      ];

      if (!isset($mimeToExt[$mime])) {
         throw new InvalidArgumentException("Unsupported image type: $mime");
      }

      $realExtension = $mimeToExt[$mime];

      // Verifica se a extensão real está na lista permitida
      if (!in_array($realExtension, $allowedExtensions)) {
         throw new InvalidArgumentException("Invalid image extension: .$realExtension");
      }

      return true;
   }
}