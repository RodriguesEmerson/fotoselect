'use client'
import AddCircleOutlineIcon from '@mui/icons-material/AddCircleOutline';
import { PurpleButton } from "../UI/buttons/PurpleButton";
import { SearchInput } from "../UI/SearchInput";
import { Select } from "../UI/Select";
import { useGalleries } from '@/Zustand/useGalleries';

export function GalleriesHeader({ serverGalleries }) {
   const setStoreGalleries = useGalleries(state => state.setStoreGalleries);
   const setSortOrder = useGalleries(state => state.setSortOrder);
   const setStatusFilter = useGalleries(state => state.setStatusFilter);
   const setSearchFilter = useGalleries(state => state.setSearchFilter);
   setStoreGalleries(serverGalleries);

   function handleFilter(status) {
      setStatusFilter(serverGalleries, status);
   }
   
   function handleSort(order) {
      setSortOrder(serverGalleries, order)
   }

   function handleSearch(chars){
      setSearchFilter(serverGalleries, chars)
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