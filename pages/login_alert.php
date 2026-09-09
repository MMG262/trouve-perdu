<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/vendor/bootstrap.min.css">
    <link rel="stylesheet" href="../css/theme.css">
    <link rel="stylesheet" href="../css/login_alert.css">
    <title>Connexion Alerte</title>
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
      <div class="container">
        <div class="row p-2">
            <div class="col-md-12 formulaire1">
                <h2>Oups votre objet n'est pas ajouté !!</h2>
                <h2 class="alert pb-0">Veuillez vous connecter ou s'inscrire si ce n'est <br>
                  pas le cas pour déclarer facilement vos objets.
                </h2>
                <div class="btn-container1">
                    <button type="button" class="btn1 btn-primary me-4"><a href="login.php">Se connecter</a></button>
                </div>
                <p class="pt-3 ">Je ne posséde pas de compte, <a href="register.php" class="lienInscrire">je m'inscris</a></p>
            </div>
        </div>
      </div>
</body>
</html>
