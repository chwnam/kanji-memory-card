import {createRoot} from 'react-dom/client'
import MemoryCard, {type Props} from './components/memory-card.tsx'
import './kanji-memory-card.css'

// wp_localize_script 함수를 통해 전역변수로 전달되는 값의 타입 지정
declare global {
    let kmcMemoryCard: Props
}

createRoot(document.getElementById('kmc-memory-card')!)!.render(
    <MemoryCard {...kmcMemoryCard} />,
)
