<?php

class Compte {
    protected int $id;
    protected string $name;
    protected string $lastName;
    protected ?string $num;
    protected string $email;
    protected string $mdp;
    protected bool $role;

    public function __construct(string $name, string $lastName, string $email, string $mdp) {
        $this->name = $name;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->mdp = password_hash($mdp, PASSWORD_DEFAULT);
    }

    public function verificationCompte(): bool {
        // vérification du compte
        return true;
    }

    public function connexion(string $email, string $mdp): bool {
        // authentification
        return true;
    }
}