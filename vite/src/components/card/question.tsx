export type Props = {
    text: string
}

export default function Question(props: Props) {
    return (
        <p className="text-5xl">{props.text}</p>
    )
}
