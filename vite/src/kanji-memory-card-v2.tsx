import {StrictMode} from 'react'
import {createRoot} from 'react-dom/client'
import {CardContext, getCardContext} from './components/card-v2/context.ts'
import MemoryCardV2 from './components/memory-card-v2.tsx'
import './kanji-memory-card-v2.css'

createRoot(document.getElementById('kmc-memory-card')!)!.render(
    <StrictMode>
        <CardContext.Provider value={getCardContext()}>
            <MemoryCardV2 />
        </CardContext.Provider>
    </StrictMode>,
)
