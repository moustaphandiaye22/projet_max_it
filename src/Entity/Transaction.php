<?php
namespace Src\Entity;

use DateTime;
use Src\Entity\Compte;

class Transaction{
   
    private int $id;
    private string $reference;
    private float $montant;
    private \DateTime $datetransaction;
    private string $type ='retrait';
    private ?Compte $compte = null;

    public function __construct($id=0, $reference='', $montant=0, $type='retrait')
    {
        $this->id = $id;
        $this->reference = $reference;
        $this->montant = $montant;
        $this->type = $type;
        $this->compte = null; 
        $this->datetransaction = new DateTime();
    }
     public function getReference(): string {
        return $this->reference;
    }

    
    public function getCompte(): ?Compte {
        return $this->compte;
    }
    public function setCompte(Compte $compte): void {
        $this->compte = $compte;    
    }
    public function toArray(): array {
        return [
            'id' => $this->id,
            'reference' => $this->reference,
            'montant' => $this->montant,
            'datetransaction' => $this->datetransaction->format('Y-m-d H:i:s'),
            'type' => $this->type,
            'compte' => $this->compte ? $this->compte->toArray() : null
        ];
    }
    public function toObject($data): object {
        return (object) $data;
    }
    public function toJson(): string {
        return json_encode($this->toArray());
    }
    public function getMontant(): float {
        return $this->montant;
    }
    public function getDatetransaction(): \DateTime {
        return $this->datetransaction;
    }
    public function getType(): string {
        return $this->type;
    }
    public function setId(int $id): void {
        $this->id = $id;
    }
    // Ajout du getter getId pour Transaction
    public function getId(): int {
        return $this->id;
    }

}