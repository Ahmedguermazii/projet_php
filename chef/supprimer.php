<?php
require 'connexion.php';

try {

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Récupérer l'ID de l'employeur à supprimer
        $employeurId = $_POST["employeur_id"];

        // Requête SQL pour supprimer l'employeur en fonction de son ID
        $deleteQuery = "DELETE FROM employeur WHERE Id = :id";
        $deleteStatement = $pdo->prepare($deleteQuery);
        $deleteStatement->bindParam(':id', $employeurId);

        // Exécuter la requête
        if ($deleteStatement->execute()) {
            echo "Employeur supprimé avec succès.";
            // Rediriger vers la page de liste des employeurs après la suppression
            header("Location: listdemp.php");
            exit();
        } else {
            echo "Erreur lors de la suppression de l'employeur : " . $deleteStatement->errorInfo()[2];
        }
    }
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>
