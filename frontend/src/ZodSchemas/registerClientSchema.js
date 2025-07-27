import { zodResolver } from "@hookform/resolvers/zod";
import { useForm } from "react-hook-form";
import z from "zod";

export function registerClientSchema() {
   const noEspecialChar = (val) => /^[A-Za-zÀ-ÿ\s&]+$/.test(val);
   const noLetters = (val) => /^\d+$/.test(val);
   const ACCEPTED_MIME_TYPES = ["image/jpeg", "image/png"];

   const registerClientSchema = z.object({
      profile_image: z.any().optional()
         .superRefine((file, ctx) => {
            if (!file || file.length === 0) return;
            if (file[0]?.size < 3_000) {
               ctx.addIssue({
                  code: z.ZodIssueCode.custom,
                  message: "A imagem deve ter no mínimo 3KB.",
               });
            }
            if (file[0]?.size > 1_000_000) {
               ctx.addIssue({
                  code: z.ZodIssueCode.custom,
                  message: "A imagem deve ter no máximo 1MB.",
               });
            }
            if (!ACCEPTED_MIME_TYPES.includes(file[0]?.type)) {
               ctx.addIssue({
                  code: z.ZodIssueCode.custom,
                  message: "Apenas as formatos .jpg, .jpeg, .png são aceitos.",
               });
            }
         }),
      name: z.string()
         .min(3, 'O nome do cliente deve ter no mínimo 3 caracteres.')
         .max(50, 'O nome do cliente deve ter no máximo 50 caracteres.')
         .refine(noEspecialChar, { message: 'Apenas caracteres de A a Z são válidos.' }),
      email: z.string().email('Insira um email válido'),
      phone: z.string().optional()
         .superRefine((value, ctx) => {
            if (!value) return
            if (value.length < 14) {
               ctx.addIssue({
                  code: z.ZodIssueCode.custom,
                  message: "Formato inválido. (Não insira espaços).",
               });
            }
            if (value.length > 14) {
               ctx.addIssue({
                  code: z.ZodIssueCode.custom,
                  message: "Formato inválido. (Não insira espaços).",
               });
            }
         }),
      password: z.string()
         .min(8, 'A senha deve ter 8 números.')
         .max(8, 'A senha deve ter 8 números.')
         .refine(noLetters, { message: 'Insira apenas números.' })
   });

   const {
      register,
      handleSubmit,
      reset,
      setError, watch,
      formState: { errors },
   } = useForm({
      resolver: zodResolver(registerClientSchema),
      defaultValues: {
         status: 'Pendente'
      }
   })
   const resetForm = () => {
      reset({
         profile_image: '',
         name: '',
         email: '',
         phone: '',
         password: ''
      });
   }

   return { register, handleSubmit, resetForm, errors, watch }
}