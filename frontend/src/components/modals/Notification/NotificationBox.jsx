'use client';
import { useEffect, useState } from 'react';
import { NotificationIcon } from './NotificationIcon';
import { Notifications } from './Notifications';

export function NotificationBox({ notifications }) {
   const [isOpen, setIsOpen] = useState(false);

   return (
      <>
         <NotificationIcon 
            notifications={notifications} 
            onClick={() => {
               setIsOpen(!isOpen)
            }} 
         />
         <Notifications isOpen={isOpen} setIsOpen={setIsOpen} notifications={notifications} />
      </>
   )
}