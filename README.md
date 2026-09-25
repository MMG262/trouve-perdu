# FIND&LOSE — plateforme d'objets perdus et trouvés

![PHP](https://img.shields.io/badge/PHP-8.x-777BB4?logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-MariaDB-4479A1?logo=mysql&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5-7952B3?logo=bootstrap&logoColor=white)

Application web qui met en relation les personnes qui ont **perdu** un objet avec celles qui l'ont **trouvé**. Chacun déclare son objet (pièce d'identité ou appareil électronique) et, dès qu'une déclaration « perdu » correspond à une déclaration « trouvé », les deux utilisateurs reçoivent une notification avec les coordonnées de l'autre pour organiser la restitution.

Projet réalisé en **PHP natif, sans framework**, afin de maîtriser les fondamentaux du développement web côté serveur : routage par pages, sessions, accès base de données avec PDO, et sécurité applicative.

## Fonctionnalités

- **Comptes utilisateurs** : inscription, connexion, déconnexion, pages protégées par session.
- **Déclaration d'objets** perdus ou trouvés, avec un formulaire adapté à chaque type :
  - documents : carte d'identité, carte étudiant, passeport (nom, prénom, date de naissance, numéro unique…) ;
  - appareils : téléphone, ordinateur, tablette (marque, couleur, date, lieu).
- **Suivi** de ses propres déclarations (objets perdus / objets trouvés).
- **Mise en relation automatique** : une page de notifications affiche les correspondances et les coordonnées de la personne à contacter.

## Comment fonctionne la mise en relation

Une déclaration « perdu » et une déclaration « trouvé » faites par deux utilisateurs différents sont considérées comme le même objet si elles sont du même type et que :

| Type d'objet | Critère de correspondance |
|---|---|
| Carte d'identité, carte étudiant, passeport | même **numéro unique** (identifiant officiel du document) |
| Téléphone, ordinateur, tablette | même **marque** et même **couleur** |

- La personne qui a perdu l'objet voit qui l'a trouvé et comment la joindre.
- La personne qui l'a trouvé voit à qui le rendre.

La logique est isolée dans la fonction `objetsCorrespondent()` de [pages/notifications.php](pages/notifications.php).

## Stack technique

| Couche | Choix |
|---|---|
| Back-end | PHP 8 natif (sessions, PDO) |
| Base de données | MySQL / MariaDB, schéma dans [database/schema.sql](database/schema.sql) |
| Front-end | HTML, CSS, Bootstrap 5 |
| Configuration | variables d'environnement via un fichier `.env` (non versionné) |

## Sécurité

Le projet étant public, une attention particulière a été portée à la sécurité :

- **Mots de passe hachés** avec `password_hash()` / `password_verify()` (bcrypt), jamais stockés en clair.
- **Requêtes préparées PDO** pour toutes les données saisies : pas d'injection SQL possible via les formulaires.
- **Protection XSS** : toutes les données affichées sont échappées avec `htmlspecialchars()`.
- **Jetons CSRF** sur tous les formulaires.
- **Sessions durcies** : cookie `HttpOnly` + `SameSite=Lax` (+ `Secure` en HTTPS), mode strict, ID régénéré à la connexion (anti-fixation), cookie supprimé à la déconnexion.
- **Validation côté serveur** des champs (en plus des contrôles HTML) : email, longueur du mot de passe, nom d'utilisateur unique.
- **Aucun secret dans le dépôt** : identifiants de la base lus depuis `.env`, ignoré par git.
- **Fichiers internes non exposés** : des règles `.htaccess` bloquent l'accès HTTP à `.env`, `.git/`, `config/`, `includes/` et `database/`.
- **Erreurs non divulguées** : en cas d'échec de connexion à la base, l'utilisateur voit un message générique, le détail part dans les logs serveur.

Le détail des mesures et des limites connues est dans [SECURITY.md](SECURITY.md).

## Structure du projet

```
├── index.php          Page d'accueil publique
├── pages/             Pages de l'application (connexion, déclarations, listes, notifications…)
├── includes/          Fonctions partagées : sessions sécurisées, CSRF, validation, contrôle d'accès
├── config/            Connexion PDO à la base (lit le fichier .env)
├── database/          Schéma SQL
├── css/               Feuilles de style (css/vendor/ : Bootstrap)
└── images/            Illustrations
```

## Installation en local

**Prérequis** : PHP 8.0+, MySQL ou MariaDB, un serveur Apache (WAMP, XAMPP, MAMP ou LAMP).

1. Cloner le dépôt dans le dossier web du serveur (`www/` pour WAMP, `htdocs/` pour XAMPP) :
   ```bash
   git clone https://github.com/MMG262/trouve-perdu.git
   ```
2. Créer le fichier de configuration à partir de l'exemple, puis y renseigner vos identifiants MySQL :
   ```bash
   cp .env.example .env
   ```
3. Créer la base de données et les tables :
   ```bash
   mysql -u root -p < database/schema.sql
   ```
   (ou importer `database/schema.sql` depuis phpMyAdmin)
4. Démarrer Apache et MySQL, puis ouvrir [http://localhost/trouve-perdu/](http://localhost/trouve-perdu/).

**Pour tester la mise en relation** : créer deux comptes, déclarer un objet « perdu » avec le premier, puis le même objet « trouvé » avec le second (même numéro de document, ou même marque et couleur). La correspondance apparaît alors dans l'onglet *Notifications* des deux comptes.

## Auteur

**Moustapha Gueye** — [github.com/MMG262](https://github.com/MMG262)
