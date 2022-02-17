import Head from 'next/head'
import Image from 'next/image'
import styles from '../styles/Home.module.css'
import 'bootstrap/dist/css/bootstrap.css'
import Button from "../components/button";

export default function Home() {
  return (
    <div className={styles.container}>
      <Head>
        <title>Quiz sur les Animés</title>
      </Head>

      <main className={styles.main}>
          <h1 className='m-3'>Quiz sur les Animés</h1>
          <h3 className='m-3'>Bienvenu que voulez-vous faire ?</h3>
          <div className="d-inline-flex m-xl-5">
              <Button link={"/play"} style={"btn btn-success btn-lg m-5"} linkText={"Jouer"}/>
              <Button link={"/create"} style={"btn btn-danger btn-lg m-5"} linkText={"Créer un question"}/>
          </div>
      </main>

      <footer className={styles.footer}>
        <a
          href="https://vercel.com?utm_source=create-next-app&utm_medium=default-template&utm_campaign=create-next-app"
          target="_blank"
          rel="noopener noreferrer"
        >
          Powered by{' '}
          <span className={styles.logo}>
            <Image src="/vercel.svg" alt="Vercel Logo" width={72} height={16} />
          </span>
        </a>
      </footer>
    </div>
  )
}
