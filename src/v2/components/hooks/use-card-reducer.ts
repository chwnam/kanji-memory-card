import {Action, reducer} from '@/v2/lib/reducer'
import {State} from '@/v2/lib/types'
import {useReducer} from 'react'

const useCardReducer = (initialState: State) => {
    return useReducer<State, [action: Action]>(reducer, initialState)
}

export default useCardReducer
