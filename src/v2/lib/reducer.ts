import V1 from '@/v2/api/v1'
import {Card, State} from '@/v2/lib/types'
import CardJudge = V1.CardJudge

enum ActionType {
    ADD_CARD = 'addCard',
    SET_CARD_JUDGE = 'setCardJudge',
    SET_TIER = 'setTier',
    RESET_CARDS = 'resetCards',
}

type Action =
    | { type: ActionType.ADD_CARD, payload: Card }
    | { type: ActionType.SET_CARD_JUDGE, payload: CardJudge }
    | { type: ActionType.SET_TIER, payload: number }
    | { type: ActionType.RESET_CARDS, payload?: undefined }

function reducer(prevState: State, action: Action): State {
    const {payload, type} = action

    switch (type) {
        case ActionType.ADD_CARD:
            return {
                ...prevState,
                allCards: [...prevState.allCards, payload],
            }

        case ActionType.SET_CARD_JUDGE:
            return {
                ...prevState,
                judges: new Map([
                    ...prevState.judges,
                    [payload.card_id, payload.result],
                ]),
            }

        case ActionType.SET_TIER:
            return {
                ...prevState,
                tier: payload,
            }

        case ActionType.RESET_CARDS:
            return {
                ...prevState,
                allCards: [],
                judges: new Map(),
            }

        default:
            return prevState
    }
}

export type {
    Action,
}

export {
    ActionType,
    reducer,
}
