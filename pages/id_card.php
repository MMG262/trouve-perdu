<?php
require_once __DIR__ . '/../includes/security.php';
start_secure_session();
require_once __DIR__ . '/../config/database.php';

$_SESSION['objet'] = "Carte identité";
$bdd = db();

// If the visitor is not logged in and tries to submit, send them to log in first.
if (empty($_SESSION['usernameverification']) && isset($_POST['soumissionOrdinateur'])) {
    header('Location: login_alert.php');
    exit;
}

if (isset($_POST['soumissionOrdinateur'])) {
    verify_csrf();

    // état is set by report_lost.php / report_found.php: without it we don't know
    // whether the object was lost or found.
    if (!in_array($_SESSION['état'] ?? null, ['Perdu', 'Trouver'], true)) {
        header('Location: dashboard.php');
        exit;
    }
    if (!post_fields_filled(['prénom', 'nom', 'date_de_naissance', 'numéro_unique', 'nationalité', 'lieu'])) {
        http_response_code(400);
        die('Veuillez remplir tous les champs du formulaire.');
    }

    $req = $bdd->prepare('INSERT INTO objet (id_utilisateur, type_objet, état_objet, prénom,
    nom, date_de_naissance, numéro_unique, nationalité, lieu) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)');
    $req->execute(array(
        $_SESSION['id_user'],
        $_SESSION['objet'],
        $_SESSION['état'],
        $_POST['prénom'],
        $_POST['nom'],
        $_POST['date_de_naissance'],
        $_POST['numéro_unique'],
        $_POST['nationalité'],
        $_POST['lieu']
    ));

    header('Location: ' . ($_SESSION['état'] === 'Perdu' ? 'lost_items.php' : 'found_items.php'));
    exit;
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
    <title>Carte d'identié</title>
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
            <?php
                if (isset($_SESSION['usernameverification'])) { ?>
                  <li class="nav-item">
                      <a class="nav-link active" id="lien" aria-current="page" href="dashboard.php"><span>Home</span></a>
                  </li>
                <?php
                } else { ?>
                  <li class="nav-item">
                  <a class="nav-link active" id="lien" aria-current="page" href="../index.php"><span>Home</span></a>
                  </li>
                <?php
                } ?>
            </ul>
        </div>
        </div>
      </nav>
        <h1 class="text mb-0">Carte d'identité</h1>
      <div class="container">
        <div class="row px-3">
            <div class="col-md-12 formulaire">
                <h2>Veuillez remplir ce formulaire !</h2>
                <form method="POST" action="">
                <?php echo csrf_field(); ?>
                <div class="sousContainer">
                    <div class="row">
                        <div class="col-md-6 ">
                            <div class="inputContainer">
                                <div class="input">
                                    <label for="">Prénon</label>
                                    <input type="text" placeholder="Entrez le prénom" name="prénom" required>
                                </div>
                            </div>
                            <div class="inputContainer">
                                <div class="input ">
                                    <label for="">Nom</label>
                                    <input type="text" placeholder="Entrez le nom" name="nom" required>
                                </div>
                            </div>
                            <div class="inputContainer">
                                <div class="input">
                                    <label for="">Date de naissance</label>
                                    <input type="date" name="date_de_naissance" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 ">
                            <div class="inputContainer">
                                <div class="input">
                                    <label for="">Numéro CIN</label>
                                    <input type="text" placeholder="Saisissez le numéro CIN" name="numéro_unique" required>
                                </div>
                            </div>
                            <div class="inputContainer">
                                <div class="input">
                                    <label for="">Ou ?</label>
                                    <input type="text" placeholder="Renseignez le lieu" name="lieu" required>
                                </div>
                            </div>
                            <div class="inputContainer">
                                <div class="input">
                                    <label for="">Nationalité</label>
                                    <input type="text" placeholder="Entrez la nationalité" name="nationalité" required>
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
                    <div class="btn-container">
                        <input type="submit" name="soumissionOrdinateur" value="Soumettre" class="btn">
                    </div>
                </form>
            </div>
        </div>
      </div>
</body>
</html>
