import {useCallback, useEffect, useState} from 'react'
import {Action, Card, Result} from '../lib/types.ts'
import {cn} from '../lib/utils.ts'
import Answer from './card/answer.tsx'
import CardContent from './card/card-content.tsx'
import Question from './card/question.tsx'
import {Button} from './common/button.tsx'

export type Props = {
    ajaxUrl: string
    actions: {
        getCard: Action
        setQuizResult: Action
    },
    initial: {
        cards: Card[]
        results: Result[]
    },
}

export default function MemoryCard(props: Props) {
    const {
        ajaxUrl,
        actions: {
            getCard: getCardAction,
            setQuizResult: setQuizResultAction,
        },
        initial: {
            cards: initialCards,
        },
    } = props

    const [flip, setFlip] = useState(false),
        [index, setIndex] = useState<number>(initialCards.length ? 0 : -1),
        [cards, setCards] = useState<Card[]>(initialCards || []),
        [results, setResults] = useState<Result[]>([]),
        [isSubmit, setIsSubmit] = useState<boolean>(false)

    const fetchNext = useCallback(() => {
        return getCard(ajaxUrl, getCardAction, cards.map((card) => card.id))
    }, [cards, index])

    const isAvailable = useCallback(() => {
        return cards.length > 0 && -1 < index && index < cards.length
    }, [cards, index])

    const isMarkable = useCallback(() => {
        return index === (cards.length - 1) && null === results[index]
    }, [cards, results, index])

    const isResultsListable = useCallback(() => {
        return (1 === results.length && null !== results[0]) || results.length > 1
    }, [results])

    useEffect(() => {
        if (!cards.length) {
            fetchNext().then((card) => {
                setCards([...cards, card])
                setResults([...results, null])
                setIndex(0)
            })
        }
    }, [])

    return (
        <div className="memory-card-app">
            <div className="card-container border-2 border-black rounded-sm">
                <div
                    className={cn(
                        'card-top',
                        'leading-[22px] pb-1',
                        'flex justify-between items-center',
                        'border-b border-black',
                    )}
                >
                    <span className="ms-2 mt-1 text-[0.75em]">{index + 1}/{cards.length}</span>
                    {isAvailable() && (<span className="me-2 mt-1 text-[0.75em]">#{cards[index].id}</span>)}
                </div>
                {isAvailable() ? (
                    <>
                        <CardContent className={cn('card-question', flip && 'hidden')}>
                            <Question text={cards[index].question} />
                        </CardContent>
                        <CardContent className={cn('card-answer', flip || 'hidden')}>
                            <Answer card={cards[index]} />
                        </CardContent>
                    </>
                ) : (
                    <CardContent></CardContent>
                )}
                <section className="card-bottom border-t border-black">
                    <div className="card-buttons flex justify-between mx-28 max-[520px]:mx-12 max-[420px]:mx-4 my-4">
                        <Button
                            disabled={index <= 0}
                            onClick={() => {
                                if (index > 0) {
                                    setIndex(index - 1)
                                    setFlip(false)
                                }
                            }}
                        >
                            이전 보기
                        </Button>
                        <Button
                            onMouseDown={() => setFlip(true)}
                            onMouseUp={() => setFlip(false)}
                            onTouchStart={() => setFlip(true)}
                            onTouchEnd={() => setFlip(false)}
                        >
                            정답 토글
                        </Button>
                        <Button
                            disabled={isMarkable()}
                            onClick={async () => {
                                setFlip(false)
                                if (-1 < index && index < cards.length - 1) {
                                    setIndex(index + 1)
                                } else {
                                    fetchNext().then((card) => {
                                        setCards([...cards, card])
                                        setResults([...results, null])
                                        setIndex(cards.length)
                                    })
                                }
                            }}
                        >
                            다음 문제
                        </Button>
                    </div>
                    {isAvailable() && (
                        <div className="fluency-container w-full text-center px-4 py-3">
                            <h4 className="select-none">답안 처리</h4>
                            <p className="mt-1 text-xs select-none italic">
                                이 단어를 맞추셨나요? 딱 한번만 입력 가능해요!
                            </p>
                            <div
                                className={cn(
                                    'mt-3',
                                    'flex flex-nowrap justify-center gap-x-2',
                                )}
                            >
                                <Button
                                    className="w-1/2 fluency-button"
                                    disabled={!isMarkable() || isSubmit}
                                    onClick={(e) => {
                                        (e.target as HTMLButtonElement).blur()
                                        setIsSubmit(true)
                                        setQuizResult(ajaxUrl, setQuizResultAction, cards[index].id, false)
                                            .then(() => {
                                                setResults((prevState) => {
                                                    const nextState = [...prevState]
                                                    nextState[index] = false
                                                    return nextState
                                                })
                                                setIsSubmit(false)
                                            })
                                    }}
                                >
                                    아니오
                                </Button>
                                <Button
                                    className="w-1/2 fluency-button"
                                    disabled={!isMarkable() || isSubmit}
                                    onClick={(e) => {
                                        (e.target as HTMLButtonElement).blur()
                                        setIsSubmit(true)
                                        setQuizResult(ajaxUrl, setQuizResultAction, cards[index].id, true)
                                            .then(() => {
                                                setResults((prevState) => {
                                                    const nextState = [...prevState]
                                                    nextState[index] = true
                                                    return nextState
                                                })
                                                setIsSubmit(false)
                                            })
                                    }}
                                >
                                    예
                                </Button>
                            </div>
                        </div>
                    )}
                </section>
            </div>

            {isResultsListable() && (
                <section className="mt-4">
                    <div className="p-2">
                        <h3>이번 결과</h3>
                        <ol className="mt-3 list-decimal list-inside">
                            {cards.map((card, i) => {
                                const flu = results[i]
                                return (
                                    <li key={i} className="text-[0.8em]">
                                        <span className="">
                                            {null === flu ? '❓' : (flu ? '⭕' : '❌')}
                                        </span>
                                        <span className="ms-2">
                                            #{card.id} {card.question}
                                        </span>
                                    </li>
                                )
                            })}
                        </ol>
                        <p className="mt-2 text-sm select-none">
                            결과는 서버에 저장되어 다음 출제에 반영됩니다.
                        </p>
                    </div>
                </section>
            )}
        </div>
    )
}

async function getCard(ajaxUrl: string, action: Action, exclude: number[] = []): Promise<Card> {
    const params = new URLSearchParams()
    params.append('action', action.action)
    params.append('nonce', action.nonce)
    params.append('exclude', exclude.join(','))

    const r = await fetch(`${ajaxUrl}?${params}`, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
    })

    const response = await r.json()

    if (!response.success) {
        throw new Error(response)
    }

    return response.data
}

async function setQuizResult(ajaxUrl: string, action: Action, id: number, result: boolean) {
    const r = await fetch(ajaxUrl, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams({
            action: action.action,
            nonce: action.nonce,
            id: id.toString(),
            result: result.toString(),
        }),
    })

    const response = await r.json()

    if (!response.success) {
        throw new Error(response)
    }

    return response.data
}
