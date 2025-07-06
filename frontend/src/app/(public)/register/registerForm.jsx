'use client';

import { useForm } from "react-hook-form"
import { zodResolver } from '@hookform/resolvers/zod';
import z from "zod";

import { DefaultInputText } from "@/components/UI/DefaultInputText";
import { PurpleSubmitButton } from "@/components/UI/PurpleSumitButton";
import { WhiteLinkButton } from "@/components/UI/WhiteLinkButton";
import { useState } from "react";
import { toast } from 'react-toastify';

export function RegisterForm() {
   const [isRegistering, setIsRegistering] = useState(false);
   const noEspecialChar = (val) => /^[A-Za-zÀ-ÿ\s]+$/.test(val);

   const registerSchema = z.object({
        name: z.string()
         .min(3, 'O nome deve ter no mínimo 3 caracteres.')
         .max(50, 'O nome deve ter no máximo 50 caracteres.')
         .refine(noEspecialChar, { message: 'Apenas caracteres de A a Z são válidos.' }),
      lastname: z.string()
         .min(3, 'O sobrenome deve ter no mínimo 3 caracteres.')
         .max(50, 'O sobrenome deve ter no máximo 50 caracteres.')
         .refine(noEspecialChar, { message: 'Insira apenas letras enter A e Z.' }),
      email: z.string().email('Insira um email válido.'),
      password: z.string().min(8, 'A senha deve ter pelo menos 8 caracteres.'),
   });

   const { 
      register, 
      handleSubmit, 
      setError, watch, 
      formState: { errors },
   } = useForm({
      resolver: zodResolver(registerSchema)
   });

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
         setIsRegistering(false);

         if(res.error){
            if(res.content.message == 'This email already exists.'){
               setError('email', {
                  type: 'manual',
                  message: "Já existe uma conta cadastrada com este email."
               })
               return;
            }
            return toast.error('Ocorreu algo inesperado, tente novamente.');
         }
         //CRIAR REDIRECT

      }catch(e){
         toast.error('Ocorreu algo inesperado.')
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
            label={'Email'} 
            id={'register-form-email'} 
            type="text" 
            errorMessage={errors?.email?.message}
         />
         <DefaultInputText 
            {...register('password', {required: 'A Senha é obrigatória.', minLength: 8,  maxLength: 100})} 
            label={'Senha'} 
            id={'register-form-password'} 
            type="password" 
            errorMessage={errors?.password?.message}
         />
         <div></div>
         <PurpleSubmitButton
            text={'Cadastrar'} isLoading={isRegistering}
         />
         <div className="flex flex-row gap-0.5 items-center">
            <span className="h-[1px] bg-gray-400 flex-1"></span>
            <span className="flex-1.5 px-2 text-sm text-gray-600">Já tem uma conta?</span>
            <span className="h-[1px] bg-gray-400 flex-1"></span>
         </div>
         <WhiteLinkButton href={'/login'} text={'Acessar conta'} />
      </form>
   )
}