
import { Spinner } from "./../Loaders/Spinner"
export function PurpleSubmitButton({text,  width = 'full', isLoading = false, ...props}){
   const sizes = {
      small: 'min-w-20 w-20',
      mid: 'min-w-48 w-48',
      large: 'min-w-62 w-62',
      full: 'w-full',
      fit: 'w-fit'
   }

   return(
      <button 
         type="submit"
         className={`h-10 rounded-md text-white bg-[var(--button-secondary-color)] cursor-pointer hover:bg-[var(--button-primary-color)] transition-all ${sizes[width]}`}
         {...props}
      >{!isLoading 
         ? text
         : <Spinner size={'mid'}/>
      }
        
      </button>
   )
}