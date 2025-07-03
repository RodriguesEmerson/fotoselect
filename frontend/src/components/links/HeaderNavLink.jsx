'use client'
import Link from "next/link";
import { usePathname } from "next/navigation";

export function HeaderNavLink({ link, text }) {

   const pathName = usePathname();
   return (
      <li className={`${pathName != link && 'hover:text-gray-400'} transition-all ${pathName == link && 'text-[var(--primary-color)] border-b-2 border-b[var(--primary-color)]'}`}>
         <Link href={link}>{text}</Link>
      </li>
   )
}