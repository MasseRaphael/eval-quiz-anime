import {useForm} from "react-hook-form";
import {useRef, useState} from "react";
import axios from "axios";
import ReactPlayer from "react-player";


export default function Create(){
    const {
        register,
        handleSubmit,
        formState: { errors },
    } = useForm();

    const [videoPath, setVideoPath] = useState('');
    const [imageUrl, setImageUrl] = useState('');

    const onSubmit = async (newData) => {
        newData.videos = imageUrl;
        newData.answers = Object.values(newData.answers);
        if(newData.answers[0] === newData.correctAnswer || newData.answers[1] === newData.correctAnswer || newData.answers[2] === newData.correctAnswer || newData.answers[3] === newData.correctAnswer){
            await  axios.post('http://localhost:8080/api/questions', newData, {
                headers: {
                    'Content-Type': 'application/json',
                    Accept: 'application/json'
                }
            });
            window.alert("La question a été enregistrée !");
            document.getElementById("form").reset();
        }else{
            window.alert("La bonne réponse ne fait pas partie des propositions")
        }
    };

    const videoCreateRef = useRef(null);

    const onFocus = () => {
        return axios.get(`https://api.trace.moe/search?url=${encodeURI(imageUrl)}`)
            .then( v => {
                setVideoPath(v.data.result[0].video)

            });
    }

    return (
        <div>
            <h1>Créer votre question</h1>
            <form id="form" className="form-control" onSubmit={handleSubmit(onSubmit)}>
                <input
                    {...register("title", { required: true })}
                    placeholder="Question ?"
                />
                {errors.title && <span>Ce champs est obligatoire</span>}

                <input
                    {...register("answers[answer0]", { required: true })}
                    placeholder="Réponse 1"
                />
                {errors.answers && <span>Ce champs est obligatoire</span>}

                <input
                    {...register("answers[answer1]", { required: true })}
                    placeholder="Réponse 2"
                />
                {errors.answers && <span>Ce champs est obligatoire</span>}

                <input
                    {...register("answers[answer2]", { required: true })}
                    placeholder="Réponse 3"
                />
                {errors.answers && <span>Ce champs est obligatoire</span>}

                <input
                    {...register("answers[answer3]", { required: true })}
                    placeholder="Réponse 4"
                />
                {errors.answers && <span>Ce champs est obligatoire</span>}

                <input
                    {...register("correctAnswer", { required: true })}
                    placeholder="Bonne réponse"
                />
                {errors.correctAnswer && <span>Ce champs est obligatoire</span>}

                <input
                    placeholder="URL de l'image pour choisir la vidéo"
                    onChange={(e) => setImageUrl(e.target.value)} onBlur={onFocus}
                />

                <input className="btn btn-dark" type="submit" />
            </form>

            <h3>La vidéo correspond bien à votre image ?</h3>
            <h4>Si ce n'est pas le cas veuillez en choisir une nouvelle</h4>
            <div ref={videoCreateRef}>
                <ReactPlayer url={videoPath} playing={true} muted={true} loop={true} controls={true} width={500} height={500} />
            </div>
        </div>
    );
}