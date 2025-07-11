<?php
namespace src\repository;

use src\entity\Compte;
use App\Core\Abstract\AbstractRepository;

class CompteRepository extends AbstractRepository
{
    public function insert(): void
    {
       
    }

   
    public function insertCompte(Compte $compte): int
    {
        $ql = "INSERT INTO compte (solde, numerotelephone, datecreation, type, client_id) VALUES (:solde, :numerotelephone, :datecreation, :type, :client_id)";
        $stmt = $this->pdo->prepare($ql);
        $stmt->bindValue(':solde', $compte->getSolde());
        $stmt->bindValue(':numerotelephone', $compte->getNumeroTelephone());
        $stmt->bindValue(':datecreation', (new \DateTime())->format('Y-m-d'));
        $stmt->bindValue(':type', $compte->getType());
        $stmt->bindValue(':client_id', $compte->getPersonne() ? $compte->getPersonne()->getId() : null, \PDO::PARAM_INT);
        $stmt->execute();
        return (int)$this->pdo->lastInsertId();
    }

    public function update(): void
    {
        // Implementation for updating a Compte
    }

    public function delete(): void
    {
        // Implementation for deleting a Compte
    }

    public function selectById(int $id): ?Compte
    {
        // Implementation for selecting a Compte by ID
        return null;
    }

    public function selectAll(): array
    {
        // Implementation for selecting all Comptes
        return [];
    }

    public function selectBy(array $filtre): array
    {
        $sql = "SELECT * FROM compte WHERE 1=1";
        $params = [];
        if (isset($filtre['personne_id'])) {
            $sql .= " AND client_id = :client_id";
            $params[':client_id'] = $filtre['personne_id'];
        }
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        $comptes = [];
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $compte = new \src\entity\Compte();
            $compte->setId($row['id']);
            $compte->setSolde($row['solde']);
            // ...ajoute les autres setters si besoin...
            $comptes[] = $compte;
        }
        return $comptes;
    }



}