import { cookies } from "next/headers";
import { Galleries } from "@/components/Galleries/Galleries";
import { GalleriesHeader } from "@/components/Galleries/GalleriesHeader";

export default async function Dashboard() {

   const token = (await cookies()).get('FSJWTToken')?.value;
   const req = await fetch(`http://localhost/fotoselect/backend/galery/fetchlot/99/0`,
      {
         method: 'GET',
         credentials: 'include',
         headers: { Authorization: `Bearer ${token}`, }
      }
   )
   if (req.status !== 200) return <></>

   const res = await req.json();
   const galleries = res.content.galleries;

   return (
      <>
         <GalleriesHeader serverGalleries={galleries} />
         <Galleries />
      </>
   )
}