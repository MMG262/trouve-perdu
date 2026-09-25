<?php
require_once __DIR__ . '/../includes/security.php';
start_secure_session();
require_once __DIR__ . '/../config/database.php';

$erreur = '';
if (isset($_POST['inscrire'])) {
    verify_csrf();

    if (!post_fields_filled(['prénom', 'nom', 'username', 'email', 'numéro_téléphone', 'mot_de_passe'])) {
        $erreur = 'Veuillez remplir tous les champs.';
    } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $erreur = "L'adresse email n'est pas valide.";
    } elseif (strlen($_POST['mot_de_passe']) < 8) {
        $erreur = 'Le mot de passe doit contenir au moins 8 caractères.';
    } else {
        $bdd = db();
        $req = $bdd->prepare('SELECT 1 FROM user WHERE username = ?');
        $req->execute(array(trim($_POST['username'])));

        if ($req->fetch()) {
            $erreur = "Ce nom d'utilisateur est déjà pris.";
        } else {
            $req = $bdd->prepare('INSERT INTO user (prénom_user, nom_user, username, email, numéro_téléphone, mot_de_passe) VALUES(?, ?, ?, ?, ?, ?)');
            $req->execute(array(
                trim($_POST['prénom']),
                trim($_POST['nom']),
                trim($_POST['username']),
                trim($_POST['email']),
                trim($_POST['numéro_téléphone']),
                password_hash($_POST['mot_de_passe'], PASSWORD_DEFAULT)
            ));
            header('Location: login.php?inscrit=1');
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/vendor/bootstrap.min.css">
    <link rel="stylesheet" href="../css/theme.css">
    <link rel="stylesheet" href="../css/forms.css">
    <title>Inscription</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
          <a class="navbar-brand" href="#"><span>FIND&LOSE</span></a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ">
              <li class="nav-item">
                <a class="nav-link active" id="lien" aria-current="page" href="../index.php"><span>Home</span></a>
              </li>
            </ul>
        </div>
        </div>
      </nav>
      <form method="POST" action="">
      <?php echo csrf_field(); ?>
      <div class="container">
        <div class="row px-3">
            <div class="col-md-12 formulaire">
                <h2>Inscription</h2>
                <?php if ($erreur !== '') { ?>
                <p style="color:red; font-weight:bold; font-size:17px"><?php echo htmlspecialchars($erreur); ?></p>
                <?php } ?>
                <div class="sousContainer">
                    <div class="row">
                        <div class="col-md-6 ">
                            <div class="input input1">
                                <input type="text" placeholder="Entrez votre prénom" name="prénom" required  >
                            </div>
                            <div class="input input1">
                                <input type="text" placeholder="Entrez votre nom" name="nom" required >
                            </div>
                            <div class="input input1">
                                <input type="text" placeholder="Entrez votre username" name="username" required >
                            </div>
                        </div>
                        <div class="col-md-6 ">
                            <div class="input input1">
                                <input type="email" placeholder="Entrez votre email" name="email" required>
                            </div>
                            <div class="input input1">
                                <input type="text" placeholder="Entrez votre numéro téléphone " name="numéro_téléphone" required >
                            </div>
                            <div class="input input1">
                                <input type="password" placeholder="Entrez votre passe" name="mot_de_passe" minlength="8" required >
                            </div>
                        </div>
                        </div>
                    </div>
                    <div class="btn-container">
                        <input type="submit" name="inscrire" value="S'inscrire" class="btn">
                    </div>
                        <p class="pt-3">J'ai déjà un compte, <a href="login.php">je me connecte</a></p>
            </div>
        </div>
      </div>
      </form>


</body>
</html>
