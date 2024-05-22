<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier l'Employeur</title>
    <!-- Add Bootstrap CSS -->
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
</head>
<body>
<header id="header" class="d-flex flex-column justify-content-center">
    <nav id="navbar" class="navbar nav-menu">
    <ul>
            <li><a href="index.html" class="nav-link scrollto "><i class="bx bx-home"></i> <span>Home</span></a></li>
            <li><a href="listdemp.php" class="nav-link scrollto "><i class="bi bi-card-list"></i> <span>List</span></a></li>
            <li><a  class="nav-link scrollto active"><i class="bx bx-user"></i> <span>Profil</span></a></li>
            <li><a href="ajouter_employe.html" class="nav-link scrollto "><i class="bi bi-person-fill-add"></i> <span>Ajouter</span></a></li>
            <li><a href="comptence.php" class="nav-link scrollto "><i class="bi bi-clipboard"></i> <span>list de comepetences</span></a></li>
            <li><a href="deconnexion.php" class="nav-link scrollto "><i class="bi bi-box-arrow-left"></i> <span>Deconexion</span></a></li>

        </ul>
    </nav>
</header>
<?php
// Assurez-vous d'inclure votre logique de connexion ici si ce n'est pas déjà fait.
require 'connexion.php';

function getLabel($key) {
    // Fonction pour obtenir des labels personnalisés
    $labels = array(
        'Nom' => 'Nom',
        'Prenom' => 'Prénom',
        'Adress' => 'Adresse',
        'Numtel' => 'Numéro de téléphone',
        'Email' => 'Email',
        'Post' => 'Poste de travail',
        'Motspasse' => 'Mot de passe',
        'Codcin' => 'Code CIN',
        'Type' => 'Type',
        'Image' => 'Image',
        'Coddir' => 'Son chef'
    );

    return isset($labels[$key]) ? $labels[$key] : ucfirst($key);
}

// Récupérez l'ID de l'employeur depuis l'URL
if (isset($_GET['employeur_id'])) {
    $employeur_id = $_GET['employeur_id'];

    // Récupérez les détails de l'employeur depuis la base de données
    try {
        $statement = $pdo->prepare("SELECT * FROM employeur WHERE Id = ?");
        $statement->execute([$employeur_id]);
        $employeur = $statement->fetch(PDO::FETCH_ASSOC);

        // Affichez le formulaire de modification avec les données pré-remplies
        echo '<div class="p-100 mb-1000 bg-light text-dark">';
        echo '    <div class="container py-4 px-3 mx-auto">';
        echo '        <div class="row justify-content-center">';
        echo '            <div class="col-lg-5">';
        echo '                <div class="card">';
        echo '                    <div class="card-body">';
        echo '                        <h5 class="card-title text-center">Mettre à jour les informations </h5>';
        echo '                        <div class="container mt-8">';
        echo '                            <form action="enregistemod.php" method="post" enctype="multipart/form-data" class="text-center">';
        echo '                                <input type="hidden" name="employeur_id" value="' . $employeur['Id'] . '">';

        // Ajoutez des champs pour toutes les colonnes de la table employeur
        foreach ($employeur as $key => $value) {
            if ($key !== 'Id') {
                echo '                                <div class="form-group">';
                echo '                                    <label for="' . $key . '">' . getLabel($key) . ' :</label>';
                
                // Si le champ est 'Image', utilisez un input de type 'file'
                if ($key === 'Image') {
                    echo '                                    <input type="file" class="form-control" name="' . $key . '">';
                } elseif ($key === 'Type') {
                    // Si le champ est 'Type', utilisez un select dropdown
                    echo '                                    <select class="form-control" required name="' . $key . '">';
                    echo '                                        <option value="E" ' . ($value === 'E' ? 'selected' : '') . '>Employeur</option>';
                    echo '                                        <option value="C" ' . ($value === 'C' ? 'selected' : '') . '>Chef</option>';
                    echo '                                    </select>';
                } else {
                    // Si le champ est 'Coddir' et sa valeur est null ou 0, laissez le champ vide
                    if ($key === 'Coddir' && ($value === null || $value === '0' || $employeur['Type'] !== 'E')) {
                        echo '                                    <input type="text" class="form-control" name="' . $key . '" value=" Admin">';
                    } else {
                        echo '                                    <input type="text" class="form-control" name="' . $key . '" value="' . $value . '">';
                    }
                }
                
                echo '                                </div>';
            }
        }

        echo '                                <div class="form-group">';
        echo '                                    <button type="button" class="btn btn-outline-secondary" onclick="goBack()">Retour</button>';
        echo '                                    <button type="submit" class="btn btn-outline-success">Enregistrer la modification</button>';
        echo '                                </div>';
        echo '                            </form>';
        echo '                        </div>';
        echo '                    </div>';
        echo '                </div>';
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

<script>
    function goBack() {
        window.history.back();
    }
</script>

</body>
</html>
