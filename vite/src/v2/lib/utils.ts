import {type State} from '@/v2/lib/types'
import {type ClassValue, clsx} from 'clsx'
import {twMerge} from 'tailwind-merge'

export function cn(...inputs: ClassValue[]) {
    return twMerge(clsx(inputs))
}

export function getDefaultState(override: Partial<State> = {}): State {
    if (!override.course && override.siteMeta && override.siteMeta.courses) {
        const keys = Object.keys(override.siteMeta.courses)
        if (keys.length > 0) {
            override.course = keys[0]
        }
    }

    return {
        allCards: [],
        course: '',
        judges: new Map(),
        siteMeta: {
            courses: {},
            pageTitle: '',
            ...override.siteMeta,
        },
        tier: -1,
        ...override,
    }
}
