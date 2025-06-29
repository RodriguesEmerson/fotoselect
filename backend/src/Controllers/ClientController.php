<?php 

namespace App\Controllers;

use App\Exceptions\UnauthorizedException;
use App\Http\Request;
use App\Http\Response;
use App\Services\ClientServices;
use App\Utils\Validators;

class ClientController{
   /**
    * Register a new client.
    * @param Request $request Object representing the HTTP request.
    * @param Response $response Object used to return the HTTP response.
    *
    * @return mixed Returns a JSON response containing login data on success,
    *               or an error message with the appropriate HTTP status code on failure.
    */
   public function register(Request $request, Response $response){
      try {
         $body = $request::body();
         Validators::checkEmptyField($body, ['phone', 'profile_image']);

         $clientServices = new ClientServices();
         $serviceResponse = $clientServices->register($body);

         if(isset($serviceResponse['error'])){
            return $response::json(['message' => $serviceResponse['error']], $serviceResponse['status'], 'error');
         }

         $response::json($serviceResponse, 200, 'success');
      } catch (UnauthorizedException $e) {
         return $response::json(['message' => $e->getMessage()], 401, 'error');

      } catch (\InvalidArgumentException $e) {
         return $response::json(['message' => $e->getMessage()], 400, 'error');
      }catch(\Exception $e){
         return $response::json(['message' => 'Internal server error.'], 500, 'error');
      }
   }

   /**
    * Fetch client by id.
    * @param Request $request Object representing the HTTP request.
    * @param Response $response Object used to return the HTTP response.
    *
    * @return mixed Returns a JSON response containing login data on success,
    *               or an error message with the appropriate HTTP status code on failure.
    */
   public function fetch(Request $request, Response $response){
      try {

         $body = $request::body(); //url

         $clientServices = new ClientServices();
         $serviceResponse = $clientServices->fetch($body);

         if(isset($serviceResponse['error'])){
            return $response::json(['message' => $serviceResponse['error']], $serviceResponse['status'], 'error');
         }

         $response::json($serviceResponse, 200, 'success');
      } catch (UnauthorizedException $e) {
         return $response::json(['message' => $e->getMessage()], 401, 'error');

      } catch (\InvalidArgumentException $e) {
         return $response::json(['message' => $e->getMessage()], 400, 'error');
      }catch(\Exception $e){
         return $response::json(['message' => 'Internal server error.'], 500, 'error');
      }
   }

   /**
    * Fetch all clients.
    * @param Request $request Object representing the HTTP request.
    * @param Response $response Object used to return the HTTP response.
    *
    * @return mixed Returns a JSON response containing login data on success,
    *               or an error message with the appropriate HTTP status code on failure.
    */
   public function fetchAll(Request $request, Response $response){
      try {

         $clientServices = new ClientServices();
         $serviceResponse = $clientServices->fetchAll();

         if(isset($serviceResponse['error'])){
            return $response::json(['message' => $serviceResponse['error']], $serviceResponse['status'], 'error');
         }

         $response::json($serviceResponse, 200, 'success');
      } catch (UnauthorizedException $e) {
         return $response::json(['message' => $e->getMessage()], 401, 'error');

      } catch (\InvalidArgumentException $e) {
         return $response::json(['message' => $e->getMessage()], 400, 'error');
      }catch(\Exception $e){
         return $response::json(['message' => 'Internal server error.'], 500, 'error');
      }
   }

   /**
    * Update client data.
    * @param Request $request Object representing the HTTP request.
    * @param Response $response Object used to return the HTTP response.
    *
    * @return mixed Returns a JSON response containing login data on success,
    *               or an error message with the appropriate HTTP status code on failure.
    */
   public function update(Request $request, Response $response){
      try {
         $body = $request::body();
         $clientServices = new ClientServices();
         $serviceResponse = $clientServices->update($body);

         if(isset($serviceResponse['error'])){
            return $response::json(['message' => $serviceResponse['error']], $serviceResponse['status'], 'error');
         }

         $response::json($serviceResponse, 200, 'success');
      } catch (UnauthorizedException $e) {
         return $response::json(['message' => $e->getMessage()], 401, 'error');

      } catch (\InvalidArgumentException $e) {
         return $response::json(['message' => $e->getMessage()], 400, 'error');
      }catch(\Exception $e){
         return $response::json(['message' => 'Internal server error.'], 500, 'error');
      }
   }

   /**
    * Update client image.
    * @param Request $request Object representing the HTTP request.
    * @param Response $response Object used to return the HTTP response.
    *
    * @return mixed Returns a JSON response containing login data on success,
    *               or an error message with the appropriate HTTP status code on failure.
    */
   public function changeImage(Request $request, Response $response){
      try {
         $body = $request::body();
         $clientServices = new ClientServices();
         $serviceResponse = $clientServices->changeimage($body);

         if(isset($serviceResponse['error'])){
            return $response::json(['message' => $serviceResponse['error']], $serviceResponse['status'], 'error');
         }

         $response::json($serviceResponse, 200, 'success');
      } catch (UnauthorizedException $e) {
         return $response::json(['message' => $e->getMessage()], 401, 'error');

      } catch (\InvalidArgumentException $e) {
         return $response::json(['message' => $e->getMessage()], 400, 'error');
      }catch(\Exception $e){
         return $response::json(['message' => 'Internal server error.'], 500, 'error');
      }
   }

   /**
    * Delete a client.
    * @param Request $request Object representing the HTTP request.
    * @param Response $response Object used to return the HTTP response.
    *
    * @return mixed Returns a JSON response containing login data on success,
    *               or an error message with the appropriate HTTP status code on failure.
    */
   public function delete(Request $request, Response $response){
      try {
         $body = $request::body();
         $clientServices = new ClientServices();
         $serviceResponse = $clientServices->delete($body);

         if(isset($serviceResponse['error'])){
            return $response::json(['message' => $serviceResponse['error']], $serviceResponse['status'], 'error');
         }

         $response::json($serviceResponse, 200, 'success');
      } catch (UnauthorizedException $e) {
         return $response::json(['message' => $e->getMessage()], 401, 'error');

      } catch (\InvalidArgumentException $e) {
         return $response::json(['message' => $e->getMessage()], 400, 'error');
      }catch(\Exception $e){
         return $response::json(['message' => 'Internal server error.'], 500, 'error');
      }
   }
}