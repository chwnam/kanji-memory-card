import CardSystem from '@/v2/components/parts/card-templates/card-system'
import CardDefault from './card-default'
import {CardTemplateProps} from './types'

const CardTemplate = (props: CardTemplateProps) => {
    const {template} = props

    switch (template) {
        case 'default':
            return <CardDefault {...props} />

        case 'system':
            return <CardSystem {...props} />
    }
}

export default CardTemplate

export type {
    CardTemplateProps,
}
