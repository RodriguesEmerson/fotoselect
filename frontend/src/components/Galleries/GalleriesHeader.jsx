'use client'
import { useGalleries } from '@/Zustand/useGalleries';
import { useModalVisibility } from '@/Zustand/useModalVisibility';
import AddCircleOutlineIcon from '@mui/icons-material/AddCircleOutline';
import { NewGalleryModal } from '../modals/NewGallery/NewGalleryModal';
import { PurpleButton } from "../UI/buttons/PurpleButton";
import { SearchInput } from "../UI/inputs/SearchInput";
import { Select } from "../UI/Select";

export function GalleriesHeader({ serverGalleries }) {
   const setStoreGalleries = useGalleries(state => state.setStoreGalleries);
   const setFilter = useGalleries(state => state.setFilter);
   const setIsNewGalleryModalVisible = useModalVisibility(state => state.setIsNewGalleryModalVisible) 
   setStoreGalleries(serverGalleries);

   function handleFilter(status) {
      setFilter(serverGalleries, {status: status});
   }
   
   function handleSort(order) {
      setFilter(serverGalleries, { order: order});
   }

   function handleSearch(chars) {
      setFilter(serverGalleries, { searchChars: chars});
   }  

   return (
      <div>
         <div className="flex flex-row justify-between py-2">
            <nav className="flex flex-row gap-3">
               <SearchInput onChange={handleSearch}/>
               <Select
                  options={[
                     { text: 'Todas', value: 'all' },
                     { text: 'Pendentes', value: 'pending' },
                     { text: 'Finalizadas', value: 'finished' },
                     { text: 'Expiradas', value: 'expired' }
                  ]}
                  handleClick={handleFilter}
               />
               <Select
                  options={[
                     { text: 'Mais recente', value: 'default' },
                     { text: 'Crescente A-Z', value: 'asc' },
                     { text: 'Decrescente Z-A', value: 'desc' },
                     { text: 'Data de Expiração', value: 'expire' }
                  ]}
                  handleClick={handleSort}
               />

            </nav>

            <PurpleButton width="fit" onClick={() => setIsNewGalleryModalVisible(true)}>
               <AddCircleOutlineIcon />
               <span>Criar Galeria</span>
            </PurpleButton> 
         </div>
         <NewGalleryModal />
      </div>
   )
}