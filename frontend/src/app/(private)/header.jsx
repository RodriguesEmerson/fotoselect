import { NotificationBox } from "@/components/modals/Notification/NotificationBox"
import { UserBox } from "@/components/modals/UserBox/UserBox"
import Image from "next/image"

export default function Header() {
   const noti = [
      { code: '1', gallery_name: 'João & Maria', client_name: 'João', created_at: '2025-07-07 19:30:17', id: 1, image: '' },
      { code: '2', gallery_name: 'João & Maria', client_name: 'Maria', created_at: '2025-07-07 19:30:17', id: 2, image: '' },
      { code: '3', gallery_name: 'João & Maria', client_name: 'Maria', created_at: '2025-07-07 19:30:17', id: 3, image: '' },
      { code: '4', gallery_name: 'João & Maria', client_name: 'Maria', created_at: '2025-07-07 19:30:17', id: 4, image: '' },
      { code: '1', gallery_name: 'João & Maria', client_name: 'João', created_at: '2025-07-07 19:30:17', id: 5, image: '' },
      { code: '2', gallery_name: 'João & Maria', client_name: 'Maria', created_at: '2025-07-07 19:30:17', id: 6, image: '' },
      { code: '3', gallery_name: 'João & Maria', client_name: 'Maria', created_at: '2025-07-07 19:30:17', id: 7, image: '' },
      { code: '4', gallery_name: 'João & Maria', client_name: 'Maria', created_at: '2025-07-07 19:30:17', id: 8, image: '' },

   ]
   const user = { name: 'Emerson', email: 'emersonrodrigues@teste.com', image: '' }

   return (
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
            <ul className="flex flex-row gap-2 text-[var(--text-main-color)]">
               <li className="relative w-fit">
                  <NotificationBox notifications={noti} />
               </li>
               <li className="relative w-fit">
                  <UserBox user={user} />
               </li>
            </ul>
         </div>
      </header>
   )
}