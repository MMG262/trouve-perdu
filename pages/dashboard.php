<?php
require_once __DIR__ . '/../includes/security.php';
start_secure_session();
require_once __DIR__ . '/../includes/auth.php';

require_login();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/vendor/bootstrap.min.css">
    <link rel="stylesheet" href="../css/theme.css">
    <link rel="stylesheet" href="../css/home.css">
    <title>Compte Utilisateur</title>
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
              <li class="nav-item ">
                <div class="nav-item1">
                <a class="nav-link active" aria-current="page" href="dashboard.php"><span>Home</span></a>
                <img src="../images/icons/active-dot.svg" alt="">
                </div>
              </li>
              <li class="nav-item">
                <a class="nav-link active" id="lien" aria-current="page" href="lost_items.php"><span>Objets Perdus</span></a>
              </li>
              <li class="nav-item">
                <a class="nav-link active" id="lien" aria-current="page" href="found_items.php"><span>Objets Trouvés</span></a>
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
       <h2 class="bienvenue">Bienvenue <strong class="text-grand-format mt-3"><?php echo htmlspecialchars($_SESSION['usernameverification']); ?></strong></h2>
      <div class="container pb-5">
        <div class="row">
            <div class="col-md-6 ">
                <h1 class="text-grand-format mt-3">UN OBJET PERDU SE <br>TRANSFORME SOUVENT <br> EN OBJET TROUVE !</h1>
                <h4 class="text-petit-format py-4">Vous avez <span>perdu ou trouvé un objet !</span> <br>Déclarez-le et la communauté
                    se mobilise <br>pour vous aidez à le retrouver.
                </h4>
                <div class="btn-container">
                    <button type="button" class="btn btn1 btn-primary me-4" value="perdu"><a href="report_lost.php">J'ai perdu</a></button>
                    <button type="button" class="btn btn2 btn-outline-primary"><a href="report_found.php">J'ai trouvé</a></button>
                </div>
            </div>
            <div class="col-md-6 image1 mt-4 ms-0">
              <img src="../images/searching.png" alt="">
            </div>
        </div>
      </div>
</body>
</html>
