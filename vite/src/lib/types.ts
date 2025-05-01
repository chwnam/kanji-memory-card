type Action<T = {}> = T & {
    action: string
    nonce: string
}

type Card = {
    id: number
    question: string
    kanji: string
    hiragana: string
    korean: string
}

export type {
    Action,
    Card,
}
