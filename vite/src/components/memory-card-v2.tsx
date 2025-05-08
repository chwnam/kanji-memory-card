import {cn} from '../lib/utils.ts'

export default function MemoryCardV2() {
    return (
        <main className="w-full">
            <div id="card--wrapper">
                <h1
                    id="card--title"
                    className={cn(
                    )}
                >
                    한자 카드 V2
                </h1>
                <div
                    id="card--container"
                    className={cn(
                    )}
                >
                    <div
                        id="card--upper-indicator"
                        className={cn(
                        )}
                    >
                    </div>
                    <div id="card--sides">
                        <section id="card--question-side">
                            Card question side
                        </section>
                        <section id="card--answer-side">
                            Card answer side
                        </section>
                    </div>
                    <div
                        id="card--bottom-controls"
                    >
                        <div>
                            <button>이전 단어</button>
                            <button>정답</button>
                            <button>다음 단어</button>
                        </div>
                        <div>
                            <h3>이 단어를 맞추셨나요?</h3>
                            <div>
                                <button>
                                    아니오
                                </button>
                                <button>
                                    네
                                </button>
                            </div>
                            <p>
                                주의하세요! 한번만 입력 가능합니다.
                            </p>
                        </div>
                    </div>
                </div>
                {/* #card--container */}

                <div id="card--used">
                    <h2
                        className={cn(
                        )}
                    >
                        학습한 카드
                    </h2>
                    <ul>
                    </ul>
                    <div>
                        <button>연습 그만하기</button>
                    </div>
                </div>
                {/* #card-used */}
            </div>
            {/* #card--wrapper */}
        </main>
    )
}
