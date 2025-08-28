import { EditGallerySlider } from "@/components/GalleriesEdit/editGallerySlider";
import { PreviousPageButton } from "@/components/UI/buttons/PreviousPageButton";
import { cookies } from "next/headers";

export default async function EditGalleryPage({ params }) {
   const { galleryId } = await params;

   const token = (await cookies()).get('FSJWTToken')?.value;
   const req = await fetch(`http://localhost/fotoselect/backend/galery/fetch/${galleryId}`,
      {
         method: 'GET',
         headers: { Authorization: `Bearer ${token}`, }
      }
   )
   const res = await req.json();
   if (req.status !== 200) return <></>
   const gallery = res.content.galery;


   return (
      <>
         <div className="w-full">
            <PreviousPageButton />
         </div>
         <div
            className="relative flex flex-col gap-2 p-2 w-full text-[var(--text-main-color)] rounded-xl border border-[var(--border-color)] overflow-hidden h-fit bg-[var(--background)] overflow-x-hidden"
         >
            <EditGallerySlider gallery={gallery} />

         </div>
      </>
   )
}

