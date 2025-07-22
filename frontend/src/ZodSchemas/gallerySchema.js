import { zodResolver } from "@hookform/resolvers/zod";
import { useForm } from "react-hook-form";
import z from "zod";

export function gallerySchema() {
   const noEspecialChar = (val) => /^[A-Za-zÀ-ÿ\s&]+$/.test(val);
   const noLetters = (val) => /^\d+$/.test(val);
   const ACCEPTED_MIME_TYPES = ["image/jpeg", "image/png"];

   const gallerySchema = z.object({
      galery_cover: z.any()
         .refine(file => file && file.length > 0, "Selecione a imagem que será a capa da galeria.")
         .refine(file => file[0]?.size > 10_000, 'A image deve ter no mínimo 10KB.')
         .refine(file => file[0]?.size < 1_000_000, 'A image deve ter no máximo 1MB.')
         .refine(file => ACCEPTED_MIME_TYPES.includes(file[0]?.type), "Apens formatos .jpg, .jpeg, .png. são aceitos"),
      galery_name: z.string()
         .min(3, 'O nome da galeria deve ter no mínimo 3 caracteres.')
         .max(50, 'O nome da galeria deve ter no máximo 50 caracteres.')
         .refine(noEspecialChar, { message: 'Apenas caracteres de A a Z são válidos.' }),
      deadline: z.string()
         .min(1, 'Informe quantos dias a galeria ficará disponível.')
         .max(3, 'Insira apenas três números.')
         .refine(noLetters, { message: 'Insira apenas números' })
         .refine(value => value <= 365, 'Período máximo: 365 dias'),
      private: z.boolean(),
      watermark: z.boolean(),
      status: z.enum(['Pendente']),
      password: z.string()
         .min(4, 'A senha deve ter entre 4 e 6 números.')
         .max(6, 'A senha deve ter entre 4 e 6 números.')
         .refine(noLetters, { message: 'Insira apenas números.' })
   });

   const {
      register,
      handleSubmit,
      reset,
      setError, watch,
      formState: { errors },
   } = useForm({
      resolver: zodResolver(gallerySchema),
      defaultValues: {
         status: 'Pendente'
      }
   })

   return { register, handleSubmit, reset, errors, watch }
}