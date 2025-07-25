'use client';
/**
 * TransparentInRedButton – A styled button using Tailwind CSS and CSS variables for custom colors.
 *
 * @component
 *
 * @param {Object} props - Component props.
 * @param {'small' | 'mid' | 'large' | 'full' | 'fit'} [props.width='mid'] - Defines the button's width.
 * Can be:
 * - `'small'`: `min-w-16 w-16`
 * - `'mid'`: `min-w-48 w-48` (default)
 * - `'large'`: `min-w-62 w-62`
 * - `'full'`: `w-full`
 * - `'fit'`: `w-fit`
 * @param {React.ButtonHTMLAttributes<HTMLButtonElement>} [props.props] - Additional native button attributes.
 *
 * @example
 * <PurpleButton width="large" onClick={() => console.log('Clicked')} />
 */
export function TransparentInPurpleButton({ size = 'mid', children, ...props }) {
   const sizes = {
      small: 'min-w-20 w-20',
      mid: 'min-w-48 w-48',
      large: 'min-w-62 w-62',
      full: 'w-full',
      fit: 'w-fit'
   }

   return (
      <button
         type="button"
         className={`flex items-center justify-center gap-2 h-10 px-4 rounded-md text-[var(--primary-color)] bg-[var(--background)] border border-[var(--primary-color)] cursor-pointer hover:bg-purple-50 transition-all ${sizes[size]} `}
         {...props}
      >
         {children}
      </button>
   )
}
