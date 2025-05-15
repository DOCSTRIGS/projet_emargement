<?php
session_start();
require_once 'config.php'; // Connexion à la base de données

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    // Préparation de la requête pour récupérer l'utilisateur par son email
    $stmt = $conn->prepare("SELECT * FROM professeurs WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows === 1) {
        $user = $res->fetch_assoc();

        // Vérifie le mot de passe
        if (password_verify($password, $user['mot_de_passe'])) {
            $_SESSION['prof_id'] = $user['id'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['nom'] = $user['nom']; // Facultatif si besoin
            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Mot de passe incorrect.";
        }
    } else {
        $error = "Aucun utilisateur trouvé avec cet email.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion Professeur</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<main>
    <section class="form">
        <div class="logo">
            <!-- Logo SVG ou image ici -->
        </div>

        <h1 class="form__title">Connexion à votre compte</h1>
        <p class="form__description">Bienvenue ! Veuillez entrer vos informations</p>

        <?php if (!empty($error)): ?>
            <div class="error" style="color:red;"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST" action="index.php">
            <label class="form-control__label">Email</label>
            <input type="email" name="email" required class="form-control">

            <label class="form-control__label">Mot de passe</label>
            <div class="password-field">
                <input type="password" name="password" class="form-control" id="password" required minlength="4">
                <!-- Icône optionnelle -->
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#999" viewBox="0 0 24 24">
                    <path d="M12 5c-7.633 0-12 6.999-12 6.999s4.351 6.999 12 6.999 12-6.999 12-6.999-4.367-6.999-12-6.999zm0 12c-2.761 0-5-2.238-5-4.999s2.239-5 5-5 5 2.239 5 5-2.239 4.999-5 4.999zm0-7.999c-1.654 0-3 1.346-3 3.001s1.346 2.998 3 2.998 3-1.343 3-2.998-1.346-3.001-3-3.001z"/>
                </svg>
            </div>

            <div class="password__settings">
                <label class="password__settings__remember">
                    <input type="checkbox">
                    <span class="custom__checkbox">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24">
                            <path d="M20.292 5.708l-11.292 11.292-5.292-5.292-1.708 1.708 7 7 13-13z"/>
                        </svg>
                    </span>
                    Se souvenir de moi
                </label>
                <a href="#">Mot de passe oublié ?</a>
            </div>

            <button type="submit" class="form__submit" id="submit">Se connecter</button>
        </form>

        <p class="form__footer">
            Pas encore de compte ? <br><a href="#">Contactez l'administrateur</a>
        </p>
    </section>

    <section class="form__animation">
        <div id="ball">
            <div class="ball">
                <div id="face">
                    <div class="ball__eyes">
                        <div class="eye_wrap"><span class="eye"></span></div>
                        <div class="eye_wrap"><span class="eye"></span></div>
                    </div>
                    <div class="ball__mouth"></div>
                </div>
            </div>
        </div>
        <div class="ball__shadow"></div>
    </section>
</main>

<script src="main.js"></script>
</body>
</html>
