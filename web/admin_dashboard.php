<?php
session_start();
require_once 'class/Compte.php';
require_once 'class/actualites.php';

// Verif du role admin
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: espace_membre.php");
    exit();
}

$db = getPDO();
$actuManager = new Actualites($db); 
$msg = "";
$uploadDir = 'img/';

// Suppr
if (isset($_GET['delete'])) {
    if ($actuManager->delete($_GET['delete'])) {
        $msg = "Article supprimé.";
    }
}

// Ajout ou Modif
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

// Recup des données
$edit_data = isset($_GET['edit']) ? $actuManager->getById($_GET['edit']) : null;
$all_news = $actuManager->getAll();
$default_date = $edit_data ? date('Y-m-d', strtotime($edit_data['date_publication'])) : date('Y-m-d');
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Admin - AeroClub du Puy</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/stylesDesktop.css">
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
                        <h3><?= $edit_data ? "Modifier l'actualité" : "Publier une news" ?></h3>
                        <form method="POST" enctype="multipart/form-data" class="form-card admin-form">
                            <input type="hidden" name="id_actu" value="<?= $edit_data['id'] ?? '' ?>">
                            <input type="hidden" name="current_image" value="<?= $edit_data['image_url'] ?? '' ?>">
                            <input type="hidden" name="current_pdf" value="<?= $edit_data['pdf_url'] ?? '' ?>">

                            <div class="form-main-inputs">
                                <input type="text" name="titre" placeholder="Titre de l'article" value="<?= htmlspecialchars($edit_data['titre'] ?? '') ?>" required>
                                <div class="file-group">
                                    <label>Date de publication</label>
                                    <input type="date" name="date_publication" value="<?= $default_date ?>" required>
                                </div>
                            </div>

                            <textarea name="contenu" placeholder="Texte de l'article" required><?= htmlspecialchars($edit_data['description'] ?? '') ?></textarea>
                            <input type="url" name="lien_externe" placeholder="Lien externe (http://...)" value="<?= htmlspecialchars($edit_data['lien_externe'] ?? '') ?>">

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
                                <?php if($all_news): foreach ($all_news as $n): ?>
                                <tr>
                                    <td class="bold"><?= htmlspecialchars($n['titre']) ?></td>
                                    <td class="txt-small"><?= date('d/m/Y', strtotime($n['date_publication'])) ?></td>
                                    <td class="action-cell">
                                        <a href="?edit=<?= $n['id'] ?>" class="link-edit">Modifier</a>
                                        <a href="?delete=<?= $n['id'] ?>" class="link-delete" onclick="return confirm('Supprimer ?')">Supprimer</a>
                                    </td>
                                </tr>
                                <?php endforeach; endif; ?>
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