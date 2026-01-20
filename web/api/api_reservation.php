<?php
ob_start();
session_start();
ini_set('display_errors', 0);
header('Content-Type: application/json');

try {
    require_once dirname(__DIR__) . '/configuration/config.php';

    if (!isset($_SESSION['user_id'])) {
        throw new Exception("Session vide. Connectez-vous à nouveau.");
    }

    $db = getPDO();
    
    $query = "INSERT INTO Reservation (id_compte, id_activite, date_reservation) VALUES (:uid, :aid, :dres)";
    $stmt = $db->prepare($query);
    $stmt->execute([
        ':uid'  => $_SESSION['user_id'],
        ':aid'  => $_POST['id_activite'],
        ':dres' => $_POST['date_reservation']
    ]);

    ob_clean();
    echo json_encode(['success' => true, 'message' => 'Réservation réussie !']);

} catch (Exception $e) {
    ob_clean();
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
exit;