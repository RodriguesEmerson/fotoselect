
export function UserIcon({ user, onClick }) {
   return (
      <div
         modalref-id="user-box"
         className='open-modal-button relative flex items-center justify-center h-9 w-9 rounded-xl bg-[var(--background)] cursor-pointer hover:brightness-95 transition-all'
         onClick={() => { onClick() }}
      >
         <div
            className='flex items-center justify-center h-9 w-9 min-w-9 rounded-full overflow-hidden bg-cyan-600 text-white'
         >
            {user?.image
               ? <Image src={user.image} width={36} height={36} alt='client image' />
               : <span className='text-xl'>{user.name.slice(0, 1)}</span>
            }
         </div>
      </div>
   )
}