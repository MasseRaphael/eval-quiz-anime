import Questions from "../components/questions";

export default function Play({questions}){
    return (
        <>
            <Questions questions={ questions }/>
        </>
    )
}

export async function getServerSideProps() {
    const questionsRes = await fetch(
        'http://localhost:8000/api/questions'
    );
    const questions = await questionsRes.json();

    if (!questions) {
        return {
            notFound: true,
        }
    }
    return {
        props: {
            questions,
        },
    };
}