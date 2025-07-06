import Link from "next/link";

export function WhiteLinkButton({href, text}) {
   return (
      <Link
         href={href}
         className="text-[var(--button-secondary-color)] border border-[var(--button-secondary-color)] w-full h-10 text-center leading-10 rounded-md hover:bg-purple-50 transition-all"
      >
         {text}
      </Link>
   )
}