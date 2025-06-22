<?php 

namespace App\Exceptions;

use Exception;

class UnauthorizedException extends Exception{

   public function __construct($message = 'Unauthorized', $code = 401, $previous = null){
      parent::__construct($message, $code, $previous);
   }
}