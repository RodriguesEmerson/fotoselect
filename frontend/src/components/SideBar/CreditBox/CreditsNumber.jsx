'use client';

import { userStoredInfo } from "@/Zustand/userStoredInfo";

export function CreditsNumber(){
   const credits = userStoredInfo(state => state.credits);

   return(
      <span className="font-bold text-xl">{new Intl.NumberFormat().format(credits)}</span>
   )
}