<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Compétences</title>
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
            <li><a href="listdemp.php" class="nav-link scrollto "><i class="bi bi-card-list"></i> <span>List</span></a></li>
            <li><a href="detatil.php?employeur_id=<?php echo $employeur_id; ?>" class="nav-link scrollto active"><i class="bx bx-user"></i> <span>Profil</span></a></li>
            <li><a href="ajouter_employe.html" class="nav-link scrollto "><i class="bi bi-person-fill-add"></i> <span>Ajouter</span></a></li>
            <li><a href="comptence.php" class="nav-link scrollto  "><i class="bi bi-clipboard"></i> <span>list de comepetences</span></a></li>
            <li><a href="deconnexion.php" class="nav-link scrollto "><i class="bi bi-box-arrow-left"></i> <span>Deconexion</span></a></li>

        </ul>
    </nav>
</header>

<?php

require 'connexion.php'; 

if (isset($_GET['employeur_id'])) {
    $employeur_id = $_GET['employeur_id'];

   $sql = "SELECT comptences.typecomptence, notecompetences.etat
            FROM comptences
            LEFT JOIN notecompetences ON comptences.Idcomp = notecompetences.competence_id
            WHERE notecompetences.employeur_id = :employeur_id";

   $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':employeur_id', $employeur_id, PDO::PARAM_INT);
    $stmt->execute();
    $competences = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($competences) {
        echo '<div class="form-container">';
        echo'<h1>Liste des Compétences</h1>';
        echo '<table class="table table-striped tablec" border="1">
                <tr>
                    <th class="table-header">Type de Compétence</th>
                    <th></th>
                    <th class="table-header">État</th>
                </tr>';

        foreach ($competences as $competence) {
            echo '<tr>
                    <td class="table-cell">' . $competence['typecomptence'] . '</td>
                    <td>
                     |
                     </td>
                    <td class="table-cell">' . ($competence['etat'] ? $competence['etat'] : 'Non encore rempli') . '</td>
                  </tr>';
        }

        echo '</table>';
        echo ' <button type="button" class="btn btn-outline-secondary" onclick="goBack()">Retour</button>';
        echo '</div>';
    } else {
        echo 'l employe n a pas encore remplir la list des comptences.';
    }
} else {
    echo 'Erreur : employeur_id non spécifié.';
}
?>

<script>
    function goBack() {
        window.history.back();
    }
</script>