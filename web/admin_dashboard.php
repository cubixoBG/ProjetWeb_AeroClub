<?php
session_start();
require_once 'class/Compte.php';

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: espace_membre.php");
    exit();
}

$db = getPDO();
$msg = "";
$uploadDir = 'img/';

// --- SAUVEGARDE ---
if (isset($_POST['save_actu'])) {
    $titre = $_POST['titre'];
    $description = $_POST['contenu'];
    $lien = $_POST['lien_externe'];
    $id = $_POST['id_actu'] ?? null;
    // On récupère la date du formulaire
    $date_publication = $_POST['date_publication'];

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

    if ($id) {
        $req = $db->prepare("UPDATE Actualite SET titre=?, description=?, lien_externe=?, image_url=?, pdf_url=?, date_publication=? WHERE id=?");
        $req->execute([$titre, $description, $lien, $imagePath, $pdfPath, $date_publication, $id]);
        $msg = "Article mis à jour !";
    } else {
        $req = $db->prepare("INSERT INTO Actualite (titre, description, lien_externe, image_url, pdf_url, date_publication) VALUES (?, ?, ?, ?, ?, ?)");
        $req->execute([$titre, $description, $lien, $imagePath, $pdfPath, $date_publication]);
        $msg = "Article publié !";
    }
}

// --- SUPPRESSION ---
if (isset($_GET['delete'])) {
    $req = $db->prepare("DELETE FROM Actualite WHERE id = ?");
    $req->execute([$_GET['delete']]);
    $msg = "Article supprimé.";
}

$edit_data = null;
if (isset($_GET['edit'])) {
    $req = $db->prepare("SELECT * FROM Actualite WHERE id = ?");
    $req->execute([$_GET['edit']]);
    $edit_data = $req->fetch();
}

// Définition de la date par défaut (Date du jour au format YYYY-MM-DD)
$default_date = $edit_data ? date('Y-m-d', strtotime($edit_data['date_publication'])) : date('Y-m-d');

$all_news = $db->query("SELECT * FROM Actualite ORDER BY date_publication DESC")->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Admin - AeroClub</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/espace_membre.css">
    <link rel="stylesheet" href="css/stylesDesktop.css">
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

                <div class="dashboard-grid">
                    <div class="mini-card full-width">
                        <h3><?= $edit_data ? "Modifier" : "Publier" ?> une news</h3>
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

                            <input type="url" name="lien_externe" placeholder="Lien externe (http://...)"
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
                                <?php foreach ($all_news as $n): ?>
                                    <tr>
                                        <td class="bold"><?= htmlspecialchars($n['titre']) ?></td>
                                        <td class="txt-small"><?= date('d/m/Y', strtotime($n['date_publication'])) ?></td>
                                        <td class="action-cell">
                                            <a href="?edit=<?= $n['id'] ?>" class="link-edit">Modifier</a>
                                            <a href="?delete=<?= $n['id'] ?>" class="link-delete"
                                                onclick="return confirm('Supprimer ?')">Supprimer</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
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