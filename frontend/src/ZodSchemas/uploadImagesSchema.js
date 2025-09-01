
import z from 'zod';

const ACCEPTED_MIME_TYPES = ["image/jpeg", "image/png", "image/jpg"];

export const uploadImagesSchema = z.object({
   images: z.any()
      .refine(file => file && file.length > 0, "Selecione a imagem que será a capa da galeria.")
      .refine(file => file[0]?.size > 10_000, 'A image deve ter no mínimo 10KB.')
      .refine(file => file[0]?.size < 1_000_000, 'A image deve ter no máximo 1MB.')
      .refine(file => ACCEPTED_MIME_TYPES.includes(file[0]?.type), "Apens formatos .jpg, .jpeg, .png. são aceitos"),
});