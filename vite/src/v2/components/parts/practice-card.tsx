import {cn} from '@/v2/lib/utils'
import {forwardRef, HTMLAttributes} from 'react'

type Props = HTMLAttributes<HTMLDivElement>

const PracticeCard = forwardRef<HTMLDivElement, Props>((props, ref) => {
    const {
        children,
        className,
        ...rest
    } = props
    return (
        <div
            className={cn(
                'bg-base-200 rounded-md',
                'border-2 border-neutral-300',
                className,
            )}
            ref={ref}
            {...rest}
        >
            <section
                className={cn(
                    'w-full h-[320px] text-lg',
                    'flex justify-center items-center',
                )}
            >
                {children}
            </section>
        </div>
    )
})
PracticeCard.displayName = 'PracticeCard'

export default PracticeCard
