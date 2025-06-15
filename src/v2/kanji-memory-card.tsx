import Api from '@/v2/api'
import useCardReducer from '@/v2/components/hooks/use-card-reducer'
import MemoryCard from '@/v2/components/memory-card'
import {State} from '@/v2/lib/types'
import {getDefaultState} from '@/v2/lib/utils.ts'
import {QueryClient, QueryClientProvider} from '@tanstack/react-query'
import {StrictMode} from 'react'
import {createRoot} from 'react-dom/client'
import {CardContext} from './lib/context'

import './kanji-memory-card.css'

declare global {
    const kmcMemoryCardV2: {
        api: {
            baseUrl: string
            nonce: string
        }
        initial: State,
    }
}

const client = new QueryClient()

const {
    api,
    initial,
} = kmcMemoryCardV2

Api.initApi(api.baseUrl, api.nonce)

function App() {
    const [state, dispatch] = useCardReducer(getDefaultState(initial))

    return (
        <StrictMode>
            <QueryClientProvider client={client}>
                <CardContext.Provider value={{dispatch, state}}>
                    <MemoryCard />
                </CardContext.Provider>
            </QueryClientProvider>
        </StrictMode>
    )
}

createRoot(document.getElementById('kmc-card-root')!)!.render(<App />)
