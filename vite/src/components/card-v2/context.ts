import {createContext, useContext} from 'react'

type Context = {}

function getCardContext(initial: Partial<Context> = {}): Context {
    return {
        ...initial,
    }
}

function useCardContext(): Context {
    return useContext<Context>(CardContext)
}

const CardContext = createContext<Context>(getCardContext())

export {
    CardContext,
    getCardContext,
    useCardContext,
}

export type {
    Context,
}
