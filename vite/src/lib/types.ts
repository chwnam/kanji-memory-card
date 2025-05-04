type Action<T = {}> = T & {
    action: string
    nonce: string
}

type Card = {
    id: number
    kanji: string
    hiragana: string
    korean: string
    levels: string[]
}

type Result = boolean | null

export type {
    Action,
    Card,
    Result,
}
