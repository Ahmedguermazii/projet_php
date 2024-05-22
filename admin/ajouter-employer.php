<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include 'config.php';
require 'vendor/autoload.php';

try {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $Nom = $_POST["Nom"];
        $Prenom = $_POST["Prenom"];
        $Adress = $_POST["Adress"];
        $Numtel = $_POST["Numtel"];
        $Email = $_POST["Email"];
        $Motspasse = $_POST["Motspasse"];
        $Post = $_POST["Post"];
        $Coddir = $_POST["Coddir"];
        $Codcin = $_POST["Codcin"];
        $Type = $_POST["type"];

        $checkIdQuery = "SELECT COUNT(*) FROM employeur WHERE Id = :Id";
        $checkIdStatement = $connexion->prepare($checkIdQuery);
        $checkIdStatement->bindParam(':Id', $Id);
        $checkIdStatement->execute();
        $idCount = $checkIdStatement->fetchColumn();

        if ($idCount > 0) {
            echo "Erreur : L'ID existe déjà dans la base de données.";
        } else {
            $Image = '';

            if (isset($_FILES['Image']) && $_FILES['Image']['error'] == 0) {
                $uploadDir = 'assets/img/testimonials/';
                $uploadPath = $uploadDir . basename($_FILES['Image']['name']);

                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                if (move_uploaded_file($_FILES['Image']['tmp_name'], $uploadPath)) {
                    $Image = basename($_FILES['Image']['name']);
                } else {
                    echo "Erreur lors du téléchargement du fichier.";
                }
            }

          if (!empty($Coddir)) {
            $insertQuery = "INSERT INTO employeur (Nom, Prenom, Adress, Numtel, Email, Codcin, Coddir, Post, Motspasse, Image, Type)
                            VALUES (:Nom, :Prenom, :Adress, :Numtel, :Email, :Codcin, :Coddir, :Post, :Motspasse, :Image, :Type)";
        } else {
            $insertQuery = "INSERT INTO employeur (Nom, Prenom, Adress, Numtel, Email, Codcin, Post, Motspasse, Image, Type)
                            VALUES (:Nom, :Prenom, :Adress, :Numtel, :Email, :Codcin, :Post, :Motspasse, :Image, :Type)";
        }

            $insertStatement = $connexion->prepare($insertQuery);
            $insertStatement->bindParam(':Nom', $Nom);
            $insertStatement->bindParam(':Prenom', $Prenom);
            $insertStatement->bindParam(':Adress', $Adress);
            $insertStatement->bindParam(':Numtel', $Numtel);
            $insertStatement->bindParam(':Email', $Email);
            $insertStatement->bindParam(':Codcin', $Codcin);

            if (!empty($Coddir)) {
                $insertStatement->bindParam(':Coddir', $Coddir);
            }

            $insertStatement->bindParam(':Post', $Post);
            $insertStatement->bindParam(':Motspasse', $Motspasse);
            $insertStatement->bindParam(':Image', $Image);
            $insertStatement->bindParam(':Type', $Type);

            if ($insertStatement->execute()) {
                $mail = new PHPMailer(true);

                try {
                    $mail->isSMTP();
                    $mail->Host       = 'smtp.gmail.com';
                    $mail->SMTPAuth   = true;
                    $mail->Username   = 'usermyb@gmail.com';
                    $mail->Password   = 'ylmk rkmw ckvj aqwv';
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                    $mail->Port       = 587;

                    $mail->setFrom('usermyb@gmail.com', 'ahmed guermazi');
                    $mail->addAddress($Email, $Nom . ' ' . $Prenom);

                    $mail->isHTML(true);
                    $mail->Subject = 'Informations d\'inscription';
                    $mail->Body    = 'Votre adresse email est : ' . $Email . '<br>Votre mot de passe est : ' . $Motspasse;

                    $mail->send();
                    header("Location: listdemp.php");
                } catch (Exception $e) {
                    echo 'Erreur lors de l\'envoi de l\'email : ', $mail->ErrorInfo;
                }
            } else {
                echo "Erreur lors de l'ajout de l'employé : " . $insertStatement->errorInfo()[2];
            }
        }
    }
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>
