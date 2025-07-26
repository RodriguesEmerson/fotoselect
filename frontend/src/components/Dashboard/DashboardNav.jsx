import Link from "next/link";
import PhotoLibraryIcon from '@mui/icons-material/PhotoLibrary';
import GroupIcon from '@mui/icons-material/Group';
import CardMembershipIcon from '@mui/icons-material/CardMembership';
import HelpIcon from '@mui/icons-material/Help';

export function DashboardNav({ dashInfo }) {
   return (
      <nav className="flex flex-row gap-4 justify-between w-full items-stretch">
         <Link
            className="h-32 bg-[var(--background)] min-w-56 flex flex-1 flex-col gap-2 items-center justify-center rounded-xl border border-[var(--border-color)] shadow-[0_0_20px_5px_var(--shadow)] text-[var(--primary-color)] transition-all hover:text-white hover:bg-[#450172]"

            href={'http://localhost:3000/galleries'}
         >
            <PhotoLibraryIcon />
            <span>Galerias</span>
         </Link>
         <Link
            className="h-32 bg-[var(--background)] min-w-56 flex flex-1 flex-col gap-2 items-center justify-center rounded-xl border border-[var(--border-color)] shadow-[0_0_20px_5px_var(--shadow)] text-[var(--primary-color)] transition-all hover:text-white hover:bg-[#450172]"

            href={''}
         >
            <GroupIcon />
            <span>Clientes</span>
         </Link>
         <Link
            className="h-32 bg-[var(--background)] min-w-56 flex flex-1 flex-col gap-2 items-center justify-center rounded-xl border border-[var(--border-color)] shadow-[0_0_20px_5px_var(--shadow)] text-[var(--primary-color)] transition-all hover:text-white hover:bg-[#450172]"

            href={''}
         >
            <CardMembershipIcon />
            <span>Comprar Créditos</span>
         </Link>
         <div
            className="h-32 bg-[var(--background)] min-w-56 flex flex-1 flex-col gap-2 items-center justify-center rounded-xl border border-[var(--border-color)] shadow-[0_0_20px_5px_var(--shadow)] text-[var(--primary-color)] transition-all"
         >
            <div className="flex flex-row w-full px-4 gap-2 text-sm items-center text-[var(--text-main-color)] opacity-80">
               <GroupIcon />
               <span>Clientes: {dashInfo.clients}</span>
            </div>
            <div className="flex flex-row w-full px-4 gap-2 text-sm items-center text-[var(--text-main-color)] opacity-80">
               <PhotoLibraryIcon />
               <span>Galerias: {dashInfo.galleries}</span>
            </div>
            <div className="flex flex-row w-full px-4 gap-2 text-sm items-center text-[var(--text-main-color)] opacity-80">
               <PhotoLibraryIcon />
               <span>Galerias Pedentes: {dashInfo.pendingGalleries}</span>
            </div>
         </div>
      </nav>
   )
}