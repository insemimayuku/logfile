LogFile - Gestion des Fichiers et Stockage

Description

LogFile est une application Symfony 6.4 permettant la gestion des fichiers et de l'espace de stockage des utilisateurs. Elle intègre un système d'authentification, un suivi de l'utilisation du stockage et un service de paiement via PayPal (non encore complètement configuré).

Branches

Le projet est organisé en plusieurs branches pour faciliter le développement et la gestion des fonctionnalités :

main : Branche stable contenant la dernière version validée du projet.

dev : Branche de développement où les nouvelles fonctionnalités sont ajoutées et testées.

dev-merger-prepare : Branche intermédiaire utilisée pour préparer la fusion des nouvelles fonctionnalités avant intégration dans main.

dev-paypal-service : Contient l'ajout du service PayPal, mais celui-ci n'est pas encore entièrement configuré.

Fonctionnalités Principales

Gestion des utilisateurs : Inscription, connexion et association à un espace de stockage.

Gestion des fichiers : Upload, suppression et affichage des fichiers stockés.

Suivi du stockage : Mise à jour de l'espace utilisé et autorisé, affiché sous forme de barres de progression.

Sécurisation des fichiers : Stockage des fichiers en dehors du dossier public.

Intégration PayPal (en cours) : Système de paiement pour l'extension de l'espace de stockage.

Installation

Cloner le dépôt :

git clone <repo_url>
cd logfile

Installer les dépendances :

composer install
npm install

Configurer l'environnement :
Copier .env.example en .env et modifier les paramètres (base de données, SMTP, etc.).

Mettre en place la base de données :

php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate

Lancer le serveur :

symfony server:start

Utilisation

Accéder à l'application via http://127.0.0.1:8000

Se connecter ou s'inscrire pour accéder à son espace de stockage

Télécharger et gérer ses fichiers

Vérifier l'utilisation de l'espace de stockage via les barres de progression

Améliorations Futures

Finalisation de la configuration PayPal

Amélioration de l'interface utilisateur

Ajout de fonctionnalités avancées de gestion des fichiers

Licence

Ce projet est sous licence MIT.

