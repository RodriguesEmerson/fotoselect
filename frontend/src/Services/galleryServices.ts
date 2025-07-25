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
   return new Promise(resolve => setTimeout(resolve, 2000));
}

export class GalleryServices {

   private baseUrl = 'http://localhost/fotoselect/backend';

   public async fetchGalleries(){
      try {
         const req = await fetch(`${this.baseUrl}/galery/fetchlot/99/0`,
            {
               method: 'GET',
               credentials: 'include',
            }
         )

         const galleries = await req.json();
         if(req.status === 200) return  galleries.content.galleries;
         return false;

      } catch (e) {
         console.log(e);
         return false;
      }
   }

   public async fetchGalleryById(galleryID: number){
      try {
         const req = await fetch(`${this.baseUrl}/galery/fetch`,
            {
               method: 'GET',
               credentials: 'include',
            }
         )

         const gallery = await req.json();
         if(req.status === 200) return  gallery.content.galleries;
         return false;

      } catch (e) {
         console.log(e);
         return false;
      }
   }

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
         if(req.status === 201) return{ gallery_name: galleryData.galery_name};
         return false;

      } catch (e) {
         console.log(e);
         return false;
      }
   }

   public async delete(galleryID: number){
      try {
         const req = await fetch(`${this.baseUrl}/galery/delete`,
            {
               method: 'DELETE',
               credentials: 'include',
               headers: {'Content-Type': 'application/json'},
               body: JSON.stringify({galery_id: galleryID})
            }
         )

         const res = await req.json();
         if(req.status === 200) return true;
         return false;

      } catch (e) {
         console.log(e);
         return false;
      }
   }

}