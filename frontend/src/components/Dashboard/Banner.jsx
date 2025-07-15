import Image from "next/image";

export function Banner() {
   return (
      <div className="flex items-center justify-center mx-auto w-full min-h-36 h-36 overflow-hidden rounded-xl border border-[var(--border-color)]">
         <Image
            src={'/images/home-banner.png'} height={396} width={1584} alt="banner"
         />
      </div>
   )
}