
export function PurpleSubmitButton({text, ...props}){
   return(
      <button 
         type="submit"
         className="h-10 w-full rounded-md text-white bg-[var(--button-secondary-color)] cursor-pointer hover:bg-[var(--button-primary-color)] transition-all"
         {...props}
      >{text}</button>
   )
}