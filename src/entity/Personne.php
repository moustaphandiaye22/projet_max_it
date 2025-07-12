<?php
namespace src\entity;

use App\Core\Abstract\AbstractEntity;
use src\entity\Compte;

class Personne extends AbstractEntity {
    private int $id;
    private string $nom;
    private string $prenom;
    private string $adresse;
    private string $login;
    private string $password;
    private string $numero_telephone;
    private string $photo_recto_carte_identite;
    private string $photo_verso_carte_identite;
    private string $numero_carte_identite;
    private string $type;
    private ?Compte $compte = null;

    public function __construct($id=0,$nom='',$prenom='',$adresse='',$login='',$password='',$numero_telephone='',$photo_recto_carte_identite='',$photo_verso_carte_identite='',$numero_carte_identite='',$type='client')
    {
        $this->id = $id;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->adresse = $adresse;
        $this->login = $login;
        $this->password = $password;
        $this->numero_telephone = $numero_telephone;
        $this->photo_recto_carte_identite = $photo_recto_carte_identite;
        $this->photo_verso_carte_identite = $photo_verso_carte_identite;
        $this->numero_carte_identite = $numero_carte_identite;
        $this->type = $type;
        $this->compte = null; // Correction : éviter la récursion infinie
    }

    
    public function getCompte(): ?Compte {
        return $this->compte;
    }
    public function addCompte(Compte $compte): void {
        $this->compte = $compte;
    }   
    public function toArray(): array {
        return [
            'id' => $this->id,
            'nom' => $this->nom,
            'prenom' => $this->prenom,
            'adresse' => $this->adresse,
            'login' => $this->login,
            'password' => $this->password,
            'numero_telephone' => $this->numero_telephone,
            'photo_recto_carte_identite' => $this->photo_recto_carte_identite,
            'photo_verso_carte_identite' => $this->photo_verso_carte_identite,
            'numero_carte_identite' => $this->numero_carte_identite,
            'type' => $this->type,
            'compte' => $this->compte instanceof \src\entity\Compte ? $this->compte->toArray() : $this->compte
        ];
    }
    public function toObject($data): object {
        return (object) $data;
    }
    public function toJson(): string {
        return json_encode($this->toArray());
    }
    public function getId(): int { return $this->id; }
    public function getNom(): string { return $this->nom; }
    public function getPrenom(): string { return $this->prenom; }
    public function getAdresse(): string { return $this->adresse; }
    public function getLogin(): string { return $this->login; }
    public function getPassword(): string { return $this->password; }
    public function getPhotoRectoCarteIdentite(): string { return $this->photo_recto_carte_identite; }
    public function getPhotoVersoCarteIdentite(): string { return $this->photo_verso_carte_identite; }
    public function getNumeroCarteIdentite(): string { return $this->numero_carte_identite; }
    public function getType(): string { return $this->type; }
    public function getNumeroTelephone(): string { return $this->numero_telephone; }
    public function setId(int $id): void {
        $this->id = $id;
    }
    
}