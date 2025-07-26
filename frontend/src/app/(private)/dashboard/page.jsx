import { Banner } from "@/components/Dashboard/Banner";
import { DashboardNav } from "@/components/Dashboard/DashboardNav";
import { DashboardGalleries } from "@/components/Dashboard/DashboadGalleries";
import { cookies } from "next/headers";

export default async function Dasjboard() {
   const galleries = [
      { id: 1, gallery_name: 'Mary & Jhon', galery_cover: '/images/gallery-cover-1.jpg', created_at: '2025-06-22 02:50:41', status: 'pedding', opned: false },
      { id: 2, gallery_name: 'Mary & Jhon', galery_cover: '/images/gallery-cover-2.jpg', created_at: '2025-06-22 02:50:41', status: 'pedding', opned: false },
      { id: 3, gallery_name: 'Mary & Jhon', galery_cover: '/images/gallery-cover-3.jpg', created_at: '2025-06-22 02:50:41', status: 'pedding', opned: false },
      { id: 4, gallery_name: 'Mary & Jhon', galery_cover: '/images/gallery-cover-4.jpg', created_at: '2025-06-22 02:50:41', status: 'pedding', opned: false },
      { id: 5, gallery_name: 'Mary & Jhon', galery_cover: '/images/gallery-cover.jpg', created_at: '2025-06-22 02:50:41', status: 'pedding', opned: false }
   ]
   const token = (await cookies()).get('FSJWTToken')?.value;

   const reqHeader = {
      method: 'GET',
      credentials: 'include',
      headers: { Authorization: `Bearer ${token}` ,}
      
   }

   const responses = await Promise.allSettled([
      fetch('http://localhost/fotoselect/backend/galery/fetchlot/7/0', reqHeader),
      fetch('http://localhost/fotoselect/backend/user/dashdata', reqHeader)
   ])

   const data = responses.map(res => res.status === "fulfilled" ? res.value.json() : null)
   const [gal, dash] =  data;

   if(!gal || !dash) return <></>;

   const dashInfo = await dash;
   const galeries = await gal;

   //CRIAR PROMISE.ALL

   return (
      <>
         <Banner />
         <DashboardNav dashInfo={dashInfo?.content} />

         <div className="flex flex-row w-full gap-4">
            <DashboardGalleries galleries={galeries?.content.galleries} />
            <div className="flex flex-1">
            </div>
            <div className="flex flex-1">
            </div>
         </div>
      </>
   )
}