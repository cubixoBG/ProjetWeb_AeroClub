<?php

class Activite {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    
    public function getAll() {
        $query = "SELECT * FROM Activite ORDER BY ordre ASC, id ASC";
        return $this->db->query($query)->fetchAll(PDO::FETCH_ASSOC);
    }
}