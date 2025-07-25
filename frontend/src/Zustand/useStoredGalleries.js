

import { create } from "zustand";

export const useStoredGalleries = create(set => ({
   storeGalleries: false,
   filters: { status: 'all', order: 'default', searchChars: '' },

   setStoreGalleries: (serverGalleries) => set(state => {
      if(state.storeGalleries) return {};
      return{
         storeGalleries: [...serverGalleries]
      }
   }),

   setFilter: ( serverGalleries, newFiltres ) => set(state => {
      const { filters, sort, utils } = state;

      const updatedFilters = {...filters, ...newFiltres};
      const { status, order, searchChars } = updatedFilters;

      const filteredByStatus = serverGalleries.filter(gallery => 
         status === 'all' ? true : gallery.status === status
      )
      const sorted = sort[order](filteredByStatus);

      const filteredBySerach = sorted.filter(gallery => 
         !searchChars ? true : utils.sanitizedString(gallery.galery_name).includes(utils.sanitizedString(searchChars))
      )

      return {
         filters: updatedFilters,
         storeGalleries: filteredBySerach
      }

   }),

   delteStoredGallery: (galleryID) => set( state => {
      const { storeGalleries } = state;

      const filtered = storeGalleries.filter(gallery => gallery.id !== galleryID);

      return {
         storeGalleries: filtered
      }
   }),

   updateGalleries: (updatedGalleries) => set(state => {
      const { filters, sort, utils } = state;
      const { status, order, searchChars } = filters;

      const filteredByStatus = updatedGalleries.filter(gallery => 
         status === 'all' ? true : gallery.status === status
      )
      const sorted = sort[order](filteredByStatus);

      const filteredBySerach = sorted.filter(gallery => 
         !searchChars ? true : utils.sanitizedString(gallery.galery_name).includes(utils.sanitizedString(searchChars))
      )

      return {
         storeGalleries: filteredBySerach
      }
   }),

   sort: {
      getFName: (string) => {
         return string.split(/[\W]/)[0].toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g, '');
      },
      getTime: (date) => {
         return new Date(date).getTime();
      },
      default: function (galleries) {
         return galleries.sort((prev, curr) => {
            if (this.getTime(prev.created_at) < this.getTime(curr.created_at)) return 1;
            if (this.getTime(prev.created_at) > this.getTime(curr.created_at)) return -1;
            return 0;
         });
      },
      asc: function (galleries) {
         return galleries.sort((prev, curr) => this.getFName(prev.galery_name).localeCompare(this.getFName(curr.galery_name)));
      },
      desc: function (galleries) {
         return galleries.sort((prev, curr) => this.getFName(curr.galery_name).localeCompare(this.getFName(prev.galery_name)));
      },
      expire: function (galleries) {
         return galleries.sort((prev, curr) => {
            if (this.getTime(prev.deadline) < this.getTime(curr.deadline)) return 1;
            if (this.getTime(prev.deadline) > this.getTime(curr.deadline)) return -1;
            return 0;
         });
      }
   },

   utils: {
      sanitizedString: function(string){
         return string.toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g, '')
      }
   }
}))