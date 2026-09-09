# FIND&LOSE

Application web (PHP + MySQL) permettant à des utilisateurs de déclarer des objets perdus ou trouvés (carte d'identité, carte étudiant, passeport, téléphone, ordinateur, tablette) et d'être mis en relation lorsqu'un objet perdu correspond à un objet trouvé.

## Stack

- PHP (PDO / MySQL), aucun framework
- Bootstrap 5 (vendored dans `css/vendor/`)
- MySQL / MariaDB

## Structure du projet

```
index.php     Point d'entrée du site (accueil public)
config/       Connexion à la base de données (lit .env, ne contient aucun secret en dur)
includes/     Fonctions partagées (ex : require_login())
database/     Schéma SQL (database/schema.sql)
pages/        Le reste des pages PHP de l'application
css/          Feuilles de style (css/vendor/ = librairies tierces)
images/       Assets images
```

## Installation locale (WAMP)

1. Copier `.env.example` vers `.env` et adapter les identifiants à votre configuration MySQL locale :
   ```
   DB_HOST=localhost
   DB_NAME=test
   DB_USER=root
   DB_PASS=root
   DB_CHARSET=utf8mb4
   ```
2. Créer la base et les tables :
   ```
   mysql -u root -p < database/schema.sql
   ```
   (ou importer `database/schema.sql` via phpMyAdmin)
3. Placer le dossier dans `www/` (WAMP) et démarrer Apache + MySQL.
4. Ouvrir `http://localhost/FIND&LOSE/`.

## Pages principales

| Page | Rôle |
|---|---|
| `index.php` | Accueil public |
| `pages/login.php` / `pages/register.php` | Connexion / inscription |
| `pages/dashboard.php` | Accueil utilisateur connecté |
| `pages/report_lost.php` / `pages/report_found.php` | Choix du type d'objet à déclarer |
| `pages/id_card.php`, `student_card.php`, `passport.php`, `phone.php`, `laptop.php`, `tablet.php` | Formulaires de déclaration par type d'objet |
| `pages/lost_items.php` / `pages/found_items.php` | Listes des objets déclarés |
| `pages/notifications.php` | Correspondances objet perdu / trouvé |
| `pages/logout.php` | Déconnexion |

## Sécurité

Voir [SECURITY.md](SECURITY.md) pour le détail des correctifs appliqués et les recommandations restantes avant une mise en production réelle.

## Notes

- Les noms de colonnes en base (`prénom_user`, `numéro_téléphone`, etc.) ont été conservés tels quels pour rester compatibles avec le code existant.
- Certains fichiers CSS (`id_card.css`, `student_card.css`, `index.css`, `logout.css`, `notifications.css`, `found_items.css`, `laptop.css`, `passport.css`, `tablet.css`, `phone.css`, `register.css`) et images (`id_card.jpg`, `student_card.png`, `magnifier.png`, `laptop.png`, `phone.png`, `passport.jpg`, `search.jpg`) existaient déjà dans le projet d'origine mais ne sont référencés par aucune page — ils ont été renommés pour rester cohérents mais peuvent être supprimés s'ils ne servent pas.
