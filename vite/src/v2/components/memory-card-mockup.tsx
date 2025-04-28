import {cn} from '@/v2/lib/utils.ts'

export default function MemoryCardMockup() {
    return (
        <main className="w-full h-full">
            <div className="mx-auto max-w-[720px] mt-12 mb-8">
                <h1 className="mb-4 text-3xl select-none">
                    한자 카드 V2
                </h1>
                <div role="tablist" className="tabs tabs-border">
                    <input type="radio" name="my_tabs_3" className="tab" aria-label="카드 학습" defaultChecked />
                    <div className="tab-content bg-base-100 border-t-base-300 py-6">
                        <div className="mb-3">
                            <label className="select select-sm w-[160px] rounded-md">
                                <span className="label">소스</span>
                                <select className="">
                                    <option disabled={true}>소스 선택</option>
                                    <option>N5</option>
                                    <option>N4</option>
                                </select>
                            </label>
                            <label className="ms-2 select select-sm w-[160px] rounded-md">
                                <span className="label">티어</span>
                                <select className="">
                                    <option disabled={true}>티어 선택</option>
                                    <option>5티어</option>
                                    <option>4티어</option>
                                    <option>3티어</option>
                                    <option>2티어</option>
                                    <option>1티어</option>
                                </select>
                            </label>
                            <button className="ms-2 btn btn-sm btn-neutral rounded-md">
                                선택
                            </button>
                        </div>
                        <div
                            className={cn(
                                'flex justify-between items-center',
                                'px-1 py-1',
                                'text-sm',
                            )}
                        >
                            <div className={''}>
                                <span>1/2</span>
                                <span className="ms-3">ID#1232</span>
                            </div>
                            <div>5 티어, 잔여 카드 233</div>
                        </div>
                        <div
                            className={cn(
                                'bg-base-200 rounded-md',
                                'border-2 border-neutral-300',
                            )}>
                            <div>
                                <section
                                    className={cn(
                                        'w-full h-[320px]',
                                        'flex justify-center items-center',
                                    )}
                                >
                                    <div>
                                        <p className="text-4xl">
                                            Card question side
                                        </p>
                                        <p className="mt-2 text-md">
                                            Hint goes here
                                        </p>
                                    </div>
                                </section>
                                <section
                                    className={cn(
                                        'w-full h-[320px]',
                                        'flex justify-center items-center',
                                    )}
                                >
                                    <div>
                                        <p className="text-4xl"> Card Answer side</p>
                                    </div>
                                </section>
                            </div>
                        </div>
                        <div className="mt-6">
                            <div
                                className={cn(
                                    'flex justify-around',
                                    'lg:px-36 md:px-18 sm:px-6 px-3',
                                )}
                            >
                                <button
                                    className="btn btn-neutral rounded-md"
                                >
                                    &laquo; 이전 단어
                                </button>
                                <button
                                    className="btn btn-neutral rounded-md"
                                >
                                    정답 토글
                                </button>
                                <button
                                    className="btn btn-neutral rounded-md"
                                >
                                    다음 단어 &raquo;
                                </button>
                            </div>

                            <div className="divider mt-8 mb-2">답안 처리</div>
                            <div className="text-center">
                                <p className="text-sm italic select-none">이 단어를 맞추셨나요? 딱 한번만 입력 가능해요!</p>
                                <div className="mt-4 flex justify-center gap-x-2">
                                    <button
                                        className="btn w-1/2 btn-soft rounded-md"
                                    >
                                        아니오
                                    </button>
                                    <button
                                        className="btn w-1/2 btn-soft rounded-md"
                                    >
                                        네
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div className="divider" />
                        <div className="collapse collapse-arrow bg-base-200">
                            <input type="checkbox" />
                            <div className="collapse-title font-semibold">
                                학습한 카드
                            </div>
                            <div className="collapse-content">
                                <ol className="list-decimal list-inside">
                                    <li>
                                        ✅ #1328 단어
                                    </li>
                                    <li>
                                        🚫 #1999 단어
                                    </li>
                                </ol>
                                <button className="mt-4 btn btn-warning rounded-md">
                                    내역 초기화
                                </button>
                            </div>
                        </div>
                    </div>

                    <input type="radio" name="my_tabs_3" className="tab" aria-label="내 진행 상황" />
                    <div className="tab-content  bg-base-100 border-t-base-300 py-6">
                        <ul className="list bg-base-100 rounded-box shadow-md">
                            <li className="list-row">
                                티어 5: 34단어가 있습니다.
                            </li>
                            <li className="list-row">
                                티어 4: 34단어가 있습니다.
                            </li>
                        </ul>
                    </div>

                    <input type="radio" name="my_tabs_3" className="tab" aria-label="소개" />
                    <div className="tab-content  bg-base-100 border-t-base-300 py-6">
                        웃기죠?
                    </div>
                </div>
            </div>
        </main>
    )
}
