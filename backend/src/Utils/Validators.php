<?php 

namespace App\Utils;

use DateTime;
use InvalidArgumentException;

class Validators{

   /**
    * Check if the array has some empty field.
    * @param array $data The array with the data to check.
    * @param array $allowedEmptyFields The fiels that may be empty.
    * @throws InvalidArgumentException if any field is empty.
    * @return void 
    */
   public static function checkEmptyField(array $data, array $allowedEmptyFields = []){
      foreach($data AS $field => $value){
         if(!isset($value) || empty($value)){
            if(in_array($field, $allowedEmptyFields)) continue;
            throw new InvalidArgumentException("The field ($field) is required.", 400);
         }
      }
   }

   /**
    * Validate date format Year-month-day.
    * @param string $fieldName The name of the field that will be validated.
    * @param string $date The date to check.
    * @return bool True if is valid or False if is a invalid date.
    */
   public static function validateDateYMD(string $fieldName, string $date, bool $returnBoll = false):bool{
      $formatedDate = DateTime::createFromFormat('Y-m-d', $date);
      $isValidDate = $formatedDate && $formatedDate->format('Y-m-d') === $date;

      
      if(!$isValidDate){
         if($returnBoll) return false;
         throw new InvalidArgumentException("The field ($fieldName), is not a valid date.");
      }

      return true;
   }

   /**
    * Validate the email format.
    * @param string $email The email to be checked.
    * @throws InvalidArgumentException if is a invalid amail.
    * @return bool True if is a valid amail.
    */
   public static function validateEmail(string $email):bool{
      if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
         throw new InvalidArgumentException("Invalid email", 400);
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
         throw new InvalidArgumentException("Invalid password format.", 400);
      }
      if(strlen($password) < 8){
         throw new InvalidArgumentException("Password must be at least 8 characters long.", 400);
      }

      return true;
   }

   /**
    * Validate if is a string and if it is between the min and the max params sent.
    * @param string $fieldName The name of the field that will be validated.
    * @param mixed $string The string to be cheked.
    * @param int $min The min length the string must to be.
    * @param int $max The max length the string must to be.
    * @param bool $returnBool Return only a boolean value. True case the string does not meets the requirements.
    * @return bool True wheather it meets the requirements or False if not.
    */
   public static function validateString(string $fieldName, $string, int $min, int $max, bool $returnBool = false):bool{

      if(!is_string($string) || strlen($string) < $min || strlen($string) > $max || $string !== strip_tags($string)){
         if($returnBool) return false;
         throw new InvalidArgumentException("The field ($fieldName) sent doesn't meets the requirements.", 400);
      };

      return true;
   }


   /**
    * Validate a number in the format (00)00000-0000 (no white spaces).
   *
   * @param string $phone
   * @return bool
   */
   public static function validatePhone(string $phone):bool {
      if(!preg_match('/^\(\d{2}\)\d{5}-\d{4}$/', $phone) === 1){
         throw new InvalidArgumentException('Invalid phone number.', 400);
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

      throw new InvalidArgumentException("The field ($fieldName) is invalid. Expected a boolean value", 400);
   }
   
   /**
    * Validate numerics
    * Checks if the value is a number, whether it is int|float or string.
    * @param string $fieldName The name of the field being validated (used for exception messages).
    * @param mixed $value The value that will be validated.
    * @param int $max The maximum length the number can be.
    * @return bool True if the value is valid.
    * @throws InvalidArgumentException If the value does not meets the expected.
    */
   public static function validateNumeric(string $fieldName,$value, int $max){
      if(!is_numeric($value)){
         throw new InvalidArgumentException("The field ($fieldName) is invalid. Expected a numeric value", 400);
      }
      
      if(strlen($value) > $max){
         throw new InvalidArgumentException("The field ($fieldName) is invalid. Expected a number with maximum 11 characters", 400);
      }

      return true;
   }

   /**
    * Checks if the image has a valid format.
    * @param array $allowedExtensions Allowed extensions (e.g., ['jpg', 'jpeg', 'png']).
    * @param array $imageFile The complete image file.
    * @param bool $returnBool Return only a boolean value. True case the image is valid and False case not.
    * @return bool True if it is a valid image.
    * @throws InvalidArgumentException Throws an error informing why the image is invalid. $returnBool must be False.
    */
   public static function validateImage(array $allowedExtensions, array $imageFile, $returnBool = false):bool{

      $errorMessage = null;

      if(!isset($imageFile['tmp_name']) || $imageFile['error'] !== 0){ 
         $errorMessage = 'Upload failed or image not provided.';
      }
      
      if(!getimagesize($imageFile['tmp_name']) && !$errorMessage){
         $errorMessage = $imageFile['name'] . ": Is not a valid image.";
      }
      
      if(!$errorMessage){
         // Gets the real MIME: image/realExtension
         $mime = mime_content_type($imageFile['tmp_name']);
   
         // Map MIME to real extension
         foreach($allowedExtensions AS $extension){
            $mimeToExt['image/'. $extension] = $extension;
         }
   
         if (!isset($mimeToExt[$mime])) {
            $errorMessage = "Unsupported image type: $mime";
         }
         
         // Verify if the real extension is in the allowed extensions list.
         $realExtension = $mimeToExt[$mime];
         if (!in_array($realExtension, $allowedExtensions) && !$errorMessage) {
            $errorMessage = "Invalid image extension: .$realExtension";
         }
      }
      
      if($errorMessage){
         if($returnBool) return false;
         throw new InvalidArgumentException($errorMessage, 400);
      }
      return true;
   }
}