import {forwardRef, HTMLAttributes} from 'react'

type Props = HTMLAttributes<HTMLDivElement> & {
    title?: string
}

const NavBar = forwardRef<HTMLDivElement, Props>((props, ref) => {
    const {
        title,
    } = props

    return (
        <div
            className="navbar bg-base-100 shadow-sm"
            ref={ref}
        >
            <div className="flex-1">
                <a className="btn btn-ghost text-xl">
                    {title}
                </a>
            </div>
            <div className="flex-none">
                <ul className="menu menu-horizontal px-1">
                    <li><a>Link</a></li>
                    <li>
                        <details>
                            <summary>Parent</summary>
                            <ul className="bg-base-100 rounded-t-none p-2">
                                <li><a>Link 1</a></li>
                                <li><a>Link 2</a></li>
                            </ul>
                        </details>
                    </li>
                </ul>
            </div>
        </div>
    )
})
NavBar.displayName = 'NavBar'

export default NavBar
