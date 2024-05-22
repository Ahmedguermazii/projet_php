<?php
// Démarrez la session avant tout autre contenu
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Employeurs</title>
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
    <!-- Ajouter des styles CSS pour les cartes -->
    <style>
        .carte-employeur {
            border: 1px solid #ddd;
            padding: 15px;
            margin: 10px;
            width: 300px;
            height: 550px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .carte-employeur img {
            width: 270px;
            height: 320px;
            object-fit: cover;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        .details {
            font-size: 14px;
            color: #555;
            max-height: 200px;
            overflow: hidden;
        }

        .message-container {
            text-align: center;
        }

        .text-ce {
            font-size: 24px;
            color: #333;
        }

        * {
            box-sizing: border-box;
        }

        .bottom-comp-buttons {
            right: 50px;
            position: absolute;
            bottom: 10px;
            width: 200px;
        }

        .topnav {
            overflow: hidden;
            background-color: #f1f1f1;
        }

        .topnav input[type=text] {
            float: right;
            padding: 6px;
            margin-top: 8px;
            margin-right: 16px;
            border: 1px solid #ccc;
            font-size: 17px;
        }

        .topnav button.search-btn {
            float: right;
            padding: 6px 10px;
            margin-top: 8px;
            margin-right: 16px;
            background-color: #2196F3;
            color: white;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            font-size: 17px;
        }

        .topnav button.search-btn:hover {
            background-color: #0b7dda;
        }

        .bottom-co-buttons {
            right: 50px;
            position: absolute;
            bottom: 20px;
            width: 200px;
        }
    </style>
</head>

<body>
    <header id="header" class="d-flex flex-column justify-content-center">
        <nav id="navbar" class="navbar nav-menu">
            <ul>
                <li><a href="index.html" class="nav-link scrollto "><i class="bx bx-home"></i> <span>Home</span></a></li>
                <li><a href="listdemp.php" class="nav-link scrollto active"><i class="bi bi-card-list"></i> <span>List</span></a></li>
                <li><a href="comtenceemp.php" class="nav-link scrollto "><i class="bi bi-clipboard"></i> <span>list de comepetences</span></a></li>
                <li><a href="objectif.php" class="nav-link scrollto "><i class="bi bi-calendar-fill"></i> <span>list des objectifs</span></a></li>
                <li><a href="deconnexion.php" class="nav-link scrollto "><i class="bi bi-box-arrow-left"></i> <span>Deconexion</span></a></li>

            </ul>
        </nav>
    </header>
    <form method="get" action="listdemp.php">
        <div class="topnav">
            <input type="text" name="search" class="search-input " placeholder="Search..">
            <button type="submit" class="search-btn btn btn-outline-info">Search</button>
        </div>
    </form>
    <div class="p-100 mb-1000 bg-light text-dark">
        <div class="container py-4 px-3 mx-auto">
            <div class="row">
            <?php
require 'connexion.php';


if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

try {
    $statement = $pdo->prepare("SELECT * FROM employeur WHERE (Type='E' ) AND Coddir = :employeur_id");

    if (isset($_GET['search'])) {
        $searchTerm = $_GET['search'];
        // Utilisez une requête SQL conditionnelle pour filtrer les résultats
        $statement = $pdo->prepare("SELECT * FROM employeur WHERE (Type='E' ) AND (Nom LIKE :searchTerm OR Prenom LIKE :searchTerm OR Email LIKE :searchTerm) AND Coddir = :employeur_id");
        $statement->bindValue(':searchTerm', '%' . $searchTerm . '%');
    }

    $statement->bindValue(':employeur_id', $_SESSION['id']);
    $statement->execute();
    $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

    if (empty($rows)) {
        echo '<div class="message-container">';
        echo ' <p class="text-ce">Cette page est réservée au chef d équipe.</p>';
        echo '</div>';
        exit();
    }

    foreach ($rows as $row) {
        echo '<div class="col-md-3 mb-4">';
        echo '<div class="card carte-employeur">';
        echo '<img src="../assets/img/testimonials/' . htmlspecialchars($row['Image']) . '" class="card-img-top" alt="Image de l\'employeur">';
        echo '<div class="card-body">';
        echo '<h5 class="card-title">' . htmlspecialchars($row['Nom']) . ' ' . htmlspecialchars($row['Prenom']) . '</h5>';
        echo '<div class="details">';
        echo '<br>';
        echo '<p>Email: ' . htmlspecialchars($row['Email']) . '</p>';
        // Ajoutez d'autres détails selon vos besoins
        echo '<div class="boutons">';
        // Ajoutez un formulaire autour du bouton "Profil"
        echo '<form method="post" action="detatil.php">';
        echo '<input type="hidden" name="employeur_id" value="' . htmlspecialchars($row['Id']) . '">';
        echo '<button type="submit" class="btn btn-outline-success bottom-comp-buttons"> Profil </button>';
        echo '</form>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>

            </div>
        </div>
    </div>

    <!-- Liens vers les fichiers CSS/JS -->
    <!-- Ajoutez vos liens vers les fichiers CSS/JS ici -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>

</html>
