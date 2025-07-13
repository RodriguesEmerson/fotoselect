'use client';

import { useEffect, useState } from "react";
import { UserIcon } from "./UserIcon";
import { UserInfo } from "./UserInfo";
import { userInfoStore } from "@/Zustand/userInfoStore";
import { handleClientScriptLoad } from "next/script";

export function UserBox() {
   const [isOpen, setIsOpen] = useState(false);
   const user = userInfoStore(state => state.user);
   const setUserInfo = userInfoStore(state => state.setUserInfo);
   
   useEffect(() => {
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