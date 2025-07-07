import { NotificationBox } from "@/components/Notification/NotificationBox"
import Image from "next/image"

export default function Header(){

   return(
      <header className="sticky top-0 z-10 flex flex-row items-center justify-between  px-3 ween h-16 bg-[var(--background)]">
         <div className="w-40 opacity-85">
            <Image 
               src={'/images/logo.png'} width={500} height={120} 
               blurDataURL="/images/logo.png" 
               alt="logo" 
               placeholder="blur"
               priority
            />
         </div>
         <div className="h-9">
            <ul className="flex flex-row text-[var(--text-main-color)]">
               <li className="relative w-fit">
                  <NotificationBox />
               </li>
            </ul>

         </div>
      </header>
   )
}