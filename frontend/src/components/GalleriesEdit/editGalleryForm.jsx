'use client';
import { PurpleSubmitButton } from "@/components/UI/buttons/PurpleSumitButton";
import { CheckboxDefault } from "@/components/UI/inputs/CheckboxDefault";
import { DefaultInputText } from "@/components/UI/inputs/DefaultInputText";
import { FileInput } from "@/components/UI/inputs/FileInput";
import { useHanldeGalleryForm } from "./hooks/useHandleEditGalleryForm";

export function EditGalleryForm({ galleryData }) {
   
   const { register, handleSubmit, isLoading, errors, preview, handleCreateGallery } = useHanldeGalleryForm();
   const galleryCoverPreview = preview ?? {src: galleryData.galery_cover}
   
   const deadline = Math.max(
      Math.floor((new Date(galleryData.deadline).getTime()- new Date().getTime()) / (1000 * 60 * 60 * 24)), 0
   );

   const onSubmit = (data) => handleCreateGallery(data);

   return (
      <form onSubmit={handleSubmit(onSubmit)}
         className="flex flex-col gap-4 mt-4 items-end pr-3  border-r border-[var(--border-color)]"
         encType="multipart/form-data"
      >
         <div className="flex flex-row items-center gap-3">
            <FileInput
               register={register}
               registerName={'galery_cover'}
               id={'galery_cover'}
               errorMessage={errors?.galery_cover?.message}
               preview={galleryCoverPreview}
               message={"cara da galeria"}
            />
            <p>{errors?.private?.message}</p>
            <p>{errors?.watermark?.message}</p>
            <div className="flex flex-col gap-4 w-100">
               <DefaultInputText
                  {...register('galery_name', { required: 'O Nome é obrigatório.', maxLength: 50, pattern: /^[A-Za-z]+$/i })}
                  label={'Nome da Galeria'}
                  id={'galery_name'}
                  errorMessage={errors?.galery_name?.message}
                  defaultValue={galleryData.galery_name}
               />
               <DefaultInputText
                  {...register('deadline')}
                  label={'Prazo para seleção (Máx: 365 dias)'}
                  placeholder={'Insira apenas números. ex: 30'}
                  id={'gallery_deadline'}
                  errorMessage={errors?.deadline?.message}
                  defaultValue={deadline}
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
                  <CheckboxDefault register={register} registerName={'private'} label={'Galeria Privada'} checked={galleryData.private} />
                  <CheckboxDefault register={register} registerName={'watermark'} label={"Marca d'água"} checked={galleryData.watermark} />
               </div>
            </div>
         </div>
         <PurpleSubmitButton
            text={'Salvar e continuar'} isLoading={isLoading} width="mid"
         />
      </form>
   )
}