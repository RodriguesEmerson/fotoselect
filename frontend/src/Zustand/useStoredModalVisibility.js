import { create } from "zustand";

export const useStoredModalVisibility = create(set => ({
   isNewGalleryModalVisible: false,
   isConfirmDecisionModalVisible: false,
   isAddClientInGalleryModal: false,
   setIsNewGalleryModalVisible: (visibility) => set(() => ({
      isNewGalleryModalVisible: visibility
   })),
   setIsConfirmDecisionModalVisible: (visibility) => set(() => ({
      isConfirmDecisionModalVisible: visibility
   })),
   setIsAddClientInGalleryModal: (visibility) => set(() => ({
      isAddClientInGalleryModal: visibility
   }))
}))