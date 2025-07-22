enum StatusRole {
   Pendente = 'pending'
}

type CreateGalleryParams = {
   galery_cover: File,
   galery_name: string,
   deadline: string,
   private: boolean,
   watermark: boolean,
   status: string,
   password: string
}

function delay() {
   return new Promise(resolve => setTimeout(resolve, 1000));
}

export class GalleryServices {

   private baseUrl = 'http://localhost/fotoselect/backend';

   public async create(galleryData: CreateGalleryParams) {
      
      try {
         const formData = new FormData();
         formData.append('galery_cover', galleryData.galery_cover[0]);
         formData.append('galery_name', galleryData.galery_name);
         formData.append('deadline', galleryData.deadline);
         formData.append('private', String(galleryData.private)); 
         formData.append('watermark', String(galleryData.watermark));
         formData.append('status',StatusRole[galleryData.status]); 
         formData.append('password', galleryData.password);

         const req = await fetch(`${this.baseUrl}/galery/create`,
            {
               method: 'POST',
               credentials: 'include',
               body: formData
            }
         )

         const res = await req.json();
         if(req.status === 201) return {galery_name: galleryData.galery_name};
         return false;

      } catch (e) {
         console.log(e);
         return false;
      }
   }

}