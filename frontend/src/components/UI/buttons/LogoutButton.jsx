import Link from "next/link";
import LogoutIcon from '@mui/icons-material/Logout';

export function LogoutButton(){
   return(
      <Link 
         href='#'
         className="flex flex-row gap-3 items-center pl-5 rounded-md bg-[var(--background)] text-[var(--text-main-color)] h-10 leading-10 hover:text-red-700 hover:brightness-90 transition-all"
      >
         <LogoutIcon />
         <p>Sair</p>
      </Link>
   )
}