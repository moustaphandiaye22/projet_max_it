<?php
namespace Src\Entity;

use App\Core\Abstract\AbstractEntity;
use DateTime;
use Src\Entity\Transaction;
use Src\Entity\Personne;

class Compte extends AbstractEntity{
    private int $id;
    private float $solde;
    private string $numero_telephone;
    private \DateTime $datecreation;
    private string $type = 'principal';
    private ?Personne $personne = null;
    private array $transaction;

    public function __construct($id = 0, $solde = 0, $numero_telephone = '')
    {
        $this->id = $id;
        $this->solde = $solde;
        $this->numero_telephone = $numero_telephone;
        $this->type = 'principal';
        $this->transaction = [];
        $this->personne = null;
        $this->datecreation = new \DateTime();
    }

    public function getPersonne(): ?Personne {
        return $this->personne;
    }

    public function setPersonne(Personne $personne): void {
        $this->personne = $personne;
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

    public function getId(): int {
        return $this->id;
    }

    public function setSolde(float $solde): void {
        $this->solde = $solde;
    }

    public function getSolde(): float {
        return $this->solde;
    }

    public function setNumeroTelephone(string $numero): void {
        $this->numero_telephone = $numero;
    }

    public function getNumeroTelephone(): string {
        return $this->numero_telephone;
    }

    public function setType(string $type): void {
        $this->type = $type;
    }

    public function getType(): string {
        return $this->type;
    }

    public function setDateCreation(\DateTime $date): void {
        $this->datecreation = $date;
    }

    public function getDateCreation(): \DateTime {
        return $this->datecreation;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'solde' => $this->solde,
            'numerotelephone' => $this->numero_telephone,
            'datecreation' => $this->datecreation->format('Y-m-d'),
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
