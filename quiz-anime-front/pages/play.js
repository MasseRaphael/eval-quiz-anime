import React from "react";
import useSWR from "swr";
import ReactPlayer from "react-player";


const questionsEndpoint = "http://localhost:8000/api/questions";

const getData = async () => {
    const response = await fetch(questionsEndpoint);
    return await response.json();
};


export default function Play(){
    const { data: questions } = useSWR(questionsEndpoint, getData);
    return (
        <>
            <h1>Les Questions</h1>
            <div>
                {questions &&
                    questions.map((question) => (
                        <div key={question.id} className="border border-dark p-5 text-center m-5">
                            <h2>{question.title}</h2>
                            <ReactPlayer url={question.videos} playing={true} muted={true} loop={true} controls={true} width={350} height={350} />
                            <div className="container">
                                <div className="row m-1">
                                    <div className="col">
                                        <button className="btn btn-light">{question.answers[0]}</button>
                                    </div>
                                    <div className="col">
                                        <button className="btn btn-light">{question.answers[1]}</button>
                                    </div>
                                </div>
                                <div className="row m-1">
                                    <div className="col">
                                        <button className="btn btn-light">{question.answers[2]}</button>
                                    </div>
                                    <div className="col">
                                        <button className="btn btn-light">{question.answers[3]}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    ))}
            </div>
        </>

    );
}