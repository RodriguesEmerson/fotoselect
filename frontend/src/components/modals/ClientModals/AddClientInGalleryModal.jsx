'use client';
import { useStoredModalVisibility } from "@/Zustand/useStoredModalVisibility";
import CloseIcon from '@mui/icons-material/Close';
import { toast } from "react-toastify";
import { ModalBackground } from "../ModalBackground";
import { ClientServices } from "@/Services/clientServices";
import { useEffect, useState } from "react";
import Image from "next/image";
import PersonAddIcon from '@mui/icons-material/PersonAdd';
import { Spinner } from "@/components/UI/Loaders/Spinner";
import { PurpleLinkButton } from "@/components/UI/links/PurpleLinkButton";
import LaunchIcon from '@mui/icons-material/Launch';
import { GalleryServices } from "@/Services/galleryServices";

export function AddClientInGalleryModal({ clients, setClients, gallery }) {
   const isAddClientInGalleryModal = useStoredModalVisibility(state => state.isAddClientInGalleryModal);
   if (!isAddClientInGalleryModal) return;
   return (
      <AddClientInGalleryModalBody
         gallery={gallery}
         clients={clients}
         setClients={setClients}
      />
   )
}

function AddClientInGalleryModalBody({ clients, setClients, gallery }) {
   const setIsAddClientInGalleryModal = useStoredModalVisibility(state => state.setIsAddClientInGalleryModal);
   const [clientsOutOfGallery, setClientsOutOfGallery] = useState(false);

   const handleCloseModal = () => {
      setIsAddClientInGalleryModal(false);
   }

   const clientServices = new ClientServices();

   useEffect(() => {
      const getClients = async () => {
         const result = await clientServices.getClients();
         if (result) {
            const clientsAlreadyInGalleryIDs = clients.map(client => client.id);
            return setClientsOutOfGallery(result.clients.filter(client => !clientsAlreadyInGalleryIDs.includes(client.id)));
         }
         return toast.error('Erro ao buscar os clientes.')
      }
      getClients();
   }, [clients]);

   return (
      <ModalBackground
         onMouseDown={() => handleCloseModal}
      >
         <section
            className="p-2 w-fit h-fit bg-[var(--background)] text-[var(--text-secondary-color)] text-sm shadow-[0_0_25px_5px_var(--shadow)] rounded-xl border border-[var(--border-color)] transition-all"
            onMouseDown={(e) => { e.stopPropagation() }}
         >
            <div className="flex flex-row items-center justify-between border-b border-[var(--border-color)] p-2">
               <span className="block w-4 h-4 bg-[var(--secondary-color)] rounded-full"></span>
               <h2 className="text-center font-semibold text-base">Clientes</h2>
               <CloseIcon
                  className="cursor-pointer"
                  onClick={() => handleCloseModal()}
               />
            </div>

            <ul className="flex flex-col w-fit min-w-100">
               {clientsOutOfGallery && clientsOutOfGallery.map(client => (
                  <LiClient 
                     key={client.id} 
                     client={client} 
                     clients={clients} 
                     setClients={setClients} 
                     gallery={gallery} 
                  />
               ))}
               {!clientsOutOfGallery &&
                  <li className="text-[var(--text-main-color)] animate-pulse text-center py-3">Buscando clientes...</li>
               }
            </ul>
            {clientsOutOfGallery.length === 0 &&
               <div className="flex items-center justify-center h-12 bg-[var(--background)] text-[var(--text-main-color)] opacity-70">
                  <p>Não há clientes para adicionar à galeria.</p>
               </div>
            }
            <div className="flex flex-row w-full justify-end border-t border-t-[var(--border-color)] pt-2 mt-5">
               <PurpleLinkButton href={''} size="fit" >
                  <span>Criar novo cliente</span>
                  <LaunchIcon className="!text-base" />
               </PurpleLinkButton>
            </div>
         </section>
      </ModalBackground>
   )
}

function LiClient({ client, clients, setClients, gallery }) {
   const letterColors = {
      a: '#FF6B6B', b: '#F06595', c: '#CC5DE8', d: '#845EF7', e: '#5C7CFA', f: '#339AF0', g: '#22B8CF', h: '#20C997', i: '#51CF66', j: '#94D82D', k: '#FCC419', l: '#FFD43B', m: '#FFA94D', n: '#FF922B', o: '#FF6B6B', p: '#F783AC', q: '#B197FC', r: '#748FFC', s: '#63E6BE', t: '#A9E34B', u: '#FAB005', v: '#E67700', w: '#D6336C', x: '#7048E8', y: '#3B5BDB', z: '#15AABF'
   };
   const clientNameInitialLeter = client.name.slice(0, 1).toLowerCase();

   const [isFetching, setIsFetching] = useState(false);
   const galleryServices = new GalleryServices();

   async function handleAddClient(clientToAdd) {
      setIsFetching(true);
      const response = await galleryServices.addClientInGallery(gallery.id, clientToAdd.email);
      setIsFetching(false);
      if (response) {
         setClients([...clients, clientToAdd]);
         return toast.success(t => (
            <p>Adicionado acesso para o(a) cliente <span className="font-semibold">{clientToAdd.name}</span> à galeria!</p>
         ));
      }
      return toast.error('Algo deu errado, tente novamente.');
   }
   return (
      <li className="flex flex-row gap-3 items-center justify-between h-12 not-last:border-b border-[var(--border-color)] px-2">
         <div className="flex flex-row gap-3 items-center">
            <div
               className={`flex items-center justify-center h-9 w-9 min-w-9 rounded-full overflow-hidden text-white`}
               style={{ backgroundColor: letterColors[clientNameInitialLeter] }}
            >
               {client.profile_image
                  ? <Image src={client.profile_image} width={36} height={36} alt='client image' />
                  : <span className='text-xl -mt-[0.10rem]'>{clientNameInitialLeter}</span>
               }
            </div>
            <p className="font-semibold text-base">{client.name}</p>
            <p>{client.email}</p>
         </div>
         <div className="flex items-center justify-center text-[var(--text-main-color)] border border-[var(--text-main-color)] h-7 w-7 rounded-md cursor-pointer bg-[var(--background)] hover:brightness-95 transition-all"
            onClick={() => { !isFetching && handleAddClient(client) }}
         >
            {isFetching
               ? <Spinner size="small" />
               : <PersonAddIcon className="!text-xl" />
            }
         </div>
      </li>
   )
}