import { Checkbox } from "@mui/material";


export function CheckboxDefault({ register, registerName, label, checked = false, size = 'small', ...props }) {
   const sizes = {
      small: {checkboxSize: 'small', labelSize: 'text-sm'},
      mid: {checkboxSize: 'medium', labelSize: 'text-base'},
      large: {checkboxSize: 'large', labelSize: 'text-xl'},
   }
   return (
      <div className={`flex items-center w-fit h-fit pr-1 `}>
         <Checkbox 
            size={sizes[size].checkboxSize} 
            {...register(registerName)} 
            sx={{ color: '#450172', '&.Mui-checked': { color: '#450172' } }} 
            id={registerName}
            defaultChecked={checked}
         />
         <label htmlFor={registerName} className={`${sizes[size].labelSize}  text-[var(--text-main-color)] -ml-1 mt-1`}>
            {label}
         </label>
      </div>
   )
}