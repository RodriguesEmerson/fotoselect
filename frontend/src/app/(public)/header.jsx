import { HeaderNavLink } from "@/components/links/HeaderNavLink"
import Image from "next/image"
export default function Header(){

   const navLinks = [
      {link: '/', text: 'Home'},
      {link: '/pricing', text: 'Preços'},
      {link: '/register', text: 'Cadastre-se'},
      {link: '/login', text: 'Acesse sua conta'}
   ]

   return(
      <header className="flex flex-row items-center justify-around h-16 border-b border-b-gray-200">
         <div className="w-40 opacity-85">
            <Image src={'/images/logo.png'} width={500} height={120} blurDataURL="/images/logo.png" alt="logo"/>
         </div>
         <nav>
            <ul className="flex flex-row gap-4 text-gray-600">
               {navLinks.map(link => (
                 <HeaderNavLink key={link.link} link={link.link} text={link.text}/>
               ))
               }
            </ul>
         </nav>   
      </header>
   )
}