
import { GalleryServices } from "@/Services/galleryServices";
import { editGallerySchema } from "@/ZodSchemas/editGallerySchema";
import { zodResolver } from "@hookform/resolvers/zod";
import { useMemo, useState } from "react";
import { useForm } from "react-hook-form";

export function useHandleGalleryForm() {
   const [isLoading, setIsLoading] = useState(false);
   const {
      register,
      handleSubmit,
      setError,
      watch,
      formState: { errors },
   } = useForm({
      resolver: zodResolver(editGallerySchema),
      defaultValues: {
         status: 'Pendente'
      }
   })

   //Avoid to re-render the image in the modal
   const gallery_cover = watch('galery_cover');
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



   const handleCreateGallery = async (data) => {
      const galleryServices = new GalleryServices();

      setIsLoading(true);
      const result = false //await galleryServices.create(data);
      setIsLoading(false);

      if (result) {
         URL.revokeObjectURL(preview.src);
      }
      return toast.error('Algo deu errado, tente novamente.')
   }


   return { register, handleSubmit, isLoading, errors, preview, handleCreateGallery }
}