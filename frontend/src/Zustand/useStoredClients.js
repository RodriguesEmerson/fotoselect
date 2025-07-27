import { create } from "zustand";

export const useStoredClients = create(set => ({
   storedClients: false,

   setStoredClients: clients => set((state) => {
      const { utils } = state;
      const orndenedClients = utils.getOrdenedClients(clients);

      return {
         storedClients: orndenedClients
      }
   }),

   setClientsSearch: (chars, clients) => set(state => {
      const { utils } = state;
      const filteredBySearch = clients.filter(client =>
         utils.sanitizedString(client.name).includes(utils.sanitizedString(chars))
      )
      const orndenedClients = utils.getOrdenedClients(filteredBySearch);

      return {
         storedClients: orndenedClients
      }

   }),

   utils: {
      getOrdenedClients: function (clients) {
         const clientNameInitialLetter = (name) => this.sanitizedString(name).slice(0, 1);
         const sortedClients = clients.sort((prev, curr) =>
            this.sanitizedString(prev.name).localeCompare(this.sanitizedString(curr.name))
         );
         const orndenedClients = {};

         sortedClients.forEach(client => {
            if (!orndenedClients.hasOwnProperty(clientNameInitialLetter(client.name))) {
               orndenedClients[clientNameInitialLetter(client.name)] = []
            }
            orndenedClients[clientNameInitialLetter(client.name)].push(client);
         });

         return orndenedClients;
      },
      sanitizedString: (string) => {
         return string.split(/[\W]/)[0].toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g, '');
      }
   }
}))