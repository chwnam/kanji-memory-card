import CardDefault from './card-default'
import {CardTemplateProps} from './types'

const CardTemplate = (props: CardTemplateProps) => {
    const {template} = props

    switch (template) {
        case 'default':
        default:
            return <CardDefault {...props} />
    }
}

export default CardTemplate

export type {
    CardTemplateProps,
}
