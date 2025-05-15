<?php
$host = 'localhost';   // Hôte de la base de données
$user = 'root';        // Utilisateur de la base de données
$password = '';        // Mot de passe de l'utilisateur (vide pour MySQL local par défaut)
$dbname = 'emargement'; // Nom de la base de données

// Connexion à la base de données
$conn = new mysqli($host, $user, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die("Connexion échouée: " . $conn->connect_error);
}
?>
