'use client';

import { userStoredInfo } from "@/Zustand/userStoredInfo";
import { useEffect, useState } from "react";
import { UserIcon } from "./UserIcon";
import { UserInfo } from "./UserInfo";

export function UserBox() {
   const [isOpen, setIsOpen] = useState(false);
   const user = userStoredInfo(state => state.user);
   const setUserInfo = userStoredInfo(state => state.setUserInfo);
   
   useEffect(() => {
      if(user.name) return;
      const handleGetUserData = async () => {
         await fetch('http://localhost/fotoselect/backend/user/fetch', 
            {
               method: 'GET',
               credentials: 'include'
            }
         )
         .then(async response => {
            response = await response.json();
            setUserInfo(response.content);
         })
         .catch(error => {
            console.log(error)
         })
      }
      handleGetUserData();
   },[])

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