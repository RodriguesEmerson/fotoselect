'use client'
import ArrowDropDownIcon from '@mui/icons-material/ArrowDropDown'
import DoneIcon from '@mui/icons-material/Done'
import { useState } from 'react'

/**
 * Select – A custom dropdown select component with animated toggle and visual feedback.
 *
 * @component
 *
 * @param {Object} props - Component props.
 * @param {string[]} props.options - Array of string options to display in the dropdown.
 * @param {'small' | 'mid' | 'large' | 'full'} [props.width='mid'] - Width size of the component.
 * Can be:
 * - `'small'`: `min-w-16 w-16`
 * - `'mid'`: `min-w-48 w-48` (default)
 * - `'large'`: `min-w-62 w-62`
 * - `'full'`: `w-full`
 *
 * @example
 * <Select options={['Option 1', 'Option 2', 'Option 3']} width="large" />
 */
export function Select({ options, width = 'mid' }) {
   const [isOpen, setIsOpen] = useState(false)
   const [currentt, setCurrent] = useState(options[0])

   const sizes = {
      small: 'min-w-16 w-16',
      mid: 'min-w-48 w-48',
      large: 'min-w-62 w-62',
      full: 'w-full',
   }

   return (
      <div
         className={`relative flex items-center justify-between h-10 border pl-2 text-sm text-[var(--text-secondary-color)] border-[var(--border-color)] rounded-md cursor-pointer min-w-16 ${sizes[width]} ${isOpen && 'border-[var(--primary-color)]'}`}
         onClick={() => setIsOpen(!isOpen)}
      >
         <p>{currentt}</p>
         <ArrowDropDownIcon />
         <ul
            className={`modal absolute flex flex-col z-10 scale-0 origin-top-right right-0 top-10 p-2 px-3 overflow-hidden bg-[var(--background)] text-sm shadow-[0_0_25px_5px_var(--shadow)] rounded-xl border border-[var(--border-color)] transition-all ${isOpen && 'scale-100'} ${sizes[width]}`}
         >
            {options.map((option) => (
               <li
                  key={option}
                  className={`flex items-center justify-between h-7 hover:text-[var(--primary-color)] ${option === currentt && 'text-[var(--primary-color)]'
                     }`}
                  onClick={() => setCurrent(option)}
               >
                  <span>{option}</span>
                  {option === currentt && <DoneIcon className="!text-base" />}
               </li>
            ))}
         </ul>
      </div>
   )
}
