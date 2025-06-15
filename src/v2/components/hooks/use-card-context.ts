import {CardContext} from '@/v2/lib/context'
import {useContext} from 'react'

const useCardContext = () => {
    return useContext(CardContext)
}

export default useCardContext
