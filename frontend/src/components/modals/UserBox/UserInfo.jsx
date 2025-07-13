import { useClickOutside } from "@/hooks/useClickOutside";
import Image from "next/image";
import { useRef } from "react";

export function UserInfo({user, isOpen, setIsOpen}) {
   const userInfoRef = useRef(null);
   const clickOutside = useClickOutside(userInfoRef, () => setIsOpen(false));
   isOpen && clickOutside.setClickOutSide();

   if(!user.name) return;

   return (
      <section
         ref={userInfoRef}
         modalref-id="user-box"
         className={`modal absolute scale-0 origin-top-right right-0 top-10 p-4  w-80  overflow-x-hidden bg-[var(--background)] text-[var(--text-secondary-color)] text-sm shadow-[0_0_25px_5px_var(--shadow)] rounded-xl border border-[var(--border-color)] transition-all ${isOpen && 'scale-100'}`}
      >
         <div className="flex flex-row gap-3 items-center">
            <div
               className='flex items-center justify-center h-12 w-12 min-w-12 rounded-full overflow-hidden bg-cyan-600 text-white'
            >
               {user?.image
                  ? <Image src={user.image} width={36} height={36} alt='client image' />
                  : <span className='text-xl'>{user.name.slice(0, 1)}</span>
               }
            </div>
            <div>
               <p className="font-bold text-[1.20rem]">{user?.name}</p>
               <p className="brightness-70">{user?.email}</p>
            </div>
         </div>
      </section>
   )
}