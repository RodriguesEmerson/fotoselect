'use client';

import { useStoredModalVisibility } from "@/Zustand/useStoredModalVisibility";
import { ModalBackground } from "../ModalBackground";
import CloseIcon from '@mui/icons-material/Close';
import { FileInput } from "@/components/UI/inputs/FileInput";
import { DefaultInputText } from "@/components/UI/inputs/DefaultInputText";
import { PurpleSubmitButton } from "@/components/UI/buttons/PurpleSumitButton";
import { clientSchema } from "@/ZodSchemas/clientSchema";
import { useMemo, useState } from "react";
import { ClientServices } from "@/Services/clientServices";
import { toast } from "react-toastify";
import { useStoredClients } from "@/Zustand/useStoredClients";

export function HandleClientModal() {
   const isHandleClientModal = useStoredModalVisibility(state => state.isHandleClientModal);
   if (!isHandleClientModal) return;
   return (
      <HandleClientModalBody />
   )
}

function HandleClientModalBody() {
   const setIsHandleClientModal = useStoredModalVisibility(state => state.setIsHandleClientModal);
   const setStoredClients = useStoredClients(state => state.setStoredClients);
   const setEditingClient = useStoredClients(state => state.setEditingClient);
   const [isFetching, setIsFetching] = useState(false);
   const { register, handleSubmit, resetForm, errors, watch } = clientSchema();
   const profile_image = watch('profile_image');


   //Avoid to re-render the image in the modal
   const preview = useMemo(() => {
      if (!profile_image || profile_image.length === 0) return null;
      const file = profile_image[0];
      const tempUrl = file.name ? URL.createObjectURL(file) : watch('profile_image');

      return {
         name: file.name,
         size: file.size,
         src: tempUrl
      }
   }, [profile_image]);

   const onSubmit = (data) => handleRegisterClient(data);

   const handleRegisterClient = async (data) =>{
      const clientServices = new ClientServices();
      setIsFetching(true);
      const respose = await clientServices.registerClient(data);
      
      if(respose){
         toast.success('Cliente cadastrado com sucesso.');
         URL.revokeObjectURL(preview?.src);
         resetForm();
         
         toast.info('Aguarde. Atualizando a os clientes em sua tela.');
         const clients = await clientServices.getClients();
         setIsFetching(false);
         if(clients){
            setStoredClients(clients.clients);
            return toast.info('Página atualizada.');
         }
         return toast.error('Não foi possível atualizar os clientes em sua tela. Por favor, atualize a página.')
      }

      return toast.error('Algo deu errado, tente novamente.');
   }

   const handleCloseModal = () => {
      URL.revokeObjectURL(preview?.src);
      setIsHandleClientModal(false);
      setEditingClient(false);
   }

   return (
      <ModalBackground onMouseDown={() => handleCloseModal}>
         <div
            className="p-2 w-fit h-fit bg-[var(--background)] text-[var(--text-secondary-color)] text-sm shadow-[0_0_25px_5px_var(--shadow)] rounded-xl border border-[var(--border-color)] transition-all"
            onMouseDown={(e) => { e.stopPropagation() }}
         >
            <div className="flex flex-row items-center justify-between border-b border-[var(--border-color)] p-2">
               <span className="block w-4 h-4 bg-[var(--secondary-color)] rounded-full"></span>
               <h2 className="text-center font-semibold text-base">Cadastrar novo Cliente</h2>
               <CloseIcon
                  className="cursor-pointer"
                  onClick={() => handleCloseModal()}
               />
            </div>

            <form onSubmit={handleSubmit(onSubmit)} className="flex flex-col gap-4 mt-4" encType="multipart/form-data">
               <div className="flex flex-row items-start gap-3 mb-3">
                  <FileInput
                     register={register}
                     registerName={'profile_image'}
                     id={'profile_image'}
                     errorMessage={errors?.profile_image?.message}
                     preview={preview}
                     message={"imagem"}
                     format={"square"}
                  />
                  <div className="flex flex-col gap-4 w-80">
                     <DefaultInputText
                        {...register('name', { required: 'O Nome é obrigatório.', maxLength: 50, pattern: /^[A-Za-z]+$/i })}
                        label={'Nome'}
                        id={'name'}
                        errorMessage={errors?.name?.message}
                     />
                     <DefaultInputText
                        {...register('email')}
                        label={'Email'}
                        id={'email'}
                        errorMessage={errors?.email?.message}
                     />
                     <DefaultInputText
                        {...register('phone')}
                        label={'Contato (opcional)'}
                        placeholder={"(00)00000-0000"}
                        errorMessage={errors?.phone?.message}
                        id={'phone'}
                     />
                     <DefaultInputText
                        {...register('password', { required: 'Preencha este campo.', maxLength: 6, pattern: /^\d+$/ })}
                        label={'Senha'}
                        id={'gallery_password'}
                        errorMessage={errors?.password?.message}
                     />
                  </div>
               </div>
               <PurpleSubmitButton
                  text={'Criar'} isLoading={isFetching}
               />
            </form>
         </div>
      </ModalBackground>
   )
}