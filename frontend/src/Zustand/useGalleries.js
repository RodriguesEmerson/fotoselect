

import { create } from "zustand";

export const useGalleries = create(set => ({
   storeGalleries: false,
   filters: { status: 'all', order: 'expire', searchChars: '' },

   setStoreGalleries: (serverGalleries => set({
      storeGalleries: [...serverGalleries]
   })),

   setSortOrder: (serverGalleries, order) => set((state) => {
      const { status, searchChars } = state.filters;
      const { sort, utils } = state;

      const filteredByStatus = serverGalleries.filter(gallery => 
         status === 'all' ? true : gallery.status === status
      )
      const sorted = sort[order](filteredByStatus);

      const filteredBySerach = sorted.filter(gallery => 
         !searchChars ? true : utils.sanitizedString(gallery.galery_name).includes(utils.sanitizedString(searchChars))
      )

      return {
         filters: { ...state.filters, order: order },
         storeGalleries: filteredBySerach
      }
   }),

   setStatusFilter: (serverGalleries, status) => set((state) => {
      const { order, searchChars } = state.filters;
      const { sort, utils } = state;

      const filteredByStatus = serverGalleries.filter(gallery => 
         status === 'all' ? true : gallery.status === status
      )
      const sorted = sort[order](filteredByStatus);

      const filteredBySerach = sorted.filter(gallery => 
         !searchChars ? true : utils.sanitizedString(gallery.galery_name).includes(utils.sanitizedString(searchChars))
      )

      return{
         filters: { ...state.filters, status: status },
         storeGalleries: filteredBySerach
      }
   }),

   setSearchFilter: (serverGalleries, chars) => set(state => {
      const {status, order} = state.filters;
      const { sort, utils } = state;

      const filteredByStatus = serverGalleries.filter(gallery => 
         status === 'all' ? true : gallery.status === status
      )
      const sorted = sort[order](filteredByStatus);

      const filteredBySerach = sorted.filter(gallery => 
         !chars ? true : utils.sanitizedString(gallery.galery_name).includes(utils.sanitizedString(chars))
      )

      return {
         filters: { ...state.filters, searchChars: chars },
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