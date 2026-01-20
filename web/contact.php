<!DOCTYPE html>
<html lang="fr">

<head>
    <!-- Meta tags SEO -->
    <meta title="Site de l'aeroclub du Velay">
    <meta description="Bienvenue sur le site de l'aeroclub du Velay, votre destination pour tout ce qui concerne l'aviation.">
    <meta keywords="aeroclub, aviation, vol, formation, avions, Velay, Haute-Loire, Puy-en-Velay, contact aeroclub">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact - AeroClub du Puy</title>
    <!-- icon -->
    <link rel="icon" type="image/x-icon" href="img/favicon.ico">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/stylesDesktop.css">
    <link rel="stylesheet" href="css/styles_contact.css">
</head>

<body>
    <header>
        <?php include 'php_parts/header.php' ?>
    </header>

    <main>
        <section class="contact-map">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2817.482903061669!2d3.757746076216333!3d45.07599975925639!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47f60792c63f26c1%3A0x4a983c53c10972d2!2sA%C3%A9ro-Club%20du%20Puy!5e0!3m2!1sfr!2sfr!4v1768466262767!5m2!1sfr!2sfr"
                width="100%"
                height="450"
                style="border:0;"
                allowfullscreen=""
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"
                title="Carte de localisation de l'Aéroclub">
            </iframe>
        </section>

        <section class="contact-form-container">
            <div class="container">
                <h1 class="form-title">Prêt au décollage ?</h1>
                <p class="form-subtitle">Écrivez-nous, on s'occupe du reste.</p>
                <form action="https://formsubmit.co/hermanntom06@gmail.com" method="POST" class="form-grid">
                    <div class="form-group">
                        <label for="nom">Nom :</label>
                        <input type="text" id="nom" name="nom" placeholder="Levand..." required>
                    </div>

                    <div class="form-group">
                        <label for="prenom">Prénom :</label>
                        <input type="text" id="prenom" name="prenom" placeholder="Hector..." required>
                    </div>

                    <div class="form-group">
                        <label for="email">Mail :</label>
                        <input type="email" id="email" name="email" placeholder="levand.hector@gmail.com" required>
                    </div>

                    <div class="form-group">
                        <label for="phone">Téléphone :</label>
                        <input type="tel" id="phone" name="phone" placeholder="+33">
                    </div>

                    <div class="form-group full-width">
                        <label for="message">Message :</label>
                        <textarea id="message" name="message" rows="5" placeholder="Écrivez votre message ici..." required></textarea>
                    </div>

                    <input type="hidden" name="_captcha" value="false">
                    <input type="hidden" name="_template" value="table">
                    <input type="hidden" name="_subject" value="Nouveau message de contact">
                    <input type="hidden" name="_next" value="http://localhost/ProjetWeb_AeroClub/web/contact.php?success=true">

                    <div class="form-submit">
                        <button type="submit" class="btn-submit">Envoyer</button>
                    </div>
                </form>
            </div>
        </section>
        <script src="script/scriptContact.js"></script>
    </main>

    <?php include 'php_parts/footer.php' ?>
</body>

</html>