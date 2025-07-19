<?php
namespace Src\Repository;

use Src\Entity\Compte;
use App\Core\Abstract\AbstractRepository;

class CompteRepository extends AbstractRepository
{
    public function __construct() {
        parent::__construct();
    }

    public function insert(): void
    {
       
    }

   
    public function insertCompte(Compte $compte): int
    {
        try {
            $sql = "INSERT INTO compte (solde, numero_telephone, date_creation, type, client_id) 
                    VALUES (:solde, :numero_telephone, :date_creation, :type, :client_id)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':solde', $compte->getSolde());
            $stmt->bindValue(':numero_telephone', $compte->getNumeroTelephone());
            $stmt->bindValue(':date_creation', $compte->getDateCreation()->format('Y-m-d'));
            $stmt->bindValue(':type', $compte->getType());
            $stmt->bindValue(':client_id', $compte->getPersonne() ? $compte->getPersonne()->getId() : null, \PDO::PARAM_INT);
            $stmt->execute();
            return (int)$this->pdo->lastInsertId('compte_id_seq');
        } catch (\PDOException $e) {
            error_log('Erreur insertCompte: ' . $e->getMessage());
            return -1;
        }
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
        if (isset($filtre['client_id'])) {
            $sql .= " AND client_id = :client_id";
            $params[':client_id'] = $filtre['client_id'];
        }
        if (isset($filtre['id'])) {
            $sql .= " AND id = :id";
            $params[':id'] = $filtre['id'];
        }
        if (isset($filtre['numero_telephone'])) {
            $sql .= " AND numero_telephone = :numero_telephone";
            $params[':numero_telephone'] = $filtre['numero_telephone'];
        }
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        $result = [];
        while ($data = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $result[] = $this->toObject($data);
        }
        return $result;
    }

    private function toObject(array $data): ?\Src\Entity\Compte {
        $compte = new \Src\Entity\Compte(
            $data['id'] ?? 0,
            $data['solde'] ?? 0,
            $data['numero_telephone'] ?? ''
        );
        if (isset($data['type'])) {
            $compte->setType($data['type']);
        }
        return $compte;
    }

    public function updateType($compteId, $type) {
        $sql = "UPDATE compte SET type = :type WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':type', $type);
        $stmt->bindValue(':id', $compteId, \PDO::PARAM_INT);
        $stmt->execute();
    }

    public function updateSolde($compteId, $nouveauSolde) {
        $sql = "UPDATE compte SET solde = :solde WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':solde', $nouveauSolde);
        $stmt->bindValue(':id', $compteId);
        $stmt->execute();
    }
}