'use client';

import { useEffect } from "react";

export function useClickOutside(refComponent, onClickOutside){
   useEffect(() => {
      function handleClick(e){
         const target = e.target;
         const isModal = target instanceof Element && target.closest('.modal');
         if(refComponent?.current &&  !isModal){
            onClickOutside();
         }
      }

      document.addEventListener('mousedown', handleClick)
      return () => { document.removeEventListener('mousedown', handleClick)}

   }, [refComponent, onClickOutside]);
}