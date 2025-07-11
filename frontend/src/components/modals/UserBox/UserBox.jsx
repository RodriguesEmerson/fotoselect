'use client';

import { useEffect, useState } from "react";
import { UserIcon } from "./UserIcon";
import { UserInfo } from "./UserInfo";

export function UserBox({ user }) {
   const [isOpen, setIsOpen] = useState(false);

   return (
      <>
         <UserIcon 
            user={user} 
            onClick={() => {
               setIsOpen(!isOpen)
            }}  
         />
         <UserInfo user={user} isOpen={isOpen} setIsOpen={setIsOpen} />
      </>
   )
}