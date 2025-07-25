import { GalleryOptions } from "@/components/Galleries/GalleryOptions";
import { PurpleLinkButton } from "@/components/UI/links/PurpleLinkButton";
import { cookies } from "next/headers";
import EditIcon from '@mui/icons-material/Edit';
import Image from "next/image";
import { PreviousPageButton } from "@/components/UI/buttons/PreviousPageButton";
import { ClientOptions } from "@/components/Clients/ClientOptions";

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
   const clients = res.content.clients;


   return (
      <section className="flex flex-col items-center gap-3 h-[calc(100vh-4rem)] -mt-2 w-full bg-[var(--dashboard-background)] shadow-[0_0_3_3px_var(--shadow)] rounded-xl pt-3 px-10 overflow-y-auto">
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
         <ClientsInGallery gallery={gallery} clients={clients} status={status} />
      </section>
   )
}


export function ClientsInGallery({ gallery, clients, status }) {
   const letterColors = {
      a: '#FF6B6B', b: '#F06595', c: '#CC5DE8', d: '#845EF7', e: '#5C7CFA', f: '#339AF0', g: '#22B8CF', h: '#20C997', i: '#51CF66', j: '#94D82D', k: '#FCC419', l: '#FFD43B', m: '#FFA94D', n: '#FF922B', o: '#FF6B6B', p: '#F783AC', q: '#B197FC', r: '#748FFC', s: '#63E6BE', t: '#A9E34B', u: '#FAB005', v: '#E67700', w: '#D6336C', x: '#7048E8', y: '#3B5BDB', z: '#15AABF'
   };


   return (
      
      <div className="w-full">
         <div>
            <h2>Clientes da galeria ({clients.length})</h2>
            
         </div>
         <div className="rounded-md overflow-hidden">
            <table className="w-full">
               <thead className="bg-[var(--primary-color)] h-10 text-white text-sm">
                  <tr>
                     <th className="text-start font-thin w-[25%] pl-3">CLIENTES</th>
                     <th className="text-start font-thin w-[70%]">SELEÇÃO</th>
                     <th></th>
                  </tr>
               </thead>
               <tbody className="text-[var(--text-main-color)] text-sm bg-[var(--background)]">
                  {clients.map(client => {
                     const clientNameInitialLeter = client.name.slice(0, 1).toLowerCase();
                     return (
                        <tr className="h-16" key={client.id}>
                           <td className="h-16 flex flex-row gap-4 px-2 items-center ">
                              <div
                                 className={`flex items-center justify-center h-9 w-9 min-w-9 rounded-full overflow-hidden text-white`}
                                 style={{ backgroundColor: letterColors[clientNameInitialLeter] }}
                              >
                                 {client.profile_image
                                    ? <Image src={client.profile_image} width={36} height={36} alt='client image' />
                                    : <span className='text-xl -mt-[0.10rem]'>{clientNameInitialLeter}</span>
                                 }
                              </div>
                              <div className="flex flex-col justify-center gap-3">
                                 <p className="font-semibold text-base">{client.name}</p>
                                 <span className="text-[0.80rem] -mt-4 opacity-90">{client.email}</span>
                              </div>
                           </td>
                           <td style={{ color: status[gallery.status]?.color }}>
                              {status[gallery.status]?.txt}</td>
                           <td>
                              <ClientOptions client={client} />
                           </td>
                        </tr>
                     )
                  })}
               </tbody>
            </table>
            {clients.length === 0 &&
               <div className="flex items-center justify-center h-12 bg-[var(--background)] text-[var(--text-main-color)] opacity-70">
                  <p>Ainda não há clientes cadastrados para esta galeria.</p>
               </div>
            }
         </div>
      </div>
   )
}