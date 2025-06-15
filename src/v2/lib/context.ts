import {Action} from '@/v2/lib/reducer'
import {State} from '@/v2/lib/types'
import {getDefaultState} from '@/v2/lib/utils'
import {ActionDispatch, createContext} from 'react'

type CardContextType = {
    dispatch: ActionDispatch<[action: Action]>
    state: State
}

const CardContext = createContext<CardContextType>({
    dispatch: () => {},
    state: getDefaultState(),
})

export {
    CardContext,
}
