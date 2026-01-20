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
    <!-- icon -->
    <link rel="icon" type="image/x-icon" href="img/favicon.ico">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/stylesDesktop.css">
    <link rel="stylesheet" href="css/stylesIndex.css">
</head>

<body>
    <header>
        <?php include 'php_parts/header.php' ?>
    </header>

    <main>
        <section class="hero">
            <img src="img/heroIndex.webp" alt="AéroClub du Puy-en-Velay">
            <div class="heroTexte">
                <h1>AéroClub du Puy-en-Velay</h1>
                <p>Donnez du sens à vos rêves !</p>
            </div>
        </section>

        <section id="infoIndex">
            <div class="info-content">
                <h2>Le Club</h2>
                <p>Fondé en 1931, l'Aéroclub du Puy, membre de la Fédération Française Aéronautique (FFA) et agréé par
                    le Ministère de la jeunesse et des Sports, s'ouvre pour entretenir le rêve d'Icare et s'efforce de
                    le concrétiser par la diversité de ses activités : baptême, formation, perfectionnement, voyage.</p>
            </div>
            <img src="img/club.webp" alt="le club aéro du puy en velay">
        </section>
        <section id="devenirpilote">
            <h3>Devenir Pilote</h3>
            <p>En faire un métier, pratiquer une activité sportive différente et exaltante, apprendre à être en pleine
                possession de ses moyens et bien dans sa peau sont quelques unes des conséquences bénéfiques que l'ont
                peut espérer retirer de cette pratique.</p>
                <button onclick="window.location.href='formations.php'">Découvrir</button>
        </section>
        <section id="infosupPDF">
            <div class="pdf-wrapper">
                <a href="img/infoPilote.pdf" target="_blank" class="pdf-link">
                    <img src="img/pdf.webp" alt="Cliquez pour ouvrir le PDF">
                    <div class="overlay-click">
                        <i class="fa fa-eye"></i>
                        <span>Ouvrir le document</span>
                    </div>
                </a>
                <div class="pdf-footer">
                    <a href="img/infoPilote.pdf" download class="btn-download">
                        <i class="fa fa-download"></i> Télécharger au lieu d'ouvrir
                    </a>
                </div>
            </div>
        </section>
    </main>

    <?php include 'php_parts/footer.php' ?>
</body>

</html>