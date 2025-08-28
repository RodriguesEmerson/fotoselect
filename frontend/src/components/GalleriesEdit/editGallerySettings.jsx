import { GalleryServices } from "@/Services/galleryServices";
import Image from "next/image";
import CloudUploadIcon from '@mui/icons-material/CloudUpload';
import { PurpleButton } from "../UI/buttons/PurpleButton";


export function EditGallerySettings({ galleryData }) {

   const galleryServices = new GalleryServices();
   galleryServices.fetchGalleryImages(62);

   return (
      <>
         <div className="h-fit w-[70%] bg-yellow-50 pl-5 border border-yellow-400 border-l-3 my-5">
            <ol className="list-decimal list-inside p-3 text-[13px]">
               <li>Clique em “Carregar fotos” para adicionar as fotos na galeria.</li>
               <li>Após finalizar o carregamento, clique em "Salvar e continuar" para prosseguir.</li>
            </ol>
         </div>
         <div className="w-full">
            <div>
               <label htmlFor={'images-gallery-upload'}>
                  <PurpleButton>
                     <span>Carregar fotos</span>
                     <CloudUploadIcon />
                  </PurpleButton>
               </label>
               <input
                  type="file"
                  // {...register(registerName)}
                  id={'images-gallery-upload'}
                  className="hidden"
                  accept="image/jpg, image/jpeg, image/png"
               />
            </div>
         </div>
      </>
   )
}