ECF Garage V. Parrot 

Le Garage V. Parrot a été réalisé dans le cadre de mon Évaluation en cours de formation pour la plateforme Studi. Le but étant de créer pour un garage fictif un site web vitrine, responsive et dynamique. Le site web propose une présentation du garage, des services ainsi que de pouvoir contacter et donner des avis sur le garage. Il possède aussi un espace administratif pour l'employeur et ses employés. 

Ce a site a été développé à l'aide du Framework Symfony 7.0.2, du SGBD MySQL 8.2.0 abritant les données du site et quant au niveau du design j'ai utilisé à l'aide du bundle WebPackEncore le Framework Bootstrap 5.1.3 et du langage de script SASS.


Pour pouvoir déployer le site à l'aide de Symfony il vous faudra : 
- PHP 8.3.1
- MySQL, ou un autre système de gestion de base de données compatible
- Un serveur web (Apache, Nginx...)
- Composer

Manuel pour le déploiement en local : 

. Cloner le projet à partir de : 
``` 
https://github.com/juliefort/Garage-Vincent-Parrot.git
```

. Ensuite se placer sur le répertoire du projet Garage V. Parrot à l'aide de la commande : 
``` 
cd Garage-Vincent-Parrot;
```

. Installer les dépendances nécessaires à l'aide de Composer: 
``` 
composer install
``` 
``` 
composer require symfony/webpack-encore-bundle
``` 
``` 
npm install
```

. Ouvrir le dossier .env à la racine du projet et ajouter les variables d'environnemment présentes et votre port de votre configuration locale pour se connecter à la BDD :
``` 
DATABASE_URL="mysql://app:!ChangeMe!@127.0.0.1:3306/app?serverVersion=10.11.2-MariaDB&charset=utf8mb4"
``` 

. Créer la base de données à l'aide de :
```
php bin/console doctrine:database:create 
``` 

. Ensuite vous pouvez commencer à créer vos tables à l'aide des Entités et de la formule suivante en vous assurant de possèder le MakerBundle:
```
php bin/console make:entity
```

. Il vous faudra par la suite migrer vos données vers la BDD :
```
php bin/console make:migration
```
```
php bin/console doctrine:migrations:migrate
```

. Vous pouvez désormais lancer votre serveur avec la commande suivante: 
```
symfony server:start
```

L'application Symfony est déployée !!

Et pour finir il vous faudra créer un compte administrateur avec un 'ROLE_ADMIN' afin d'avoir accès et gérer toutes les fonctionnalités de l'espace administratif !

. Pour se faire via votre ligne de commande se placer sur le projet Garage-Vincent-Parrot :
```
cd Garage-Vincent-Parrot
```
```
mysql -u admin -p
```

. Rentrer le mot de passe inclus dans le dossier .env de la Base de données et taper :
```
USE GarageVParrot;
```

. De là inclure le mail (se trouvant dans les valeurs du dossier .env) et le mot de passe préalablement hashé : 
```
INSERT INTO user(id, email, roles, password, lastName, firstName) VALUES ('1', 'email', '[\ROLE_ADMIN\]' , 'password', 'Parrot', 'Vincent');
```