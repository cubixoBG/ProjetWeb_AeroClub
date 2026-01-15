<?php 

class Flotte {
    private int $id;
    private string $name;
    private string $immatriculation;
    private string $type;
    private string $puissance;
    private string $vitesse_croisiere;
    private string $autonomie;

    public function __construct(string $name, string $immatriculation, string $type, string $puissance, string $vitesse_croisiere, string $autonomie) {
        $this->name = $name;
        $this->immatriculation = $immatriculation;
        $this->type = $type;
        $this->puissance = $puissance;
        $this->vitesse_croisiere = $vitesse_croisiere;
        $this->autonomie = $autonomie;
    }

    public function contactForm(): void {
        // Logique formulaire
    }

    public function recupCompte(): void {
        // Récupération infos
    }
}

?>