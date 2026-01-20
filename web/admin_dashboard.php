<?php
session_start();
require_once 'configuration/config.php';
require_once 'class/Compte.php';
require_once 'class/actualites.php';
require_once 'class/flotte.php';
require_once 'class/Activite.php';

// Verif du role admin
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: espace_membre.php");
    exit();
}

$db = getPDO();
$actuManager = new Actualites($db);
$flotteManager = new Flotte($db);
$activiteManager = new Activite($db);
$msg_activite = "";
$msg = "";
$msg_avion = "";
$uploadDir = 'img/';

// --- ACTIONS ACTUALITÉS ---

// Suppr Actu
if (isset($_GET['delete'])) {
    if ($actuManager->delete($_GET['delete'])) {
        $msg = "Article supprimé.";
    }
}

// Ajout ou Modif Actu
if (isset($_POST['save_actu'])) {
    $imagePath = $_POST['current_image'] ?? null;
    if (!empty($_FILES['image_file']['name'])) {
        $imageName = time() . '_' . basename($_FILES['image_file']['name']);
        if (move_uploaded_file($_FILES['image_file']['tmp_name'], $uploadDir . $imageName)) {
            $imagePath = $uploadDir . $imageName;
        }
    }

    $pdfPath = $_POST['current_pdf'] ?? null;
    if (!empty($_FILES['pdf_file']['name'])) {
        $pdfName = time() . '_' . basename($_FILES['pdf_file']['name']);
        if (move_uploaded_file($_FILES['pdf_file']['tmp_name'], $uploadDir . $pdfName)) {
            $pdfPath = $uploadDir . $pdfName;
        }
    }

    $data = [
        'id' => $_POST['id_actu'] ?? null,
        'titre' => $_POST['titre'],
        'description' => $_POST['contenu'],
        'lien_externe' => $_POST['lien_externe'],
        'image_url' => $imagePath,
        'pdf_url' => $pdfPath,
        'date_publication' => $_POST['date_publication']
    ];

    if ($actuManager->save($data)) {
        $msg = "Opération réussie !";
    }
}

// --- ACTIONS FLOTTE (AVIONS) ---

// Suppr Avion (Placé avant la récupération de la liste)
if (isset($_GET['delete_avion'])) {
    if ($flotteManager->delete($_GET['delete_avion'])) {
        $msg_avion = "L'avion a été supprimé de la flotte.";
    }
}

// Ajout ou Modif Avion
if (isset($_POST['save_avion'])) {
    $imagePath = $_POST['current_image_avion'] ?? null;
    if (!empty($_FILES['avion_file']['name'])) {
        $imageName = 'avion_' . time() . '_' . basename($_FILES['avion_file']['name']);
        if (move_uploaded_file($_FILES['avion_file']['tmp_name'], $uploadDir . $imageName)) {
            $imagePath = $uploadDir . $imageName;
        }
    }

    $data_avion = [
        'id' => $_POST['id_avion'] ?? null,
        'immatriculation' => $_POST['immatriculation'],
        'type' => $_POST['type'],
        'puissance' => $_POST['puissance'],
        'vitesse_croisiere' => $_POST['vitesse'],
        'autonomie' => $_POST['autonomie'],
        'image' => $imagePath
    ];

    if ($flotteManager->save($data_avion)) {
        $msg_avion = "Avion enregistré avec succès !";
    }
}

// --- ACTIONS ACTIVITÉS (TARIFS) ---

if (isset($_POST['save_activite'])) {
    $data_activite = [
        'id' => $_POST['id_activite'] ?: null,
        'name' => $_POST['name'],
        'description' => $_POST['description'],
        'prix' => $_POST['prix'],
        'nb_places' => $_POST['nb_places'],
        'duree' => $_POST['duree'],
        'ordre' => $_POST['ordre'] ?: 0
    ];

    if ($data_activite['id']) {
        // Update sans highlight ni btn_text
        $req = $db->prepare("UPDATE Activite SET name=?, description=?, prix=?, nb_places=?, duree=?, ordre=? WHERE id=?");
        $req->execute([$data_activite['name'], $data_activite['description'], $data_activite['prix'], $data_activite['nb_places'], $data_activite['duree'], $data_activite['ordre'], $data_activite['id']]);
    } else {
        // Insert sans highlight ni btn_text
        $req = $db->prepare("INSERT INTO Activite (name, description, prix, nb_places, duree, ordre) VALUES (?,?,?,?,?,?)");
        $req->execute([$data_activite['name'], $data_activite['description'], $data_activite['prix'], $data_activite['nb_places'], $data_activite['duree'], $data_activite['ordre']]);
    }
    $msg_activite = "Tarif mis à jour !";
}

if (isset($_GET['delete_activite'])) {
    $id_a_supprimer = $_GET['delete_activite'];
    
    // On prépare la requête SQL pour la table 'Activite'
    $stmt = $db->prepare("DELETE FROM Activite WHERE id = ?");
    
    if ($stmt->execute([$id_a_supprimer])) {
        // Redirection pour "nettoyer" l'URL et éviter de supprimer en boucle au rafraîchissement
        header("Location: admin_dashboard.php?msg_del=1"); 
        exit();
    }
}

