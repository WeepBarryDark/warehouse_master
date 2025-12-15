import { cva, type VariantProps } from 'class-variance-authority'

export { default as Button } from './Button.vue'

export const buttonVariants = cva(
  'inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-lg text-sm font-medium transition-all duration-300 disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg:not([class*=\'size-\'])]:size-4 shrink-0 [&_svg]:shrink-0 outline-none focus-visible:border-blue-500 focus-visible:ring-blue-500/50 focus-visible:ring-[3px] aria-invalid:ring-destructive/20 dark:aria-invalid:ring-destructive/40 aria-invalid:border-destructive relative overflow-hidden',
  {
    variants: {
      variant: {
        default:
          'bg-gradient-to-r from-green-600 via-green-600 to-green-500 text-white shadow-lg hover:shadow-xl hover:from-green-700 hover:via-green-700 hover:to-green-600 hover:scale-[1.02] active:scale-[0.98] border border-green-500/30 hover:border-green-600/50',
        destructive:
          'bg-gradient-to-r from-red-500 via-red-600 to-red-500 text-white shadow-lg hover:shadow-xl hover:from-red-600 hover:via-red-700 hover:to-red-600 hover:scale-[1.02] active:scale-[0.98] border border-red-500/30 hover:border-red-600/50',
        outline:
          'border-2 border-green-300 bg-gradient-to-r from-green-50 via-green-50 to-green-50 text-green-700 shadow-md hover:shadow-lg hover:bg-gradient-to-r hover:from-green-600 hover:via-green-600 hover:to-green-500 hover:border-green-600 hover:text-white hover:scale-[1.02] active:scale-[0.98] dark:from-green-800/50 dark:via-green-800/50 dark:to-green-800/50 dark:text-green-100 dark:border-green-600 dark:hover:from-green-600 dark:hover:via-green-600 dark:hover:to-green-500',
        secondary:
          'bg-gradient-to-r from-green-500 via-green-600 to-green-500 text-white shadow-lg hover:shadow-xl hover:from-green-600 hover:via-green-700 hover:to-green-600 hover:scale-[1.02] active:scale-[0.98] border border-green-400/30 hover:border-green-500/50',
        ghost:
          'bg-gradient-to-r from-green-100/80 via-green-50/80 to-green-100/80 text-green-700 hover:shadow-lg hover:bg-gradient-to-r hover:from-green-600 hover:via-green-600 hover:to-green-500 hover:text-white hover:scale-[1.02] active:scale-[0.98] dark:from-green-800/30 dark:via-green-800/30 dark:to-green-800/30 dark:text-green-100 dark:hover:from-green-600 dark:hover:via-green-600 dark:hover:to-green-500',
        professional:
          'bg-gradient-to-r from-green-200 via-green-100 to-green-200 text-green-800 border border-green-300 shadow-md hover:shadow-lg hover:from-green-600 hover:via-green-500 hover:to-green-600 hover:text-white hover:border-green-500 hover:scale-[1.02] active:scale-[0.98] dark:from-green-700 dark:via-green-600 dark:to-green-700 dark:text-green-100 dark:border-green-500 dark:hover:from-green-600 dark:hover:via-green-500 dark:hover:to-green-600 dark:hover:text-white',
        link: 'text-green-600 underline-offset-4 hover:underline hover:text-green-700 transition-colors duration-200 dark:text-green-400 dark:hover:text-green-300',
      },
      size: {
        default: 'h-10 px-5 py-2.5 has-[>svg]:px-4 font-medium',
        sm: 'h-8 rounded-lg gap-1.5 px-3 has-[>svg]:px-2.5 text-xs font-medium',
        lg: 'h-12 rounded-lg px-8 has-[>svg]:px-6 text-base font-semibold',
        icon: 'size-10 rounded-lg',
      },
    },
    defaultVariants: {
      variant: 'default',
      size: 'default',
    },
  },
)

export type ButtonVariants = VariantProps<typeof buttonVariants>
