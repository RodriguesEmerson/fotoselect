import { ClientOptions } from "@/components/Clients/ClientOptions";
import { TransparentInPurpleButton } from "@/components/UI/buttons/TransparentInPurpleButton";
import PersonAddIcon from '@mui/icons-material/PersonAdd';
import Image from "next/image";

export function ClientsInGallery({ gallery, clients, status }) {
   const letterColors = {
      a: '#FF6B6B', b: '#F06595', c: '#CC5DE8', d: '#845EF7', e: '#5C7CFA', f: '#339AF0', g: '#22B8CF', h: '#20C997', i: '#51CF66', j: '#94D82D', k: '#FCC419', l: '#FFD43B', m: '#FFA94D', n: '#FF922B', o: '#FF6B6B', p: '#F783AC', q: '#B197FC', r: '#748FFC', s: '#63E6BE', t: '#A9E34B', u: '#FAB005', v: '#E67700', w: '#D6336C', x: '#7048E8', y: '#3B5BDB', z: '#15AABF'
   };

   //CRIAR FUNÇÃO PARA EXCLUIR E ADICIONAR CLIENTES NA GALERIA

   return (
      <div className=" flex flex-col gap-3 w-full text-[var(--text-main-color)] mt-3">
         <div className="flex flex-row items-end justify-between">
            <h2 className="font-bold pl-1">Clientes da galeria ({clients.length})</h2>
            <TransparentInPurpleButton >
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
                  {clients.map(client => {
                     const clientNameInitialLeter = client.name.slice(0, 1).toLowerCase();
                     return (
                        <tr className="h-16 not-last:border-b border-[var(--border-color)]" key={client.id}>
                           <td className="h-16 flex flex-row gap-4 px-2 items-center ">
                              <div
                                 className={`flex items-center justify-center h-9 w-9 min-w-9 rounded-full overflow-hidden text-white`}
                                 style={{ backgroundColor: letterColors[clientNameInitialLeter] }}
                              >
                                 {client.profile_image
                                    ? <Image src={client.profile_image} width={36} height={36} alt='client image' />
                                    : <span className='text-xl -mt-[0.10rem]'>{clientNameInitialLeter}</span>
                                 }
                              </div>
                              <div className="flex flex-col justify-center gap-3">
                                 <p className="font-semibold text-base">{client.name}</p>
                                 <span className="text-[0.80rem] -mt-4 opacity-90">{client.email}</span>
                              </div>
                           </td>
                           <td style={{ color: status[gallery.status]?.color }}>
                              {status[gallery.status]?.txt}</td>
                           <td>
                              <ClientOptions client={client} />
                           </td>
                        </tr>
                     )
                  })}
               </tbody>
            </table>
            {clients.length === 0 &&
               <div className="flex items-center justify-center h-12 bg-[var(--background)] text-[var(--text-main-color)] opacity-70">
                  <p>Ainda não há clientes cadastrados para esta galeria.</p>
               </div>
            }
         </div>
      </div>
   )
}