<!DOCTYPE html>
<html lang="fr">
<head>
    <!-- Meta tags SEO -->
    <meta title="Site de l'aeroclub du Velay">
    <meta description="Bienvenue sur le site de l'aeroclub du Velay, votre destination pour tout ce qui concerne l'aviation.">
    <meta keywords="aeroclub, aviation, vol, formation, avions, Velay, Haute-Loire, Puy-en-Velay">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Politique de confidentialité - AeroClub du Puy</title>
    <!-- icon -->
    <link rel="icon" type="image/x-icon" href="img/favicon.ico">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/styles_tarifs.css">
    <link rel="stylesheet" href="css/stylesDesktop.css">
</head>

<body>
    <header class="site-header">
        <?php include 'php_parts/header.php' ?>
    </header>

    <main>
        <section class="hero-section">
            <img src="img/tarifs_hero.webp" alt="Vue aérienne avion" class="hero-bg-img">
            
            <div class="hero-overlay"></div>

            <div class="hero-content">
                <h1>NOS TARIFS</h1>
                <h2>Des sites extraordinaires à <span class="underline">redécouvrir</span></h2>
                <p>Venez survoler le Puy et sa région dans l'un de nos avions.</p>
            </div>
        </section>
    
        <section class="pricing-section">
            <div class="pricing-grid">
                
                <div class="price-card">
                    <h3>Vol Découverte</h3>
                    <div class="duration">15 minutes</div>
                    <p class="desc">Secteurs du Puy, d'Allègre, ou lac du Bouchet.</p>
                    <div class="price-tag">
                        <span>Dès 100 €</span> / vol (1-3 pers)*
                    </div>
                    <a href="#" class="btn-card">Réserver</a>
                </div>

                <div class="price-card highlight">
                    <h3>Vol Panoramique</h3>
                    <div class="duration">30 minutes</div>
                    <p class="desc">Bas-Monistrol, Mezenc, Langogne-Naussac ou Brioude.</p>
                    <div class="price-tag">
                        <span>Dès 150 €</span> / vol (1-3 pers)*
                    </div>
                    <a href="#" class="btn-card">Réserver</a>
                </div>

                <div class="price-card">
                    <h3>Tarif Groupes</h3>
                    <div class="duration">Demi-journée</div>
                    <p class="desc">Applicable dès que 3 vols ou plus sont commandés.</p>
                    <div class="price-tag">
                        <span>- 10 €</span> / vol environ
                    </div>
                    <a href="#" class="btn-card">Nous contacter</a>
                </div>

            </div>

            <div class="disclaimer">
                <p>*Les avions embarquent jusqu'à 3 passagers + 1 pilote. Le tarif est le même pour 1, 2 ou 3 personnes.</p>
                <p>Envie d'apprendre ? Découvrez <a href="formations.php" style="text-decoration:underline; color:var(--primary-color);">notre école de pilotage</a>.</p>
            </div>
        </section>
    </main>

    <?php include 'php_parts/footer.php' ?>
</body>
</html>