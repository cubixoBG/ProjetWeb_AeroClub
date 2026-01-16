<!DOCTYPE html>
<html lang="fr">

<head>
    <!-- Meta tags SEO -->
    <meta title="Site de l'aeroclub du Velay">
    <meta description="Bienvenue sur le site de l'aeroclub du Velay, votre destination pour tout ce qui concerne l'aviation.">
    <meta keywords="aeroclub, aviation, vol, formation, avions, Velay, Haute-Loire, Puy-en-Velay, l'école aeroclub">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formations - AeroClub du Puy</title>
    <!-- icon -->
    <link rel="icon" type="image/x-icon" href="img/favicon.ico">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/stylesDesktop.css">
     <link rel="stylesheet" href="css/style_formation.css">
</head>

<body>
    <header>
        <?php include 'php_parts/header.php' ?>
    </header>

    <main>

    <!-- HERO ECOLE -->
<section class="hero-ecole">
    <img src="img/image lecole.jpg" alt="Notre école">
    <div class="hero-overlay"></div>

    <div class="hero-text">
        <h1 class="font-clash">Notre École</h1>
        <p>
            Formez-vous aux côtés d’instructeurs expérimentés.
            Une pédagogie rigoureuse pour devenir un pilote compétent et serein.
        </p>
    </div>
</section>

<!-- NOS FORMATIONS -->
<section class="formations">

<h2 class="font-clash">Nos Formations</h2>

<h3 class="formation-link-custom">
    Notre formule de découverte<br>
    <span>du pilotage !</span>
</h3>

    <p>
        Ces vols d’initiation au pilotage avec instructeur ont déjà permis
        à beaucoup d’exaucer un rêve et à d’autres de se découvrir une vocation.
        Une véritable leçon de 30 minutes telle qu’un élève pilote la vivrait,
        une expérience intense et riche en émotions.
    </p>

    <span class="price">Prix pour 30 min : 180 €</span>
</section>



<!-- NOS AVIONS -->
<section class="avions">
<h2 class="font-clash">Nos Avions</h2>


   <p class="text-avions">
    Deux DR400 constituent la flotte de l’aéroclub.
    Ces appareils fiables et faciles à piloter permettent la pratique
    du vol moteur dans les meilleures conditions.
</p>

    <div class="avions-grid">

        <article class="avion-card">
            <img src="img/FBUSH.jpg" alt="Avion F-BUSH">

<h3 class="avion-title">F-BUSH</h3>
            <div class="avion-infos">
                <span>👤 Nombre de personnes</span>
                <span>🪪 DR400-140</span>
                <span>⚙️ 152 CH</span>
                <span>🛫 110 KT</span>
            </div>

            <button class="btn-card">En savoir plus</button>
        </article>

       <article class="avion-card avion-card--red">
  <img src="img/FGJZT.jpg" alt="Avion F-GJZT">

<h3 class="avion-title">F-GJZT</h3>

  <div class="avion-infos">
    <span class="chip">👤 Nombre de personnes</span>
    <span class="chip">🪪 DR400-140</span>
    <span class="chip">⚙️ 160CH</span>
    <span class="chip">🛫 110 KT</span>
  </div>

  <button class="btn-card">En savoir plus</button>
</article>

    </div>
</section>




<!-- PEDAGOGIE -->
<section class="pedagogie">

<h3 class="formation-link-custom">
    Apprendre à piloter, c’est facile grâce à l’Aéroclub du Puy
</h3>

<p>
    La formation théorique est dispensée gratuitement à tous les membres
    par une équipe qualifiée. L’aéroclub met l’accent sur la formation
    avec une heure de vol en instruction majorée de seulement 5 €.
</p>

<p>
    En outre, l’aéroclub peut vous permettre d’obtenir des bourses
    réduisant le coût de votre formation.
</p>

<div class="galerie">
    <img src="img/photo 1 avion.jpg" alt="">
    <img src="img/photo 2 avion.jpg" alt="">
    <img src="img/photo 3.jpg" alt="">

</div>

<h2 class="font-clash brevets-title">Les brevets</h2>

<p class="brevets-intro">
    Les brevets auxquels préparent l'Aéro-Club sont listés dans le document pdf suivant :
</p>

   <section class="section-brevets">
        <div class="div-center">
            <a href="img/brevets.pdf" target="_blank" class="pdf-link-container">
            <div class="pdf-container">
            <img src="img/brevets.png" alt="Document des brevets" class="pdf-image">
        </div>
    </a>
</div>


</section>
</section>

</section>


    </main>

    <?php include 'php_parts/footer.php' ?>


    
</body>



</html>