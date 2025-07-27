'use client'
import { ClientsInGalleryOptions } from "@/components/Clients/InGallery/ClientsInGalleryOptions";
import { TransparentInPurpleButton } from "@/components/UI/buttons/TransparentInPurpleButton";
import { GalleryServices } from "@/Services/galleryServices";
import { useStoredModalVisibility } from "@/Zustand/useStoredModalVisibility";
import PersonAddIcon from '@mui/icons-material/PersonAdd';
import Image from "next/image";
import { useState } from "react";
import { toast } from "react-toastify";
import { AddClientInGalleryModal } from "../../modals/ClientModals/AddClientInGalleryModal";
import { ProfileLetterIcon } from "@/components/UI/ProfileLetterIcon";

export function ClientsInGallery({ gallery, serverClients }) {
   const setIsAddClientInGalleryModal = useStoredModalVisibility(state => state.setIsAddClientInGalleryModal);

   const [clients, setClients] = useState(false);
   !clients && setClients(serverClients);

   if (!clients) return (
      <div className="w-full text-center animate-pulse text-[var(--text-main-color)] pt-4">
         <p>Buscando clientes da galeria...</p>
      </div>
   )

   return (
      <>
         <AddClientInGalleryModal
            gallery={gallery}
            clients={clients}
            setClients={setClients}
         />
         
         <div className=" flex flex-col gap-3 w-full text-[var(--text-main-color)] mt-3">
            <div className="flex flex-row items-end justify-between">
               <h2 className="font-bold pl-1">Clientes da galeria ({clients.length})</h2>
               <TransparentInPurpleButton
                  onClick={() => setIsAddClientInGalleryModal(true)}
               >
                  <PersonAddIcon />
                  <span>Adicionar cliente</span>
               </TransparentInPurpleButton>
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
                  <tbody className="text-sm bg-[var(--background)]">
                     {clients && clients.map(client => (
                        <TableTrClient
                           key={client.id}
                           gallery={gallery}
                           client={client}
                           clients={clients}
                           setClients={setClients}
                        />
                     ))}
                  </tbody>
               </table>
               {clients.length === 0 &&
                  <div className="flex items-center justify-center h-12 bg-[var(--background)] text-[var(--text-main-color)] opacity-70">
                     <p>Ainda não há clientes cadastrados para esta galeria.</p>
                  </div>
               }
            </div>
         </div>
      </>
   )
}

function TableTrClient({ gallery, client, clients, setClients }) {
   const status = {
      pending: { txt: 'Pendente', color: '#ca8a04' },
      finished: { txt: 'Finalizada', color: '#4d7c0f' },
      expired: { txt: 'Expirada', color: '#991b1b' }
   }
   const letterColors = {
      a: '#FF6B6B', b: '#F06595', c: '#CC5DE8', d: '#845EF7', e: '#5C7CFA', f: '#339AF0', g: '#22B8CF', h: '#20C997', i: '#51CF66', j: '#94D82D', k: '#FCC419', l: '#FFD43B', m: '#FFA94D', n: '#FF922B', o: '#FF6B6B', p: '#F783AC', q: '#B197FC', r: '#748FFC', s: '#63E6BE', t: '#A9E34B', u: '#FAB005', v: '#E67700', w: '#D6336C', x: '#7048E8', y: '#3B5BDB', z: '#15AABF'
   };
   const clientNameInitialLeter = client.name.slice(0, 1).toLowerCase();
   const [isFetching, setIsFetching] = useState(false);
   const galleryServices = new GalleryServices();

   async function handleRemoveClient(clientToRemove) {
      setIsFetching(true);
      const response = await galleryServices.removeClientFromGallery(gallery.id, clientToRemove.email);
      setIsFetching(false);
      if (response) {
         setClients([...clients].filter(client => client.id !== clientToRemove.id));
         return toast.success(t => (
            <p>Removido o acesso do(a) cliente <span className="font-semibold">{clientToRemove.name}</span> da galeria!</p>
         ));
      }
      return toast.error('Algo deu errado, tente novamente.');
   }

   return (
      <tr className="h-16 not-last:border-b border-[var(--border-color)]">
         <td className="h-16 flex flex-row gap-4 px-2 items-center ">

            <ProfileLetterIcon name={client.name} image={client.profile_image}/>
            
            <div className="flex flex-col justify-center gap-3">
               <p className="font-semibold text-base">{client.name}</p>
               <span className="text-[0.80rem] -mt-4 opacity-90">{client.email}</span>
            </div>
         </td>
         <td style={{ color: status[gallery.status]?.color }}>
            {status[gallery.status]?.txt}</td>
         <td>
            <ClientsInGalleryOptions
               client={client}
               handleRemoveClient={handleRemoveClient}
               isFetching={isFetching}
            />
         </td>
      </tr>
   )
}