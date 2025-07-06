'use client';

import { useTheme } from "next-themes";
import { ThemeSwitch } from "../UI/ThemeSwitch";

export function SwitchThemeBox() {
   const { theme, setTheme } = useTheme();

   return (
      <button
         className="flex flex-row h-10 rounded-md p-2 bg-[var(--background)] text-[var(--text-main-color)] text-sm brightness-90 cursor-pointer"
         onClick={() => { setTheme(theme === 'light' ? 'dark' : 'light') }}
         >
         <div 
            className="flex flex-row gap-2 w-full items-center justify-between"
         >
            {theme === 'light'
               ? <p>Modo Claro</p>
               : <p>Modo Escuro</p>
            }
            <ThemeSwitch checked={theme !== 'light'}/>
         </div>

      </button>

   )
}