<?php
require 'connexion.php';
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['envoyer_note'])) {
    foreach ($_POST as $key => $value) {
        if (strpos($key, 'note_') !== false) {
            $objectif_id = str_replace('note_', '', $key);
            $note_value = $value;
            try {
                $updateStatement = $pdo->prepare("UPDATE objectif SET Note = :note WHERE Id = :id");
                $updateStatement->execute([':note' => $note_value, ':id' => $objectif_id]);
            } catch (PDOException $e) {
                echo "Erreur lors de la mise à jour de la note : " . $e->getMessage();
            }
        }
    }
    header("Location: competances.php");
    exit();
} else {
    echo "Requête invalide.";
}
?>
