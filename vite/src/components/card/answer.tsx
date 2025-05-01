import {Card} from '../../lib/types.ts'

export type Props = {
    card: Card
}

export default function Answer(props: Props) {
    const {kanji, hiragana, korean} = props.card

    return (
        <div className="flex flex-row justify-center items-center text-3xl">
            <div className="text-center px-4 leading-10">
                <p className="border-b border-solid border-black">{kanji}</p>
                <p>{hiragana}</p>
            </div>
            <div className="text-center px-4">
                {korean}
            </div>
        </div>
    )
}
