'use client';
import { PurpleSubmitButton } from "@/components/UI/buttons/PurpleSumitButton";
import { CheckboxDefault } from "@/components/UI/inputs/CheckboxDefault";
import { DefaultInputText } from "@/components/UI/inputs/DefaultInputText";
import { gallerySchema } from "@/ZodSchemas/gallerySchema";
import { useModalVisibility } from "@/Zustand/useModalVisibility";
import { ModalBackground } from "../ModalBackground";
import { FileInput } from "@/components/UI/inputs/FileInput";
import CloseIcon from '@mui/icons-material/Close';
import { GalleryServices } from "@/Services/galleryServices";
import { toast } from "react-toastify";
import { useMemo, useState } from "react";

export function NewGalleryModal() {
   const isNewGalleryModalVisible = useModalVisibility(state => state.isNewGalleryModalVisible);
   if (!isNewGalleryModalVisible) return;
   return (
      <NewGalleryModalBody />
   )
}

function NewGalleryModalBody() {
   const setIsNewGalleryModalVisible = useModalVisibility(state => state.setIsNewGalleryModalVisible);
   const [isLoading, setIsLoading] = useState(false);
   const handleCloseModal = () => {
      URL.revokeObjectURL(preview?.src);
      setIsNewGalleryModalVisible(false);
   }

   const galleryServices = new GalleryServices();

   const { register, handleSubmit, reset, errors, watch } = gallerySchema();
   const gallery_cover = watch('galery_cover');

   //Avoid to re-render the image in the modal
   const preview = useMemo(() => {
      if (!gallery_cover || gallery_cover.length === 0) return null;
      const file = gallery_cover[0];
      const tempUrl = URL.createObjectURL(file);

      return {
         name: file.name,
         size: file.size,
         src: tempUrl
      }
   }, [gallery_cover]);

   const onSubmit = (data) => handleCreateGallery(data);

   const handleCreateGallery = async (data) => {
      setIsLoading(true);
      const result = await galleryServices.create(data);
      setIsLoading(false);
      if (result) {
         toast.success(t => (
            <p>A galeria <span className="font-semibold">{result.galery_name}</span> foi criada!</p>
         ));

         return setTimeout(() => {
            URL.revokeObjectURL(preview.src);
            reset({
               galery_cover: '',
               galery_name: '',
               deadline: '',
               password: '',
               private: true,
               watermark: false,
               status: 'Pendente'
            });
         }, 2000);
      }
      return toast.error('Algo deu errado, tente novamente.')
   }



   return (
      <ModalBackground
         onMouseDown={() => handleCloseModal}
      >
         <section
            className="p-2 w-fit h-fit bg-[var(--background)] text-[var(--text-secondary-color)] text-sm shadow-[0_0_25px_5px_var(--shadow)] rounded-xl border border-[var(--border-color)] transition-all"
            onMouseDown={(e) => { e.stopPropagation() }}
         >
            <div className="flex flex-row items-center justify-between border-b border-[var(--border-color)] p-2">
               <span className="block w-4 h-4 bg-[var(--secondary-color)] rounded-full"></span>
               <h2 className="text-center font-semibold text-base">Nova Galeria</h2>
               <CloseIcon
                  className="cursor-pointer"
                  onClick={() => handleCloseModal()}
               />
            </div>

            <form onSubmit={handleSubmit(onSubmit)} className="flex flex-col gap-4 mt-4" encType="multipart/form-data">
               <div className="flex flex-row items-center gap-3">
                  <FileInput
                     register={register}
                     registerName={'galery_cover'}
                     id={'galery_cover'}
                     errorMessage={errors?.galery_cover?.message}
                     preview={preview}
                  />
                  <p>{errors?.private?.message}</p>
                  <p>{errors?.watermark?.message}</p>
                  <div className="flex flex-col gap-4 w-80">
                     <DefaultInputText
                        {...register('galery_name', { required: 'O Nome é obrigatório.', maxLength: 50, pattern: /^[A-Za-z]+$/i })}
                        label={'Nome da Galeria'}
                        id={'galery_name'}
                        errorMessage={errors?.galery_name?.message}
                     />
                     <DefaultInputText
                        {...register('deadline')}
                        label={'Prazo para seleção (Máx: 365 dias)'}
                        placeholder={'Insira apenas números. ex: 30'}
                        id={'gallery_deadline'}
                        errorMessage={errors?.deadline?.message}
                     />
                     <DefaultInputText
                        {...register('password', { required: 'Preencha este campo.', maxLength: 6, pattern: /^\d+$/ })}
                        label={'Senha'}
                        id={'gallery_password'}
                        errorMessage={errors?.password?.message}
                     />
                     <div>
                        <DefaultInputText
                           {...register('status')}
                           label={'Situação'}
                           errorMessage={errors?.status?.message}
                           defaultValue="Pendente"
                           id={'gallery_status'}
                           disabled={true}
                        />
                        <CheckboxDefault register={register} registerName={'private'} label={'Galeria Privada'} checked />
                        <CheckboxDefault register={register} registerName={'watermark'} label={"Marca d'água"} />
                     </div>
                  </div>
               </div>
               <PurpleSubmitButton
                  text={'Criar'} isLoading={isLoading}
               />
            </form>
         </section>
      </ModalBackground>
   )
}