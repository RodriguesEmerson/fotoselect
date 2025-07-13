import { create } from 'zustand';

export const userInfoStore = create((set) => ({
   user: { name: false, lastname: false, email: false, image: false },
   credits: 0,
   setUserInfo: (data) => set({
      user: {
         name: data.name, 
         lastname: data.lastname,
         email: data.email, 
         image: data.profile_image || false
      },
      credits: data.credits
   }),
   decreaseCredits: () => set((state) => ({
      credits: state.credits - 1
   })),
   setCredits: (newCredits) => set((state) => ({
      credits: newCredits
   }))
}));