'use client';
import { useClickOutside } from '@/hooks/useClickOutside';
import { GalleryServices } from '@/Services/galleryServices';
import { useStoredConfirmModal } from '@/Zustand/useStoredConfirmModal';
import { useStoredGalleries } from '@/Zustand/useStoredGalleries';
import { useStoredModalVisibility } from '@/Zustand/useStoredModalVisibility';
import MoreHorizIcon from '@mui/icons-material/MoreHoriz';
import { useRef, useState } from 'react';
import { toast } from 'react-toastify';
import { Spinner } from '../UI/Loaders/Spinner';

export function ClientOptions({ client }) {
   const [isOpen, setIsOpen] = useState(false);
   const [isDeleting, setIsDeleting] = useState(false);
   const galleryServices = new GalleryServices();
   const setIsConfirmDecisionModalVisible = useStoredModalVisibility(state => state.setIsConfirmDecisionModalVisible);
   const setConfirmModalData = useStoredConfirmModal(state => state.setConfirmModalData);
   const delteStoredGallery = useStoredGalleries(state => state.delteStoredGallery);
   const optionsRef = useRef(null);

   const clickOutside = useClickOutside(optionsRef, () => setIsOpen(false));
   isOpen && clickOutside.setClickOutSide();

   const handleClick = async () => {

      setIsDeleting(true);
      setIsConfirmDecisionModalVisible(false);
      const result = await galleryServices.delete(client.id);
      setIsDeleting(false);
      if(result){
         toast.success(t => (
            <p>A galeria <span className="font-semibold">{client.galery_name}</span> foi excluída permanentemente!</p>
         ));
         return delteStoredGallery(client.id);
      }
      return toast.error('Algo deu errado, tente novamente.');
   }

   return (
      <div
         className='open-modal-button relative w-9 h-fit cursor-pointer'
         onClick={() => setIsOpen(!isOpen)}
         ref={optionsRef}
         modalref-id={`g-options-${client.id}`}
      >
         <span className='flex items-center justify-center h-9 border bg-[var(--background)] text-[var(--text-main-color)] border-[var(--border-color)] rounded-md hover:brightness-95 transition-all'>
            {!isDeleting
               ? <MoreHorizIcon />
               : <Spinner size='small' />
            }

         </span>

         <ul className={`modal absolute scale-0 origin-bottom-right w-32 text-sm flex flex-col gap-1 bottom-10 right-0 border bg-[var(--background)] text-[var(--text-main-color)] border-[var(--border-color)] rounded-md shadow-[0_0_25px_5px_var(--shadow)] overflow-hidden transition-all ${isOpen && 'scale-100'}`}>
            <li
               className='w-full bg-[var(--background)] text-center hover:brightness-95 transition-all p-2'
               onClick={(e) => {
                  e.preventDefault();
                  e.stopPropagation();
                  setConfirmModalData(
                     'Deseja relamente excluir as informações do(a) clinte ',
                     `${client.name}`,
                     false,
                     handleClick
                  );
                  setIsConfirmDecisionModalVisible(true);
               }}
            >
               Excluir cliente
            </li>
         </ul>
      </div>
   )
}