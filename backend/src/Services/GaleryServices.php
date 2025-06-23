<?php 

namespace App\Services;

use App\CloudinaryHandle\CloudinaryHandleImage;
use App\DTOs\GaleryDTOs\CreateGaleryDTO;
use App\DTOs\GaleryDTOs\DeleteImageGaleryDTO;
use App\DTOs\GaleryDTOs\FetchImagesGaleryDTO;
use App\DTOs\GaleryDTOs\UploadGaleryDTO;
use App\Exceptions\UnauthorizedException;
use App\JWT\JWT;
use App\Repositories\GaleryRepository;
use Exception;
use InvalidArgumentException;
use PDOException;
use Throwable;

class GaleryServices extends PDOExeptionErrors{

   private int $userId;
   private GaleryRepository $galeryRepository;

   public function __construct(){
      $this->userId = (int) JWT::getUserId();
      if(!$this->userId){
         throw new UnauthorizedException('Please login to continue.', 401);
      } 
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
         $data['user_id'] =$this->userId;
         $data = CreateGaleryDTO::toArray($data);

         //Try to save the galery_cover in Cloudinary
         $wasImageUploaded = CloudinaryHandleImage::upload($data['tmp_cover'], $data['cdl_id']);
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
         
         return ['error' => $e->getMessage(), 'status' => 400]; 
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
         $data['user_id'] =$this->userId;

         $data =  UploadGaleryDTO::toArray($data);
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

   public function delete(array $data){
      try{
         $data['user_id'] =$this->userId;
         $data = FetchImagesGaleryDTO::toArray($data);
         $galery = $this->galeryRepository->getGaleryData($data);

         if(!$galery) throw new Exception('Galery not found.', 400);

         $galeryImages = $this->galeryRepository->getGaleryImages($data);

         if(count($galeryImages) > 0){
            //Delete images from Cloudinary
            $deleteResults = CloudinaryHandleImage::deleteLots($galeryImages);
            if(count($deleteResults['deletedImagesId']) === 0){
               throw new Exception('It was not possible delte images in Cloudinary.', 500);
            }
            //Set only the successfuly deleted images id into $data.
            $data['imagesId'] = $deleteResults['deletedImagesId'];

            $wasImagesDeleted = $this->galeryRepository->deleteImagesFromGalery($data);
            if(!$wasImagesDeleted){
               throw new Exception('It was not possible complete the galery exclusion.', 500);
            }
         }
         
         //Delete galery cover from Cloudinary
         $wasGaleryCoverDeleted = CloudinaryHandleImage::delete($galery[0]->cdl_id);
         $wasGaleryDeleted = $this->galeryRepository->deleteGalery($data);
         if(isset($wasGaleryCoverDeleted['error']) || !$wasGaleryDeleted){
            throw new Exception('It was not possible complete the galery exclusion.', 500);
         }

         return ['message' => 'Galery successfuly deleted.'];
      
      }catch(PDOException $e){
         return ['error' => $e->getMessage(), 'status' => 500];
      }catch(Exception $e){
         
         return ['error' => $e->getMessage(), 'status' => $e->getCode()];
      }catch(Throwable $e){
         return ['error' => 'Internal server error: ' . $e->getMessage(), 'status' => 500];
      }
   }

   /**
    * Delete a single image
    * @param array $data Containing the image data, like id and which galery id it belongs.
    * @return array{error: string, status: int} on Failure.
    * @return array{message: string} on Success. 
    */
   public function deleteImage(array $data):array{
      try{
         $data['user_id'] =$this->userId;
         $data = DeleteImageGaleryDTO::toArray($data);
         
         $image = $this->galeryRepository->getImageUrlAndCdlIdById($data);

         if(!$image) throw new Exception('Image not found.', 400);

         //Cheking if the image realy exists, if not, delete data from database.

         //Try to delete the image in Cloudinary
         $wasImageDeleted = CloudinaryHandleImage::delete($image['cdl_id']);
         if(isset($wasImageDeleted['error'])){
            throw new Exception($wasImageDeleted['error'], 500);
         }

         $wasDataDelete = $this->galeryRepository->deleteOneImageFromGalery($data);
         if(!$wasDataDelete) throw new Exception('Something went wrong.', 500);

         return ['message' => 'Image delete successfuly'];
      }catch(InvalidArgumentException $e){
         
         return ['error' => $e->getMessage(), 'status' => $e->getCode()];
      }catch(PDOException $e){

         return ['error' => $e->getMessage(), 'status' => 500];
      }catch(Exception $e){
         return ['error' => $e->getMessage(), 'status' => $e->getCode()];
      }catch(Throwable $e){
         return ['error' => $e->getMessage(), 'status' => 500];
      }
   }
}