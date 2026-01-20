<?php
session_start();
require_once 'configuration/config.php';
require_once 'class/Compte.php';
require_once 'class/Activite.php';

try {
    $db = getPDO();
    $activiteManager = new Activite($db);
    $services = $activiteManager->getAll();
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

$session_user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 'null';
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
    <title>Nos Tarifs - AeroClub du Puy</title>
    <!-- icon -->
    <link rel="icon" type="image/x-icon" href="img/favicon.ico">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/stylesDesktop.css">
    <link rel="stylesheet" href="css/styles_tarifs.css">
</head>

<body>
    <header class="site-header">
        <?php include 'php_parts/header.php' ?>
    </header>

    <main>
        <section class="hero-section">
            <img src="img/tarifs_hero.webp" alt="Vue aérienne" class="hero-bg-img">
            <div class="hero-overlay"></div>
            <div class="hero-content">
                <h1>NOS TARIFS</h1>
                <h2>Des sites extraordinaires à <span class="underline">redécouvrir</span></h2>
            </div>
        </section>

        <section class="pricing-section">
            <div class="pricing-grid">

                <?php foreach ($services as $s): ?>
                    <div class="price-card">
                        <h3><?= htmlspecialchars($s['name']) ?></h3>

                        <div class="duration"><?= htmlspecialchars($s['duree']) ?></div>

                        <p class="desc"><?= htmlspecialchars($s['description']) ?></p>

                        <div class="price-tag">
                            <span>
                                <?= ($s['prix'] > 0) ? 'Dès ' . number_format($s['prix'], 0, ',', ' ') : number_format($s['prix'], 0, ',', ' ') ?>
                                €
                            </span>
                            / vol (1-<?= htmlspecialchars($s['nb_places']) ?> pers)*
                        </div>

                        <button class="btn-reserve"
                            onclick="openReservation(<?= $s['id'] ?>, '<?= addslashes($s['name']) ?>', <?= $session_user_id ?>)">
                            Réserver
                        </button>
                    </div>
                <?php endforeach; ?>

            </div>

            <div class="disclaimer">
                <p>*Les avions embarquent jusqu'à 3 passagers + 1 pilote. Le tarif est le même pour 1, 2 ou 3 personnes.
                </p>
            </div>
        </section>
        <div id="reservation-modal" class="modal">
            <div class="modal-content">
                <span class="close-modal" onclick="closeModal()">&times;</span>
                <div id="modal-body">
                </div>
            </div>
        </div>
    </main>

    <?php include 'php_parts/footer.php' ?>

    <script src="script/reservation.js"></script>
</body>

</html>