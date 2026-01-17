<?php
class Flotte {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAll() {
        return $this->db->query("SELECT * FROM Avion ORDER BY id DESC")->fetchAll();
    }

    public function getById($id) {
        $req = $this->db->prepare("SELECT * FROM Avion WHERE id = ?");
        $req->execute([$id]);
        return $req->fetch();
    }

    public function save($data) {
        if (!empty($data['id'])) {
            // Update avec tes vrais noms de colonnes
            $req = $this->db->prepare("UPDATE Avion SET immatriculation=?, type=?, puissance=?, vitesse_croisiere=?, autonomie=?, image=? WHERE id=?");
            return $req->execute([
                $data['immatriculation'], $data['type'], $data['puissance'], 
                $data['vitesse_croisiere'], $data['autonomie'], $data['image'], $data['id']
            ]);
        } else {
            // Insert
            $req = $this->db->prepare("INSERT INTO Avion (immatriculation, type, puissance, vitesse_croisiere, autonomie, image) VALUES (?, ?, ?, ?, ?, ?)");
            return $req->execute([
                $data['immatriculation'], $data['type'], $data['puissance'], 
                $data['vitesse_croisiere'], $data['autonomie'], $data['image']
            ]);
        }
    }

    public function delete($id) {
        $req = $this->db->prepare("DELETE FROM Avion WHERE id = ?");
        return $req->execute([$id]);
    }
}
?>