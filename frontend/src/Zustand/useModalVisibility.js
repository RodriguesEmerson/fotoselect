import { create } from "zustand";

export const useModalVisibility = create(set => ({
   isNewGalleryModalVisible: false,
   setIsNewGalleryModalVisible: (visibility) => set(() => ({
      isNewGalleryModalVisible: visibility
   }))
}))