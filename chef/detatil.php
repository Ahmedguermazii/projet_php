<!-- detail.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails de l'Employeur</title>
    <style>
        .position {
            margin-top: 150px;
            margin-left: 250px; /* Ajustez la valeur selon vos besoins */
        }
        .button-container {
            position: relative;
        }
        .bottom-right-buttons
        {
            position: absolute;
            bottom: -40px;
            right: 0;
            width:140px;
        }
        .bottom-mid-buttons {
            right: 145px;
            position: absolute;
            bottom: -40px; 
            width:130px;
        }
        .bottom-comp-buttons {
            right: 280px;
            position: absolute;
            bottom: -40px; 
            width:130px;
        }
    </style>
    <!-- Add Bootstrap CSS -->
    <link href="https://cdn.jselivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KyZXEAg3QhqLMpG8r+Knujsl7/1L_dstPt3HV5HzF6Gvk/e3s4Wz6iJgD/+ub2oU" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">
    <link href="assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>
<header id="header" class="d-flex flex-column justify-content-center">
    <nav id="navbar" class="navbar nav-menu">
        <ul>
            <li><a href="index.html" class="nav-link scrollto "><i class="bx bx-home"></i> <span>Home</span></a></li>
            <li><a href="listdemp.php" class="nav-link scrollto "><i class="bi bi-card-list"></i> <span>List</span></a></li>
            <li><a  class="nav-link scrollto active"><i class="bx bx-user"></i> <span>Profil</span></a></li>
            <li><a href="comtenceemp.php" class="nav-link scrollto "><i class="bi bi-clipboard"></i> <span>list de comepetences</span></a></li>
            <li><a href="objectif.php" class="nav-link scrollto "><i class="bi bi-calendar-fill"></i> <span>list des objectifs</span></a></li>
            <li><a href="deconnexion.php" class="nav-link scrollto "><i class="bi bi-box-arrow-left"></i> <span>Deconexion</span></a></li>

        </ul>
    </nav>
</header>
<?php
// Récupérez l'ID de l'employeur depuis le formulaire
if(isset($_POST['employeur_id'])) {
    $employeur_id = $_POST['employeur_id'];

    // Récupérez les détails de l'employeur depuis la base de données
    require 'connexion.php';
    try {
        $statement = $pdo->prepare("SELECT * FROM employeur WHERE Id = ?");
        $statement->execute([$employeur_id]);
        $employeur = $statement->fetch(PDO::FETCH_ASSOC);

        // Afficher les informations dans le format souhaité
        echo '<div class="position">';
        echo '    <div class="container mt-6s">';
        echo '        <div class="row">';
        echo '            <div class="col-md-3 text-center">';
        echo '    <img src="../assets/img/testimonials/' . htmlspecialchars($employeur['Image']) . '" alt="Profile Image" class="img-fluid rounded-circle mb-2">';
        echo '    <h5>' . htmlspecialchars($employeur['Nom']) . ' ' . htmlspecialchars($employeur['Prenom']) . '</h5>';
        echo '    <p>' . htmlspecialchars($employeur['Post']) . '</p>';
        echo '</div>';
        
        echo '            <div class="col-md-6">';
        echo '                <div class="card">';
        echo '                    <div class="card-body">';
        echo '                        <h5 class="card-title">Profile</h5>';
        echo '                    </div>';
        echo '                </div>';
        echo '                <div class="card mt-3">';
        echo '                    <div class="card-body">';
        echo '                        <h5 class="card-title">Profile Details</h5>';
        echo '                        <ul class="list-group list-group-flush">';
        echo '                            <li class="list-group-item">Nom et Prenom: ' . htmlspecialchars($employeur['Nom']) . ' ' . htmlspecialchars($employeur['Prenom']) . '</li>';
        echo '                            <li class="list-group-item">Post: ' . htmlspecialchars($employeur['Post']) . '</li>';
        echo '                            <li class="list-group-item">Adress: ' . htmlspecialchars($employeur['Adress']) . '</li>';
        echo '                            <li class="list-group-item">Numero de telephone: ' . htmlspecialchars($employeur['Numtel']) . '</li>';
        echo '                            <li class="list-group-item">Email: <a href="mailto:' . htmlspecialchars($employeur['Email']) . '">' . htmlspecialchars($employeur['Email']) . '</a></li>';
        echo '                        </ul>';
        echo '                    </div>';
        echo '                </div>';
        echo '<div class="button-container">';
        echo '    <a href="objectifemp.php?employeur_id=' . $employeur['Id'] . '" class="btn btn-outline-secondary bottom-right-buttons">Ajouter objectif</a>';
        echo '    <a href="noter.php?employeur_id=' . $employeur['Id'] . '" class="btn btn-outline-success bottom-mid-buttons">Noter objectif</a>';
        echo '    <a href="notecomptence.php?employeur_id=' . $employeur['Id'] . '" class="btn btn-outline-info bottom-comp-buttons">Compétence</a>';

        echo '</div>';
        echo '            </div>';
        echo '        </div>';
        echo '    </div>';
        echo '</div>';

    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
} else {
    // Si l'ID n'est pas fourni, affichez un message d'erreur ou redirigez l'utilisateur
    echo '<p>Erreur : ID de l\'employeur non fourni.</p>';
}

?>


</body>
</html>
