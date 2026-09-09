<?php
session_start();
$_SESSION['état'] = "Perdu";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/vendor/bootstrap.min.css">
    <link rel="stylesheet" href="../css/theme.css">
    <link rel="stylesheet" href="../css/report_lost.css">
    <title>Declarer Perdu</title>
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
    <h2 class="text">Je déclare un <span>objet perdu</span></h2>
    <div class="container">
        <div class="row choixContainer">
            <a href="id_card.php" class="col-md-2 choix">
                Carte d'identité
            </a>
            <a href="student_card.php" class="col-md-2 choix">
                Carte étudiant
            </a>
            <a href="passport.php" class="col-md-2 choix">
                Passeport
            </a>
            <a href="phone.php" class="col-md-2 choix">
                Téléphone
            </a>
            <a href="laptop.php" class="col-md-2 choix">
                Ordinateur
            </a>
            <a href="tablet.php" class="col-md-2 choix">
                Tablette
            </a>
        </div>
    </div>
</body>
</html>
