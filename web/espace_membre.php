<?php
session_start();
require_once 'class/Compte.php';
require_once 'configuration/config.php';

$msg = "";

// Traitement Connexion
if (isset($_POST['login'])) {
    $auth = new Compte();
    if ($auth->connexion($_POST['email'], $_POST['mdp'])) {
        if ($_SESSION['user_role'] === 'admin') {
            header("Location: admin_dashboard.php");
        } else {
            header("Location: espace_membre.php");
        }
        exit();
    }
}

// Traitement Inscription
if (isset($_POST['register'])) {
    $nouveau = new Compte($_POST['name'], $_POST['lastname'], $_POST['email'], $_POST['mdp']);
    if ($nouveau->creerCompte()) {
        $msg = "Compte créé ! Connectez-vous.";
    }
}

$isLoggedIn = isset($_SESSION['user_id']);


// API Météo
function getMeteo()
{
    $apiKey = "";
    $city = "Le Puy-en-Velay";
    $url = "https://api.openweathermap.org/data/2.5/weather?q=" . urlencode($city) . "&appid=" . $apiKey . "&units=metric&lang=fr";

    // Système de cache 30 min
    if (!isset($_SESSION['meteo_data']) || (time() - $_SESSION['meteo_time'] > 1800)) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Important sur Docker pour éviter les erreurs de certificat

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode === 200) {
            $data = json_decode($response, true);
            $_SESSION['meteo_data'] = [
                'temp' => round($data['main']['temp']),
                'desc' => ucfirst($data['weather'][0]['description']),
                'wind' => round($data['wind']['speed'] * 3.6),
                'icon' => $data['weather'][0]['icon']
            ];
            $_SESSION['meteo_time'] = time();
        } else {
            return null; // Si l'API renvoie une erreur (ex: clé invalide)
        }
    }
    return $_SESSION['meteo_data'] ?? null;
}

$meteo = getMeteo();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace Membre - AeroClub du Puy</title>
    <link rel="icon" type="image/x-icon" href="img/favicon.ico">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/stylesDesktop.css">
    <link rel="stylesheet" href="css/espace_membre.css">
</head>

<body>
    <header>
        <?php include 'php_parts/header.php' ?>
    </header>

    <main>
        <?php if (!$isLoggedIn): ?>
            <section class="div-center">

                <?php if ($msg): ?>
                    <div class="auth-msg"><?= $msg ?></div>
                <?php endif; ?>

                <div class="auth-container">
                    <form method="POST" class="form-card">
                        <h2>Connexion</h2>
                        <input type="email" name="email" placeholder="Email" required>
                        <input type="password" name="mdp" placeholder="Mot de passe" required>
                        <button type="submit" name="login" class="btn-reserve">Se connecter</button>
                    </form>

                    <form method="POST" class="form-card">
                        <h2>Créer un compte</h2>
                        <input type="text" name="name" placeholder="Prénom" required>
                        <input type="text" name="lastname" placeholder="Nom" required>
                        <input type="email" name="email" placeholder="Email" required>
                        <input type="password" name="mdp" placeholder="Mot de passe" required>
                        <button type="submit" name="register" class="btn-reserve">S'inscrire</button>
                    </form>
                </div>
            </section>
        <?php else: ?>
            <section class="div-center auth-wrapper">
                <div class="dashboard-card main-dashboard">
                    <h1>Bonjour <?= $_SESSION['user_name'] ?> !</h1>
                    <p class="subtitle">Prêt pour un nouveau vol ?</p>

                    <div class="dashboard-grid">
                        <div class="mini-card">
                            <h3>Météo</h3>
                            <?php if ($meteo): ?>
                                <ul class="meteo-list">
                                    <li><i class="fa fa-map-marker" style="color: var(--primary-color);"></i> Le-Puy-en-Velay</li>
                                    <li>
                                        <img src="https://openweathermap.org/img/wn/<?= $meteo['icon'] ?>.png" alt="icon"
                                            style="width:25px; vertical-align:middle;">
                                        <?= $meteo['desc'] ?>
                                    </li>
                                    <li><i class="fa-solid fa-wind" style="color: var(--primary-color);"></i> <?= $meteo['wind'] ?> km/h</li>
                                    <li><i class="fa fa-thermometer-half" style="color: var(--primary-color);"></i> <?= $meteo['temp'] ?>°C</li>
                                </ul>
                            <?php else: ?>
                                <p>Météo indisponible</p>
                            <?php endif; ?>
                        </div>

                        <div class="mini-card">
                            <h3>Prochain Vol</h3>
                            <div class="empty-vol">
                                <i class="fa fa-plane"></i>
                                <p>Aucun vol prévu</p>
                            </div>
                        </div>

                        <div class="mini-card action-card">
                            <h3>Actions rapides</h3>
                            <div class="action-row">
                                <button class="btn-mail"><i class="fa fa-envelope-o"></i></button>
                                <a href="reservation.php" class="btn-reserve">Réserver</a>
                            </div>
                        </div>

                        <div class="mini-card map-container">
                            <span class="map-label">Trafic Aérien</span>
                        </div>
                    </div>

                    <div class="dashboard-footer">
                        <a href="logout.php" class="btn-logout">Se déconnecter</a>
                    </div>
                </div>
            </section>
        <?php endif; ?>
    </main>

    <?php include 'php_parts/footer.php' ?>
</body>

</html>