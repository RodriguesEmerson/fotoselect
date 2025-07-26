import { ClientsInGallery } from "@/components/Clients/InGallery/ClientsInGallery";
import { GalleryOptions } from "@/components/Galleries/GalleryOptions";
import { PreviousPageButton } from "@/components/UI/buttons/PreviousPageButton";
import { PurpleLinkButton } from "@/components/UI/links/PurpleLinkButton";
import EditIcon from '@mui/icons-material/Edit';
import { cookies } from "next/headers";
import Image from "next/image";


export default async function GalleryPage({ params }) {
   const { galleryId } = await params;

   const status = {
      pending: { txt: 'Pendente', color: '#ca8a04' },
      finished: { txt: 'Finalizada', color: '#4d7c0f' },
      expired: { txt: 'Expirada', color: '#991b1b' }
   }

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
   const serverClients = res.content.clients;


   return (
      <>
         <div className="w-full">
            <PreviousPageButton />
         </div>
         <div
            className="relative flex flex-row gap-2 p-2 w-full text-[var(--text-main-color)] rounded-xl border border-[var(--border-color)] overflow-hidden h-65 bg-[var(--background)]"
         >
            <div className="w-100 h-65 -mt-2 -ml-2 rounded-l-md overflow-hidden">
               <Image
                  src={gallery.galery_cover} height={400} width={800} alt="gallery cover" priority
                  className="h-full w-full" style={{ objectFit: "cover" }}
               />
            </div>
            <div className="flex flex-col justify-between gap-2 p-3">
               <p
                  className="font-semibold transition-all text-xl mb-1 tracking-widest text-[var(--primary-color)]"
               >
                  {gallery.galery_name.toUpperCase()}
               </p>
               <div className="flex flex-col gap-1">
                  <div className="flex flex-row gap-1 items-center text-xs text-[var(--text-main-color)]">
                     <span className="font-thin opacity-60">CRIADA DIA:  </span>
                     <span className="">
                        {new Date(gallery.created_at)
                           .toLocaleDateString('pt-br',
                              { day: '2-digit', month: 'long', year: 'numeric' }
                           )
                        }
                     </span>
                  </div>
                  <div className="flex flex-row gap-1 items-center text-xs text-[var(--text-main-color)]">
                     <span className="font-thin opacity-60">PRAZO: </span>
                     <span className="">
                        {new Date(gallery.deadline)
                           .toLocaleDateString('pt-br',
                              { day: '2-digit', month: 'long', year: 'numeric' }
                           )
                        }
                     </span>
                  </div>
                  <div className="flex flex-row gap-1 items-center text-xs text-[var(--text-main-color)]">
                     <span className="font-thin opacity-60">SELEÇÂO: </span>
                     <span style={{ color: status[gallery.status]?.color }}>
                        {status[gallery.status]?.txt}
                     </span>
                  </div>
                  <div className="flex flex-row gap-1 items-center text-xs text-[var(--text-main-color)]">
                     <span className="font-thin opacity-60">URL: </span>
                     <span className="">to do </span>
                  </div>
               </div>
               <PurpleLinkButton href={''} size="small">
                  <EditIcon />
                  <span>Editar galeria</span>
               </PurpleLinkButton>
            </div>

            <div className="absolute right-3 bottom-3 cursor-pointer">
               <GalleryOptions gallery={gallery} />
            </div>
         </div>
         <ClientsInGallery gallery={gallery} serverClients={serverClients} status={status} />
      </>
   )
}

