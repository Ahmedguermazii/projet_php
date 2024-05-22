<?php
if(isset($_GET['employeur_id'])) {
    $employeur_id = $_GET['employeur_id'];

    // Inclure le fichier de connexion à la base de données
    require 'connexion.php';

    // Traitement de l'ajout, de la modification et de la suppression d'un objectif
    if(isset($_POST['ajouter_objectif'])) {
        $nouvel_objectif = $_POST['nouvel_objectif'];

        // Effectuer l'insertion dans la base de données
        try {
            $statement = $pdo->prepare("INSERT INTO objectif (Id, Nomobjectif) VALUES (?, ?)");
            $statement->execute([$employeur_id, $nouvel_objectif]);
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
    }

    

    if(isset($_GET['supprimer_objectif'])) {
        $nom_objectif = urldecode($_GET['supprimer_objectif']);
    
        try {
            $statement = $pdo->prepare("DELETE FROM objectif WHERE Id = ? AND Nomobjectif = ?");
            $statement->execute([$employeur_id, $nom_objectif]);
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
    }

    // Récupérer et afficher les objectifs associés à cet employeur
    try {
        $statement = $pdo->prepare("SELECT * FROM objectif WHERE Id = ?");
        $statement->execute([$employeur_id]);
        $objectifs = $statement->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
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
    .container {
            text-align: center;
            margin-top: 120px;
        }

        .tablec {
            width: 1000px;
            margin: 0 auto;
        }

        .form-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 120px;
        }

        .form-container input {
            width: 70%;
        }
        </style>

</head>
<body>
    <header id="header" class="d-flex flex-column justify-content-center">
        <nav id="navbar" class="navbar nav-menu">
            <ul>
                <li><a href="index.html" class="nav-link scrollto "><i class="bx bx-home"></i> <span>Home</span></a></li>
                <li><a href="listdemp.php" class="nav-link scrollto "><i class="bi bi-card-list"></i> <span>List</span></a></li>
                <li><a href="ajouter_employe.html" class="nav-link scrollto "><i class="bi bi-person-fill-add"></i> <span>Ajouter</span></a></li>
                <li><a href="comptence.php" class="nav-link scrollto "><i class="bi bi-clipboard"></i> <span>list de comepetences</span></a></li>
                <li><a href="objectif.php" class="nav-link scrollto active"><i class="bi bi-calendar-fill"></i> <span>list des objectifs</span></a></li>
                <li><a href="" class="nav-link scrollto "><i class="bi bi-box-arrow-left"></i> <span>Deconexion</span></a></li>

            </ul>
        </nav>
    </header>

    <div class="container text-center"> <!-- Ajout de la classe text-center pour centrer -->
        <?php
        // Afficher les objectifs dans un tableau
        if(isset($objectifs) && count($objectifs) > 0) {
            echo '<h1>Objectif</h1>';
            echo '<table class="table table-striped">';
            echo '<tr><th>Nom de l\'Objectif</th><th>Action</th></tr>';
            foreach ($objectifs as $objectif) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($objectif['Nomobjectif']) . '</td>';
                echo '<td>';
                echo ' | ';
                echo '<a href="objectif.php?employeur_id=' . $employeur_id . '&supprimer_objectif=' . urlencode($objectif['Nomobjectif']) . '" class="btn btn-outline-danger">Supprimer</a>';
                echo '</td>';                
                echo '</tr>';
            }
            echo '</table>';
        } else {
            echo '<p>Aucun objectif trouvé.</p>';
        }
        ?>
    </div>



    <!-- Ajouter un nouvel objectif -->
    <div class="container text-center"> <!-- Ajout de la classe text-center pour centrer -->
    <h1>Ajouter un nouvel objectif</h1>
    <form method="post" action="objectif.php?employeur_id=<?php echo $employeur_id; ?>">
        <label for="nouvel_objectif">Nouvel Objectif :</label>
        <input type="text" name="nouvel_objectif" required>
        <button type="submit" name="ajouter_objectif" class="btn btn-outline-info">Ajouter</button>
        <a href="detatil.php?employeur_id=<?php echo $employeur_id; ?>" class="btn btn-outline-secondary">Retour</a>
    </form>
</div>


    <!-- Liens vers les fichiers CSS/JS -->
    <!-- Ajoutez vos liens vers les fichiers CSS/JS ici -->

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

 
</body>
</html>