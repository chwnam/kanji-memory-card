import {cn} from '@/v2/lib/utils'
import {forwardRef, HTMLAttributes, InputHTMLAttributes} from 'react'

const TabList = forwardRef<HTMLDivElement, HTMLAttributes<HTMLDivElement>>((props, ref) => {
    const {children, className, role, ...rest} = props

    return (
        <div
            className={cn('tabs tabs-border', className)}
            role={cn('tablist', role)}
            ref={ref}
            {...rest}
        >
            {children}
        </div>
    )
})
TabList.displayName = 'TabList'

type TabProps = InputHTMLAttributes<HTMLInputElement> & {
    label: string
}

const Tab = forwardRef<HTMLInputElement, TabProps>((props, ref) => {
    const {
        label,
        children,
        className,
        type, // discard type whatever it says
        ...rest
    } = props
    return (
        <>
            <input
                aria-label={label}
                className={'tab'}
                type="radio"
                ref={ref}
                {...rest}
            />
            {!!children && (
                <div className={cn('tab-content', className)}>{children}</div>
            )}
        </>
    )
})

Tab.displayName = 'Tab'

export {
    Tab,
    TabList,
}
