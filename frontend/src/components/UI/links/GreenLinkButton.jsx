import Link from "next/link";

export function GreenLinkButton({href, text}) {
   return (
      <Link
         href={href}
         className="h-10 text-center leading-10 w-full rounded-md text-white bg-[var(--button-third-color)] cursor-pointer hover:brightness-95 transition-all"
      >
         {text}
      </Link>
   )
}