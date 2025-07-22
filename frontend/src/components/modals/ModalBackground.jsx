
export function ModalBackground({ children, onMouseDown }){
   return(
      <div 
         className={`fixed flex justify-center items-center z-10 left-0 top-0 h-[100vh] w-[100vw] bg-[#00000050]`}
         onMouseDown={onMouseDown()}
      >
         {children}
      </div>
   )
}