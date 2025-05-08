import {cn} from '../lib/utils.ts'

export default function MemoryCardV2() {
    return (
        <>
            카드에 필요한 유저 인터페이스 목록
            <ul>
                <li>- 단어 정답 스위치 카드</li>
                <li>- 판정 UI</li>
                <li>- 레벨 선택 (N1~5)</li>
                <li>- 티어 선택 (1~5)</li>
                <li>- 단어 조작 UI</li>
                <li>- 현재 단어 테스트 과정</li>
                <li>- 내 티어별 공부 상황</li>
            </ul>

            <div className="w-full">
                <h1
                    className={cn(
                    )}
                >
                    한자 카드 V2
                </h1>
                <div
                    id="card--container"
                    className=""
                >
                    <section id="card--question-side">
                        Card question side
                    </section>
                    <section id="card--answer-side">
                        Card answer side
                    </section>
                </div>
            </div>
            <input type="checkbox" value="night" className="toggle theme-controller" />
        </>
    )
}
