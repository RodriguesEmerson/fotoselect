

export function ModalBackground({ isOpen, setIsOpen, children}){
   console.log('aqui')
   return(
      <div 
         className={`z-10 fixed left-0 top-0 scale-0 origin-top-right h-[100vh] w-[100vw] bg-transparent ${isOpen && 'scale-100'}`}
         onMouseDown={() => setIsOpen(false)}
      >
         {children}
      </div>
   )
}