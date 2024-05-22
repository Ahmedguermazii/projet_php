<?php
require 'connexion.php';
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}
if (isset($_SESSION['id'])) {
    $employeur_id = $_SESSION['id'];

      header('Location: index.html');
} else {
    header("Location: login.php");
    exit();
}
?>
