import {forwardRef, HTMLAttributes} from 'react'

type Props = HTMLAttributes<HTMLDivElement>

const Main = forwardRef<HTMLDivElement, Props>((props, ref) => {
    return (
        <main className="w-full grow" ref={ref}>
            <div className="container mx-auto max-w-[720px] mt-12 mb-8 px-4">
                {props.children}
            </div>
        </main>
    )
})
Main.displayName = 'Main'

export default Main
