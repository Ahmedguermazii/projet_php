
<?php
// Connexion à la base de données (à adapter selon votre configuration)
require 'connexion.php'; // Assurez-vous d'ajuster le chemin vers le fichier de connexion

// Fonction pour afficher les compétences
function afficherComptences($pdo) {
    $query = $pdo->prepare("SELECT * FROM comptences");
    $query->execute();
    return $query->fetchAll(PDO::FETCH_ASSOC);
}

// Ajouter une compétence
if(isset($_POST['ajouter'])) {
    $typecomptence = $_POST['typecomptence'];
    $query = $pdo->prepare("INSERT INTO comptences (typecomptence) VALUES (:typecomptence)");
    $query->bindParam(':typecomptence', $typecomptence);
    $query->execute();
}


// Supprimer une compétence
if(isset($_GET['supprimer'])) {
    $id = $_GET['supprimer'];
    $query = $pdo->prepare("DELETE FROM comptences WHERE Idcomp = :id");
    $query->bindParam(':id', $id);
    $query->execute();
}

// Modifier une compétence
if(isset($_POST['modifier'])) {
    $id = $_POST['id'];
    $typecomptence = $_POST['typecomptence'];
    $query = $pdo->prepare("UPDATE comptences SET typecomptence = :typecomptence WHERE Idcomp = :id");
    $query->bindParam(':typecomptence', $typecomptence);
    $query->bindParam(':id', $id);
    $query->execute();
}

// Afficher les compétences
$comptences = afficherComptences($pdo);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Compétences</title>
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
            margin-top: 50px;
        }

        .tablec {
            width: 1000px;
            margin: 0 auto;
        }

        .form-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 20px;
        }

        .form-container input {
            width: 70%;
        }
    </style>
</head>
<body class="d-flex justify-content-center align-items-center">
    <header id="header" class="d-flex flex-column justify-content-center">
        <nav id="navbar" class="navbar nav-menu">
            <ul>
                <li><a href="index.html" class="nav-link scrollto "><i class="bx bx-home"></i> <span>Home</span></a></li>
                <li><a href="listdemp.php" class="nav-link scrollto "><i class="bi bi-card-list"></i> <span>List</span></a></li>
                <li><a href="ajouter_employe.html" class="nav-link scrollto "><i class="bi bi-person-fill-add"></i> <span>Ajouter</span></a></li>
                <li><a href="comptence.php" class="nav-link scrollto active "><i class="bi bi-clipboard"></i> <span>list de comepetences</span></a></li>
                <li><a href="deconnexion.php" class="nav-link scrollto "><i class="bi bi-box-arrow-left"></i> <span>Deconexion</span></a></li>

            </ul>
        </nav>
    </header>

    <div class="container">
        <h2>Liste des Compétences</h2>

        <table class="table table-striped tablec" border="1">
            <tr>
                <th class="table-header">ID</th>
                <th class="table-header">Type de Compétence</th>
                <th class="table-header">Action</th>
            </tr>

            <?php foreach ($comptences as $comptence): ?>
                <tr>
                    <td class="table-cell"><?php echo $comptence['Idcomp']; ?></td>
                    <td class="table-cell"><?php echo $comptence['typecomptence']; ?></td>
                    <td class="table-cell">
                        <a href="?supprimer=<?php echo $comptence['Idcomp']; ?>" class="btn btn-outline-danger">Supprimer</a>
                        <a href="#" onclick="modifierComptence(<?php echo $comptence['Idcomp']; ?>, '<?php echo $comptence['typecomptence']; ?>')" class="btn btn-outline-info">Modifier</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table><br>

            <h3>Ajouter une compétence</h3>
            <form method="post">
                <input type="text" name="typecomptence" placeholder="Nouveau Type de Compétence" required class="form-control tablec">
                <button type="submit" name="ajouter" class="btn btn-outline-success">Ajouter</button>
            </form>
        

            <div id="modal" style="display: none;"><br>
    <h3>Modifier la compétence</h3>
    <form method="post">
        <input type="hidden" id="editId" name="id" value="">
        <input type="text" id="editTypeComptence" name="typecomptence" placeholder="Modifier le Type de Compétence" required class="form-control tablec">
        <button type="submit" name="modifier" class="btn btn-outline-primary">Enregistrer la modification</button>
        <button type="button" onclick="fermerModal()" class="btn btn-outline-secondary">Fermer</button>
    </form>
</div>

    </div>

    <script>
        function modifierComptence(id, typecomptence) {
            document.getElementById('editId').value = id;
            document.getElementById('editTypeComptence').value = typecomptence;
            document.getElementById('modal').style.display = 'block';
        }

        function fermerModal() {
            document.getElementById('modal').style.display = 'none';
        }
    </script>
</body>
</html>

