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
use PDOException;
use Throwable;

class GaleryServices extends PDOExeptionErrors{

   private int $userId;
   private GaleryRepository $galeryRepository;

   public function __construct(){
      $this->userId = (int) JWT::getUserId();
      $this->galeryRepository = new GaleryRepository();
   }
   
   /**
    * Create new galery.
    * @param array $data Containing the galery data.
    * @return array{error: string, status: int} on Failure.
    * @return array{message: string} on Success.
    */
   public function create(array $data):array{
      try {
         if(!$this->userId) return ['error' => 'Please login to continue.', 'status' => 401];
         $data['user_id'] =$this->userId;

         $data = GaleryCreateModel::toArray($data);

         //Try to save the galery_cover in Cloudinary
         $wasImageUploaded = CloudinaryHandleImage::upload($data['tmp_cover'], $data['galery_cover']);
         if(isset($wasImageUploaded['error'])){
            throw new Exception('Error uploading the galery cover, try again.', 500);
         }

         $data['galery_cover'] = $wasImageUploaded['url'];

         $wasDataSaved = $this->galeryRepository->create($data);
         if(!$wasDataSaved){
            throw new Exception("Error trying to create the galery.", 500);
         }

         return ['message' => 'Galery has been created successfuly.'];
      } catch (InvalidArgumentException $e) {

         return ['error' => $e->getMessage(), 'status' => 400]; 
      }catch (\PDOException $e) {

         return PDOExeptionErrors::getErrorBasedOnCode($e->getCode() . 'GALERYCREATE');
      }catch(Exception $e){

         return ['error' => $e->getMessage(), 'status' => $e->getCode()];
      }
   }

   /**
    * Upload images to a galery
    * - If any image does not upload successfuly, even so the rest of the images will be save in DB.
    * - The images that are not uploaded will be returned in the array `failedUploadImages`.
    * @param array $data With the images and the galery id.
    * @return array{error: string, status: int} on Failure.
    * @return array{message: string, failedUploadImages: array} on Success. 
    */
   public function upload(array $data):array{
      try{
         if(!$this->userId) return ['error' => 'Please login to continue.', 'status' => 401];
         $data['user_id'] =$this->userId;

         $data = GaleryUploadModel::toArray($data);
         //Upload images in Cloudinary
         $uploadResults = CloudinaryHandleImage::updloadLots($data['images']);

         //Remove all images from $data
         unset($data['images']);
         if(!count($uploadResults['seccesfulyUpdloadedImages']) > 0){
            throw new Exception('The images upload failed, try again', 500);
         };

         //Set only the successfuly uploaded images into $data.
         $data['images'] = $uploadResults['seccesfulyUpdloadedImages'];

         $wasDataSaved = $this->galeryRepository->upload($data);
 
         if(!$wasDataSaved){
            throw new Exception('It was not possible complete the upload.', 500);
         }

         return ['message' => 'Images successfuly uploaded.', 'failedUploadImages' => $uploadResults['failedUploadImages']];
         // return ['message' => $wasDataSaved, 'failedUploadImages' => 0];
      
      }catch(InvalidArgumentException $e){
         
         return ['error' => $e->getMessage(), 'status' => $e->getCode()];
      }catch(PDOException $e){

         return ['error' => $e->getMessage(), 'status' => 500];
      }catch(Exception $e){
         
         return ['error' => $e->getMessage(), 'status' => $e->getCode()];
      }catch(Throwable $e){
         return ['error' => 'Internal server error' . $e->getMessage(), 'status' => 500];
      }
   }
}