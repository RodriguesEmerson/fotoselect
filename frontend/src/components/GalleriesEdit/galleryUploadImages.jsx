import { GalleryServices } from "@/Services/galleryServices";
import Image from "next/image";
import CloudUploadIcon from '@mui/icons-material/CloudUpload';
import { PurpleButton } from "../UI/buttons/PurpleButton";
import { zodResolver } from "@hookform/resolvers/zod";
import { useForm } from "react-hook-form";
import { uploadImagesSchema } from "@/ZodSchemas/uploadImagesSchema";
import { Utils } from "@/lib/utils";


export function GalleryUploadImages({ galleryData }) {

   const galleryServices = new GalleryServices();
   // galleryServices.fetchGalleryImages(62);
   const {
         register,
         handleSubmit,
         setError,
         watch,
         formState: { errors },
      } = useForm({
         resolver: zodResolver(uploadImagesSchema),
      });

   function handleUploadImages(e){
      const files = Array.from(e.target.files);
      const utils = new Utils();
      const images = utils.validadeImages(files);
      galleryServices.uploadImages(62, images.validImages)
   }

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
               <label htmlFor={'images-gallery-upload'} className="flex items-center justify-center gap-2 h-10 px-4 rounded-md min-w-48  w-48 text-white bg-[var(--button-secondary-color)] cursor-pointer hover:bg-[var(--button-primary-color)] transition-all">
                  <span>Carregar fotos</span>
                  <CloudUploadIcon />
               </label>
               <input
                  type="file"
                  multiple
                  // {...register(registerName)}
                  id={'images-gallery-upload'}
                  className="hidden"
                  accept="image/jpg, image/jpeg, image/png"
                  onChange={(e) => handleUploadImages(e)}
               />
            </div>
         </div>
      </>
   )
}