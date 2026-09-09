<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/vendor/bootstrap.min.css">
    <link rel="stylesheet" href="css/theme.css">
    <link rel="stylesheet" href="css/home.css">
    <title>Index</title>
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
                <a class="nav-link active" id="lien" aria-current="page" href="pages/login.php"><span>Se connecter</span></a>
              </li>
              <li class="nav-item">
                <a class="nav-link active" id="lien" aria-current="page" href="pages/register.php"><span>S'inscrire</span></a>
              </li>
            </ul>
        </div>
        </div>
      </nav>
      <div class="container py-5">
        <div class="row">
            <div class="col-md-6">
                <h1 class="text-grand-format">UN OBJET PERDU SE <br>TRANSFORME SOUVENT <br> EN OBJET TROUVE !</h1>
                <h4 class="text-petit-format py-4">Vous avez <span>perdu ou trouvé un objet !</span> <br>Déclarez-le et la communauté
                    se mobilise <br>pour vous aidez à le retrouver.
                </h4>
                <div class="btn-container pt-2">
                    <button type="button" class="btn btn1 btn-primary me-4"><a href="pages/report_lost.php">J'ai perdu</a></button>
                    <button type="button" class="btn btn2 btn-outline-primary"><a href="pages/report_found.php">J'ai trouvé</a></button>
                </div>
            </div>
            <div class="col-md-6 image1 mt-4 ms-0">
              <img src="images/searching.png" alt="">
            </div>
        </div>
      </div>
</body>
</html>
