import { useClickOutside } from "@/hooks/useClickOutside";
import { useRef } from "react";
import Image from "next/image";

export function Notifications({ isOpen, setIsOpen, notifications }) {

   const notificationsRef = useRef(null);

   const clickOutside = useClickOutside(notificationsRef, () => setIsOpen(false));
   isOpen && clickOutside.setClickOutSide();

   return (
      <section
         ref={notificationsRef}
         modalref-id="notification-box"
         className={`modal absolute scale-0 origin-top-right right-0 top-10 p-2 overflow-hidden pt-0 w-80 bg-[var(--background)] text-[var(--text-secondary-color)] text-sm shadow-[0_0_25px_5px_var(--shadow)] rounded-xl border border-[var(--border-color)] transition-all ${isOpen && 'scale-100'}`}
      >
         {/** Notification top blur gradient  */}
         <div className="absolute z-10 left-0 w-80 h-10 bg-[linear-gradient(180deg,var(--background)_0%,var(--background)_18%,rgba(237,221,83,0)_100%)]  pointer-events-none" >
         </div>
         <div className='h-fit max-h-[calc(100vh-5rem)] bg-[var(--background)] overflow-y-scroll pb-5 pt-5'>
            {notifications?.length > 0
               ? notifications.map(notification => (

                  //Notification body
                  <div
                     key={notification.id}
                     className='flex flex-row items-center gap-3 py-2 border-b border-[var(--border-color)]'
                  >
                     {/** Client image */}
                     <div
                        className='flex items-center justify-center h-9 w-9 min-w-9 rounded-full overflow-hidden bg-cyan-600 text-white'
                     >
                        {notification.image
                           ? <Image src={notification.image} width={36} height={36} alt='client image' />
                           : <span className='text-xl'>{notification.client.slice(0, 1)}</span>
                        }
                     </div>

                     {/** Notification message */}
                     <div className='flex flex-col gap-3'>
                        {(notification.type == '1') &&
                           <p><strong>{notification.client}</strong> acessou a galeria <strong>{notification.gallery}</strong>.</p>
                        }
                        {(notification.type == '2') &&
                           <p><strong>{notification.client}</strong> finalizou a seleção de fotos da galeria <strong>{notification.gallery}</strong>.</p>
                        }
                        {(notification.type == '3') &&
                           <p>A geleria <strong>{notification.gallery}</strong> foi enviada para o&#40;a&#41; cliente <strong>{notification.client}</strong>.</p>
                        }
                        {(notification.type == '4') &&
                           <p><strong>{notification.client}</strong> perdeu o prazo para a seleção de fotos da galeria <strong>{notification.gallery}</strong>.</p>
                        }

                        {/** Notification date */}
                        <p className='text-xs opacity-70 text-end'>
                           {new Date(notification.data)
                              .toLocaleDateString('pt-br',
                                 { day: '2-digit', month: 'long', year: 'numeric', hour: 'numeric', minute: '2-digit' }
                              )
                           }
                           <span> h</span>
                        </p>
                     </div>

                  </div>
               ))
               : <p className='text-center my-3'>Você ainda não tem nenuma notificação.</p>
            }
         </div>
         {/** Notification bottom blur gradient  */}
         <div className="absolute z-10 -bottom-0 left-0 w-80 h-16 bg-[linear-gradient(0deg,var(--background)_0%,var(--background)_18%,rgba(237,221,83,0)_100%)]  pointer-events-none" >
         </div>
      </section>
   )
}