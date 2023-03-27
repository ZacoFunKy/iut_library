# SAE 4 - IUT Bibliothèque Bordeaux

## Table des matières

 1. [Présentation des membres de l'équipe]()
 2. [Description du projet]()
 3. [Fonctionnalités principales]()
 4. [Évaluation du projet]()


## 1. Présentation des membres de l'équipe 

Notre équipe était composé de 6 membres : 

 - Mael JEGU
 - Aurelien LUXEY
 - Yanis MERCIER-TALLET
 - Romain CORDIER
 - Edouard SENSE
 - Zachary TANJI
 
Nous avons travaillé ensemble pendant une semaine et demi sur ce projet.

## 2. Description du projet 

Le projet consiste à créer un site internet pour la bibliothèque de l'IUT de Bordeaux, qui proposera des fonctionnalités classiques telles que la recherche de livres, la visualisation d'informations liées aux livres et les dernières acquisitions de la bibliothèque.

 

## 3. Fonctionnalités principales 

 - Partie Front-End : 
	 - [X] Utilisation du framework React pour le développement de la partie front du site internet.
	 - [X] Utilisation du package "react-router-dom" pour permettre une navigation multi-pages.
	 - [ ] Utilisation de TypeScript (optionnel).
	 - [ ] Qualité de code à respecter avec l'outil d'audit de votre navigateur.

 - Partie Back-End : 
	 - [ ] Qualité de code à respecter avec l'outil d'audit de votre navigateur.
	 - [ ] Importation des données des livres via l'API Google Books.
	 - [ ] Génération d'une base de données représentative d'une base réelle avec 200 livres, 50 auteurs différents, chaque livre n'étant présent qu'une fois dans la base.
	 - [ ] Génération d'une base de données représentative d'une base réelle avec 200 livres, 50 auteurs différents, chaque livre n'étant présent qu'une fois dans la base.
	 - [ ] Création de notre propre API.
	 - [ ] Documentation de l'API au format OpenAPI.

 - Partie BD : 
	 - [X] Conception des données avec un schéma entité-association.
	 - [X] Utilisation de MariaDB ou MySQL.

 - Partie Gestion devops :
	 - [X] Utilisation d'un pipeline pour vérifier le respect des données générées, analyser le code PHP avec php-cs-fixer.
	 - [ ]  Faire des tests unitaires en PHP (optionnel).
	 - [ ] Suivi du workflow suivant : ticket/merge-request-review et CI, merge dans principal.

## 4. Évaluation du projet 

Planing des **rendu** : 

|24 mars| 27 mars |
|--|--|
| à partir de 16H : ● Evaluation de la chaîne CI mise en place sur votre GitLab par Pierre Ramet. ● Vous recevrez un retour sur la qualité de la chaîne mise en place dans les issues de votre gitlab | Démonstration fonctionnelle du MVP entre 14H et 18H ● 20 minutes Front : vous devez a minima montrer une fonctionnalité opérationnelle (un composant, utilisation d’une route de l’API, modification de la base). ● 20 minutes Back: vous présenterez la structure de votre API, la manière dont elle est documentée, et les tests mis en place pour valider son fonctionnement |
|Critères d'acceptation pour la partie CI : - pipeline opérationnel - la production d’une image docker adaptée au projet - preuve de concept avec 2 ou 3 tests intégrés (scripts BD, tests back, …) - configuration des Merge Request avec la CI Bien sur, toute la suite du Dev devra s’appuyer sur cette CI et respecter l’organisation du développement avec le Workflow Gitlab utilisant les Issues et Merge Requests Les tests devront être ajoutés au fur et à mesure du Dev. Aucune Merge Request ne sera acceptée sans respecter la CI.|pour 18H Sur votre GitLab, rédiger dans le README un texte indiquant comment : ● vous avez décidé d’ordonner les comptes à suivre qui sont proposés ● ce que vous proposez comme fonctionnalité de proposition de nouvelles lectures Livrable BD (déposer un document sur votre dépôt GitLab) contenant les informations suivantes : ● un schéma entité-association (avec les éventuelles contraintes d’intégrité non exprimées dans le schéma ou commentaires) ● un script SQL permettant de créer toute la base de données (tables et contraintes d’intégrité, et éventuels privilèges, vues, déclencheurs, procédures/fonctions stockées, index) et des données N. B. : en cas de dénormalisation, justifiez impérativement vos choix ● des requêtes d’interrogation SQL indiquant le nombre de tuples de chaque table, à intégrer aux tests  |


Le 31 mars : Présentation technique de 15 minutes de votre travail :

-   Les fonctionnalités développées via le VPS
-   La chaîne CI
-   La partie Back/BD
-   La partie Front

15 minutes de questions :


