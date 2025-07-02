
import { Spinner } from "./Loaders/Spinner"
export function PurpleSubmitButton({text, isLoading = false, ...props}){
   return(
      <button 
         type="submit"
         className="h-10 w-full rounded-md text-white bg-[var(--button-secondary-color)] cursor-pointer hover:bg-[var(--button-primary-color)] transition-all"
         {...props}
      >{!isLoading 
         ? text
         : <Spinner size={8}/>
      }
        
      </button>
   )
}