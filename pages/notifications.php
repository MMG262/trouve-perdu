<?php
session_start();
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../config/database.php';

require_login();

$bdd = db();

// Un objet perdu et un objet trouvé sont considérés comme le même objet si :
// - c'est un document (carte d'identité/étudiant, passeport) avec le même numéro unique, ou
// - c'est un appareil (téléphone, ordinateur, tablette) avec la même marque et la même couleur.
function objetsCorrespondent(array $a, array $b): bool
{
    if ($a['type_objet'] !== $b['type_objet']) {
        return false;
    }
    if (!empty($a['numéro_unique']) && !empty($b['numéro_unique'])) {
        return $a['numéro_unique'] === $b['numéro_unique'];
    }
    if (!empty($a['marque']) && !empty($b['marque'])) {
        return $a['marque'] === $b['marque'] && $a['couleur'] === $b['couleur'];
    }
    return false;
}

$objetsPerdus = $bdd->query('
    SELECT objet.*, user.prénom_user, user.nom_user, user.numéro_téléphone, user.email
    FROM objet
    INNER JOIN user ON user.id_user = objet.id_utilisateur
    WHERE objet.état_objet = "Perdu"
')->fetchAll();

$objetsTrouves = $bdd->query('
    SELECT objet.*, user.prénom_user, user.nom_user, user.numéro_téléphone, user.email
    FROM objet
    INNER JOIN user ON user.id_user = objet.id_utilisateur
    WHERE objet.état_objet = "Trouver"
')->fetchAll();

// Objets que l'utilisateur connecté a perdus et que quelqu'un d'autre a retrouvés :
// on lui montre l'objet trouvé et les coordonnées de la personne qui l'a trouvé.
$retrouves = [];

// Objets que l'utilisateur connecté a trouvés et qui appartiennent à quelqu'un d'autre :
// on lui montre l'objet perdu et les coordonnées de la personne à qui le rendre.
$reclames = [];

foreach ($objetsPerdus as $perdu) {
    foreach ($objetsTrouves as $trouve) {
        if ($perdu['id_utilisateur'] == $trouve['id_utilisateur']) {
            continue;
        }
        if (!objetsCorrespondent($perdu, $trouve)) {
            continue;
        }
        if ($perdu['id_utilisateur'] == $_SESSION['id_user']) {
            $retrouves[] = $trouve;
        }
        if ($trouve['id_utilisateur'] == $_SESSION['id_user']) {
            $reclames[] = $perdu;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications</title>
    <link rel="stylesheet" href="../css/vendor/bootstrap.min.css">
    <link rel="stylesheet" href="../css/theme.css">
    <link rel="stylesheet" href="../css/items.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light ">
        <div class="container-fluid">
          <a class="navbar-brand" href="#"><span>FIND&LOSE</span></a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ">
                <li class="nav-item">
                    <a class="nav-link active" id="lien" aria-current="page" href="dashboard.php"><span>Home</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" id="lien" aria-current="page" href="found_items.php"><span>Objets Perdus</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" id="lien" aria-current="page" href="found_items.php"><span>Objets Trouvés</span></a>
                  </li>
              <li class="nav-item ">
                <div class="nav-item1">
                <a class="nav-link active" aria-current="page" href="notifications.php"><span>Notifications</span></a>
                <img src="../images/icons/active-dot.svg" alt="">
                </div>
              </li>
              <li class="nav-item">
                <a class="nav-link active" id="lien" aria-current="page" href="logout.php"><span>Déconnexion</span></a>
              </li>
            </ul>
        </div>
        </div>
      </nav>
      <div class="container">
        <?php if ($retrouves) { ?>
        <h2 class="mt-4">Vos objets perdus ont été retrouvés</h2>
        <div class="row choixContainer">
            <?php foreach ($retrouves as $objet) { ?>
            <div class="col-md-4 choix">
                <h2><?php echo htmlspecialchars($objet['type_objet']); ?></h2>
                <div>
                    <p>Etat : <span class="badge-success">Retrouvé</span></p>
                    <?php if ($objet['type_objet'] === 'Téléphone' || $objet['type_objet'] === 'Tablette' || $objet['type_objet'] === 'Ordinateur') { ?>
                    <p>Marque : <?php echo htmlspecialchars($objet['marque']); ?></p>
                    <p>Couleur : <?php echo htmlspecialchars($objet['couleur']); ?></p>
                    <?php } else { ?>
                    <p>Prénom : <?php echo htmlspecialchars($objet['prénom']); ?></p>
                    <p>Nom : <?php echo htmlspecialchars($objet['nom']); ?></p>
                    <p>Num  : <?php echo htmlspecialchars($objet['numéro_unique']); ?></p>
                    <?php } ?>
                    <p>Lieu : <?php echo htmlspecialchars($objet['lieu']); ?></p>
                </div>
                <h2 class="mt-4">Personne qui l'a retrouvé</h2>
                    <p>Prénom : <?php echo htmlspecialchars($objet['prénom_user']); ?></p>
                    <p>Nom : <?php echo htmlspecialchars($objet['nom_user']); ?></p>
                    <p>Tel : <?php echo htmlspecialchars($objet['numéro_téléphone']); ?></p>
                    <p>Email : <?php echo htmlspecialchars($objet['email']); ?></p>
            </div>
            <?php } ?>
        </div>
        <?php } ?>

        <?php if ($reclames) { ?>
        <h2 class="mt-4">Objets que vous avez trouvés et qui ont été réclamés</h2>
        <div class="row choixContainer">
            <?php foreach ($reclames as $objet) { ?>
            <div class="col-md-4 choix">
                <h2><?php echo htmlspecialchars($objet['type_objet']); ?></h2>
                <div>
                    <p>Etat : <span class="badge-info">Réclamé</span></p>
                    <?php if ($objet['type_objet'] === 'Téléphone' || $objet['type_objet'] === 'Tablette' || $objet['type_objet'] === 'Ordinateur') { ?>
                    <p>Marque : <?php echo htmlspecialchars($objet['marque']); ?></p>
                    <p>Couleur : <?php echo htmlspecialchars($objet['couleur']); ?></p>
                    <?php } else { ?>
                    <p>Prénom : <?php echo htmlspecialchars($objet['prénom']); ?></p>
                    <p>Nom : <?php echo htmlspecialchars($objet['nom']); ?></p>
                    <p>Num  : <?php echo htmlspecialchars($objet['numéro_unique']); ?></p>
                    <?php } ?>
                    <p>Lieu : <?php echo htmlspecialchars($objet['lieu']); ?></p>
                </div>
                <h2 class="mt-4">Personne à qui le rendre</h2>
                    <p>Prénom : <?php echo htmlspecialchars($objet['prénom_user']); ?></p>
                    <p>Nom : <?php echo htmlspecialchars($objet['nom_user']); ?></p>
                    <p>Tel : <?php echo htmlspecialchars($objet['numéro_téléphone']); ?></p>
                    <p>Email : <?php echo htmlspecialchars($objet['email']); ?></p>
            </div>
            <?php } ?>
        </div>
        <?php } ?>

        <?php if (!$retrouves && !$reclames) { ?>
        <p class="mt-4">Aucune notification pour le moment.</p>
        <?php } ?>
      </div>
</body>
</html>
