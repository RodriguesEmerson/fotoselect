'use client';
import { useClickOutside } from '@/hooks/useClickOutside';
import MoreHorizIcon from '@mui/icons-material/MoreHoriz';
import { useRef, useState } from 'react';
import { Spinner } from '../../UI/Loaders/Spinner';
import { ClientServices } from '@/Services/clientServices';
import { toast } from 'react-toastify';
import { useStoredClients } from '@/Zustand/useStoredClients';
import { useStoredConfirmModal } from '@/Zustand/useStoredConfirmModal';
import { useStoredModalVisibility } from '@/Zustand/useStoredModalVisibility';

export function ClientsInPageOptions({ client }) {
   const setStoredClients = useStoredClients(state => state.setStoredClients);
   const setConfirmModalData = useStoredConfirmModal(state => state.setConfirmModalData);
   const setIsConfirmDecisionModalVisible = useStoredModalVisibility(state => state.setIsConfirmDecisionModalVisible);
   const [isOpen, setIsOpen] = useState(false);
   const [isFetching, setIsFetching] = useState(false);
   const optionsRef = useRef(null);

   const clickOutside = useClickOutside(optionsRef, () => setIsOpen(false));
   isOpen && clickOutside.setClickOutSide();

   async function handleDeleteClient(){
      setIsConfirmDecisionModalVisible(false);
      const clientServices = new ClientServices();
      setIsFetching(true);
      const response = await clientServices.deleteClient(client.id);
      if(response){
         toast.success('Cliente excluído.');
         toast.info('Aguarde. Atualizando a os clientes em sua tela.');
         const clients = await clientServices.getClients();
         setIsFetching(false);
         if(clients){
            setStoredClients(clients.clients);
            return toast.info('Página atualizada.');
         }
         return toast.error('Não foi possível atualizar os clientes em sua tela. Por favor, atualize a página.')
      }
      setIsFetching(false);
      toast.error('Não foi possível excluir o cliente, tente novamente.')
   }

   return (
      <div
         className='open-modal-button relative w-9 h-fit cursor-pointer'
         onClick={() => setIsOpen(!isOpen)}
         ref={optionsRef}
         modalref-id={`g-options-${client.id}`}
      >
         <span className='flex items-center justify-center h-9 border bg-[var(--background)] text-[var(--text-main-color)] border-[var(--border-color)] rounded-md hover:brightness-95 transition-all'>
            {isFetching
               ? <Spinner size='small' />
               : <MoreHorizIcon />
            }
         </span>

         <ul className={`modal absolute scale-0 origin-bottom-right min-w-46 w-fit text-sm flex flex-col gap-1 bottom-10 right-0 border bg-[var(--background)] text-[var(--text-main-color)] border-[var(--border-color)] rounded-md shadow-[0_0_25px_5px_var(--shadow)] overflow-hidden transition-all ${isOpen && 'scale-100'}`}>
            <li
               className='w-full bg-[var(--background)] text-center hover:brightness-95 transition-all p-2'
               onClick={() => {
               }}
            >
               Editar cliente
            </li>
            <li
               className='w-full bg-[var(--background)] text-center hover:brightness-95 transition-all p-2'
               onClick={() => {
                  setConfirmModalData(
                     `Realmente deseja excluir o(a) cliente`, 
                     client.name,
                     'Ao excluir este cliente, todas as informações e notificações vinculadas a ele serão removidas permanentemente. O acesso às galerias também será revogado.',
                     handleDeleteClient
                  );
                  setIsConfirmDecisionModalVisible(true);
               }}
               //text: '', hltext: '', warnning: false, action: false
            >
               Excluir cliente
            </li>
         </ul>
      </div>
   )
}