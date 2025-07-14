'use client';
import { useEffect, useState } from 'react';
import { NotificationIcon } from './NotificationIcon';
import { Notifications } from './Notifications';
// import useSWR from 'swr';

export function NotificationBox() {
   const [isOpen, setIsOpen] = useState(false);
   const [notifications, setNotifications] = useState();

   //CRIAR FUNÇÃO PARA MARCAR NOTIFICAÇÃO COMO LIDA

   useEffect(() => {
      if(notifications) return;
      const fetchNotifications = async () => {
         await fetch('http://localhost/fotoselect/backend/user/notifications', 
            {
               method: 'GET',
               credentials: 'include',
               // cache: 'force-cache',
               // next:{
               //    revalidate: 10
               // }
            },
         )
         .then(async response => {
            response = await response.json();
            setNotifications(response.content.notifications);
         })
         .catch(error => {
            console.log(error)
         })
      }
      fetchNotifications();
   },[])

   return (
      <>
         <NotificationIcon 
            notifications={notifications} 
            onClick={() => {
               setIsOpen(!isOpen)
            }} 
         />
         <Notifications isOpen={isOpen} setIsOpen={setIsOpen} notifications={notifications} setNotifications={setNotifications} />
      </>
   )
}