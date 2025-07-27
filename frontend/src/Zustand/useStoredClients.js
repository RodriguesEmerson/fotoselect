import { create } from "zustand";

export const useStoredClients = create(set => ({
   storedClients: false,
   setStoredClients: clients => set(() => {
      const sanitizedName = (string) => (string.split(/[\W]/)[0].toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g, ''));
      const clientNameInitialLetter = (name) => sanitizedName(name).slice(0, 1);
      const sortedClients = clients.sort((prev, curr) => sanitizedName(prev.name).localeCompare(sanitizedName(curr.name)));
      const orndenedClients = {};

      sortedClients.forEach(client => {
         if(!orndenedClients.hasOwnProperty(clientNameInitialLetter(client.name))){
            orndenedClients[clientNameInitialLetter(client.name)] = []
         }
         orndenedClients[clientNameInitialLetter(client.name)].push(client);
      });

      return{
         storedClients: orndenedClients
      }
   })
}))