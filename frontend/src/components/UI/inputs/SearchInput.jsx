import SearchIcon from '@mui/icons-material/Search';

export function SearchInput({ width = 'xlarge', onChange }){

   const sizes = {
      small: 'min-w-16 w-16',
      mid: 'min-w-48 w-48',
      large: 'min-w-62 w-62',
      xlarge: 'min-w-80 w-80',
      full: 'w-full',
   }

   return(
      <div className='text-[var(--text-main-color)]'>
         <input 
            type="text" 
            className={`h-10 border pl-2 text-sm border-[var(--border-color)]  rounded-md placeholder:text-gray-400 focus-within:border-[var(--primary-color)] outline-none pr-7 ${sizes[width]} bg-[var(--background)]`}
            placeholder="Buscar"
            onChange={(e) => {onChange(e.target.value)}}
         />
         <SearchIcon 
            className='-ml-7 text-gray-400 pointer-events-none'
         />
      </div>
   )
}