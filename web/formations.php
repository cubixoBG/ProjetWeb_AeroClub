<?php
// Inclusions selon ta structure
require_once 'configuration/config.php';
require_once 'class/Compte.php';
require_once 'class/flotte.php';

try {
    $db = getPDO(); // Ta fonction de connexion
    $flotteManager = new Flotte($db);
    $avions = $flotteManager->getAll(); // Ta méthode qui fait le SELECT * FROM Avion
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <!-- Meta tags SEO -->
    <meta title="Site de l'aeroclub du Velay">
    <meta
        description="Bienvenue sur le site de l'aeroclub du Velay, votre destination pour tout ce qui concerne l'aviation.">
    <meta keywords="aeroclub, aviation, vol, formation, avions, Velay, Haute-Loire, Puy-en-Velay">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AeroClub du Puy</title>
    <link rel="icon" type="image/x-icon" href="img/favicon.ico">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/stylesDesktop.css">
    <link rel="stylesheet" href="css/style_formation.css">
</head>

<body>
    <?php include 'php_parts/header.php' ?>

    <main>
        <section class="hero-page">
            <img src="img/image-lecole.webp" alt="Notre École" class="hero-bg">
            <div class="hero-overlay"></div>
            <div class="hero-content">
                <h2>Notre École</h2>
                <p>Formez-vous avec des instructeurs passionnés sur le plateau du Velay.</p>
            </div>
        </section>

        <section class="container-section">
            <div>
                <h2>Vols d'initiation</h2>
                <div class="divider"></div>
            </div>
            <div class="intro-content">
                <h3>Notre formule de découverte du pilotage !</h3>
                <p>Ces vols d’initiation au pilotage avec instructeur ont déjà permis à beaucoup d’exaucer un rêve. Une
                    véritable leçon de 30 minutes, une expérience intense et riche en émotions.</p>
                <p class="price-badge">Tarif : 180 € (30 min)</p>
            </div>
        </section>

        <section class="container-section bg-light">
            <div>
                <h2>Nos Avions</h2>
                <div class="divider"></div>
            </div>

            <div class="avions-grid">
                <?php foreach ($avions as $index => $avion): ?>
                    <article class="avion-card">
                        <div class="card-img">
                            <img src="<?= htmlspecialchars($avion['image']) ?>"
                                alt="<?= htmlspecialchars($avion['immatriculation']) ?>">
                        </div>
                        <div class="card-body">
                            <h3 class="avion-name"><?= htmlspecialchars($avion['immatriculation']) ?></h3>
                            <div class="avion-specs">
                                <p>👤 4 PLACES</p>
                                <p>🪪 <?= htmlspecialchars($avion['type']) ?></p>
                                <p>⚙️ <?= htmlspecialchars($avion['puissance']) ?> CH</p>
                                <p>🛫 <?= htmlspecialchars($avion['vitesse_croisiere']) ?> KT</p>
                                <p>🕒 <?= htmlspecialchars($avion['autonomie']) ?> H</p>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        </section>

        <section class="container-section">
            <div>
                <h2 class="font-clash">Pédagogie</h2>
                <div class="divider"></div>
            </div>
            <p>La formation théorique est dispensée gratuitement à tous les membres. L’aéroclub met l’accent sur la
                formation avec une instruction accessible.</p>

            <div class="galerie-grid">
                <img src="img/photo-1-avion.webp" alt="Avion">
                <img src="img/photo-2-avion.webp" alt="Cockpit">
                <img src="img/photo-3.webp" alt="Vol">
            </div>
        </section>

        <section class="container-section bg-light">
            <div>
                <h2 class="font-clash">Les Brevets</h2>
                <div class="divider"></div>
            </div>
            <p>Découvrez les différents brevets aéronautiques préparés au sein de notre club.</p>
            <div class="pdf-wrapper div-center">
                <a href="img/brevets.pdf" target="_blank" class="pdf-card">
                    <img src="img/brevets.webp" alt="Brevets PDF">
                </a>
            </div>
        </section>
    </main>

    <?php include 'php_parts/footer.php' ?>
</body>

</html>