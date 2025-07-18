import Image from "next/image"
import Link from "next/link"


export function Galleries({ galleries }) {

   const status = {
      pending: {txt: 'Pendente', color: '#ca8a04'},
      finished: {txt :'Finalizada', color: '#4d7c0f'},
      expired: {txt: 'Expirada', colors: '#991b1b'}
   }

   if (!galleries) return (
      <div>
         Não foi possível carregar suas galerias. Atualize a página.
      </div>
   )

   return (
      <div className="flex flex-col gap-2">
         {galleries.map(gallery => (
            <Link href={''}
               key={gallery.id}
               className="flex flex-row gap-2 p-2 text-[var(--text-main-color)] hover:text-[var(--primary-color)] rounded-xl border border-[var(--border-color)] overflow-hidden h-32"
            >
               <div className="w-52 h-32 -mt-2 -ml-2 rounded-l-md overflow-hidden">
                  <Image
                     src={gallery.galery_cover} height={200} width={400} alt="gallery cover"
                     className="h-full" style={{objectFit: "cover"}}
                  />
               </div>
               <div className="flex flex-col justify-between p-1">
                  <div>
                     <p className="font-semibold transition-all text-sm mb-1 tracking-widest">{gallery.galery_name.toUpperCase()}</p>
                     <div className="flex flex-row gap-1 items-center text-xs text-[var(--text-main-color)] opacity-60">
                        <span>Criada em </span>
                        <span className="">
                           {new Date(gallery.created_at)
                              .toLocaleDateString('pt-br',
                                 { day: '2-digit', month: 'long', year: 'numeric' }
                              )
                           }
                        </span>
                     </div>
                     <div className="flex flex-row gap-1 items-center text-xs text-[var(--text-main-color)] opacity-60">
                        <span>Expira dia </span>
                        <span className="">
                           {new Date(gallery.deadline)
                              .toLocaleDateString('pt-br',
                                 { day: '2-digit', month: 'long', year: 'numeric' }
                              )
                           }
                        </span>
                     </div>
                  </div>
                  <div 
                     className={`flex flex-row gap-1 items-center text-xs text-[var(--text-main-color)]`}
                  >
                     <span>Situação:</span> 
                     <span style={{color: status[gallery.status].color}}>
                        {status[gallery.status].txt}
                     </span>
                  </div>
               </div>
            </Link>
         ))}
      </div>
   )
}