// Message de succès après redirection
if (isset($_GET['msg_del'])) {
    $msg_activite = "Le tarif a été supprimé avec succès.";
}


// --- RÉCUPÉRATION DES DONNÉES POUR L'AFFICHAGE ---
$edit_data = isset($_GET['edit']) ? $actuManager->getById($_GET['edit']) : null;
$all_news = $actuManager->getAll();
$default_date = $edit_data ? date('Y-m-d', strtotime($edit_data['date_publication'])) : date('Y-m-d');

$edit_avion = isset($_GET['edit_avion']) ? $flotteManager->getById($_GET['edit_avion']) : null;
$all_avions = $flotteManager->getAll();

$edit_activite = isset($_GET['edit_activite']) ? $activiteManager->getById($_GET['edit_activite']) : null;
$all_activites = $activiteManager->getAll();
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
    <title>Panel Admin - AeroClub du Puy</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/stylesDesktop.css">
    <link rel="stylesheet" href="css/espace_membre.css">
</head>

<body>
    <header><?php include 'php_parts/header.php' ?></header>
    <main>
        <section class="div-center auth-wrapper">
            <div class="dashboard-card main-dashboard">
                <h1>Panel Admin <span class="admin-badge">Staff</span></h1>

                <?php if ($msg): ?>
                    <div class="auth-msg success-msg"><?= $msg ?></div>
                <?php endif; ?>
                <?php if ($msg_avion): ?>
                    <div class="auth-msg success-msg"><?= $msg_avion ?></div>
                <?php endif; ?>

                <div class="dashboard-grid">

                    <div class="mini-card full-width">
                        <h3><?= $edit_activite ? "Modifier le tarif" : "Ajouter un tarif" ?></h3>

                        <form method="POST" class="form-card admin-form">
                            <input type="hidden" name="id_activite" value="<?= $edit_activite['id'] ?? '' ?>">

                            <div class="form-main-inputs">
                                <input type="text" name="name" placeholder="Nom du service"
                                    value="<?= htmlspecialchars($edit_activite['name'] ?? '') ?>" required>
                                <input type="text" name="duree" placeholder="Durée"
                                    value="<?= htmlspecialchars($edit_activite['duree'] ?? '') ?>" required>
                            </div>

                            <textarea name="description" placeholder="Description courte"
                                required><?= htmlspecialchars($edit_activite['description'] ?? '') ?></textarea>

                            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 10px; margin-top:10px;">
                                <input type="number" name="prix" placeholder="Prix (€)"
                                    value="<?= $edit_activite['prix'] ?? '' ?>" required>
                                <input type="number" name="nb_places" placeholder="Passagers"
                                    value="<?= $edit_activite['nb_places'] ?? '' ?>" required>
                                <input type="number" name="ordre" placeholder="Ordre d'affichage"
                                    value="<?= $edit_activite['ordre'] ?? '0' ?>">
                            </div>

                            <div class="form-actions" style="margin-top:15px;">
                                <button type="submit" name="save_activite" class="btn-reserve">Enregistrer</button>
                                <?php if ($edit_activite): ?>
                                    <a href="admin_dashboard.php" class="link-delete">Annuler</a>
                                <?php endif; ?>
                            </div>
                        </form>
                    </div>

                    <div class="mini-card full-width">
                        <h3>Activités en ligne</h3>
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>Nom</th>
                                    <th>Prix</th>
                                    <th>Ordre</th>
                                    <th class="txt-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($all_activites as $act): ?>
                                    <tr>
                                        <td class="bold">
                                            <?= ($act['is_highlight']) ? '⭐ ' : '' ?>
                                            <?= htmlspecialchars($act['name']) ?>
                                        </td>
                                        <td><?= $act['prix'] ?> €</td>
                                        <td><?= $act['ordre'] ?></td>
                                        <td class="action-cell">
                                            <a href="?edit_activite=<?= $act['id'] ?>" class="link-edit">Modifier</a>
                                            <a href="?delete_activite=<?= $act['id'] ?>" class="link-delete"
                                                onclick="return confirm('Supprimer cette activitée ?')">Supprimer</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="mini-card full-width">
                        <h3><?= $edit_data ? "Modifier l'actualité" : "Publier une news" ?></h3>
                        <form method="POST" enctype="multipart/form-data" class="form-card admin-form">
                            <input type="hidden" name="id_actu" value="<?= $edit_data['id'] ?? '' ?>">
                            <input type="hidden" name="current_image" value="<?= $edit_data['image_url'] ?? '' ?>">
                            <input type="hidden" name="current_pdf" value="<?= $edit_data['pdf_url'] ?? '' ?>">

                            <div class="form-main-inputs">
                                <input type="text" name="titre" placeholder="Titre de l'article"
                                    value="<?= htmlspecialchars($edit_data['titre'] ?? '') ?>" required>
                                <div class="file-group">
                                    <label>Date de publication</label>
                                    <input type="date" name="date_publication" value="<?= $default_date ?>" required>
                                </div>
                            </div>

                            <textarea name="contenu" placeholder="Texte de l'article"
                                required><?= htmlspecialchars($edit_data['description'] ?? '') ?></textarea>
                            <input type="url" name="lien_externe" placeholder="Lien externe"
                                value="<?= htmlspecialchars($edit_data['lien_externe'] ?? '') ?>">

                            <div class="file-inputs">
                                <div class="file-group">
                                    <label>Image de couverture</label>
                                    <input type="file" name="image_file" accept="image/*">
                                </div>
                                <div class="file-group">
                                    <label>Document PDF</label>
                                    <input type="file" name="pdf_file" accept=".pdf">
                                </div>
                            </div>

                            <div class="form-actions">
                                <button type="submit" name="save_actu" class="btn-reserve">Sauvegarder</button>
                            </div>
                        </form>
                    </div>

                    <div class="mini-card full-width">
                        <h3>Articles en ligne</h3>
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>Titre</th>
                                    <th>Date</th>
                                    <th class="txt-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($all_news):
                                    foreach ($all_news as $n): ?>
                                        <tr>
                                            <td class="bold"><?= htmlspecialchars($n['titre']) ?></td>
                                            <td class="txt-small"><?= date('d/m/Y', strtotime($n['date_publication'])) ?></td>
                                            <td class="action-cell">
                                                <a href="?edit=<?= $n['id'] ?>" class="link-edit">Modifier</a>
                                                <a href="?delete=<?= $n['id'] ?>" class="link-delete"
                                                    onclick="return confirm('Supprimer ?')">Supprimer</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="mini-card full-width">
                        <h3><?= $edit_avion ? "Modifier l'appareil" : "Ajouter à la Flotte" ?></h3>
                        <form method="POST" enctype="multipart/form-data" class="form-card admin-form">
                            <input type="hidden" name="id_avion" value="<?= $edit_avion['id'] ?? '' ?>">
                            <input type="hidden" name="current_image_avion" value="<?= $edit_avion['image'] ?? '' ?>">

                            <div class="form-main-inputs">
                                <input type="text" name="immatriculation" placeholder="Immatriculation (ex: F-BUSH)"
                                    value="<?= htmlspecialchars($edit_avion['immatriculation'] ?? '') ?>" required>
                                <input type="text" name="type" placeholder="Modèle (ex: DR400-140)"
                                    value="<?= htmlspecialchars($edit_avion['type'] ?? '') ?>" required>
                            </div>

                            <div>
                                <input type="text" name="puissance" placeholder="Puissance (ex: 152 CH)"
                                    value="<?= htmlspecialchars($edit_avion['puissance'] ?? '') ?>">
                                <input type="text" name="vitesse" placeholder="Vitesse (ex: 110 KT)"
                                    value="<?= htmlspecialchars($edit_avion['vitesse_croisiere'] ?? '') ?>">
                                <input type="text" name="autonomie" placeholder="Autonomie (ex: 4h30)"
                                    value="<?= htmlspecialchars($edit_avion['autonomie'] ?? '') ?>">
                            </div>

                            <div class="file-group">
                                <label>Photo de l'appareil</label>
                                <input type="file" name="avion_file" accept="image/*">
                            </div>

                            <div class="form-actions">
                                <button type="submit" name="save_avion" class="btn-reserve">Sauvegarder
                                    l'appareil</button>
                            </div>
                        </form>
                    </div>

                    <div class="mini-card full-width">
                        <h3>Liste de la Flotte</h3>
                        <div class="table-container">
                            <table class="admin-table">
                                <thead>
                                    <tr>
                                        <th>Immat</th>
                                        <th>Type</th>
                                        <th>Puissance</th>
                                        <th class="txt-right">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($all_avions):
                                        foreach ($all_avions as $av): ?>
                                            <tr>
                                                <td class="bold"><?= htmlspecialchars($av['immatriculation']) ?></td>
                                                <td class="txt-small"><?= htmlspecialchars($av['type']) ?></td>
                                                <td class="txt-small"><?= htmlspecialchars($av['puissance']) ?></td>
                                                <td class="action-cell">
                                                    <a href="?edit_avion=<?= $av['id'] ?>" class="link-edit">Modifier</a>
                                                    <a href="?delete_avion=<?= $av['id'] ?>" class="link-delete"
                                                        onclick="return confirm('Supprimer cet avion ?')">Supprimer</a>
                                                </td>
                                            </tr>
                                        <?php endforeach; endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
                <div class="dashboard-footer">
                    <a href="logout.php" class="btn-logout">Déconnexion</a>
                </div>
            </div>
        </section>
    </main>
    <?php include 'php_parts/footer.php' ?>
</body>

</html>