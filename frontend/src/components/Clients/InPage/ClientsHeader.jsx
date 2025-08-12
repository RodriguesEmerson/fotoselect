'use client'
import { PurpleButton } from "@/components/UI/buttons/PurpleButton";
import { SearchInput } from "@/components/UI/inputs/SearchInput";
import { ClientServices } from "@/Services/clientServices";
import { useStoredClients } from "@/Zustand/useStoredClients";
import { useStoredModalVisibility } from "@/Zustand/useStoredModalVisibility";
import PersonAddIcon from '@mui/icons-material/PersonAdd';
import { useEffect, useState } from "react";
import { toast } from "react-toastify";

export function ClientsHeader() {
   const setIsHandleClientModal = useStoredModalVisibility(state => state.setIsHandleClientModal);
   const setStoredClients = useStoredClients(state => state.setStoredClients);
   const setClientsSearch = useStoredClients(state => state.setClientsSearch);
   const [clients, setClients] = useState(false);
   const [isFetching, setIsFetching] = useState(false);
   const clientServies = new ClientServices();

   useEffect(() => {
      async function handleGetClients() {
         setIsFetching(true);
         const response = await clientServies.getClients();
         setIsFetching(false);
         if (response) {
            setClients(response.clients);
            return setStoredClients(response.clients);
         }
         return toast.error('Erro ao buscar os dados dos seus clientes.')
      }
      handleGetClients();
   }, [])

   function handleSerchClients(chars) {
      clients && setClientsSearch(chars, clients);
   }

   return (
      <>
         <div className="flex flex-row justify-between py-2">
            <div className="flex flex-row gap-3">
               <SearchInput onChange={handleSerchClients} />
            </div>
            <div>
               <PurpleButton width="fit" onClick={() => setIsHandleClientModal(true)}>
                  <PersonAddIcon />
                  <span>Cadastrar cliente</span>
               </PurpleButton>
            </div>
         </div>
         <div>
            {isFetching &&
               <p className="text-[var(--text-main-color)] animate-pulse text-center mt-10">Buscando dados dos clientes...</p>
            }
         </div>
      </>
   )
}