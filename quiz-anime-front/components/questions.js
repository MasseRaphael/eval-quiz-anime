import {useEffect} from "react";

export default function Questions(props) {
    const questions = props.questions;

    useEffect(() =>
    {
        console.log(typeof questions)
    })
    return(
        <>
            { Object.assign(questions).map(
                (el) => (
                    <>
                        { !active ? (
                            active
                        ) : (
                            <div>
                                <h2>Question</h2>

                                <p> {el} </p>

                            </div>
                        )}
                    </>
                )
            )}
        </>
    )
}