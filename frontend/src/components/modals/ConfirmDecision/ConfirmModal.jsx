'use client'
import { useModalVisibility } from "@/Zustand/useModalVisibility";
import { ModalBackground } from "../ModalBackground";
import { useConfirmModal_ZUS } from "@/Zustand/useConfirmModal_ZUS";
import CloseIcon from '@mui/icons-material/Close';
import { PurpleButton } from "@/components/UI/buttons/PurpleButton";
import { TransparentInRedButton } from "@/components/UI/buttons/TransparentInRedButton";
import AnnouncementIcon from '@mui/icons-material/Announcement';

export function ConfirmModal() {
   const isConfirmDecisionModalVisible = useModalVisibility(state => state.isConfirmDecisionModalVisible);
   const setIsConfirmDecisionModalVisible = useModalVisibility(state => state.setIsConfirmDecisionModalVisible)
   const confirmModalData = useConfirmModal_ZUS(state => state.confirmModalData);
   const resetConfirmModalData = useConfirmModal_ZUS(state => state.resetConfirmModalData);
   if (!isConfirmDecisionModalVisible) return;

   function handleCloseModal(){
      setIsConfirmDecisionModalVisible(false);
      resetConfirmModalData();
   }

   return (
      <ModalBackground onMouseDown={() => handleCloseModal}>
         <section
            className="flex items-center flex-col gap-1 px-3 w-96 min-h-48 bg-[var(--background)] text-[var(--text-secondary-color)] text-sm shadow-[0_0_25px_5px_var(--shadow)] rounded-xl border border-[var(--border-color)] transition-all"
            onMouseDown={(e) => { e.stopPropagation() }}
         >
            <div className="flex flex-row w-full items-center justify-between border-b border-[var(--border-color)] py-2">
               <span className="block w-4 h-4 bg-[var(--secondary-color)] rounded-full"></span>
               <h2 className="text-center font-semibold text-base">Revisar Ação</h2>
               <CloseIcon
                  className="cursor-pointer"
                  onClick={() => handleCloseModal()}
               />
            </div>

            <div className="flex flex-1 items-center justify-center flex-col gap-5 py-2">
               <div>
                  <p className="text-base">
                     {confirmModalData?.text}
                     <span className="font-semibold">
                        {confirmModalData?.hltext}
                     </span>?
                  </p>
                  <div className="flex flex-row gap-3 items-start justify-center text-red-800">
                     <AnnouncementIcon className="!text-xl text-red-800"/>
                     <p className="text-sm">
                        {confirmModalData?.warnning
                           ? confirmModalData.warnning
                           : 'Esta ação não poderá ser desfeita!'
                        }
                     </p>
                  </div>
               </div>
               <div className="flex flex-row gap-2 w-full">
                  <TransparentInRedButton 
                     size="full"
                     onClick={() => confirmModalData?.action()}
                  >
                     <span>Confirmar</span>
                  </TransparentInRedButton>
                  <PurpleButton 
                     width="full"
                     onClick={() => handleCloseModal()}
                  >
                     <span>Cancelar</span>
                  </PurpleButton>
               </div>
            </div>

         </section>
      </ModalBackground>
   )
}