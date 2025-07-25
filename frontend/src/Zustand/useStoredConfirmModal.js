import { create } from "zustand";

export const useStoredConfirmModal = create(set => ({
   confirmModalData: {text: '', hltext: '', warnning: false, action: false},
   setConfirmModalData: (text, hltext, warnning,  action) => set(() => ({
      confirmModalData: {text: text, hltext: hltext, warnning: warnning, action: action}
   })),
   resetConfirmModalData: () => set(() => ({
      confirmModalData: {text: '', hltext: '', warnning: false, action: false}
   })),
   
}))