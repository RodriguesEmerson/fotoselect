import { useClickOutside } from "@/hooks/useClickOutside";
import { useRef } from "react";
import Image from "next/image";
import { ProfileLetterIcon } from "@/components/UI/ProfileLetterIcon";

export function Notifications({ isOpen, setIsOpen, notifications, setNotifications }) {

   const notificationsRef = useRef(null);

   const clickOutside = useClickOutside(notificationsRef, () => setIsOpen(false));
   isOpen && clickOutside.setClickOutSide();
   const letterColors = {
      a: '#FF6B6B', b: '#F06595', c: '#CC5DE8', d: '#845EF7', e: '#5C7CFA', f: '#339AF0', g: '#22B8CF', h: '#20C997', i: '#51CF66', j: '#94D82D', k: '#FCC419', l: '#FFD43B', m: '#FFA94D', n: '#FF922B', o: '#FF6B6B', p: '#F783AC', q: '#B197FC', r: '#748FFC', s: '#63E6BE', t: '#A9E34B', u: '#FAB005', v: '#E67700', w: '#D6336C', x: '#7048E8', y: '#3B5BDB', z: '#15AABF'
   };



   async function handleMarkAsRead(id) {
      await fetch(`http://localhost/fotoselect/backend/user/notifications/read`,
         {
            method: 'PUT',
            credentials: 'include',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id: id })
         }
      )
         .then(async res => {
            if (res.status === 200) {
               const updatedNotifications = [...notifications];
               updatedNotifications.forEach(notification => {
                  if (notification.id == id) {
                     notification.read_at = true;
                  }
                  setNotifications(updatedNotifications);
               });
            }
         })
         .catch(error => {
            console.log(error)
         })
   }

   return (
      <section
         ref={notificationsRef}
         modalref-id="notification-box"
         className={`modal absolute scale-0 origin-top-right right-0 top-10 p-2 overflow-hidden pt-0 w-80 bg-[var(--background)] text-[var(--text-secondary-color)] text-sm shadow-[0_0_25px_5px_var(--shadow)] rounded-xl border border-[var(--border-color)] transition-all ${isOpen && 'scale-100'}`}
      >
         {/** Notification top blur gradient  */}
         {notifications?.length > 7 &&
            <div className="absolute z-10 left-0 w-80 h-5 bg-[linear-gradient(180deg,var(--background)_0%,var(--background)_18%,rgba(237,221,83,0)_100%)]  pointer-events-none" >
            </div>
         }
         <div className='h-fit max-h-[calc(100vh-5rem)] px-1 bg-[var(--background)] overflow-y-auto pb-5 pt-5'>
            {notifications?.length > 0
               ? notifications.map(notification => {
                  const clientNameInitialLeter = notification.client_name.slice(0, 1).toLowerCase();
                  return (
                     //Notification body
                     <div
                        key={notification.id}
                        className={`flex flex-row items-center gap-3 py-2  border-[var(--border-color)] not-last:border-b `}
                     >
                        
                        <ProfileLetterIcon name={notification.client_name} image={notification.client_image}/>

                        {/** Notification message */}
                        <div className={`flex flex-col gap-3  ${notification.read_at && 'opacity-60'}`}>
                           {(notification.code == '1') &&
                              <p><strong>{notification.client_name}</strong> acessou a galeria <strong>{notification.gallery_name}</strong>.</p>
                           }
                           {(notification.code == '2') &&
                              <p><strong>{notification.client_name}</strong> finalizou a seleção de fotos da galeria <strong>{notification.gallery_name}</strong>.</p>
                           }
                           {(notification.code == '3') &&
                              <p>A geleria <strong>{notification.gallery_name}</strong> foi enviada para o&#40;a&#41; cliente <strong>{notification.client_name}</strong>.</p>
                           }
                           {(notification.code == '4') &&
                              <p><strong>{notification.client_name}</strong> perdeu o prazo para a seleção de fotos da galeria <strong>{notification.gallery_name}</strong>.</p>
                           }

                           {/** Notification date */}
                           <p className='text-xs opacity-70 text-end'>
                              {new Date(notification.created_at)
                                 .toLocaleDateString('pt-br',
                                    { day: '2-digit', month: 'long', year: 'numeric', hour: 'numeric', minute: '2-digit' }
                                 )
                              }
                              <span> h</span>
                           </p>
                           {!notification.read_at &&
                              <div className="text-end -mt-2">
                                 <button
                                    className="text-xs underline justify-self-end w-fit cursor-pointer"
                                    onClick={() => handleMarkAsRead(notification.id)}
                                 >
                                    Marcar como lida
                                 </button>
                              </div>
                           }
                        </div>

                     </div>
                  )
               })
               : <p className='text-center my-3'>Você não novas notificações.</p>
            }
         </div>
         {/** Notification bottom blur gradient  */}
         {notifications?.length > 7 &&
            <div className="absolute z-10 -bottom-2 left-0 w-80 h-10 bg-[linear-gradient(0deg,var(--background)_0%,var(--background)_18%,rgba(237,221,83,0)_100%)] pointer-events-none" >
            </div>
         }
      </section>
   )
}