
import { RegisterForm } from "./registerForm";


export default function Register(){
   return(
      <main className="flex justify-center items-center h-[calc(100vh-4rem)] bg-gray-100">
        <section className="bg-white w-[25rem] h-[32rem] rounded-md shadow-gray-200 shadow-md p-4">
            <h2 className="text-center text-3xl font-bold text-[var(--text-main-color)]">Cadastre-se</h2>
            <RegisterForm />
        </section>
      </main>
   )
}