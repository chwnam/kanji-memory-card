import {createRoot} from 'react-dom/client'
import MemoryCardV2 from './components/memory-card-v2.tsx'
import './kanji-memory-card-v2.css'

createRoot(document.getElementById('kmc-memory-card')!)!.render(
    <MemoryCardV2 />,
)
