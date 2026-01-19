<!DOCTYPE html>
<html lang="fr">

<head>
    <!-- Meta tags SEO -->
    <meta title="Site de l'aeroclub du Velay">
    <meta
        description="Bienvenue sur le site de l'aeroclub du Velay, votre destination pour tout ce qui concerne l'aviation.">
    <meta keywords="aeroclub, aviation, vol, formation, avions, Velay, Haute-Loire, Puy-en-Velay, services aeroclub">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Les Services - AeroClub du Puy</title>
    <!-- icon -->
    <link rel="icon" type="image/x-icon" href="img/favicon.ico">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/stylesDesktop.css">
    <link rel="stylesheet" href="css/styles_tarifs.css">
</head>

<body>
    <header>
        <?php include 'php_parts/header.php' ?>
    </header>

    <main>
        <section class="hero-page">
            <img src="img/tarifs_hero.webp" alt="Deux avions, un rouge et un bleu">
            <div class="hero-overlay"></div>
            <div class="hero-content">
                <h1>Nos tarifs</h1>
                <h2>Des sites extraordinaires à <span class="underline">redécouvrir</span></h2>
                <p>Venez survoler le Puy et sa région dans l'un de nos avions. Vous pourrez choisir entre différentes
                    formules :</p>
            </div>
        </section>

        <section class="options-prix">
            <div class="container">
                <!-- vol 15 minutes-->
                <div class="option-prix">
                    <h3>Vol local de 15 minutes</h3>
                    <p>Découverte des secteurs du Puy, d'Allègre, ou lac du Bouchet.</p>
                    <div class="prix">
                        Dès 100 € pour un vol jusqu'à 3 personnes*
                    </div>
                </div>

                <!-- vol 30 minutes-->
                <div class="option-prix">
                    <h3>Vol de 30 minutes aux confins du département</h3>
                    <p>Découverte des environs de Bas-Monistrol, du Mezenc, de Langogne-Naussac ou de Brioude.</p>
                    <div class="prix">
                        Dès 150 € pour un vol jusqu'à 3 personnes*
                    </div>
                </div>

                <!-- tarif groupes -->
                <div class="option-prix">
                    <h3>Tarif groupes</h3>
                    <p>Applicable dès que 3 vols ou plus sont commandés par un même groupe sur une demi journée.</p>
                    <div class="prix">
                        Dès 95 € au lieu de 100 € pour 1 à 3 personnes*
                    </div>
                    <div class="prix">
                        Dès 140 € au lieu de 150 € pour 1 à 3 personnes*
                    </div>
                </div>

                <!-- decouverte pilotage -->
                <div class="option-prix">
                    <h3>Découverte du pilotage</h3>
                    <p>Vous référer à la rubrique <a href="#" class="text-link">l'école</a>.</p>
                </div>

                <div class="disclaimer">
                    *Les avions pouvant embarquer 3 passagers et un pilote, les tarifs sont identiques pour une, deux ou
                    trois personnes.
                </div>

                <div class="div-center btn-service">
                    <a href="#" class="btn-reserve">Réserver</a>
                </div>
            </div>
        </section>
    </main>

    <?php include 'php_parts/footer.php' ?>
</body>

</html>