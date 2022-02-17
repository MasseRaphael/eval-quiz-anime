import React from "react";
import useSWR from "swr";
import axios from "axios";

const questionsEndpoint = "http://localhost:8000/api/questions";

const getData = async () => {
    const response = await fetch(questionsEndpoint);
    return await response.json();
};


export default function Play(){
    const { data: questions } = useSWR(questionsEndpoint, getData);
    console.log(questions)
    return (
        <>
            p
        </>
    )
}