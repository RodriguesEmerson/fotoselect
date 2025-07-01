

export function DefaultInputText({ name, label, id, type = 'text', errorMessage, ...props }) {
   return (
      <div className="relative w-full">
         <label className="ml-1 text-sm" htmlFor={id}>{label}</label>
         <input type={type} name={name} id={id} {...props} className="w-full h-8 pl-2 text-sm border border-gray-300 rounded-md outline-gray-600" autoComplete="on"/>
         {errorMessage &&
            <span className="absolute -bottom-4 left-1 text-red-500 text-xs -mt-3">{errorMessage}</span>
         }
      </div>
   )
}