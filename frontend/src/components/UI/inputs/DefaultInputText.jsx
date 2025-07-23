

export function DefaultInputText({ name, label, id, type = 'text', errorMessage, defaultValue = '', disabled = false, ...props }) {

   return (
      <div className="flex flex-col relative w-full">
         <label className="ml-1 text-sm w-fit" htmlFor={id}>{label}</label>
         <input 
            type={type} 
            name={name} 
            id={id} 
            className={`w-full h-8 pl-2 text-sm border bg-[var(--background)] light-autofill border-[var(--border-color)]  rounded-md placeholder:text-gray-400 focus-within:border-[var(--primary-color)] outline-none ${disabled && 'brightness-90'}`} autoComplete="on"
            defaultValue={defaultValue}
            disabled = {disabled}
            {...props} 
         />
         {errorMessage &&
            <span className="absolute -bottom-4 left-1 text-red-500 text-xs -mt-3">{errorMessage}</span>
         }
      </div>
   )
}