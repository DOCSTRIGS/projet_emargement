<?php
require_once 'config.php';

$sql = "SELECT m.id, m.professeur_id, m.ue, m.contenu, m.date_envoi, p.nom
        FROM messages m
        LEFT JOIN professeurs p ON m.professeur_id = p.id
        ORDER BY m.date_envoi DESC";

$result = $conn->query($sql);
$messages = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $messages[] = $row;
    }
} else {
    die("Erreur récupération messages : " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>Messages de Notification</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            background: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding-top: 40px;
        }
        h2 {
            color: #0d6efd;
            margin-bottom: 30px;
            font-weight: 700;
            text-align: center;
        }
        .table thead th {
            background-color: #0d6efd;
            color: white;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        .table tbody tr:hover {
            background-color: #e9f0ff;
        }
        .badge-ue {
            background-color: #198754;
            font-size: 0.9rem;
        }
        .badge-prof {
            background-color: #0dcaf0;
            font-size: 0.9rem;
        }
        .contenu-msg {
            font-style: italic;
            color: #212529;
        }
        .date-msg {
            color: #6c757d;
            font-size: 0.85rem;
            font-weight: 500;
        }
        .container {
            max-width: 900px;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        }
        .no-msg {
            text-align: center;
            color: #6c757d;
            font-size: 1.1rem;
            margin-top: 40px;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>📨 Messages de notification à l'administration</h2>

    <?php if (count($messages) > 0): ?>
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>#ID</th>
                    <th>Professeur</th>
                    <th>UE</th>
                    <th>Message</th>
                    <th>Date d'envoi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($messages as $msg): ?>
                    <tr>
                        <td><?= htmlspecialchars($msg['id']) ?></td>
                        <td>
                            <span class="badge badge-prof rounded-pill"><?= htmlspecialchars($msg['nom'] ?? 'Inconnu') ?></span>
                        </td>
                        <td>
                            <span class="badge badge-ue rounded-pill"><?= htmlspecialchars($msg['ue']) ?></span>
                        </td>
                        <td class="contenu-msg"><?= htmlspecialchars($msg['contenu']) ?></td>
                        <td class="date-msg"><?= date('d/m/Y H:i', strtotime($msg['date_envoi'])) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="no-msg">Aucun message à afficher pour le moment.</p>
    <?php endif; ?>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
