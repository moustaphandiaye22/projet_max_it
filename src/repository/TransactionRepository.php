<?php
namespace src\repository;

use App\Core\Abstract\AbstractRepository;

class TransactionRepository extends AbstractRepository
{
    public function insert(): void
    {
        // Implementation for inserting a transaction
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
        // Implementation for selecting transactions by filter criteria
        return [];
    }
    
}
