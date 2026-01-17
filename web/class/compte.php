<?php
require_once 'configuration/config.php';

class Compte {
    protected string $name;
    protected string $lastName;
    protected string $email;
    protected string $mdp;
    private $db;

    public function __construct(string $name = "", string $lastName = "", string $email = "", string $mdp = "") {
        $this->name = $name;
        $this->lastName = $lastName;
        $this->email = $email;
        if (!empty($mdp)) {
            $this->mdp = password_hash($mdp, PASSWORD_DEFAULT);
        }
        
        $this->db = getPDO();
    }

    public function creerCompte(): bool {
        $req = $this->db->prepare("INSERT INTO Compte (name, lastname, email, mdp, role) VALUES (?, ?, ?, ?, 'membre')");
        return $req->execute([$this->name, $this->lastName, $this->email, $this->mdp]);
    }

    public function connexion(string $email, string $mdp): bool {
        $req = $this->db->prepare("SELECT * FROM Compte WHERE email = ?");
        $req->execute([$email]);
        $user = $req->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($mdp, $user['mdp'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_role'] = $user['role'];
            return true;
        }
        return false;
    }
}