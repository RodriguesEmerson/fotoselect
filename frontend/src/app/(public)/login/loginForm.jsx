'use client';

import { PurpleSubmitButton } from "@/components/UI/buttons/PurpleSumitButton";
import { DefaultInputText } from "@/components/UI/inputs/DefaultInputText";
import { WhiteLinkButton } from "@/components/UI/links/WhiteLinkButton";
import { zodResolver } from "@hookform/resolvers/zod";
import { Checkbox } from "@mui/material";
import { useState } from "react";
import { useForm } from "react-hook-form";
import { toast } from 'react-toastify';
import z from "zod";

export function LoginForm() {
   const [isLoging, setIsLoging] = useState(false);
   
   const registerSchema = z.object({
      email: z.string().email('Insira um email válido.'),
      password: z.string(),
      keeploged: z.boolean()
   });

   const { 
      register, 
      handleSubmit, 
      watch, 
      formState: { errors },
   } = useForm({
      resolver: zodResolver(registerSchema)
   });

   const onSubmit = (data) => handleLogin(data);

   const handleLogin = async (data) => {
      try{
         setIsLoging(true);
         const req = await fetch(`http://localhost/fotoselect/backend/user/login`, 
            {
               method: 'POST',
               headers: {'Content-Type': 'application/json'},
               credentials: 'include',
               body: JSON.stringify(data)
            }
         );
         const res = await req.json();
         setIsLoging(false);
         
         if(res.error){
            return toast.error('Email ou senha inválidos.');
         }
         window.location.href = res?.content?.redirect;
         
      }catch(e){
         setIsLoging(false);
         console.log(e)
         toast.error('Ocorreu algo inesperado, tente novamente.')
      }
   }

   return (
      <form onSubmit={handleSubmit(onSubmit)} className="flex flex-col gap-4 mt-2">
         <DefaultInputText 
            {...register('email', {required: 'Insira seu email.',  maxLength: 100})} 
            label={'Email'} 
            id={'register-form-email'} 
            type="text"
            errorMessage={errors?.email?.message}
         />
        
         <DefaultInputText 
            {...register('password', {required: 'Insira sua senha.',  maxLength: 100})} 
            label={'Senha'} 
            id={'register-form-password'} 
            type="password" 
         />

         <div className="flex items-center justify-end -mt-4 pr-1">
            <Checkbox size="" {...register('keeploged')} sx={{color: '#450172', '&.Mui-checked': {color: '#450172' }}}id="checkbox-keeploged"/>
            <label htmlFor="checkbox-keeploged" className="text-xs text-gray-600 -ml-1">
               Permanecer conectado
            </label>
         </div>

         <div></div>

         <PurpleSubmitButton
            text={'Acessar'} isLoading={isLoging}
         />

         <div className="flex flex-row gap-0.5 items-center">
            <span className="h-[1px] bg-gray-400 flex-1"></span>
            <span className="flex-2 text-sm text-center text-gray-600">Ainda não tem uma conta?</span>
            <span className="h-[1px] bg-gray-400 flex-1"></span>
         </div>

         <WhiteLinkButton href={'/register'} text={'Cadastre-se'} />
      </form>
   )
}