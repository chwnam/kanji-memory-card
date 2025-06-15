import useCardContext from '@/v2/components/hooks/use-card-context'
import {ActionType} from '@/v2/lib/reducer'
import {useRef} from 'react'

export default function TierSelector() {
    const {
        dispatch,
        state: {
            tier,
        },
    } = useCardContext()

    const selectRef = useRef<HTMLSelectElement>(null)

    return (
        <div className="mb-3">
            <label className="ms-2 select select-sm w-fit rounded-md">
                <span className="label">티어</span>
                <select
                    className=""
                    defaultValue={tier}
                    ref={selectRef}
                >
                    <option value={-1} disabled={true}>티어 선택</option>
                    <option value={1}>1티어</option>
                    <option value={2}>2티어</option>
                    <option value={3}>3티어</option>
                    <option value={4}>4티어</option>
                    <option value={5}>5티어</option>
                </select>
            </label>
            <button
                className="ms-2 btn btn-sm btn-neutral rounded-md"
                onClick={() => {
                    if (selectRef.current && confirm('티어를 변경하면 현재 화면에 보이는 카드 목록이 초기화됩니다. 괜찮으십니까?')) {
                        dispatch({
                            type: ActionType.SET_TIER,
                            payload: parseInt(selectRef.current.value),
                        })
                    }
                }}
            >
                선택
            </button>
        </div>
    )
}