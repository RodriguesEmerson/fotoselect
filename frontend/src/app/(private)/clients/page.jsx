import { ClientsHeader } from "@/components/Clients/InPage/ClientsHeader";
import { ClientList } from "@/components/Clients/InPage/ClientsList";
import { HandleClientModal } from "@/components/modals/ClientModals/HandleClientModal";

export default async function ClientsPage() {
   return (
      <>
         <div className="w-[90%] mx-auto">
            <HandleClientModal />
            <ClientsHeader />
            <ClientList />
         </div>
      </>
   )
}