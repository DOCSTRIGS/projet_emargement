<?php
session_start();
if (!isset($_SESSION['prof_id'])) {
    header("Location: index.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace Professeur - Dashboard</title>
    <!-- Lien vers Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .svg-button {
            display: inline-flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            color: #0d6efd;
            margin: 20px;
            font-weight: bold;
            transition: transform 0.2s;
        }

        .svg-button:hover {
            transform: scale(1.1);
            color: #084298;
        }

        .svg-button .text {
            margin-top: 10px;
            font-size: 16px;
        }

        .container {
            text-align: center;
            margin-top: 200px;
        }

        .d-flex {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 50px;
        }
    </style>
</head>
<!-- navbar.php -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

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
<body>

<div class="container">
    <h2 class="mb-4">Bienvenue dans votre espace</h2>
    <div class="d-flex">
        <!-- Bouton Émargement Prof -->
        <a href="emargement.php" class="svg-button">
            <img src="https://cdn-icons-png.flaticon.com/128/10601/10601276.png" alt="Afrique" width="80" height="80">
            <div class="text">Émargement Prof</div>
        </a>

        <!-- Bouton Contrôle Administration -->
        <a href="admin_dashboard.php" class="svg-button">
            <img src="https://cdn-icons-png.flaticon.com/128/10601/10601276.png" alt="Afrique" width="80" height="80">
            <div class="text">Contrôle Administration Prof</div>
        </a>

        <!-- Bouton Devoir -->
        <a href="quota_notification.php" class="svg-button">
            <img src="https://cdn-icons-png.flaticon.com/128/10601/10601276.png" alt="Afrique" width="80" height="80">
            <div class="text">Quotas heure enseignant</div>
        </a>

        <!-- Bouton Messagerie -->
        <a href="messages.php" class="svg-button">
            <img src="https://cdn-icons-png.flaticon.com/128/10601/10601276.png" alt="Afrique" width="80" height="80">
            <div class="text">Messagerie</div>
        </a>
    </div>
</div>


</body>
</html>
