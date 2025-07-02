'use client';

import { useForm } from "react-hook-form"
import { DefaultInputText } from "@/components/UI/DefaultInputText";
import { PurpleSubmitButton } from "@/components/UI/PurpleSumitButton";
import { WhiteLinkButton } from "@/components/UI/WhiteLinkButton";
import { useState } from "react";

export function RegisterForm() {
   const [isRegistering, setIsRegistering] = useState(false);
   const {
      register,
      handleSubmit,
      watch,
      formState: { errors },
   } = useForm();

   const onSubmit = (data) => handleRegister(data);

   const handleRegister = async (data) => {
      try{
         setIsRegistering(true);
         const req = await fetch(`http://localhost/fotoselect/backend/user/register`, 
            {
               method: 'POST',
               headers: {'Content-Type': 'application/json'},
               credentials: 'include',
               body: JSON.stringify(data)
            }
         );
         const res = await req.json();
         if(res.error){
            console.log(res.content.message);
         }
         setIsRegistering(false);

      }catch(e){
         console.log("Erro: " + e);
      }
   }

   return (
      <form onSubmit={handleSubmit(onSubmit)} className="flex flex-col gap-4 mt-2">
         <DefaultInputText 
            {...register('name', {required: 'O Nome é obrigatório.',  maxLength: 50, pattern: /^[A-Za-z]+$/i})} 
            label={'Nome'} 
            id={'register-form-name'} 
            errorMessage={errors?.name?.message}
         />
         <DefaultInputText 
            {...register('lastname', {required: 'O Sobrenome é obrigatório.',  maxLength: 50, pattern: /^[A-Za-z]+$/i})} 
            label={'Sobrenome'}
            id={'register-form-lastname'}
            errorMessage={errors?.lastname?.message}
         />
         <DefaultInputText 
            {...register('email', {required: 'O Email é obrigatório.',  maxLength: 100})} 
            label={'Email'} id={'register-form-email'} 
            type="email" 
            errorMessage={errors?.email?.message}
         />
         <DefaultInputText 
            {...register('password', {required: 'A Senha é obrigatória.',  maxLength: 100})} 
            label={'Senha'} id={'register-form-password'} 
            type="password" 
            errorMessage={errors?.password?.message}
         />
         <div></div>
         <PurpleSubmitButton
            text={'Cadastrar'} isLoading={isRegistering}
         />
         <div className="flex flex-row gap-0.5 items-center">
            <span className="h-[1px] bg-gray-400 flex-1"></span>
            <span className="flex-1 text-sm text-gray-600">Já tem uma conta?</span>
            <span className="h-[1px] bg-gray-400 flex-1"></span>
         </div>
         <WhiteLinkButton href={'/login'} text={'Acessar conta'} />
      </form>
   )
}