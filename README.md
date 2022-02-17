# Eval Quiz Anime

## Description
Evaluation qui nous demande de créer un quiz sur les amines en Reactjs pour le front et Symfony en api pour le back

## Installation
### Pour la partie back

Assurez-vous de bien être minimum en php 8.0.2

Ouvrez une invide de commande dans le dossier quiz-anime-back.

Exectuter la commande tapez
```
composer install
```

Remplacez les information du fichier `.env` par les votre à la lignes:

```
DATABASE_URL="mysql://root:db_password@127.0.0.1:3306/quiz_anime?serverVersion=mariadb-10.4.22"

root par votre nom d'utilisateur de la base de donnée
db_password par votre mot de passe de la base de donnée
127.0.0.1 par l'url de votre base de donnée et 3306 par votre port
Et enfin mariadb-10.4.22 par votre version de serveur de votre base de donnée
```

puis tapez la commande `php bin/console doctrine:database:create` suivi de `php bin/console doctrine:migrations:migrate`.(récuération de la base de donnée)

Une fois la base de donnée créer lancer le fonctionnement du back avec la commande `symfony server:start`.

### Pour la partie front

Rendez-vous dans le dossier quiz-anime-front et ouvrez une invite de commande, lancez :
```
npm install ou yarn install
```
puis faite
```
npm start ou yarn dev
```

## Lancement de l'application

Une fois l'installations terminer rendez-vous à l'adresse : 
``http://localhost:3000/`` et profitez !