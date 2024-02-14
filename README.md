# cyber_training
Support de cours de sécurité des applications web. 

> [!WARNING]
> Attention, le code présent sur ce repo comprend volontairement des failles de sécurité.
> Ne pas installer cette BDD et ces codes PHP sur un serveur web exposé sur internet.

## Création de la BDD ##
Nom de la BDD à créer manuellement : example

## Création d'un utilisateur de BDD nécessaire ##
- Nom d'utilisateur à créer manuellement : example
- Mot de passe à créer manuellement : example

## Création des tables nécessaires ##

### création automatique ###
Importer le fichier [example.sql](BDD/example.sql) dans votre BDD (PHPMyAdmin).

### création manuelle ###
- Nom de la table : comment
	- Colonnes :
		- Comment (Text)
		- Name (Text)
- Nom de la table : users
	- Colonnes :
		- id (int) - Primary - Auto increment
		- password (Text)
		- username (Text)
Il est conseillé de remplir des données d'exemples dans la table "users".
