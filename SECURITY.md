# Sécurité

Ce projet a été audité et corrigé avant sa publication sur GitHub. Résumé de ce qui a été trouvé et corrigé, et de ce qui reste à faire.

## Corrigé

- **Identifiants de base de données en dur** (`root`/`root` répétés dans 13 fichiers) : déplacés dans `.env` (ignoré par git) via `config/database.php`. `.env.example` documente les variables attendues.
- **Mots de passe stockés et comparés en clair** : remplacé par `password_hash()` / `password_verify()` (`pages/login.php`).
- **Requête de login non filtrée** (`SELECT * FROM user` puis boucle PHP pour comparer chaque ligne) : remplacée par une requête préparée `SELECT * FROM user WHERE username = ?`.
- **Session non régénérée à la connexion** (risque de fixation de session) : ajout de `session_regenerate_id(true)` après une connexion réussie.
- **`header('Location: ...')` sans `exit;`** : plusieurs pages continuaient à s'exécuter après avoir envoyé une redirection. `exit;` a été ajouté systématiquement après chaque `header('Location: ...')`.
- **Messages d'erreur de connexion à la base exposés aux visiteurs** (`die('Erreur : ' . $e->getMessage())` affichait potentiellement des détails internes) : remplacé par un message générique + `error_log()` côté serveur.
- **Injection XSS stockée** : les pages `lost_items.php`, `found_items.php`, `notifications.php` et `dashboard.php` affichaient des données utilisateur/DB sans échappement. Tous les affichages dynamiques passent maintenant par `htmlspecialchars()`.
- **Connexions à la base inutilisées** : `dashboard.php`, `report_lost.php` et `report_found.php` ouvraient une connexion PDO qu'ils n'utilisaient jamais — supprimée.

## Reste à faire (hors périmètre de cette réorganisation)

- **Pas de protection CSRF** sur les formulaires (login, inscription, déclaration d'objet). À ajouter avec un token de session si le site accepte des utilisateurs réels.
- **Pas de limitation du nombre de tentatives de connexion** (brute force possible). À ajouter (ex : verrouillage temporaire après N échecs).
- **Pas de vérification d'email** à l'inscription.
- **Cookies de session** : en production, activer `session.cookie_secure`, `session.cookie_httponly` et `session.cookie_samesite=Lax` (ou `Strict`) dans la configuration PHP.
- **HTTPS** : à imposer en production (le projet est actuellement pensé pour un usage local WAMP en HTTP).
- **Noms de colonnes SQL accentués** (`prénom_user`, `numéro_téléphone`, etc.) : fonctionnels mais non conventionnels. Un renommage en ASCII (`first_name`, `phone_number`...) nécessiterait une migration de la base existante — non fait ici pour ne pas casser vos données locales.
- **Validation des entrées** : les champs de formulaire (email, téléphone, dates) ne sont validés que côté navigateur (`required`, `type="email"`). Une validation côté serveur est recommandée avant toute mise en production.

## Avant de pousser sur GitHub

- Vérifiez que `.env` n'est jamais committé (`.gitignore` s'en charge).
- Ne partagez jamais un export de votre base de données réelle (avec de vrais mots de passe/emails) dans le repo.
