import Api from '@/v2/api'
import useCardContext from '@/v2/components/hooks/use-card-context'
import CardTemplate from '@/v2/components/parts/card-templates'
import PracticeCard from '@/v2/components/parts/practice-card'
import {ActionType} from '@/v2/lib/reducer'
import {cn} from '@/v2/lib/utils'
import {useEffect, useRef, useState} from 'react'

export default function SectionPracticeCourse() {
    const {
        dispatch,
        state: {
            allCards,
            course,
            judges,
            tier,
        },
    } = useCardContext()

    // Ref
    const flipButtonRef = useRef<HTMLButtonElement>(null)

    // State
    const [cardCount, setCardCount] = useState(0)
    const [flip, setFlip] = useState(false)
    const [index, setIndex] = useState(-1)

    // Any callbacks
    const flipCard = () => setFlip(true)
    const unflipCard = () => setFlip(false)
    const getNextCard = () => {
        if (0 === course.toString().length || 1 > tier || 5 < tier) {
            return
        }
        Api.V1.getCard(course, tier).then((data) => {
            dispatch({
                type: ActionType.ADD_CARD,
                payload: data,
            })
        }).catch((message) => {
            alert(message)
        })
    }
    const judgeCard = (result: boolean): void => {
        if (-1 < index && index < allCards.length && 1 <= tier && tier <= 5) {
            const card = allCards[index]
            Api.V1.judgeCard(card.id, result)
                .then((data) => {
                    if (data.card_id == card.id && data.result === result) {
                        dispatch({
                            type: ActionType.SET_CARD_JUDGE,
                            payload: data,
                        })
                    }
                })
                .then(() => setCardCount(cardCount - 1))
        }
    }

    // Effects
    useEffect(() => {
        getNextCard()
        setIndex(index + 1)
    }, [course, judges])

    useEffect(() => {
        Api.V1.getNumCards(course, tier).then(({count}) => {
            setCardCount(count)
        }).then(() => {
            dispatch({
                type: ActionType.RESET_CARDS,
            })
        }).then(() => {
            getNextCard()
            setIndex(0)
        })
    }, [tier])

    if (tier < 1 || tier > 5) {
        return <PracticeCard>티어가 올바르게 선택되지 않았습니다.</PracticeCard>
    }

    if (index < 0 || index > allCards.length - 1) {
        return <PracticeCard>카드가 선택되지 않았습니다.</PracticeCard>
    }

    const theCard = allCards[index]

    return (
        <>
            <div
                className={cn(
                    'flex justify-between items-center',
                    'px-1 py-1',
                    'text-sm',
                )}
            >
                <div className={''}>
                    <span>{index + 1}/{allCards.length}</span>
                    <span className="ms-3">#{theCard.id}</span>
                </div>
                <div>{tier} 티어, 잔여 카드 {cardCount}</div>
            </div>

            {/* Card */}
            <CardTemplate
                card={theCard}
                side={flip ? 'answer' : 'question'}
                template={'default'}
            />

            {/* Below-card area */}
            <div className="mt-6">
                {/* Card control */}
                <div
                    className={cn(
                        'flex justify-around',
                        'lg:px-36 md:px-18 sm:px-6 px-3',
                    )}
                    onMouseOutCapture={unflipCard}
                    onTouchMoveCapture={(e) => (e.target as HTMLElement).contains(flipButtonRef.current!) || unflipCard()}
                >
                    <button
                        className="btn btn-neutral rounded-md"
                        disabled={0 === index}
                        onClick={() => {
                            if (allCards.length && 0 < index) {
                                setIndex(index - 1)
                            }
                        }}
                    >
                        &laquo; 이전 단어
                    </button>
                    <button
                        className="btn btn-neutral rounded-md"
                        onMouseDown={flipCard}
                        onMouseUp={unflipCard}
                        onTouchStart={flipCard}
                        onTouchEnd={unflipCard}
                        ref={flipButtonRef}
                    >
                        정답 토글
                    </button>
                    <button
                        className="btn btn-neutral rounded-md"
                        disabled={index >= allCards.length - 1}
                        onClick={() => {
                            if (allCards.length && index < allCards.length - 1) {
                                setIndex(index + 1)
                            }
                        }}
                    >
                        다음 단어 &raquo;
                    </button>
                </div>

                <div className="divider mt-8 mb-2 select-none">답안 처리</div>
                <div className="text-center">
                    <p className="text-sm italic select-none">
                        이 단어를 맞추셨나요? 딱 한번만 입력 가능해요!
                    </p>
                    <div className="mt-4 flex justify-center gap-x-2">
                        <button
                            className="btn w-1/2 btn-soft rounded-md"
                            disabled={index !== allCards.length - 1 && cardCount > 0}
                            onClick={() => {judgeCard(false)}}
                        >
                            아니오
                        </button>
                        <button
                            className="btn w-1/2 btn-soft rounded-md"
                            disabled={index !== allCards.length - 1 && cardCount > 0}
                            onClick={() => {judgeCard(true)}}
                        >
                            네
                        </button>
                    </div>
                </div>
            </div>
            <div className="divider" />
            <div className="collapse collapse-arrow bg-base-200 rounded-sm">
                <input type="checkbox" />
                <div className="collapse-title font-semibold">
                    학습한 카드
                </div>
                <div className="collapse-content">
                    <ol className="list-decimal list-inside">
                        {allCards.map((card) => {
                            const result = judges.get(card.id)
                            if (undefined === result) {
                                return null
                            }
                            return (
                                <li key={card.id}>
                                    <span className="inline-block me-2">{judges.get(card.id) ? '✅' : '🚫'}</span>
                                    <span className="inline-block min-w-16">{card.question}</span>
                                    <span className="inline-block">{card.answer}</span>
                                </li>
                            )
                        })}
                    </ol>
                </div>
            </div>
        </>
    )
}
