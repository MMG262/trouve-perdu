# Sécurité

Ce document décrit les mesures de sécurité en place dans FIND&LOSE et les limites connues du projet. Il s'agit d'un projet d'apprentissage, pensé pour tourner en local : les limites ci-dessous seraient à traiter avant toute mise en production avec de vrais utilisateurs.

## Mesures en place

| Risque | Mesure | Où |
|---|---|---|
| Fuite des identifiants de la base | Lus depuis `.env` (ignoré par git) ; `.env.example` documente les variables attendues | [config/database.php](config/database.php) |
| Vol de mots de passe | Hachage `password_hash()` (bcrypt), vérification `password_verify()` | [pages/register.php](pages/register.php), [pages/login.php](pages/login.php) |
| Injection SQL | Requêtes préparées PDO pour toute donnée venant de l'utilisateur | toutes les pages |
| XSS stockée | Échappement `htmlspecialchars()` de chaque donnée affichée | pages de listes et de notifications |
| CSRF | Jeton aléatoire par session, vérifié avec `hash_equals()` sur chaque formulaire POST | [includes/security.php](includes/security.php) |
| Vol / fixation de session | Cookie `HttpOnly`, `SameSite=Lax`, `Secure` en HTTPS, `use_strict_mode`, `session_regenerate_id()` à la connexion, cookie supprimé à la déconnexion | [includes/security.php](includes/security.php), [pages/logout.php](pages/logout.php) |
| Pages privées accessibles sans compte | `require_login()` en tête de chaque page protégée, suivi d'un `exit` | [includes/auth.php](includes/auth.php) |
| Données invalides | Validation côté serveur : champs obligatoires, format email, mot de passe de 8 caractères minimum, nom d'utilisateur unique | [includes/security.php](includes/security.php), [pages/register.php](pages/register.php) |
| Divulgation d'informations techniques | Message générique en cas d'erreur de base, détail envoyé dans `error_log()` | [config/database.php](config/database.php) |
| Accès HTTP aux fichiers internes | `.htaccess` : fichiers cachés (`.env`…) et `.git/` refusés, pas de listing de dossiers, `config/`, `includes/` et `database/` inaccessibles | [.htaccess](.htaccess) |

## Limites connues

- **Pas de limitation des tentatives de connexion** : une attaque par force brute sur un compte reste possible. Piste : compteur d'échecs par compte / IP avec verrouillage temporaire.
- **Pas de vérification de l'adresse email** à l'inscription.
- **Critère de correspondance des appareils trop large** : deux appareils « de même marque et même couleur » sont considérés comme identiques, ce qui partage les coordonnées (téléphone, email) entre les deux utilisateurs. Quelqu'un pourrait déclarer un faux objet trouvé pour obtenir les coordonnées de personnes ayant perdu un appareil courant. En production, il faudrait un identifiant unique (IMEI, numéro de série) ou une validation par le propriétaire avant de révéler les coordonnées.
- **Données personnelles sensibles** : les déclarations de documents stockent nom, date de naissance et numéro de pièce d'identité. Une mise en production imposerait une politique de conservation et de suppression conforme au RGPD / à la loi locale.
- **HTTPS** non imposé : le projet est configuré pour un usage local en HTTP. En production, HTTPS est indispensable (le cookie de session passe alors automatiquement en `Secure`).

## Signaler une vulnérabilité

Si vous découvrez une faille, merci d'ouvrir une *issue* sur le dépôt GitHub en décrivant le problème (sans publier d'exploit prêt à l'emploi).
