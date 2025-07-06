
import { Spinner } from "../Loaders/Spinner"
export function GreenButton({ text, type = 'submit', isLoading = false, ...props }) {
   return (
      <button
         type={type}
         className="h-10 w-full rounded-md text-white bg-[var(--button-third-color)] cursor-pointer hover:brightness-95 transition-all"
         {...props}
      >
         {!isLoading
         ? text
         : <Spinner size={8} />
         }
      </button>
   )
}