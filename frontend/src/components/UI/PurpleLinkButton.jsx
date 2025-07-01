import Link from "next/link";

export function PurpleLinkButton({href, text}) {
   return (
      <Link
         href={href}
         className="bg-[var(--button-secondary-color)] w-54 h-12 text-center leading-12 rounded-md hover:bg-[var(--button-primary-color)] hover:outline transition-all text-white"
      >
         {text}
      </Link>
   )
}