<?php 

namespace App\Services;

use App\JWT\JWT;
use App\Models\GaleryModels\GaleryCreateModel;
use App\Repositories\GaleryRepository;
use Exception;
use InvalidArgumentException;

class GaleryServices{
   
   public static function create(array $data){
      try {
         $userId = JWT::getUserId();
         if(!$userId) return ['error' => 'Please login to continue.', 'status' => 401];
         $data['user_foreign_key'] = (int)$userId;
         $data = GaleryCreateModel::create($data);
         $wasGaleryCreated = GaleryRepository::create($data);

         if(!$wasGaleryCreated) return ['error' => 'Somethig went wrong, try again', 'status' => 500];

         return ['message' => 'Galery has been created successfuly.'];
      } catch (InvalidArgumentException $e) {
         return ['error' => $e->getMessage(), 'status' => 400];
      }catch (\PDOException $e) {
         echo json_encode($e->getMessage());exit;
      }catch(Exception $e){
         return ['error' => 'Internal server error.', 'status' => 500];
      }
   }
}