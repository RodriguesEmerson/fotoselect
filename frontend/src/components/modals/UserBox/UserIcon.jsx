import { Person } from "@mui/icons-material"

export function UserIcon({ user, onClick }) {
   return (
      <div
         modalref-id="user-box"
         className='open-modal-button relative flex items-center justify-center h-9 w-9 rounded-xl bg-[var(--background)] hover:brightness-95 transition-all'
         onClick={() => { user.name && onClick() }}
      >
         <div
            className={`flex items-center justify-center h-9 w-9 min-w-9 rounded-full cursor-pointer overflow-hidden bg-cyan-600 text-white ${!user.name && 'animate-pulse !bg-[var(--background)] brightness-70 !cursor-default'}`}
         >
            {!user.name 
               ? <Person color="disabled"/>
               : <UserImageProfile user={user} />
            }
         </div>
      </div>
   )
}

function UserImageProfile({ user }) {
   return (
      <>
         {user?.image
            ? <Image src={user.image} width={36} height={36} alt='client image' />
            : <span className='text-xl'>{user?.name.slice(0, 1)}</span>
         }
      </>
   )
}