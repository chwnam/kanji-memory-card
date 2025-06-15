const queryKeys = {
    default: ['kanji-memory-card', 'v2'] as const,
    getCards: (course: string, tier: number) => [...queryKeys.default, 'get-cards', course, tier] as const,
} as const

export default queryKeys
