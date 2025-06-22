<?php 

namespace App\Services;

use App\CloudinaryHandle\CloudinaryHandleImage;
use App\JWT\JWT;
use App\Models\GaleryModels\GaleryCreateModel;
use App\Models\GaleryModels\GaleryUploadModel;
use App\Repositories\GaleryRepository;
use App\Utils\ImagesHandle;
use Cloudinary\Transformation\Extract;
use Exception;
use InvalidArgumentException;

class GaleryServices extends PDOExeptionErrors{

   private int $userId;
   private GaleryRepository $galeryRepository;

   public function __construct(){
      $this->userId = (int) JWT::getUserId();
      $this->galeryRepository = new GaleryRepository();
   }
   
   public function create(array $data):array{
      try {
         if(!$this->userId) return ['error' => 'Please login to continue.', 'status' => 401];
         $data['user_foreign_key'] =$this->userId;

         $data = GaleryCreateModel::toArray($data);

         $this->galeryRepository->create($data);

         return ['message' => 'Galery has been created successfuly.'];
      } catch (InvalidArgumentException $e) {

         return ['error' => $e->getMessage(), 'status' => 400]; 
      }catch (\PDOException $e) {

         return PDOExeptionErrors::getErrorBasedOnCode($e->getCode() . 'GALERYCREATE');
      }catch(Exception $e){

         return ['error' => 'Internal server error. | ' . $e->getMessage(), 'status' => 500];
      }
   }


   public function upload(array $data):array{
      try{
         if(!$this->userId) return ['error' => 'Please login to continue.', 'status' => 401];
         $data['user_id'] =$this->userId;

         $data = GaleryUploadModel::toArray($data);

         //Upload images in Cloudinary
         $uploadResults = CloudinaryHandleImage::updloadLots($data['images']);

         unset($data['images']);
         if(!count($uploadResults['seccesfulyUpdloadedImages']) > 0){
            echo json_encode('Images array empty'); exit;
         };
         //Gets only the successfuly uploaded images.
         $data['images'] = $uploadResults['seccesfulyUpdloadedImages'];

         $this->galeryRepository->upload($data);


         //criando aqui

      }catch(Exception $e){
         echo json_encode($e->getMessage());
      }

      return [];
   }
}