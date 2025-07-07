import { GreenButton } from "../UI/buttons/GreenButton";
import { GreenLinkButton } from "../UI/links/GreenLinkButton";

export function CreditsBox(){
   const credits = 1000;
   return(
      <section className="flex flex-col gap-1 items-center mt-5 bg-[var(--background)] brightness-90 h-fit w-50 p-2 py-3 rounded-md">
         <p className="text-sm">Créditos diponíveis</p>
         <span className="font-bold text-xl">{new Intl.NumberFormat().format(credits)}</span>
         <GreenLinkButton href={'/credits'} text={'Comprar Créditos'} />
      </section>
   )
}