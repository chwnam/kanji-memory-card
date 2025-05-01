import {useCallback, useEffect, useState} from 'react'
import {Action, Card} from '../lib/types.ts'
import {cn} from '../lib/utils.ts'
import Answer from './card/answer.tsx'
import CardContent from './card/card-content.tsx'
import Question from './card/question.tsx'
import {Button} from './common/button.tsx'

export type Props = {
    ajaxUrl: string
    actions: {
        getCard: Action
    },
    initial: {
        cards: Card[]
    },
}

export default function MemoryCard(props: Props) {
    const {
        ajaxUrl,
        actions: {
            getCard: getCardAction,
        },
        initial: {
            cards: initialCards,
        },
    } = props

    const [flip, setFlip] = useState(false),
        [index, setIndex] = useState<number>(initialCards.length ? 0 : -1),
        [cards, setCards] = useState<Card[]>(initialCards || [])

    const fetchNext = useCallback(() => {
        return getCard(ajaxUrl, getCardAction)
    }, [cards, index])

    const isAvailable = useCallback(() => {
        return cards.length > 0 && -1 < index && index < cards.length
    }, [cards, index])

    useEffect(() => {
        if (!cards.length) {
            fetchNext().then((card) => {
                setCards([...cards, card])
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
                    <div className="card-buttons flex justify-between mx-28 max-[520px]:mx-12 max-[420px]:mx-4 max-[420px]:mx-4 mx-12 my-4">
                        <Button
                            disabled={index <= 0}
                            onClick={() => {
                                if (index > 0) {
                                    setIndex(index - 1)
                                }
                            }}
                        >
                            이전
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
                            onClick={async () => {
                                if (-1 < index && index < cards.length - 1) {
                                    setIndex(index + 1)
                                } else {
                                    fetchNext().then((card) => {
                                        setCards([...cards, card])
                                        setIndex(cards.length)
                                    })
                                }
                            }}
                        >
                            다음
                        </Button>
                    </div>
                </section>
            </div>
            {isAvailable() && (
                <div className="fluency-container mt-8 text-center">
                    <h5>이 단어를 맞추셨나요?</h5>
                    <div>
                        <span>아니오</span>
                        <span>예</span>
                    </div>
                </div>
            )}
        </div>
    )
}

async function getCard(ajaxUrl: string, action: Action): Promise<Card> {
    const params = new URLSearchParams()
    params.append('action', action.action)
    params.append('nonce', action.nonce)

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
