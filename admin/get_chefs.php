<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "stage";

try {
    $connexion = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $fetchChefsQuery = "SELECT Id, Nom, Prenom FROM employeur WHERE Type = 'C'";
    $fetchChefsStatement = $connexion->prepare($fetchChefsQuery);
    $fetchChefsStatement->execute();
    $chefs = $fetchChefsStatement->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($chefs);
} catch (PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
}
?>
