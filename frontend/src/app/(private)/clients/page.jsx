import { ClientsHeader } from "@/components/Clients/InPage/ClientsHeader";
import { ClientList } from "@/components/Clients/InPage/ClientsList";
import { RegisterNewClientModal } from "@/components/modals/ClientModals/RegisterNewClientModal";

export default async function ClientsPage() {
   return (
      <>
         <div className="w-[90%] mx-auto">
            <RegisterNewClientModal />
            <ClientsHeader />
            <ClientList />
         </div>
      </>
   )
}