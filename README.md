# Application de prise et de suivi de commandes - Oumami
Application web destinée à un traiteur japonais indépendant. Il permet la prise de commandes avec l'envoi possible d'un mail récapitulatif au client ainsi qu'un suivi des commandes (gestion de l'état de la commande à venir). Un soin particulier a été apporté à l'UX afin d'éviter au maximum une perte de temps à l'utilisation au client

## Installer le projet
1. Cloner le repository
2. Créer un fichier .env.local à partir du fichier .env et renseigner vos données :  
*db_user* = votre nom d'utilisateur  
*db_password* = votre mot de passe  
*db_name* = le nom de la base de données  
`DATABASE_URL=mysql://db_user:db_password@127.0.0.1:3306/db_name`

3. Installer Composer :
`$ composer install`

4. Installer yarn
`$ yarn install`

5. Créer la base de données :
`$ php bin/console doctrine:database:create`

6. Mettre à jour la base de données :
`$ php bin/console doctrine:schema:update --force`

7. Charger les fixtures :
`$ php bin/console doctrine:fixture:load`

8. Compiler le SCSS avec la commande :
`$ yarn encore dev`

9. Lancer le serveur :
`$ symfony server:start`

## Outils de développement
* Symfony 5.2
* PHP 7.4
* SCSS
