import NotificationsIcon from '@mui/icons-material/Notifications';

export function NotificationIcon({notifications, onClick}) {
   return (
      <div
         modalref-id="notification-box"
         className='open-modal-button relative flex items-center justify-center h-9 w-9 rounded-xl bg-[var(--background)] border-2 border-[var(--border-color)] cursor-pointer hover:brightness-95 transition-all'
         onClick={() => { onClick() }}
      >
         {(notifications?.length > 0) &&
            <span className='absolute top-1 right-1 w-[10px] h-[10px] bg-red-800 leading-4 rounded-full'></span>
         }
         <NotificationsIcon />
      </div>
   )
}