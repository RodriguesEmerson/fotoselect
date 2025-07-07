'use client';

import { useTheme } from "next-themes";
import { ThemeSwitch } from "../ThemeSwitch";
import { useEffect, useState } from "react";

export function SwitchThemeBox() {
   const { theme, setTheme } = useTheme();
   const [isLoaded, setIsLoaded] = useState(false);
   useEffect(() => {
      setIsLoaded(true)
   }, [])

   return (
      <button
         className="flex flex-row h-10 rounded-md p-2 bg-[var(--background)] text-[var(--text-main-color)] text-sm brightness-90 cursor-pointer"
         onClick={() => setTheme(theme === 'light' ? 'dark' : 'light')}
      >
         <div
            className={`flex flex-row gap-2 bg-[var(--background)] w-full items-center justify-between rounded-md ${!isLoaded && "brightness-90 animate-pulse"}`}
         >
            {isLoaded && 
               <>
                  {
                  theme === 'light'
                     ? <p>Modo Claro</p>
                     : <p>Modo Escuro</p>
                  }
                     <ThemeSwitch checked={theme !== 'light'} />
               </>
            }
          
         </div>

      </button>

   )
}