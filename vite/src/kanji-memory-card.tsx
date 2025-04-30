import {createRoot} from 'react-dom/client'

// wp_localize_script 함수를 통해 전역변수로 전달되는 값의 타입 지정
declare global {
    let kmcKanjiMemoryCard: {
        varName: string
    }
}

createRoot(document.getElementById('kmc-memory-card')!)!.render(
    <p>{kmcKanjiMemoryCard.varName} 동작 중!</p>
)
