import Link from "next/link";

export function PurpleLinkButton({ href, text, size = 'mid', children }) {

   const sizes = {
      small: 'min-w-42 w-42',
      mid: 'min-w-54 w-54',
      large: 'min-w-62 w-62',
      full: 'w-full',
      fit: 'w-fit'
   }
   return (
      <Link
         href={href}
         className={`flex flex-row  items-center justify-center gap-2 bg-[var(--button-secondary-color)] h-12 leading-12 rounded-md hover:bg-[var(--button-primary-color)] hover:outline transition-all text-white ${sizes[size]}`}
      >
         {children
            ? children
            : text
         }
      </Link>
   )
}