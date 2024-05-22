<?php
require 'connexion.php';
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

// Retrieve the user ID from the session
$employeur_id = $_SESSION['id'];

try {
    $statement = $pdo->prepare("SELECT * FROM objectif WHERE Id = ?");
    $statement->execute([$employeur_id]);
    $objectifs = $statement->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Ajoutez vos balises meta, title, et liens vers les fichiers CSS/JS ici -->
    <title>Objectifs </title>
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
   <style>
    body {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            text-align: center;
            margin-top: -200px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .tablec {
            width: 1000px;
            margin: 20px auto;
        }

        .form-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 20px;
        }

        .form-container input {
            width: 70%;
        }

        h2,
        h5 {
            text-align: center;
            margin-top: 20px;
        }

        .btn {
            width: 150px;
        }

        .reset-button {
            margin-top: 10px;
        }
    </style>

</head>
<body>
<header id="header" class="d-flex flex-column justify-content-center">

<nav id="navbar" class="navbar nav-menu">
<ul>
        <li><a href="index.html" class="nav-link scrollto "><i class="bx bx-home"></i> <span>Home</span></a></li>
        <li><a href="comtenceemp.php" class="nav-link scrollto "><i class="bi bi-clipboard"></i> <span>list de comepetences</span></a></li>
        <li><a href="objectif.php" class="nav-link scrollto active"><i class="bi bi-calendar-fill"></i> <span>list des objectifs</span></a></li>
        <li><a href="deconnexion.php" class="nav-link scrollto "><i class="bi bi-box-arrow-left"></i> <span>Deconexion</span></a></li>
  
    </ul>
</nav><!-- .nav-menu -->

</header>
<div class="container text-center">
<?php
// Afficher les objectifs dans un tableau
if (isset($objectifs) && count($objectifs) > 0) {
    echo '<div class="form-container">';
    echo '<h1>Mes objectif</h1>';
    echo '<table class="table table-striped tablec" border="1">';
    echo '<tr><th class="table-cell">Nom de l\'Objectif</th></tr>';
    
    foreach ($objectifs as $objectif) {
        echo '<tr>';
        echo '<td class="table-cell">' . htmlspecialchars($objectif['Nomobjectif']) . '</td>';
        echo '</tr>';
    }
    
    echo '</table>';
    echo ' <button type="button" class="btn btn-outline-secondary" onclick="goBack()">Retour</button>';
    echo '</div>';
} else {
    echo '<p>Aucun objectif trouvé.</p>';
}
?>

    </div>



</div>



    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <script>
    function goBack() {
        window.history.back();
    }
</script>
</body>
</html>