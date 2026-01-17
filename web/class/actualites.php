<?php
class Actualites {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Récupérer toutes les actualités
    public function getAll() {
        return $this->db->query("SELECT * FROM Actualite ORDER BY date_publication DESC")->fetchAll();
    }

    // Récupérer une seule actualité par son ID
    public function getById($id) {
        $req = $this->db->prepare("SELECT * FROM Actualite WHERE id = ?");
        $req->execute([$id]);
        return $req->fetch();
    }

    // Ajouter ou mettre à jour
    public function save($data) {
        if (!empty($data['id'])) {
            // Update
            $req = $this->db->prepare("UPDATE Actualite SET titre=?, description=?, lien_externe=?, image_url=?, pdf_url=?, date_publication=? WHERE id=?");
            return $req->execute([
                $data['titre'], $data['description'], $data['lien_externe'], 
                $data['image_url'], $data['pdf_url'], $data['date_publication'], $data['id']
            ]);
        } else {
            // Insert
            $req = $this->db->prepare("INSERT INTO Actualite (titre, description, lien_externe, image_url, pdf_url, date_publication) VALUES (?, ?, ?, ?, ?, ?)");
            return $req->execute([
                $data['titre'], $data['description'], $data['lien_externe'], 
                $data['image_url'], $data['pdf_url'], $data['date_publication']
            ]);
        }
    }

    // Supprimer
    public function delete($id) {
        $req = $this->db->prepare("DELETE FROM Actualite WHERE id = ?");
        return $req->execute([$id]);
    }
}
?>