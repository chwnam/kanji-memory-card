import MemoryCardMockup from '@/v2/components/memory-card-mockup'
import {createRoot} from 'react-dom/client'
import './kanji-memory-card-mockup.css'

createRoot(document.getElementById('kmc-memory-card')!)!.render(
    <MemoryCardMockup />,
)
