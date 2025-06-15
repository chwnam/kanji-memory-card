import useCardContext from '@/v2/components/hooks/use-card-context'
import DefaultLayout from '@/v2/components/layouts/default-layout'
import {Tab, TabList} from '@/v2/components/layouts/tabs'
import SectionAbout from '@/v2/components/parts/section-about'
import SectionPractice from '@/v2/components/parts/section-practice'
import SectoinProgress from '@/v2/components/parts/sectoin-progress'
import PageTitle from '@/v2/components/parts/page-title'
import {useState} from 'react'

export default function MemoryCard() {
    const {
        state: {
            course,
            siteMeta: {
                courses,
                pageTitle,
            },
        },
    } = useCardContext()

    const [activeTab, setActiveTab] = useState<number>(1)

    return (
        <DefaultLayout title={pageTitle}>
            <PageTitle>
                {course in courses && courses[course]}
            </PageTitle>
            <TabList>
                <Tab
                    className="bg-base-100 border-t-base-300 py-6"
                    checked={1 === activeTab}
                    label="카드 학습"
                    name="main-tab"
                    onChange={() => setActiveTab(1)}
                >
                    <SectionPractice />
                </Tab>
                <Tab
                    className="bg-base-100 border-t-base-300 py-6"
                    checked={2 === activeTab}
                    label="내 진행 상황"
                    name="main-tab"
                    onChange={() => setActiveTab(2)}
                >
                    <SectoinProgress />
                </Tab>
                <Tab
                    className="bg-base-100 border-t-base-300 py-6"
                    checked={3 === activeTab}
                    label="소개"
                    name="main-tab"
                    onChange={() => setActiveTab(3)}
                >
                    <SectionAbout />
                </Tab>
            </TabList>
        </DefaultLayout>
    )
}
