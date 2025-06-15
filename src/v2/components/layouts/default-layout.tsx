import Main from '@/v2/components/layouts/main'
import NavBar from '@/v2/components/layouts/nav-bar'
import {PropsWithChildren} from 'react'

type Props = PropsWithChildren<{
    title?: string
}>

const DefaultLayout = (props: Props) => {
    const {
        children,
        title,
    } = props

    return (
        <div className="w-lvw h-lvh flex flex-col">
            <header>
                <NavBar title={title} />
            </header>
            <Main>
                {children}
            </Main>
            {/* maybe footer */}
        </div>
    )
}

export default DefaultLayout
