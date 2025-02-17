<?php
// Informations de connexion à la bdd définis
$host = "localhost";
$dbname= "cks_db";
$username = "root";
$password = "";

// Méthode de connexion à la BDD
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (PDOException $e) {
    error_log("Erreur de connexion MySQL : " . $e->getMessage()); // Enregistre l'erreur dans le journal système
    exit("Une erreur est survenue. Veuillez réessayer plus tard."); // Message générique pour ne pas exposer des infos sensibles
}