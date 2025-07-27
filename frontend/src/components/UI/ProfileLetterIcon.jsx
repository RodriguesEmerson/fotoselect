import Image from "next/image";

export function ProfileLetterIcon({ name, image }) {
   const letterColors = {
      a: '#FF6B6B', b: '#F06595', c: '#CC5DE8', d: '#845EF7', e: '#5C7CFA', f: '#339AF0', g: '#22B8CF', h: '#20C997', i: '#51CF66', j: '#94D82D', k: '#FCC419', l: '#FFD43B', m: '#FFA94D', n: '#FF922B', o: '#FF6B6B', p: '#F783AC', q: '#B197FC', r: '#748FFC', s: '#63E6BE', t: '#A9E34B', u: '#FAB005', v: '#E67700', w: '#D6336C', x: '#7048E8', y: '#3B5BDB', z: '#15AABF'
   };
   const sanitizedName = (string) => (string.split(/[\W]/)[0].toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g, ''));
   const clientNameInitialLetter = sanitizedName(name).slice(0, 1);
   return (
      <div
         className={`flex items-center justify-center h-9 w-9 min-w-9 rounded-full overflow-hidden text-white`}
         style={{ backgroundColor: letterColors[clientNameInitialLetter] }}
      >
         {image
            ? <Image src={image} width={36} height={36} alt='client image' className="h-full object-cover"/>
            : <span className='text-xl -mt-[0.10rem]'>{clientNameInitialLetter}</span>
         }
      </div>
   )
}