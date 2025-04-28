import {baseUrl, nonce} from '@/v2/api/base'
import {Card, Course} from '@/v2/lib/types'

namespace V1 {
    export async function getCard(course: Course, tier: number, exclude: number[] = []) {
        const r = await fetch(`${baseUrl}/get-card`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Origin': location.origin,
                'X-WP-Nonce': nonce,
            },
            body: JSON.stringify({
                course,
                exclude,
                tier,
            }),
        })

        if (200 !== r.status) {
            throw await r.json() as Promise<string>
        }

        return await r.json() as Promise<Card>
    }

    export type NumCards = {
        count: number
        course: Course
        tier: number
    }

    export async function getNumCards(course: Course, tier: number) {
        const r = await fetch(`${baseUrl}/get-num-cards/${course}/${tier}`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'Origin': location.origin,
                'X-WP-Nonce': nonce,
            },
        })

        return await r.json() as Promise<NumCards>
    }

    export type CardJudge = {
        card_id: number
        result: boolean
        user_id: number
    }

    export async function judgeCard(id: number, result: boolean) {
        const r = await fetch(`${baseUrl}/judge-card`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Origin': location.origin,
                'X-WP-Nonce': nonce,
            },
            body: JSON.stringify({
                card_id: id,
                result: result,
            }),
        })

        return await r.json() as Promise<CardJudge>
    }
}

export default V1
