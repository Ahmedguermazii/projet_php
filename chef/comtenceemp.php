<?php
require 'connexion.php';
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['competence']) && is_array($_POST['competence'])) {
        $competences = $_POST['competence'];
        if (isset($_SESSION['id'])) {
            $employeur_id = $_SESSION['id'];

            try {
                foreach ($competences as $competence_id => $etat) {
                    $checkStatement = $pdo->prepare("SELECT COUNT(*) FROM notecompetences WHERE employeur_id = ? AND competence_id = ?");
                    $checkStatement->execute([$employeur_id, $competence_id]);
                    $count = $checkStatement->fetchColumn();

                    if ($count > 0) {
                        $updateStatement = $pdo->prepare("UPDATE notecompetences SET etat = ? WHERE employeur_id = ? AND competence_id = ?");
                        $updateStatement->execute([$etat, $employeur_id, $competence_id]);
                    } else {
                        $insertStatement = $pdo->prepare("INSERT INTO notecompetences (employeur_id, competence_id, etat) VALUES (?, ?, ?)");
                        $insertStatement->execute([$employeur_id, $competence_id, $etat]);
                    }
                }

                header("Location: confirmation.php");
                exit();
            } catch (PDOException $e) {
                echo "Erreur lors de la mise à jour des compétences : " . $e->getMessage();
            }
        } else {
            echo "ID de l'employeur manquant dans la session.";
        }
    } else {
        echo "Aucune donnée de compétence soumise.";
    }
} else {
    echo "Requête invalide.";
}

?>


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
        <li><a href="comtenceemp.php" class="nav-link scrollto active"><i class="bi bi-clipboard"></i> <span>list de comepetences</span></a></li>
        <li><a href="objectif.php" class="nav-link scrollto "><i class="bi bi-calendar-fill"></i> <span>list des objectifs</span></a></li>
        <li><a href="deconnexion.php" class="nav-link scrollto "><i class="bi bi-box-arrow-left"></i> <span>Deconexion</span></a></li>
  
    </ul>
</header>
    <div class="container">
        <h2>Tableau de Compétences</h2>
        <h5>Remplir toutes les zones</h5>

        <div class="form-container">
            <form action="#" method="post">
                <table class="table table-striped tablec" border="1">
                    <thead>
                        <tr>
                            <th class="table-header">Compétence</th>
                            <th class="table-header">Compétence maîtrisée</th>
                            <th class="table-header">Compétence à développer</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = $pdo->query("SELECT * FROM comptences");
                        $competences_list = $query->fetchAll(PDO::FETCH_ASSOC);

                        if (isset($_SESSION['id'])) {
                            $employeur_id = $_SESSION['id'];
                    
                            $existingCompetencesQuery = $pdo->prepare("SELECT competence_id, etat FROM notecompetences WHERE employeur_id = ?");
                            $existingCompetencesQuery->execute([$employeur_id]);
                            $existingCompetences = $existingCompetencesQuery->fetchAll(PDO::FETCH_ASSOC);
                    
                            $existingCompetencesMap = [];
                            foreach ($existingCompetences as $row) {
                                $existingCompetencesMap[$row['competence_id']] = $row['etat'];
                            }
                        }
                        foreach ($competences_list as $competence) {
                            echo "<tr>";
                            echo "<td class='table-cell'>" . $competence['typecomptence'] . "</td>";
                    
                            $maitriseeChecked = (isset($existingCompetencesMap[$competence['Idcomp']]) && $existingCompetencesMap[$competence['Idcomp']] === 'Maitrisee') ? 'checked' : '';
                            $developperChecked = (isset($existingCompetencesMap[$competence['Idcomp']]) && $existingCompetencesMap[$competence['Idcomp']] === 'A developper') ? 'checked' : '';
                    
                            echo "<td class='table-cell'><input type='radio' name='competence[" . $competence['Idcomp'] . "]' value='Maitrisee' $maitriseeChecked></td>";
                            echo "<td class='table-cell'><input type='radio' name='competence[" . $competence['Idcomp'] . "]' value='A developper' $developperChecked></td>";
                            echo "</tr>";
                        }
                        ?>
                        
                    </tbody>
                </table>

                <button type="submit" class="btn btn-outline-success" value="Enregistre">Enregistrer</button>
                <button type="button" class="btn btn-outline-secondary" onclick="resetForm()">Effacer</button>
            </form>
        </div>
    </div>

    <script>
        function resetForm() {
            document.querySelectorAll('input[type="radio"]').forEach(input => input.checked = false);
        }
    </script>
</body>

</html>
