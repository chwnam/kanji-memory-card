import {ButtonHTMLAttributes, DetailedHTMLProps, forwardRef} from 'react'
import {cn} from '../../lib/utils.ts'
import './button.css'

const Button = forwardRef<HTMLButtonElement, DetailedHTMLProps<ButtonHTMLAttributes<HTMLButtonElement>, HTMLButtonElement>>(
    ({className, children, ...props}, ref) => {
        return (
            <button className={cn('button', className)} {...props} ref={ref}>
                {children}
            </button>
        )
    },
)
Button.displayName = 'Button'

export {
    Button,
}
