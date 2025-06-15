import {cn} from '@/v2/lib/utils'
import {forwardRef, HTMLAttributes} from 'react'

type Props = HTMLAttributes<HTMLDivElement>

const CardBase = forwardRef<HTMLDivElement, Props>((props, ref) => {
    const {children, className, ...rest} = props

    return (
        <div
            className={cn(
                'bg-base-200 rounded-md',
                'border-2 border-neutral-300',
            )}
            ref={ref}
        >
            <section
                className={cn(
                    'w-full h-[240px]',
                    'flex justify-center items-center',
                    className,
                )}
                {...rest}
            >
                {children}
            </section>
        </div>
    )
})

CardBase.displayName = 'CardBase'

export default CardBase
