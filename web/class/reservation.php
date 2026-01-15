<?php 

class Reservation {
    private int $id;
    private string $nom;
    private int $nb_person;
    private int $id_compte;
    private int $id_activite;
    private DateTime $date_heure;

    public function reservation(): void {
        // Créer une résa
    }

    public function annuler(): void {
        // Annuler la résa
    }

    public function archiver(): void {
        // Archiver la résa
    }
}

class Services { // Correspond à "Activité" dans ta BDD
    private int $id;
    private string $name;
    private string $type;
    private string $description;
    private int $prix;
    private DateTime $date_heure;

    public function __construct(string $name, string $type, string $description, int $prix, DateTime $date_heure) {
        $this->name = $name;
        $this->type = $type;
        $this->description = $description;
        $this->prix = $prix;
        $this->date_heure = $date_heure;
    }

    public function verifierDisponibilite(): bool {
        return true;
    }

    public function remboursementFait(): void { }
}

?>