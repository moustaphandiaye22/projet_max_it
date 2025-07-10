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
    private ?Personne $personne = null; // Correction : éviter la récursion infinie
    private array $transaction;
    
    public function __construct($id=0,$solde=0,$numerotelephone=0,)
    {
        $this->type = 'principal';
        $this->transaction= [];
        $this->personne = null; // Correction : éviter la récursion infinie
        
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
