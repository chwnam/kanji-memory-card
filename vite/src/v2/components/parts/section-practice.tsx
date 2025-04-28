import useCardContext from '@/v2/components/hooks/use-card-context'
import PracticeCard from '@/v2/components/parts/practice-card'
import SectionPracticeCourse from '@/v2/components/parts/section-practice-course'
import TierSelector from '@/v2/components/parts/tier-selector'

export default function SectionPractice() {
    const {
        state: {
            tier,
        },
    } = useCardContext()

    return (
        <>
            <TierSelector />
            {0 > tier && <PracticeCard>진행할 티어를 선택하세요</PracticeCard>}
            {0 < tier && <SectionPracticeCourse />}
        </>
    )
}
