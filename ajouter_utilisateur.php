<?php
// Connexion à la base de données
require_once 'config.php'; // Connexion à la base de données

// Nom, email et mot de passe de l'utilisateur
$nom = 'jo'; // Remplacer par le nom réel
$email = 'jo@gmail.com'; // Remplacer par l'email réel
$mot_de_passe = '1234'; // Remplacer par le mot de passe réel

// Hachage du mot de passe avec bcrypt
$mot_de_passe_hache = password_hash($mot_de_passe, PASSWORD_BCRYPT);

// Insertion dans la base de données
$sql = "INSERT INTO professeurs (nom, email, mot_de_passe) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql); // Préparation de la requête
$stmt->bind_param("sss", $nom, $email, $mot_de_passe_hache); // Lier les paramètres à la requête

if ($stmt->execute()) {
    echo "Utilisateur ajouté avec succès!"; // Message de succès
} else {
    echo "Erreur lors de l'ajout de l'utilisateur : " . $stmt->error; // Message d'erreur en cas de problème
}

$stmt->close(); // Fermer la requête préparée
$conn->close(); // Fermer la connexion à la base de données
?>
