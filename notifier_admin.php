<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $prof_id = $_POST['prof_id'] ?? null;
    $ue = $_POST['ue'] ?? null;

    if ($prof_id && $ue) {
        // Récupérer le nom du professeur pour affichage dans le message
        $stmt = $conn->prepare("SELECT nom FROM professeurs WHERE id = ?");
        $stmt->bind_param("i", $prof_id);
        $stmt->execute();
        $prof_result = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        $nom_prof = $prof_result['nom'] ?? "Inconnu";

        $contenu = "Le professeur $nom_prof (ID $prof_id) a atteint ou approche son quota pour l’UE : $ue.";

        // Insérer le message dans la table messages
        $stmt = $conn->prepare("INSERT INTO messages (professeur_id, ue, contenu) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $prof_id, $ue, $contenu);
        $stmt->execute();
        $stmt->close();

        // Rediriger vers une page (ex : liste des messages) après insertion
        header("Location: messages.php");
        exit();
    } else {
        echo "Données manquantes pour notifier l'administration.";
    }
} else {
    echo "Méthode non autorisée.";
}
?>
