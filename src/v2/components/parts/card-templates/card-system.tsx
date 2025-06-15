import CardBase from '@/v2/components/parts/card-templates/card-base'
import {CardTemplateProps} from './index'

export default function CardSystem(props: CardTemplateProps) {
    const {
        card: {
            question
        }
    } = props

    return (
        <CardBase>
            <div>
                <p className="text-xl">{question}</p>
            </div>
        </CardBase>
    )
}
