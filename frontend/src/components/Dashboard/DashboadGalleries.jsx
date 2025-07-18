import Image from "next/image";
import Link from "next/link";

export function DashboardGalleries({galleries}) {

   if(!galleries) return(
      <div>
         Não foi possível carregar suas galerias. Atualize a página.
      </div>
   )
   return (
      <div className="flex-1 shadow-[0_0_10px_5px_var(--shadow)] border border-[var(--border-color)] bg-[var(--background)] rounded-xl overflow-hidden">

         <div className="flex flex-row justify-between items-center p-2 px-4 border-b border-[var(--border-color)]" >
            <p className="text-xl font-semibold text-[var(--text-main-color)]">Galerias</p>
            <Link href={''} className="text-sm text-[var(--primary-color)]">Ver todas</Link>
         </div>

         <div className="flex flex-col gap-1 p-1 w-full bg-[var(--background)] overflow-hidden overflow-y-auto max-h-[55vh]">
            {galleries.map(gallery => (
               <Link href={''}
                  key={gallery.id}
                  className="flex flex-row gap-2 p-2 text-[var(--text-main-color)] hover:text-[var(--primary-color)] not-last:border-b border-[var(--border-color)]"
               >
                  <div className="w-[35%] h-20 rounded-md overflow-hidden">
                     <Image
                        src={gallery.galery_cover} height={200} width={500} alt="banner"
                        className="h-full"
                     />
                  </div>
                  <div className="flex flex-col justify-between p-1">
                     <div>
                        <p className="font-semibold transition-all text-sm tracking-widest">{gallery.galery_name.toUpperCase()}</p>
                        <p className="text-xs text-[var(--text-main-color)] opacity-60">
                           {new Date(gallery.created_at)
                              .toLocaleDateString('pt-br',
                                 { day: '2-digit', month: 'long', year: 'numeric' }
                              )
                           }
                        </p>
                     </div>
                     <span className="text-xs text-[var(--text-main-color)] opacity-60">Status: {gallery.status}</span>
                  </div>
               </Link>
            ))}
         </div>
      </div>
   )
}