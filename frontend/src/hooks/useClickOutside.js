'use client';

export function useClickOutside(modalRef, setIsOpen) {
   
   function onClickOutside(e) {
      const target = e.target;
      if(!target instanceof Element) return;
      const isModal = target.closest('.modal');
      const isOpenModalButton = target.closest('.open-modal-button');
      
      if (modalRef?.current && !isModal) {

         document.removeEventListener('mousedown', onClickOutside);
         
         if(isOpenModalButton){
            const modalId = modalRef.current.getAttribute('modalref-id');
            const buttonId = isOpenModalButton.getAttribute('modalref-id');
            
            if(modalId == buttonId) return;
         }

         setIsOpen(); //set to false
      }
   }

   function setClickOutSide(){
      document.addEventListener('mousedown', onClickOutside);
   }
   
   return { setClickOutSide }
}

