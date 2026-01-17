<?php
require_once 'class/Compte.php';
require_once 'class/flotte.php';

header('Content-Type: application/json');

try {
    $db = getPDO();
    $flotteManager = new Flotte($db);
    $avions = $flotteManager->getAvions();

    // On renvoie les données au format JSON
    echo json_encode($avions);
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>