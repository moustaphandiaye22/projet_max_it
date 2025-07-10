<?php
namespace src\repository;

use src\entity\Compte;
use App\Core\Abstract\AbstractRepository;

class CompteRepository extends AbstractRepository
{
    public function insert(): void
    {
        // Implementation for inserting a Compte
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
        // Implementation for selecting Comptes by filter
        return [];
    }



}