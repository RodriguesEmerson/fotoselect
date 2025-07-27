'use client'
import { PurpleButton } from "@/components/UI/buttons/PurpleButton";
import { TransparentInRedButton } from "@/components/UI/buttons/TransparentInRedButton";
import { useStoredConfirmModal } from "@/Zustand/useStoredConfirmModal";
import { useStoredModalVisibility } from "@/Zustand/useStoredModalVisibility";
import AnnouncementIcon from '@mui/icons-material/Announcement';
import CloseIcon from '@mui/icons-material/Close';
import { ModalBackground } from "../ModalBackground";

export function ConfirmModal() {
   const isConfirmDecisionModalVisible = useStoredModalVisibility(state => state.isConfirmDecisionModalVisible);
   const setIsConfirmDecisionModalVisible = useStoredModalVisibility(state => state.setIsConfirmDecisionModalVisible)
   const confirmModalData = useStoredConfirmModal(state => state.confirmModalData);
   const resetConfirmModalData = useStoredConfirmModal(state => state.resetConfirmModalData);
   if (!isConfirmDecisionModalVisible) return;

   function handleCloseModal(){
      setIsConfirmDecisionModalVisible(false);
      resetConfirmModalData();
   }

   return (
      <ModalBackground onMouseDown={() => handleCloseModal}>
         <section
            className="flex items-center flex-col gap-1 px-3 w-110 min-h-48 bg-[var(--background)] text-[var(--text-secondary-color)] text-sm shadow-[0_0_25px_5px_var(--shadow)] rounded-xl border border-[var(--border-color)] transition-all"
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
                  <p className="text-base text-center mb-2">
                     {confirmModalData?.text} <span className="font-semibold">{confirmModalData?.hltext}</span>?
                  </p>
                  <div className="flex flex-row gap-3 items-center justify-center text-red-900">
                     <AnnouncementIcon className="!text-xl text-red-900"/>
                     <p className="text-sm text-center">
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