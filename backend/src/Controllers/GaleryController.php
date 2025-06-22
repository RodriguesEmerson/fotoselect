<?php 

namespace App\Controllers;

use App\CloudinaryHandle\UploadImage;
use App\Http\Request;
use App\Http\Response;
use App\Services\GaleryServices;
use App\Utils\ImagesHandle;
use App\Utils\Validators;
use Exception;
use InvalidArgumentException;

class GaleryController{

   /**
    * Create a new galery.
    * @param Request $request Object representing the HTTP request.
    * @param Response $response Object used to return the HTTP response.
    *
    * @return mixed Returns a JSON response containing login data on success,
    *               or an error message with the appropriate HTTP status code on failure.
    */
   public static function create(Request $request, Response $response){
      try {
         $body = $request::body();
         Validators::checkEmptyField($body);

         $galeryServices = new GaleryServices();
         $serviceResponse = $galeryServices->create($body);

         if(isset($serviceResponse['error'])){
            return $response::json(['message' => $serviceResponse['error']], $serviceResponse['status'], 'error');
         } 

         $response::json($serviceResponse, 200, 'success');
      } catch (InvalidArgumentException $e) {
         return $response::json(['message' => $e->getMessage()], 400, 'error');
      }catch(Exception $e){
         return $response::json(['message' => 'Internal server error.'], 500, 'error');
      }
   }

   /**
    * Upload images into a galery.
    * @param Request $request Object representing the HTTP request.
    * @param Response $response Object used to return the HTTP response.
    *
    * @return mixed Returns a JSON response containing login data on success,
    *               or an error message with the appropriate HTTP status code on failure.
    */
   public static function upload(Request $request, Response $response){
      try {
         $body = $request::body();
         Validators::checkEmptyField($body);

         $images = ImagesHandle::getValidAndInvalidImages($body['files'], 'images');

         //Remove 'files' from body.
         unset($body['files']);
         // $body = array_filter($body, fn($field) => $field !== 'files', ARRAY_FILTER_USE_KEY);

         //Set only the valid images into the body.
         $body['images'] = $images['validImages'];

         $galeryServices = new GaleryServices();
         $serviceResponse = $galeryServices->upload($body);

         if(isset($serviceResponse['error'])){
            return $response::json(['message' => $serviceResponse['error']], $serviceResponse['status'], 'error');
         }
         $response::json([...$serviceResponse, 'invalidImages' => $images['invalidImages']], 201, 'success');
      } catch (InvalidArgumentException $e) {
         return $response::json(['message' => $e->getMessage()], 400, 'error');
      }catch(Exception $e){
         return $response::json(['message' => 'Internal server error.'], 500, 'error');
      }
   }
}