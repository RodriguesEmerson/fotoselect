import { PurpleLinkButton } from "@/components/UI/links/PurpleLinkButton";
//  bg-[url('/images/homebackgroundimg.jpg')]
export default function Home() {
   return (
      <main className="">
         <section className="flex flex-row justify-center items-center min-h-[85vh] bg-center bg-cover bg-no-repeat text-white bg-[url('/images/homebackgroundimg.jpg')]">
            <div className="w-[80%] flex flex-row justify-around items-stretch">
               <div className="w-[50%] flex flex-col gap-8">
                  <h2 className="text-5xl font-bold">Seleção de fotos profissional, simples e segura.</h2>
                  <p>
                     Uma plataforma feita para fotógrafos que desejam organizar e compartilhar álbuns com seus clientes de forma segura, prática e elegante. Simplifique a seleção de fotos e valorize seu trabalho com uma experiência profissional do início ao fim
                  </p>
                  <PurpleLinkButton href={'/register'} text={'Cadastre-se'}/>
               </div>
               <div className=" w-[40%] h-[45vh] bg-cover rounded-md"></div>
            </div>
         </section>

      </main>
   );
}
