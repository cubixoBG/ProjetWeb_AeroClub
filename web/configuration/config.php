<?php
// config.php

define('DB_HOST', 'mysql'); 
define('DB_NAME', 'aeroclub');
define('DB_USER', 'root');
define('DB_PASS', 'rootpass');

function getPDO() {
    try {
        $pdo = new PDO(
            "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8",
            DB_USER,
            DB_PASS
        );
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        die("Erreur de connexion : " . $e->getMessage());
    }
}