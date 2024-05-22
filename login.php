<?php
session_start();
require 'admin/config.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['Email'];
    $pswd = $_POST['Motspasse'];
    try {
        $query = "SELECT * FROM employeur WHERE Email = :email";
        $statement = $connexion->prepare($query);
        $statement->bindParam(':email', $email);
        $statement->execute();
        if ($statement->rowCount() == 1) {
            $utilisateur = $statement->fetch(PDO::FETCH_ASSOC);
            if ($pswd == $utilisateur['Motspasse']) {
                $_SESSION['id'] = $utilisateur['Id'];
                $_SESSION['email'] = $utilisateur['Email'];
                if ($utilisateur['Type'] == 'A') {
                    header("Location: admin/index.html");
                    exit();
                } elseif ($utilisateur['Type'] == 'E') {
                    header("Location: employe/index.html");
                    exit();
                }elseif ($utilisateur['Type'] == 'C') {
                    header("Location: chef/index.html");
                    exit();
                }
            } else {
                echo "Mot de passe incorrect. Veuillez réessayer.";
            }
        } else {
            echo "Email incorrect. Veuillez réessayer.";
        }
    } catch (PDOException $e) {
        echo "Erreur de connexion à la base de données : " . $e->getMessage();
        echo " Requête SQL : " . $query;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Description de votre site">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="assets/css/main.css" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
    <link href="assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <title>Login</title>
</head>

<body>
<header id="header" class="d-flex flex-column justify-content-center">

    <nav id="navbar" class="navbar nav-menu">
      <ul>
        <li><a href="index.html" class="nav-link scrollto "><i class="bx bx-home"></i> <span>Home</span></a></li>
        <li><a href="login.php" class="nav-link scrollto active"><i class="bi bi-door-open"></i> <span>login</span></a></li>
        </ul>
    </nav><!-- .nav-menu -->

  </header>
    <section class="vh-100" style="background-color: #F5F5F5;">
        <div class="container py-5 h-100" >
            <div class="row d-flex justify-content-center align-items-center h-100" >
                <div class="col col-xl-10" >
                    <div class="card" style="border-radius: 1rem;">
                        <div class="row g-0">
                            <div class="col-md-6 col-lg-5 d-none d-md-block">
                                <img src="assets/img/login.jpg"
                                    alt="login form" class="img-fluid" style="border-radius: 1rem 0 0 1rem;" />
                            </div>
                            <div class="col-md-6 col-lg-7 d-flex align-items-center">
                                <div class="card-body p-4 p-lg-5 text-black">
                                    <form action="#" method="post">
                                        <div class="d-flex align-items-center mb-3 pb-1">
                                            <i class="fas fa-cubes fa-2x me-3" style="color: #3f5b89;"></i>
                                            <span class="h2 fw-bold mb-0">FINLOGIK</span>
                                        </div>
                                        <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">connectez vous</h5>
                                        <div class="form-outline mb-4">
                                            <input type="email" id="form2Example17" class="form-control form-control-lg" name="Email" required/>
                                            <label class="form-label" for="form2Example17">Email</label>
                                        </div>
                                        <div class="form-outline mb-4">
                                              <input type="password" id="form2Example27" class="form-control form-control-lg" name="Motspasse" required />
                                             <label class="form-label" for="form2Example27">Mot de passe</label>
                                        </div>

                                        <div class="pt-1 mb-4">
                                            <button class="btn btn-dark btn-lg btn-block" type="submit">se connecter</button>

                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>
</body>

</html>
