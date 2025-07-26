'use client';
import { useClickOutside } from '@/hooks/useClickOutside';
import MoreHorizIcon from '@mui/icons-material/MoreHoriz';
import { useRef, useState } from 'react';
import { Spinner } from '../../UI/Loaders/Spinner';

export function ClientsInGalleryOptions({ client, handleRemoveClient, isFetching }) {
   const [isOpen, setIsOpen] = useState(false);
   const optionsRef = useRef(null);

   const clickOutside = useClickOutside(optionsRef, () => setIsOpen(false));
   isOpen && clickOutside.setClickOutSide();

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
               onClick={(e) => {
                  handleRemoveClient(client)
               }}
            >
               Remover acesso a galeria
            </li>
         </ul>
      </div>
   )
}