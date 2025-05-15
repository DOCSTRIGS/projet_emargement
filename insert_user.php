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
