<?php

namespace App\Http;

/**
 * Response -> É responsável por enviar a resposta, seja erro, bool e dados. 
 *    -json -> Envia a resposta no formato json
 * Poderia haver outros métodos para responder em outros formatos com XML por exemplo.
 * @param array $data -> Dados que serão enviados para o frontend;
 * @param int $status -> Status code da resposta
 */
class Response{
   public static function json(array $content, int $status, string $type){

      $error = $type == 'error' ? true : false;
      $success = $type == 'success' ? true : false;
      
      $response = [
         'error'   => $error, 
         'success' => $success,
         'content'    => $content
      ];

      // echo json_encode($_ENV['APP_ENV']);exit;

      header('Content-Type: application/json');
      $json = json_encode($response);
      if($json === false){
         http_response_code(500);
         echo json_encode([
            'error' => true,
            'success' => false,
            'content' =>['message', 'Error trying to generate the JSON response.']
         ]);
         exit;
      }
      
      http_response_code($status);
      echo $json;
      exit;
   }
}