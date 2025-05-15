<?php
session_start();
require_once 'config.php';

// Définir explicitement le fuseau horaire
date_default_timezone_set('Africa/Lome');

if (!isset($_SESSION['prof_id'])) {
    header("Location: index.php");
    exit();
}

$message = "";
$prof_id = $_SESSION['prof_id'];
$nom = $_SESSION['nom'] ?? $_SESSION['email']; // Utiliser le nom s’il est défini sinon email

// --- ARRIVÉE ---
if (isset($_POST['btn_arrivee'])) {
    $classe = $_POST['classe'];
    $ue = $_POST['ue'];
    $filiere = $_POST['filiere'];
    $heure_arrivee = date("H:i:s"); // Heure actuelle selon le fuseau horaire défini
    $date = date("Y-m-d");

    $stmt = $conn->prepare("INSERT INTO emargement (professeur_id, nom, classe, ue, filiere, heure_arrivee, date) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issssss", $prof_id, $nom, $classe, $ue, $filiere, $heure_arrivee, $date);

    if ($stmt->execute()) {
        $message = "✅ Heure d'arrivée enregistrée à $heure_arrivee.";
    } else {
        $message = "❌ Erreur arrivée : " . $stmt->error;
    }
    $stmt->close();
}

// --- DÉPART ---
$heure_depart = "";
$duree = "";
if (isset($_POST['btn_depart'])) {
    $heure_depart = date("H:i:s");

    $stmt = $conn->prepare("SELECT id, heure_arrivee FROM emargement 
        WHERE professeur_id = ? AND date = CURDATE() AND heure_depart IS NULL 
        ORDER BY id DESC LIMIT 1");
    $stmt->bind_param("i", $prof_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    $stmt->close();

    if ($data) {
        $id_emargement = $data['id'];
        $heure_arrivee = $data['heure_arrivee'];
        $diff = strtotime($heure_depart) - strtotime($heure_arrivee);
        if ($diff < 0) $diff = 0; // éviter durée négative si erreur d'heure
        $duree = gmdate("H:i:s", $diff);

        $stmt = $conn->prepare("UPDATE emargement SET heure_depart = ?, duree = ? WHERE id = ?");
        $stmt->bind_param("ssi", $heure_depart, $duree, $id_emargement);

        if ($stmt->execute()) {
            $message = "✅ Départ enregistré à $heure_depart. Durée : $duree.";
        } else {
            $message = "❌ Erreur départ : " . $stmt->error;
        }
        $stmt->close();
    } else {
        $message = "⚠️ Aucun enregistrement d'arrivée trouvé ou déjà clôturé.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>Émargement Prof</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        .box {
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 20px;
            height: 100%;
        }
        .readonly-input {
            background-color: #e9ecef;
        }
    </style>
</head>
<body class="container mt-5">

<!-- Navbar -->
<div class="container mt-2">
  <div class="card shadow-sm border rounded-4">
    <div class="card-body p-3">
      <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
          <a class="navbar-brand fw-bold text-primary" href="dashboard.php">📘 Émargement Prof</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
          </button>

          <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item"><a class="nav-link" href="dashboard.php">🏠 Tableau de bord</a></li>
              <li class="nav-item"><a class="nav-link active" aria-current="page" href="emargement.php">📝 Émargement</a></li>
              <li class="nav-item"><a class="nav-link" href="quota_notification.php">📊 Quotas</a></li>
              <li class="nav-item"><a class="nav-link" href="admin_dashboard.php">👨‍💼 Administration</a></li>
              <li class="nav-item"><a class="nav-link" href="messages.php">📨 Messages</a></li>
            </ul>
            <span class="navbar-text">
              <a href="index.php" class="btn btn-outline-danger btn-sm">🔒 Déconnexion</a>
            </span>
          </div>
        </div>
      </nav>
    </div>
  </div>
</div>

<h2 class="mb-4">📋 Émargement Professeur</h2>
<?php if (!empty($message)) : ?>
    <div class="alert alert-info"><?= htmlspecialchars($message) ?></div>
<?php endif; ?>

<div class="row">
    <!-- Bloc ARRIVÉE -->
    <div class="col-md-6">
        <div class="box bg-light">
            <h4 class="mb-3">🟢 Formulaire d'Arrivée</h4>
            <form method="post">
                <div class="mb-2">
                    <label class="form-label">Nom</label>
                    <input type="text" class="form-control readonly-input" value="<?= htmlspecialchars($nom) ?>" readonly>
                </div>
                <div class="mb-2">
                    <label class="form-label">Date</label>
                    <input type="text" class="form-control readonly-input" value="<?= date("Y-m-d") ?>" readonly>
                </div>
                <div class="mb-2">
                    <label class="form-label">Heure d'arrivée</label>
                    <input type="text" class="form-control readonly-input" value="<?= date("H:i:s") ?>" readonly>
                </div>

                <div class="mb-2">
                    <label for="classe" class="form-label">Classe</label>
                    <select class="form-select" name="classe" id="classe" required>
                        <option selected disabled>Choisissez une classe</option>
                        <option value="L1">L1</option>
                        <option value="L2">L2</option>
                        <option value="L3">L3</option>
                        <option value="M1">M1</option>
                        <option value="M2">M2</option>
                    </select>
                </div>

                <div class="mb-2">
                    <label for="ue" class="form-label">UE</label>
                    <select class="form-select" name="ue" id="ue" required>
                        <option selected disabled>Choisissez une UE</option>
                        <option value="ALGORITHME">ALGORITHME</option>
                        <option value="RESEAUX MIKROTIK">RESEAUX MIKROTIK</option>
                        <option value="INFOGRAPHIE">INFOGRAPHIE</option>
                        <option value="INITIATION SI">INITIATION SI</option>
                        <option value="STRUCTURE DE DONNEE">STRUCTURE DE DONNEE</option>
                        <option value="BASES DE DONNEES">BASES DE DONNEES</option>
                        <option value="SYSTEMES D’EXPLOITATION">SYSTEMES D’EXPLOITATION</option>
                        <option value="GENIE LOGICIEL">GENIE LOGICIEL</option>
                        <option value="MATHÉMATIQUES">MATHÉMATIQUES</option>
                        <option value="PHYSIQUE">PHYSIQUE</option>
                    </select>
                </div>

                <div class="mb-2">
                    <label for="filiere" class="form-label">Filière</label>
                    <select class="form-select" name="filiere" id="filiere" required>
                        <option selected disabled>Choisissez une filière</option>
                        <option value="Informatique">Informatique</option>
                        <option value="Génie Civil">Génie Civil</option>
                        <option value="Génie Électrique">Génie Électrique</option>
                        <option value="Génie Mécanique">Génie Mécanique</option>
                        <option value="Télécommunications">Télécommunications</option>
                        <option value="Réseaux Informatiques">Réseaux Informatiques</option>
                        <option value="MIAGE">MIAGE</option>
                        <option value="Mathématiques">Mathématiques
</option> </select> </div>
            <button type="submit" name="btn_arrivee" class="btn btn-success mt-3">Enregistrer l'arrivée</button>
        </form>
    </div>
</div>

<!-- Bloc DÉPART -->
<div class="col-md-6">
    <div class="box bg-light">
        <h4 class="mb-3">🔴 Formulaire de Départ</h4>
        <form method="post">
            <div class="mb-2">
                <label class="form-label">Nom</label>
                <input type="text" class="form-control readonly-input" value="<?= htmlspecialchars($nom) ?>" readonly>
            </div>
            <div class="mb-2">
                <label class="form-label">Date</label>
                <input type="text" class="form-control readonly-input" value="<?= date("Y-m-d") ?>" readonly>
            </div>
            <div class="mb-2">
                <label class="form-label">Heure de départ</label>
                <input type="text" class="form-control readonly-input" value="<?= date("H:i:s") ?>" readonly>
            </div>
            <button type="submit" name="btn_depart" class="btn btn-danger mt-3">Enregistrer le départ</button>
        </form>
    </div>
</div>
</div> <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> </body> </html> ```