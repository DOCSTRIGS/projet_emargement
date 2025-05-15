<?php
require_once 'config.php';

$selected_ue = $_GET['ue'] ?? null;
$prof_info = null;
$quota_total = 0;
$heures_effectuees = 0;

// Liste des UE depuis la table quotas
$ue_list = [];
$ue_query = $conn->query("SELECT DISTINCT ue FROM quotas");
if ($ue_query && $ue_query->num_rows > 0) {
    $ue_list = $ue_query->fetch_all(MYSQLI_ASSOC);
}

if ($selected_ue) {
    // Récupérer le professeur lié à l’UE
    $stmt = $conn->prepare("SELECT p.id, p.nom, p.email FROM professeurs p
        JOIN quotas q ON p.id = q.professeur_id
        WHERE q.ue = ?");
    $stmt->bind_param("s", $selected_ue);
    $stmt->execute();
    $prof_info = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if ($prof_info) {
        // Récupérer le quota pour ce professeur + UE
        $stmt = $conn->prepare("SELECT quota_heures FROM quotas WHERE professeur_id = ? AND ue = ?");
        $stmt->bind_param("is", $prof_info['id'], $selected_ue);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        $quota_total = isset($result['quota_heures']) ? strtotime($result['quota_heures']) - strtotime("00:00:00") : 0;
        $stmt->close();

        // Récupérer la somme des heures effectuées
        $stmt = $conn->prepare("SELECT duree FROM emargement WHERE professeur_id = ? AND ue = ?");
        $stmt->bind_param("is", $prof_info['id'], $selected_ue);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            $heures_effectuees += strtotime($row['duree']) - strtotime("00:00:00");
        }
        $stmt->close();
    }
}

function formatHeure($secondes) {
    return gmdate("H:i:s", $secondes);
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Suivi des Quotas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script>
        var initialHeuresEffectuees;
        var initialHeuresRestantes;

        function reduireHeures() {
            var heuresEffectuees = parseInt(document.getElementById('heures_effectuees').dataset.seconds);
            var quotaTotal = parseInt(document.getElementById('quota_total').dataset.seconds);

            var heuresReduites = 3 * 3600;
            heuresEffectuees += heuresReduites;
            var heuresRestantes = quotaTotal - heuresEffectuees;

            document.getElementById('heures_effectuees').innerText = formatHeure(heuresEffectuees);
            document.getElementById('heures_restantes').innerText = formatHeure(heuresRestantes);

            document.getElementById('heures_effectuees').dataset.seconds = heuresEffectuees;
            document.getElementById('heures_restantes').dataset.seconds = heuresRestantes;
        }

        function annulerReduction() {
            document.getElementById('heures_effectuees').innerText = formatHeure(initialHeuresEffectuees);
            document.getElementById('heures_restantes').innerText = formatHeure(initialHeuresRestantes);

            document.getElementById('heures_effectuees').dataset.seconds = initialHeuresEffectuees;
            document.getElementById('heures_restantes').dataset.seconds = initialHeuresRestantes;
        }

        function formatHeure(secondes) {
            var heures = Math.floor(secondes / 3600);
            var minutes = Math.floor((secondes % 3600) / 60);
            var secondesRestantes = secondes % 60;
            return heures.toString().padStart(2, '0') + ":" + minutes.toString().padStart(2, '0') + ":" + secondesRestantes.toString().padStart(2, '0');
        }

        window.onload = function() {
            initialHeuresEffectuees = parseInt(document.getElementById('heures_effectuees').dataset.seconds);
            initialHeuresRestantes = parseInt(document.getElementById('heures_restantes').dataset.seconds);
        }
    </script>
</head>
<body>
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

<div class="container mt-5">
    <h2 class="mb-4">📊 Suivi des quotas d'heures</h2>

    <form method="get" class="mb-4">
        <label class="form-label">📘 Choisir une UE</label>
        <select name="ue" class="form-select" onchange="this.form.submit()">
            <option selected disabled>-- Sélectionnez une UE --</option>
            <?php foreach ($ue_list as $ue): ?>
                <option value="<?= htmlspecialchars($ue['ue']) ?>" <?= $selected_ue === $ue['ue'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($ue['ue']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </form>

    <?php if ($prof_info): ?>
        <div class="card p-4 shadow-sm">
            <h5>👨‍🏫 <?= htmlspecialchars($prof_info['nom'] ?: $prof_info['email']) ?></h5>
            <p>📘 UE : <strong><?= htmlspecialchars($selected_ue) ?></strong></p>
            <p>🕒 Quota total : <span id="quota_total" data-seconds="<?= $quota_total ?>"><?= $quota_total > 0 ? formatHeure($quota_total) : 'Non défini' ?></span></p>
            <p>✅ Heures effectuées : <span id="heures_effectuees" data-seconds="<?= $heures_effectuees ?>"><?= formatHeure($heures_effectuees) ?></span></p>
            <p>⏳ Heures restantes : <span id="heures_restantes" data-seconds="<?= max($quota_total - $heures_effectuees, 0) ?>"><?= formatHeure(max($quota_total - $heures_effectuees, 0)) ?></span></p>

            <button type="button" class="btn btn-danger mt-2" onclick="reduireHeures()">Réduire 3 heures</button>
            <button type="button" class="btn btn-secondary mt-2" onclick="annulerReduction()">Annuler</button>

            <form method="post" action="notifier_admin.php">
                <input type="hidden" name="prof_id" value="<?= $prof_info['id'] ?>">
                <input type="hidden" name="ue" value="<?= htmlspecialchars($selected_ue) ?>">
                <button type="submit" class="btn btn-warning mt-2">📩 Notifier l'administration</button>
            </form>
        </div>
    <?php elseif ($selected_ue): ?>
        <div class="alert alert-danger mt-3">
            Aucun professeur trouvé pour cette UE, ou aucun quota n’a été défini.
        </div>
    <?php endif; ?>
</div>
</body>
</html>
