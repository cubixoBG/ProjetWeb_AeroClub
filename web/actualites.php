<?php
require_once 'class/Compte.php';
require_once 'class/actualites.php';

try {
    $db = getPDO();
    $actuManager = new Actualites($db);
    $articles = $actuManager->getAll();
    $annees = $actuManager->getYears();
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
    <meta keywords="aeroclub, aviation, vol, formation, avions, Velay, Haute-Loire, Puy-en-Velay, actualités aeroclub">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Les Actualités - AeroClub du Puy</title>
    <!-- icon -->
    <link rel="icon" type="image/x-icon" href="img/favicon.ico">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/stylesDesktop.css">
    <link rel="stylesheet" href="css/styles_actu.css">
    <script src="script/actualites.js"></script>
</head>

<body>
    <header>
        <?php include 'php_parts/header.php' ?>
    </header>

    <main>
        <div class="archive-nav">
            <a href="#" class="btn-archive active" onclick="filterNews(event, 'all')">Toutes</a>

            <?php foreach ($annees as $annee): ?>
                <a href="#" class="btn-archive" onclick="filterNews(event, '<?= $annee ?>')"><?= $annee ?></a>
            <?php endforeach; ?>
        </div>

        <div class="news-feed">
            <?php foreach ($articles as $art):
                $anneeArt = date('Y', strtotime($art['date_publication']));
                ?>
                <article class="card-box news-card" data-year="<?= $anneeArt ?>">
                    <div class="news-header">
                        <span class="news-date"><?= date('d F Y', strtotime($art['date_publication'])) ?></span>
                        <h2><?= htmlspecialchars($art['titre']) ?></h2>
                    </div>

                    <?php if (!empty($art['image'])): ?>
                        <div class="news-image">
                            <img src="img/<?= htmlspecialchars($art['image']) ?>" alt="Image Actu">
                        </div>
                    <?php endif; ?>

                    <div class="news-content">
                        <p><?= nl2br(htmlspecialchars($art['description'])) ?></p>

                        <?php if (!empty($art['pdf_url'])): ?>
                            <div class="div-center">
                                <a href="<?= htmlspecialchars($art['pdf_url']) ?>" download class="btn-simple">
                                    Télécharger le document
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </main>

    <?php include 'php_parts/footer.php' ?>

</body>

</html>