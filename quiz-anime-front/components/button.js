import Link from "next/link";

export default function Button(props){
    return(
        <>
            <Link href={props.link}>
                <a className={props.style}>{props.linkText}</a>
            </Link>
        </>
    )
}