import { GreenButton } from "../UI/buttons/GreenButton";

export function CreditsBox(){
   const credits = 1000;
   return(
      <section className="flex flex-col gap-1 items-center mt-5 bg-[var(--credits-box-background)] brightness-95 h-fit w-50 p-2 py-3 rounded-md">
         <p className="text-sm">Créditos diponíveis</p>
         <span className="font-bold text-xl">{new Intl.NumberFormat().format(credits)}</span>
         <GreenButton text={'Comprar Créditos'} />
      </section>
   )
}