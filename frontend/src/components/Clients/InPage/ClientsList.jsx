'use client';

import { ProfileLetterIcon } from "@/components/UI/ProfileLetterIcon";
import { useStoredClients } from "@/Zustand/useStoredClients";
import { ClientsInPageOptions } from "./ClientsInPageOptions";

export function ClientList() {
   const storedClients = useStoredClients(state => state.storedClients);
   const letters = Object.keys(storedClients);

   return (
      <div className="flex flex-col gap-7 w-full mt-7">
         {letters.map(letter => {
            return (
               <div key={`clients${letter}`} className="text-[var(--text-main-color)]">
                  <span className="ml-5 block text-center font-semibold text-white leading-7 h-7 w-10 rounded-t-md bg-[var(--primary-color)]">{letter.toUpperCase()}</span>
                  <ul className="flex flex-col w-full bg-[var(--background)] rounded-md p-2">
                     {storedClients[letter].map(client => (
                        <li
                           key={client.id}
                           className="flex flex-row justify-between items-center not-last:border-b border-[var(--border-color)] h-16 px-2"
                        >
                           <div className="flex flex-row gap-3">
                              <ProfileLetterIcon name={client.name} image={client.profile_image} />
                              <div className="flex flex-col">
                                 <p>{client.name}</p>
                                 <span className="text-xs opacity-70">{client.email}</span>
                              </div>
                           </div>

                           <ClientsInPageOptions client={client} isFetching={false} />
                        </li>
                     ))}
                  </ul>
               </div>
            )
         })}
      </div>
   )
}