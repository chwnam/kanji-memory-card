type Judges = Map<number, boolean>          // Mapping of card - judge: true: corret, false: incorrect, undefined: not judged.
type Courses = { [key: string]: string }    // Key and title of courses.
type Course = string                        // Key of the current course.

type Card = {
    id: number
    question: string
    questionHint: string
    answer: string
    answerSupplement: string
    course: Course
}

type SiteMeta = {
    courses: Courses
    pageTitle: string
}

type State = {
    allCards: Card[] // 0th: tier
    course: Course
    judges: Judges
    siteMeta: SiteMeta
    tier: number
}

export type {
    Card,
    Judges,
    Course,
    Courses,
    SiteMeta,
    State,
}
