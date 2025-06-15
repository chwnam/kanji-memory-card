import CardBase from '@/v2/components/parts/card-templates/card-base'
import {CardTemplateProps} from './index'

export default function CardDefault(props: CardTemplateProps) {
    const {
        card,
        side,
    } = props

    return (
        <CardBase>
            {'question' == side ? (
                <div>
                    <p className="text-4xl">{card.question}</p>
                    {card.questionHint.length > 0 && (<p className="mt-2 text-md">{card.questionHint}</p>)}
                </div>
            ) : (
                <div>
                    <p className="text-4xl">{card.answer}</p>
                    {card.answerSupplement.length > 0 && (<p className="mt-2 text-md">{card.answerSupplement}</p>)}
                </div>
            )}
        </CardBase>
    )
}
