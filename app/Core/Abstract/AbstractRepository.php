<?php
namespace App\Core\Abstract;
use App\Core\Database;

abstract class AbstractRepository
{
protected \PDO $pdo;

    public function __construct() {
            $this->pdo =  Database::getInstance();
    }
    
    abstract public function insert();
    abstract public function update();
    abstract public function delete();
    abstract public function selectById(int $id);
    abstract public function selectAll(): array;
    abstract public function selectBy(array $filtre): array;
    
}