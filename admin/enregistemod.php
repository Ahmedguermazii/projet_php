<?php
require 'connexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['employeur_id'])) {
    // Récupérez l'ID de l'employeur depuis le formulaire
    $employeur_id = $_POST['employeur_id'];

    // Initialiser un tableau pour stocker les colonnes et leurs valeurs mises à jour
    $update_data = [];

    foreach ($_POST as $key => $value) {
        // Vérifiez si la valeur est une chaîne vide, remplacez-la par NULL
        $value = ($value === '') ? null : $value;

        // Ajoutez la colonne et la valeur au tableau si ce n'est pas l'ID
        if ($key !== 'employeur_id') {
            $update_data[$key] = $value;
        }
    }

    // Gestion du fichier image
    if ($_FILES['Image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'assets/img/testimonials/'; // Remplacez par le chemin approprié
        $uploadFile = $uploadDir . basename($_FILES['Image']['name']);

        // Déplacez le fichier vers le dossier d'upload
        if (move_uploaded_file($_FILES['Image']['tmp_name'], $uploadFile)) {
            $update_data['Image'] = $_FILES['Image']['name'];
        } else {
            echo "Erreur lors du téléchargement du fichier.";
            exit();
        }
    }

    // Utilisez le tableau pour générer la requête SQL
    $columns = implode('=?, ', array_keys($update_data)) . '=?';
    $sql = "UPDATE employeur SET $columns WHERE Id = ?";

    // Ajoutez l'ID à la fin du tableau des valeurs
    $update_data['Id'] = $employeur_id;
    $values = array_values($update_data);

    try {
        // Préparez et exécutez la requête SQL
        $statement = $pdo->prepare($sql);
        $statement->execute($values);

        // Redirigez l'utilisateur après la mise à jour
        header("Location: listdemp.php");
        exit();
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
} else {
    // Si la méthode de requête n'est pas POST ou si l'ID de l'employeur est manquant, redirigez l'utilisateur vers une page d'erreur
    header("Location: erreur.php");
    exit();
}
?>
