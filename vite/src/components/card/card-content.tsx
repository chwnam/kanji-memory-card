import {forwardRef, HTMLAttributes} from 'react'
import {cn} from '../../lib/utils.ts'

const CardContent = forwardRef<HTMLElement, HTMLAttributes<HTMLElement>>(
    ({className, children, ...props}, ref) => {
        return (
            <section
                className={cn(
                    'card-content',
                    'flex justify-center items-center h-[240px]',
                    className
                )}
                {...props}
                ref={ref}
            >
                {children}
            </section>
        )
    },
)
CardContent.displayName = 'CardContent'

export default CardContent
