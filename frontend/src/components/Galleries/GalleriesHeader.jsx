'use client'
import AddCircleOutlineIcon from '@mui/icons-material/AddCircleOutline';
import { PurpleButton } from "../UI/buttons/PurpleButton";
import { SearchInput } from "../UI/SearchInput";
import { Select } from "../UI/Select";
import { useGalleries } from '@/Zustand/useGalleries';

export function GalleriesHeader({ serverGalleries }) {
   const setStoreGalleries = useGalleries(state => state.setStoreGalleries);
   const setFilter = useGalleries(state => state.setFilter);
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
                     { text: 'Ordenar', value: 'expire' },
                     { text: 'Crescente A-Z', value: 'asc' },
                     { text: 'Decrescente Z-A', value: 'desc' },
                     { text: 'Data de Expiração', value: 'expire' }
                  ]}
                  handleClick={handleSort}
               />

            </nav>

            <PurpleButton width="fit">
               <AddCircleOutlineIcon />
               <span>Criar Galeria</span>
            </PurpleButton>
         </div>

      </div>
   )
}