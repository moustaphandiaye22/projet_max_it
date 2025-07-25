<?php
namespace Src\Repository;

use App\Core\Abstract\AbstractRepository;

class TransactionRepository extends AbstractRepository
{
    public function insert(): void
    {       
    }

    
    public function insertTransaction(\Src\Entity\Transaction $transaction): void
    {
        $query = "INSERT INTO transaction (reference, montant, date_transaction, type, compte_id) VALUES (:reference, :montant, :date_transaction, :type, :compte_id)";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':reference', $transaction->getReference());
        $stmt->bindValue(':montant', $transaction->getMontant());
        $stmt->bindValue(':date_transaction', $transaction->getDatetransaction()->format('Y-m-d H:i:s'));
        $stmt->bindValue(':type', $transaction->getType());
        $stmt->bindValue(':compte_id', $transaction->getCompte() && method_exists($transaction->getCompte(), 'getId') ? $transaction->getCompte()->getId() : null, \PDO::PARAM_INT);
        $stmt->execute();
        $transaction->setId($this->pdo->lastInsertId());
    }

    public function update(): void
    {
        // Implementation for updating a transaction
    }

    public function delete(): void
    {
        // Implementation for deleting a transaction
    }

    public function selectById(int $id): array
    {
        // Implementation for selecting a transaction by ID
        return [];
    }

    public function selectAll(): array
    {
        // Implementation for selecting all transactions
        return [];
    }

    public function selectBy(array $filter): array
    {
        $sql = "SELECT * FROM transaction WHERE 1=1";
        $params = [];
        if (isset($filter['compte_id'])) {
            $sql .= " AND compte_id = :compte_id";
            $params[':compte_id'] = $filter['compte_id'];
        }
        $sql .= " ORDER BY date_transaction DESC, id DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        $transactions = [];
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $transactions[] = $row;
        }
        return $transactions;
    }
    
}
