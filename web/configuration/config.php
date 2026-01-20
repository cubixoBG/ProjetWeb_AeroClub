<?php
// config.php

define('DB_HOST', 'localhost'); 
define('DB_NAME', 'aeroclub');
define('DB_USER', 'root');
define('DB_PASS', '');

$cleMeteo = "a221fcf8378ab5ca6e6911f79368a0aa";

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