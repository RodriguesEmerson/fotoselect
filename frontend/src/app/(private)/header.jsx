import { HeaderNavLink } from "@/components/UI/links/HeaderNavLink"
import Image from "next/image"
export default function Header(){

   const navLinks = [
      {link: '/', text: 'Home'},
      {link: '/pricing', text: 'Preços'},
      {link: '/register', text: 'Cadastre-se'},
      {link: '/login', text: 'Acesse sua conta'}
   ]

   return(
      <header className="sticky top-0 z-10 flex flex-row items-center justify-between  px-3 ween h-16 bg-[var(--background)]">
         <div className="w-40 opacity-85">
            <Image src={'/images/logo.png'} width={500} height={120} blurDataURL="/images/logo.png" alt="logo"/>
         </div>
         <nav>
            <ul className="flex flex-row gap-4 text-gray-600">
               {navLinks.map(link => (
                 <HeaderNavLink key={link.link} link={link.link} text={link.text}/>
               ))}
            </ul>
         </nav>   
      </header>
   )
}