import { GreenLinkButton } from "../../UI/links/GreenLinkButton";
import { CreditsNumber } from "./CreditsNumber";

export async function CreditsBox() {
   return (
      <section className="flex flex-col gap-1 items-center mt-5 bg-[var(--background)] brightness-90 h-fit w-50 p-2 py-3 rounded-md">
         <p className="text-sm">Créditos diponíveis</p>
            <CreditsNumber />
         <GreenLinkButton href={'/credits'} text={'Comprar Créditos'} />
      </section>
   )
}