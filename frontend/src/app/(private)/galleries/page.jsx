import { cookies } from "next/headers";
import { Galleries } from "./galleries";
import { SearchInput } from "@/components/UI/SearchInput";
import { Select } from "@/components/UI/Select";
import { PurpleButton } from "@/components/UI/buttons/PurpleButton";
import AddCircleOutlineIcon from '@mui/icons-material/AddCircleOutline';

export default async function Dasjboard() {

   const token = (await cookies()).get('FSJWTToken')?.value;
   const req = await fetch(`http://localhost/fotoselect/backend/galery/fetchlot/99/0`,
      {
         method: 'GET',
         credentials: 'include',
         headers: { Authorization: `Bearer ${token}`, }
      }
   )
   if (req.status !== 200) return <></>

   const res = await req.json();
   const galleries = res.content.galleries;

   return (
      <section className="flex flex-col gap-3 h-[calc(100vh-4rem)] -mt-2 w-full bg-[var(--dashboard-background)] shadow-[0_0_3_3px_var(--shadow)] rounded-xl pt-3 px-10 overflow-y-auto">
         <div>
            <div className="flex flex-row justify-between">
               <nav className="flex flex-row gap-3">
                  <SearchInput />
                  <Select options={['Filtrar', 'Pendente', 'Finalizada', 'Expirada']}/>
                  <Select options={['Ordenar', 'Crescente A-Z', 'Decrescente Z-A', 'Data de Expiração']}/>
               </nav>

              <PurpleButton width="fit"> 
                  <AddCircleOutlineIcon />
                  <span>Criar Galeria</span>
              </PurpleButton>
            </div>

         </div>

         <Galleries galleries={galleries} />

      </section>
   )
}