import HomeIcon from '@mui/icons-material/Home';
import PersonIcon from '@mui/icons-material/Person';
import PhotoLibraryIcon from '@mui/icons-material/PhotoLibrary';
import SettingsApplicationsIcon from '@mui/icons-material/SettingsApplications';
import InvertColorsIcon from '@mui/icons-material/InvertColors';
import { SideBarLink } from "../UI/links/SideBarLink";
import { CreditsBox } from './CreditsBox';
import { LogoutButton } from '../UI/buttons/LogoutButton';
import { SwitchThemeBox } from './SwitchThemeBox';

export function SideBar() {

   const sideBarLinks = [
      { icon: 'home', link: '/dashboard', label: 'Início' },
      { icon: 'gallery', link: '/galleries', label: 'Galerias' },
      { icon: 'person', link: '/clients', label: 'Clientes' },
      { icon: 'settings', link: '/settings', label: 'Configurações' },
      { icon: 'personalization', link: '/personalization', label: 'Personalizações' },
   ]
   const iconMap = { 
      home: HomeIcon,
      gallery: PhotoLibraryIcon,
      person: PersonIcon,
      settings: SettingsApplicationsIcon,
      personalization: InvertColorsIcon
   }
   return (
      <aside className="relative  flex flex-col justify-between gap-3 w-54 min-w-54 h-full bg-[var(--background)] text-[var(--text-main-color)] shadow-[0_0_3_3px_var(--shadow)] rounded-xl p-2">
         <nav>
            <ul className='flex flex-col gap-2'>
               {sideBarLinks.map(link => {
                  const LinkIcon = iconMap[link.icon];
                  return(
                     <li key={link.label}>
                        <SideBarLink link={link.link}>
                           <div className='h-full content-center'>{LinkIcon && <LinkIcon />}</div>
                           <p className='h-full leading-11'>{link.label}</p>
                        </SideBarLink>
                     </li>
                  )
               })}
            </ul>
         </nav>
         <div className='flex flex-col gap-3 mb-2'>
            <CreditsBox />
            <hr className='w-54 -ml-2 border-[var(--background)] brightness-80'/>
            <LogoutButton />
            <SwitchThemeBox />
         </div>

      </aside>
   )
}