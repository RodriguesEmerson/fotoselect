import CloudSyncIcon from '@mui/icons-material/CloudSync';
import { memo } from 'react';
export const FileInput = memo(({ register, registerName, id, preview, errorMessage, message = '', format = 'rectangle' }) => {
   const imgBoxFormat = {
      rectangle: {box: 'w-80 h-48', me: 'w-80'},
      square: {box: 'w-48 h-48', me: 'w-48'},
      full: {box:'w-full h-full', me: 'w-full'}
   }

   return (
      <div className="">
         <label htmlFor={id}
            className={`flex flex-col items-center justify-center border-2 border-[var(--border-color)] border-dashed rounded-lg cursor-pointer bg-[var(--background)] brightness-96 hover:brightness-93 transition-all overflow-hidden ${imgBoxFormat[format].box}`}>
            {!preview
               ? <div className="flex flex-col items-center justify-center pt-5 pb-6 opacity-80">
                  <svg className="w-8 h-8 mb-4  text-[var(--text-main-color)]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                     <path stroke="currentColor" strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                  </svg>
                  <p className="mb-2 text-sm text-[var(--text-main-color)]">
                     <span className="font-semibold">Selecionar</span> {message}.
                  </p>
                  <p className="text-xs text-[var(--text-main-color)]">PNG, JPG ou JPEG (MAX. 1MB)</p>
               </div>
               : <div
                  className={`w-full h-full`}
                  style={{
                     backgroundImage: `url(${preview.src})`,
                     backgroundSize: 'cover',
                     backgroundPosition: 'center',
                     backgroundRepeat: 'no-repeat'
                  }}
               >
                  <div className="flex flex-col text-xs items-center justify-center w-ful h-full bg-[#00000080] text-white">
                     <CloudSyncIcon />
                     <p>Alterar imagem</p>
                  </div>
               </div>
            }
         </label>
         {errorMessage &&
            <p className={`text-xs text-red-700 text-center ${imgBoxFormat[format].me}`}>{errorMessage}</p>
         }
         <input
            type="file"
            {...register(registerName)}
            id={id}
            className="hidden"
            accept="image/jpg, image/jpeg, image/png"
         />
      </div >
   )
})