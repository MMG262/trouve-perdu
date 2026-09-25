<?php
require_once __DIR__ . '/../includes/security.php';
start_secure_session();
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../config/database.php';

require_login();

$bdd = db();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Objets Perdus</title>
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
              <li class="nav-item ">
                <div class="nav-item1">
                <a class="nav-link active" aria-current="page" href="lost_items.php"><span>Objets Perdus</span></a>
                <img src="../images/icons/active-dot.svg" alt="">
                </div>
              </li>
              <li class="nav-item">
                <a class="nav-link active" id="lien" aria-current="page" href="found_items.php"><span>Objets trouvés</span></a>
              </li>
              <li class="nav-item">
                <a class="nav-link active" id="lien" aria-current="page" href="notifications.php"><span>Notifications</span></a>
              </li>
              <li class="nav-item">
                <a class="nav-link active" id="lien" aria-current="page" href="logout.php"><span>Déconnexion</span></a>
              </li>
            </ul>
        </div>
        </div>
      </nav>
      <div class="container">
        <div class="row choixContainer">
            <?php
              // Afficher la table objet dont l'état_objet = perdu et l'ordonner par ordre décroissant selon le id_objet
              $donnees = $bdd->query('SELECT * FROM objet WHERE état_objet="Perdu" ORDER BY id_objet DESC');
              foreach ($donnees as $reponse) {
                if ($reponse['id_utilisateur'] == $_SESSION['id_user']) {
            ?>
              <div class="col-md-4 choix">
                <h2><?php echo htmlspecialchars($reponse['type_objet']); ?></h2>
                <div>
                  <?php
                    // Afficher les objets de type Ordinateur ou Tablette ou Téléphone
                    if ($reponse['type_objet'] == "Tablette" or $reponse['type_objet'] == "Téléphone"
                    or $reponse['type_objet'] == "Ordinateur") {
                  ?>
                      <p>Etat : <span class="badge-warn"><?php echo htmlspecialchars($reponse['état_objet']); ?></span></p>
                      <p>Marque : <?php echo htmlspecialchars($reponse['marque']); ?></p>
                      <p>Couleur : <?php echo htmlspecialchars($reponse['couleur']); ?></p>
                      <p>Lieu : <?php echo htmlspecialchars($reponse['lieu']); ?></p>
                      <p>Date : <?php echo htmlspecialchars($reponse['dates']); ?></p>
                  <?php

                  // Sinon afficher les objets de type Carte d'identité ou Carte étudiant ou Passeport
                  } else { ?>
                      <p>Etat : <span class="badge-warn"><?php echo htmlspecialchars($reponse['état_objet']); ?></span></p>
                      <p>Prénom : <?php echo htmlspecialchars($reponse['prénom']); ?></p>
                      <p>Nom : <?php echo htmlspecialchars($reponse['nom']); ?></p>
                      <p>Date de naissance : <?php echo htmlspecialchars($reponse['date_de_naissance']); ?></p>
                      <p>Numéro unique: <?php echo htmlspecialchars($reponse['numéro_unique']); ?></p>
                      <p>Lieu : <?php echo htmlspecialchars($reponse['lieu']); ?></p>
                  <?php } ?>
                </div>
              </div>
            <?php
                }
              }
            ?>
        </div>
      </div>
</body>
</html>
