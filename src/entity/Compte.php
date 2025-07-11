<?php
namespace src\entity;

use App\Core\Abstract\AbstractEntity;
use DateTime;
use src\entity\Transaction;
use src\entity\Personne;

class Compte extends AbstractEntity{
    private int $id;
    private float $solde;
    private int $numerotelephone;
    private \DateTime $datecreation;
    private $type= 'principal';
    private ?Personne $personne = null;
    private array $transaction;
    
    public function __construct($id=0,$solde=0,$numerotelephone=0,)
    {
        $this->type = 'principal';
        $this->transaction= [];
        $this->personne = null; 
        
    }
    
    public function getPersonne(): Personne {
        return $this->personne;
    }
   
    public function getTransaction(): array {
        return $this->transaction;
    }
  
    public function addTransaction(Transaction $transaction): void {
        $this->transaction[] = $transaction;
    }
    public function setId(int $id): void {
        $this->id = $id;
    }
    public function setSolde(float $solde): void {
        $this->solde = $solde;
    }
    public function setPersonne(Personne $personne): void {
        $this->personne = $personne;
    }

    public function getSolde(): float {
        return $this->solde;
    }
    public function getNumeroTelephone(): int {
        return $this->numerotelephone;
    }
    public function getType(): string {
        return $this->type;
    }
    public function getId(): int {
        return $this->id;
    }

public function toArray(): array
    {
        return [
            'id' => $this->id,
            'solde' => $this->solde,
            'numerotelephone' => $this->numerotelephone,
            'datecreation' => $this->datecreation,
            'type' => $this->type,
        ];
    }
    public function toObject($data): object
    {
        return (object) $data;
    }
    public function toJson(): string
    {
        return json_encode($this->toArray());
    }
}
