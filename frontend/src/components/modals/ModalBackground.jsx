import { useModalVisibility } from "@/Zustand/useModalVisibility";


export function ModalBackground({ children }){
   const setIsNewGalleryModalVisible = useModalVisibility(state => state.setIsNewGalleryModalVisible);
   return(
      <div 
         className={`fixed flex justify-center items-center z-10 left-0 top-0 h-[100vh] w-[100vw] bg-[#00000050]`}
         onMouseDown={() => setIsNewGalleryModalVisible(false)}
      >
         {children}
      </div>
   )
}