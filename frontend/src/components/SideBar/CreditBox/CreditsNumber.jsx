'use client';

import { userInfoStore } from "@/Zustand/userInfoStore";

export function CreditsNumber(){
   const credits = userInfoStore(state => state.credits);

   return(
      <span className="font-bold text-xl">{new Intl.NumberFormat().format(credits)}</span>
   )
}