<?php
// Connexion à la base de données
require_once 'config.php';

// Tableau des utilisateurs à insérer (nom, email, mot de passe)
$utilisateurs = [
    ["SALAMI", "salami@gmail.com", "salami"],
    ["OGOU", "ogou@gmail.com", "ogou"],
    ["OUYAYI", "ouyayi@gmail.com", "ouyayi"],
    ["BANDAWA", "bandawa@gmail.com", "bandawa"],
    ["OGAH", "ogah@gmail.com", "ogah"],
    ["OBANDJE", "obandje@gmail.com", "obandje"],
    ["SEWAVI", "sewavi@gmail.com", "sewavi"],
    ["INNOCENTS", "innocents@gmail.com", "innocents"],
    ["AYIVI", "ayivi@gmail.com", "ayivi"],
    ["ABOTSI", "abotsi@gmail.com", "abotsi"]
];

// Préparation de la requête
$stmt = $conn->prepare("INSERT INTO professeurs (nom, email, mot_de_passe) VALUES (?, ?, ?)");

if (!$stmt) {
    die("Erreur de préparation : " . $conn->error);
}

// Insertion de chaque utilisateur
foreach ($utilisateurs as $utilisateur) {
    [$nom, $email, $mot_de_passe] = $utilisateur;
    $mot_de_passe_hache = password_hash($mot_de_passe, PASSWORD_DEFAULT);

    $stmt->bind_param("sss", $nom, $email, $mot_de_passe_hache);

    if ($stmt->execute()) {
        echo "✅ Utilisateur $nom ajouté avec succès.<br>";
    } else {
        echo "❌ Erreur pour $nom : " . $stmt->error . "<br>";
    }
}

// Fermeture
$stmt->close();
$conn->close();
?>
















<?php
// Connexion à la base de données
require_once 'config.php'; // Assure-toi que ce fichier existe et contient les informations de connexion

// Données à insérer
$nom = "joseph";
$email = "joseph@gmail.com";
$mot_de_passe = "joseph"; // Mot de passe en clair

// Hachage du mot de passe
$mot_de_passe_hache = password_hash($mot_de_passe, PASSWORD_DEFAULT);

// Requête d'insertion
$stmt = $conn->prepare("INSERT INTO professeurs (nom, email, mot_de_passe) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $nom, $email, $mot_de_passe_hache);

// Exécution de la requête
if ($stmt->execute()) {
    echo "Utilisateur ajouté avec succès !";
} else {
    echo "Erreur : " . $stmt->error;
}

// Fermeture de la connexion
$stmt->close();
$conn->close();
?>
