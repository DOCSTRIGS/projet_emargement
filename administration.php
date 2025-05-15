<?php
session_start();
require_once 'config.php';

// Vérifie que l'utilisateur est admin (ajuste si besoin)
if (!isset($_SESSION['admin'])) {
    header("Location: index.php");
    exit();
}

// Récupération de la filière sélectionnée
$filiere_filtre = isset($_GET['filiere']) ? $_GET['filiere'] : "";

// Récupération des filières disponibles dans la base
$filiere_result = $conn->query("SELECT DISTINCT filiere FROM emargement ORDER BY filiere");

// Construction de la requête SQL principale avec ou sans filtre
$sql = "SELECT p.nom, e.classe, e.filiere, e.ue, e.date, e.heure_arrivee, e.heure_depart, e.duree
        FROM emargement e
        JOIN professeur p ON e.professeur_id = p.id";

if (!empty($filiere_filtre)) {
    $sql .= " WHERE e.filiere = ?";
}
$sql .= " ORDER BY e.date DESC";

$stmt = $conn->prepare($sql);

if (!empty($filiere_filtre)) {
    $stmt->bind_param("s", $filiere_filtre);
}

$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Suivi des Émargements par Filière</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<!-- navbar.php -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- navbar.php -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- navbar.php -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

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
              <li class="nav-item">
                <a class="nav-link" href="dashboard.php">🏠 Tableau de bord</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="emargement.php">📝 Émargement</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="quota_notification.php">📊 Quotas</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="admin_dashboard.php">👨‍💼 Administration</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="messages.php">📨 Messages</a>
              </li>
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

<body class="container mt-4">
    <h2 class="mb-4">📊 Suivi des Émargements</h2>

    <!-- Sélecteur de filière -->
    <form method="get" class="mb-3">
        <label for="filiere" class="form-label">🔎 Filtrer par filière :</label>
        <select name="filiere" id="filiere" class="form-select" onchange="this.form.submit()">
            <option value="">-- Toutes les filières --</option>
            <?php while ($row = $filiere_result->fetch_assoc()): ?>
                <option value="<?= $row['filiere'] ?>" <?= ($row['filiere'] == $filiere_filtre) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($row['filiere']) ?>
                </option>
            <?php endwhile; ?>
        </select>
    </form>

    <!-- Tableau des résultats -->
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Nom Professeur</th>
                <th>Classe</th>
                <th>Filière</th>
                <th>UE</th>
                <th>Date</th>
                <th>Heure d'Arrivée</th>
                <th>Heure de Départ</th>
                <th>Durée</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['nom']) ?></td>
                        <td><?= htmlspecialchars($row['classe']) ?></td>
                        <td><?= htmlspecialchars($row['filiere']) ?></td>
                        <td><?= htmlspecialchars($row['ue']) ?></td>
                        <td><?= htmlspecialchars($row['date']) ?></td>
                        <td><?= htmlspecialchars($row['heure_arrivee']) ?></td>
                        <td><?= htmlspecialchars($row['heure_depart']) ?></td>
                        <td><?= htmlspecialchars($row['duree']) ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="8" class="text-center">Aucun enregistrement trouvé.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
