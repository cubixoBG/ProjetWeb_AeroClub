<?php
session_start();
require_once 'class/Compte.php';
require_once 'configuration/config.php';

$db = getPDO();
$isLoggedIn = isset($_SESSION['user_id']);

// On récupère le prochain vol seulement si connecté
$prochainVol = null;
if ($isLoggedIn) {
    $queryVol = "SELECT r.*, a.name as activite_nom 
                 FROM Reservation r 
                 JOIN Activite a ON r.id_activite = a.id 
                 WHERE r.id_compte = :uid 
                 AND r.date_reservation >= NOW() 
                 ORDER BY r.date_reservation ASC LIMIT 1";
    $stmtVol = $db->prepare($queryVol);
    $stmtVol->execute(['uid' => $_SESSION['user_id']]);
    $prochainVol = $stmtVol->fetch(PDO::FETCH_ASSOC);
}

// API Météo (Fonction conservée pour l'affichage initial)
function getMeteo()
{
    global $cleMeteo;
    $apiKey = $cleMeteo;
    $city = "Le Puy-en-Velay";
    $url = "https://api.openweathermap.org/data/2.5/weather?q=" . urlencode($city) . "&appid=" . $apiKey . "&units=metric&lang=fr";

    if (!isset($_SESSION['meteo_data']) || (time() - $_SESSION['meteo_time'] > 1800)) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
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
        } else { return null; }
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
                <div class="auth-container">
                    <form id="loginForm" class="form-card">
                        <h2>Connexion</h2>
                        <input type="email" name="email" placeholder="Email" required>
                        <input type="password" name="mdp" placeholder="Mot de passe" required>
                        <input type="hidden" name="action" value="login">
                        <button type="submit" class="btn-reserve">Se connecter</button>
                        <div id="loginMsg" class="auth-msg" style="margin-top:10px;"></div>
                    </form>

                    <form id="registerForm" class="form-card">
                        <h2>Créer un compte</h2>
                        <input type="text" name="name" placeholder="Prénom" required>
                        <input type="text" name="lastname" placeholder="Nom" required>
                        <input type="email" name="email" placeholder="Email" required>
                        <input type="password" name="mdp" placeholder="Mot de passe" required>
                        <input type="hidden" name="action" value="register">
                        <button type="submit" class="btn-reserve">S'inscrire</button>
                        <div id="registerMsg" class="auth-msg" style="margin-top:10px;"></div>
                    </form>
                </div>
            </section>
        <?php else: ?>
            <section class="div-center auth-wrapper">
                <div class="dashboard-card main-dashboard">
                    <h1>Bonjour <?= htmlspecialchars($_SESSION['user_name']) ?> !</h1>
                    <p class="subtitle">Prêt pour un nouveau vol ?</p>

                    <div class="dashboard-grid">
                        <div class="mini-card">
                            <h3>Météo</h3>
                            <?php if ($meteo): ?>
                                <ul class="meteo-list">
                                    <li><i class="fa fa-map-marker" style="color: var(--primary-color);"></i> Le-Puy-en-Velay</li>
                                    <li>
                                        <img src="https://openweathermap.org/img/wn/<?= $meteo['icon'] ?>.png" alt="icon" style="width:25px; vertical-align:middle;">
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
                            <?php if ($prochainVol): ?>
                                <div class="vol-info" style="text-align: center;">
                                    <i class="fa fa-plane" style="color: var(--primary-color); font-size: 2em;"></i>
                                    <p style="font-weight: bold; margin-top: 10px;"><?= htmlspecialchars($prochainVol['activite_nom']) ?></p>
                                    <p>Le <?= date('d/m/Y à H:i', strtotime($prochainVol['date_reservation'])) ?></p>
                                </div>
                            <?php else: ?>
                                <div class="empty-vol">
                                    <i class="fa fa-plane"></i>
                                    <p>Aucun vol prévu</p>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="mini-card action-card">
                            <h3>Actions rapides</h3>
                            <div class="action-row">
                                <button class="btn-mail"><i class="fa fa-envelope-o"></i></button>
                                <a href="services.php" class="btn-reserve">Réserver</a>
                            </div>
                        </div>

                        <div class="mini-card map-container">
                            <div class="card-box" style="padding: 0; overflow: hidden; height: 600px;">
                                <iframe src="https://globe.adsbexchange.com/?lat=45.080&lon=3.760&zoom=11&hideSidebar&hideButtons" width="100%" height="100%" frameborder="0" style="border:0;"></iframe>
                            </div>
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

    <script>
    // Fonction universelle pour gérer l'auth via l'API
    async function initAuth(formId, msgId) {
        const form = document.getElementById(formId);
        if (!form) return;

        form.onsubmit = async (e) => {
            e.preventDefault();
            const msgZone = document.getElementById(msgId);
            const formData = new FormData(form);

            try {
                const response = await fetch('api/api_auth.php', {
                    method: 'POST',
                    body: formData
                });
                const result = await response.json();

                if (result.success) {
                    msgZone.style.color = "green";
                    msgZone.innerText = result.message;
                    // Redirection si connexion réussie ou après inscription
                    setTimeout(() => {
                        window.location.href = (formData.get('action') === 'login' && result.role === 'admin') 
                            ? "admin_dashboard.php" 
                            : "espace_membre.php";
                    }, 1000);
                } else {
                    msgZone.style.color = "red";
                    msgZone.innerText = result.message;
                }
            } catch (err) {
                msgZone.innerText = "Erreur de communication avec le serveur.";
            }
        };
    }

    // Lancement des écouteurs
    initAuth('loginForm', 'loginMsg');
    initAuth('registerForm', 'registerMsg');
    </script>
</body>
</html>