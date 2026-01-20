<?php
session_start();
ini_set('display_errors', 0);
header('Content-Type: application/json');

try {
    $root = dirname(__DIR__); 
    
    require_once $root . '/configuration/config.php';
    require_once $root . '/class/Compte.php';

    $response = ['success' => false, 'message' => 'Données manquantes'];

    if (isset($_POST['action'])) {
        if ($_POST['action'] === 'login') {
            $auth = new Compte();
            if ($auth->connexion($_POST['email'], $_POST['mdp'])) {
                // MODIFICATION ICI : on ajoute le rôle dans la réponse JSON
                $response = [
                    'success' => true,
                    'message' => 'Connexion réussie',
                    'user_id' => $_SESSION['user_id'],
                    'role'    => $_SESSION['user_role'] 
                ];
            } else {
                $response['message'] = 'Email ou mot de passe incorrect';
            }
        } 
        elseif ($_POST['action'] === 'register') {
            $nouveau = new Compte($_POST['name'], $_POST['lastname'], $_POST['email'], $_POST['mdp']);
            if ($nouveau->creerCompte()) {
                $response = ['success' => true, 'message' => 'Compte créé !'];
            } else {
                $response['message'] = 'Erreur lors de la création';
            }
        }
    }
    echo json_encode($response);

} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
exit;