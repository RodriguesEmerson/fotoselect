<?php 

namespace App\Services;

use App\JWT\JWT;
use App\Models\GaleryModels\GaleryCreateModel;
use App\Repositories\GaleryRepository;
use Exception;
use InvalidArgumentException;

class GaleryServices extends PDOExeptionErrors{
   
   public static function create(array $data){
      try {
         $userId = JWT::getUserId();
         if(!$userId) return ['error' => 'Please login to continue.', 'status' => 401];
         
         $data['user_foreign_key'] = (int)$userId;
         $data = GaleryCreateModel::create($data);

         GaleryRepository::create($data);

         return ['message' => 'Galery has been created successfuly.'];
      } catch (InvalidArgumentException $e) {

         return ['error' => $e->getMessage(), 'status' => 400]; 
      }catch (\PDOException $e) {

         return PDOExeptionErrors::getErrorBasedOnCode($e->getCode() . 'GALERYCREATE');
      }catch(Exception $e){

         return ['error' => 'Internal server error. | ' . $e->getMessage(), 'status' => 500];
      }
   }
}