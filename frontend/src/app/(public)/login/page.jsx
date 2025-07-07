
import { LoginForm } from "./loginForm";


export default function Login(){
   return(
      <main className="flex justify-center items-center h-[calc(100vh-4rem)] bg-gray-100">
        <section className="bg-white w-[25rem] h-fit rounded-md shadow-gray-200 shadow-md p-4">
            <h2 className="text-center text-3xl font-bold text-[#393939]">Login</h2>
            <LoginForm />
        </section>
      </main>
   )
}