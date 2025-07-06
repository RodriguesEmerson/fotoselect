'use client'
import Link from "next/link";
import { usePathname } from "next/navigation";

export function SideBarLink({ link, children }) {

   const pathName = usePathname();
   const isActive = pathName == link;
   
   return (
      <Link
         href={link}
         className={`flex flex-row gap-2 text-sm h-10 rounded-md items-center pl-4 hover:text-[var(--primary-color)] transition-all 
            ${ isActive && 'bg-[var(--button-primary-color)] text-white hover:text-white'}`}
      >
         {children}
      </Link>
   )
}