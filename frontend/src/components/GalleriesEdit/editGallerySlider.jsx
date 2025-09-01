'use client';
import Image from "next/image";
import { EditGalleryForm } from "./editGalleryForm";
import { useState } from "react";
import { EditGallerySettings, GalleryUploadImages } from "./galleryUploadImages";


export function EditGallerySlider({ gallery }) {
   const [slide, setSlide] = useState(0);
   const slideProgressBarWidth = [`${slide * 80}px`];
   return (
      <>
         <div className="relative flex flex-row gap-10">
            <span className={`z-3 absolute top-3 block h-2 bg-gray-400 rounded-md transition-all w-20`}></span>
            <span 
               className={`z-5 absolute top-3 block h-2 bg-purple-900 rounded-md transition-all`}
               style={{width: `${slideProgressBarWidth}`}}
            ></span>
            <span
               className={`z-10 block h-8 w-8 rounded-full text-center leading-8 text-white font-semibold bg-gray-400 
               ${slide >= 0 && 'bg-purple-900'} cursor-pointer transition-all`}
               onClick={() => setSlide(0)}
            >1</span>
            <span
               className={`z-10 block h-8 w-8 rounded-full text-center leading-8 text-white font-semibold bg-gray-400 
               ${slide >= 1 && 'bg-purple-900'} cursor-pointer transition-all`}
               onClick={() => setSlide(1)}
            >2</span>
         </div>

         <div className="flex flex-row w-[200%] transition-all" style={{marginLeft: slide === 0 ? '0px' : '-100%'}}>
            <div className="flex flex-row justify-around w-[50%] p-2">
               <EditGalleryForm galleryData={gallery} />
               <Image src={'/edit-gallery.svg'} className="-scale-x-100 hidden 2xl:block" width={300} height={300} alt="edit gallery image" />
            </div>
            <div className="flex flex-col items-center gap-3 w-[50%] p-2">
               <GalleryUploadImages galleryData={gallery} />
            </div>
         </div>

      </>
   )
}