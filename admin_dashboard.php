<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['prof_id'])) {
    header("Location: index.php");
    exit();
}

$sql = "SELECT nom, classe, filiere, ue, date, heure_arrivee, heure_depart, duree FROM emargement";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>Contrôle Administration - Filtrer par UE (JS)</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
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


<body class="container mt-4">

<h2>👨‍💼 Tableau de bord Administration</h2>

<label for="ueFilter" class="form-label">Filtrer par UE :</label>
<select id="ueFilter" class="form-select w-50 mb-3">
    <option selected disabled value="">Choisissez une UE</option>
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

<table id="tableauEmargement" class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>Nom</th>
            <th>Classe</th>
            <th>Filière</th>
            <th>UE</th>
            <th>Date</th>
            <th>Heure arrivée</th>
            <th>Heure départ</th>
            <th>Durée</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['nom']) ?></td>
                    <td><?= htmlspecialchars($row['classe']) ?></td>
                    <td><?= htmlspecialchars($row['filiere']) ?></td>
                    <td><?= htmlspecialchars($row['ue']) ?></td>
                    <td><?= htmlspecialchars($row['date']) ?></td>
                    <td><?= htmlspecialchars($row['heure_arrivee']) ?></td>
                    <td><?= htmlspecialchars($row['heure_depart'] ?? '-') ?></td>
                    <td><?= htmlspecialchars($row['duree'] ?? '-') ?></td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="8" class="text-center">Aucun enregistrement trouvé.</td></tr>
        <?php endif; ?>
    </tbody>
</table>

<script>
// Filtrage sur colonne UE (index 3)
document.getElementById('ueFilter').addEventListener('change', function() {
    const filtre = this.value.toLowerCase();
    const table = document.getElementById('tableauEmargement');
    const lignes = table.tBodies[0].rows;

    for (let i = 0; i < lignes.length; i++) {
        const ueCell = lignes[i].cells[3].textContent.toLowerCase();
        if (filtre === "" || ueCell === filtre) {
            lignes[i].style.display = "";
        } else {
            lignes[i].style.display = "none";
        }
    }
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
