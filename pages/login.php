<?php
require_once __DIR__ . '/../includes/security.php';
start_secure_session();
require_once __DIR__ . '/../config/database.php';

$bdd = db();

$message = '';
if (isset($_GET['inscrit'])) {
    $message = "<p style='color:green; font-weight:bold; font-size:17px'>
                Inscription réussie, vous pouvez vous connecter.</p>";
}

if (!empty($_POST['conecter'])) {
    verify_csrf();

    $utilisateur = false;
    if (post_fields_filled(['usernameverification', 'mot_de_passeverification'])) {
        $req = $bdd->prepare('SELECT * FROM user WHERE username = ?');
        $req->execute(array($_POST['usernameverification']));
        $utilisateur = $req->fetch();
    }

    if ($utilisateur && password_verify($_POST['mot_de_passeverification'], $utilisateur['mot_de_passe'])) {
        // Regenerate the session id on login to prevent session fixation.
        session_regenerate_id(true);
        $_SESSION['usernameverification'] = $utilisateur['username'];
        $_SESSION['id_user'] = $utilisateur['id_user'];
        header('Location: dashboard.php');
        exit;
    }

    $message = "<p style='color:red; font-weight:bold; font-size:17px'>
                le username ou le mot de passe n'est pas correct</p>";
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
    <title>Connexion</title>
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
        <div class="row">
            <div class="col-md-12 formulaire">
                <h2>Connexion</h2>
                <?php echo $message ; ?>
                <div class="input input1">
                    <input type="text" placeholder="Entrez votre username" name="usernameverification" required>
                </div>
                <div class="input input1">
                    <input type="password" placeholder="Entrez votre passe" name="mot_de_passeverification" >
                </div>
                <div class="btn-container ">
                    <input type="submit" name="conecter" value="Se connecter" class="btn">
                </div>
                <p class="pt-3">Je ne posséde pas de compte, <a href="register.php">je m'inscris </a></p>
            </div>
        </div>
      </div>
      </form>
</body>
</html>
