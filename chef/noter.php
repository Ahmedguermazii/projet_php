<?php
// Inclure le fichier de connexion à la base de données
require 'connexion.php';

// Vérifier si l'ID de l'employeur est présent dans l'URL
if (isset($_GET['employeur_id'])) {
    $employeur_id = $_GET['employeur_id'];

    // Récupérer les objectifs associés à cet employeur
    try {
        $statement = $pdo->prepare("SELECT * FROM objectif WHERE Id = ?");
        $statement->execute([$employeur_id]);
        $objectifs = $statement->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }

    // Vérifier si le formulaire a été soumis
    if(isset($_POST['submit'])) {
        // Récupérer les données du formulaire
        $objectifs_post = $_POST['objectifs'];

        // Parcourir les objectifs et mettre à jour la table
        foreach ($objectifs_post as $id_objectif => $valeurs) {
            // Assurez-vous que l'ID de l'objectif est numérique pour des raisons de sécurité
            $id_objectif = intval($id_objectif);

            // Mettez à jour la table "objectif" avec les valeurs des boutons radio
            try {
                $updateStatement = $pdo->prepare("UPDATE objectif SET Note = ? WHERE id_objectif = ?");
                $updateStatement->execute([$valeurs, $id_objectif]);
            } catch (PDOException $e) {
                echo "Erreur : " . $e->getMessage();
            }
        }

        // Rafraîchir la page après la mise à jour
        header("Location: {$_SERVER['PHP_SELF']}?employeur_id=$employeur_id");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
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
            width: 80%;
        }
        .espace-entre-paragraphes {
        margin-left: 20px; 
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
        .radio-container {
            display: flex;
            align-items: center;
        }

        .label-container label,
        .radio-container label {
            margin-right: 10px;
        }
    </style>
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

<div class="container">
        <h2>ÉVALUATION DES OBJECTIFS</h2>
        <h5>Sélectionnez l'état d'avancement pour chaque objectif</h5>
        
        <?php
        if(isset($objectifs) && count($objectifs) > 0) {
            echo '<form method="post" action="' . $_SERVER['PHP_SELF'] . '?employeur_id=' . $employeur_id . '">';
            echo '<table class="table table-striped tablec" border="1">';
            echo '<tr><th class="table-header">Objectif</th><th class="table-header">Progression</th></tr>';
            foreach ($objectifs as $objectif) {
                echo '<tr>';
                echo '<td class=table-cell>' . htmlspecialchars($objectif['Nomobjectif']) . '</td>';
                echo '<td class=table-cell>';
                
                echo '<label for="objectif_respecte_' . $objectif['id_objectif'] . '"> Objectif Respecté </label>';
                echo '<input type="radio" id="objectif_respecte_' . $objectif['id_objectif'] . '" name="objectifs[' . $objectif['id_objectif'] . ']" value="respecte" ' . ($objectif['Note'] === 'respecte' ? 'checked' : '') . '> || ';
                
                echo '<label for="objectif_en_cours_' . $objectif['id_objectif'] . '"> En Cours </label>';
                echo '<input type="radio" id="objectif_en_cours_' . $objectif['id_objectif'] . '" name="objectifs[' . $objectif['id_objectif'] . ']" value="en_cours" ' . ($objectif['Note'] === 'en_cours' ? 'checked' : '') . '>';
                
                echo '</td>';
                echo '</tr>';
            }
            echo '</table>';
            echo '<button type="submit" name="submit" class="btn btn-outline-info">Enregistrer</button>';
            echo ' <button type="button" class="btn btn-outline-secondary" onclick="goBack()">Retour</button>';
            echo '</form>';
        } else {
            echo '<p>Aucun objectif trouvé.</p>';
        }
        ?>
    </div>
    <script>
    function goBack() {
        window.history.back();
    }
</script>
</body>
</html>
