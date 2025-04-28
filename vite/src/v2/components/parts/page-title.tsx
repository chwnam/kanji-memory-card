import {cn} from '@/v2/lib/utils'
import {forwardRef, HTMLAttributes} from 'react'

const PageTitle = forwardRef<HTMLHeadingElement, HTMLAttributes<HTMLHeadingElement>>((props, ref) => {
    const {
        children,
        className,
        ...rest
    } = props
    return (
        <h1
            className={cn(
                'mb-4 text-3xl select-none',
                className,
            )}
            ref={ref}
            {...rest}
        >
            {children}
        </h1>
    )
})

PageTitle.displayName = 'PageTitle'

export default PageTitle
