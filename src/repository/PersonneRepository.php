<?php
namespace src\repository;

use src\entity\Personne;
use App\Core\Abstract\AbstractRepository;
use app\config\ErrorMessage;
use PDO;

 class PersonneRepository extends AbstractRepository{
        
    public function __construct() {
          parent::__construct();
      }
       public function SelectByLogin(string $login): ?Personne {
        $query = "SELECT * FROM personne WHERE login = :login";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':login', $login);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$data) {
            return null;
        }
        return $this->toObject($data);
    }
 
    public function insert(): void
    {
    }


    public function insertPersonne(Personne $personne) {
        try {
            $query = "INSERT INTO personne (nom, prenom, adresse, login, password, numero_telephone, photo_recto_carte_identite, photo_verso_carte_identite, numero_carte_identite, type) VALUES (:nom, :prenom, :adresse, :login, :password, :numero_telephone, :photo_recto_carte_identite, :photo_verso_carte_identite, :numero_carte_identite, :type)";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindValue(':nom', $personne->getNom());
            $stmt->bindValue(':prenom', $personne->getPrenom());
            $stmt->bindValue(':adresse', $personne->getAdresse());
            $stmt->bindValue(':login', $personne->getLogin());
            $stmt->bindValue(':password', $personne->getPassword());
            $stmt->bindValue(':numero_telephone', $personne->getNumeroTelephone());
            $stmt->bindValue(':photo_recto_carte_identite', $personne->getPhotoRectoCarteIdentite());
            $stmt->bindValue(':photo_verso_carte_identite', $personne->getPhotoVersoCarteIdentite());
            $stmt->bindValue(':numero_carte_identite', $personne->getNumeroCarteIdentite());
            $stmt->bindValue(':type', $personne->getType());
            $stmt->execute();
            $lastId = (int)$this->pdo->lastInsertId('personne_id_seq');
            if ($lastId > 0) {
                $personne->setId($lastId);
                return ['personne' => $personne];
            } else {
                return ['errors' => ['sql' => ["Erreur lors de l'insertion de la personne (ID non généré)."]]];
            }
        } catch (\PDOException $e) {
           
            // On retourne l'erreur SQL proprement
            return ['errors' => ['sql' => [$e->getMessage()]]];
        }
    }

    public function existsByTelephone(string $numero): bool {
        $query = "SELECT COUNT(*) FROM personne WHERE numero_telephone = :numero_telephone";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':numero_telephone', $numero);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    public function existsByCni(string $cni): bool {
        $query = "SELECT COUNT(*) FROM personne WHERE numero_carte_identite = :numero_carte_identite";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':numero_carte_identite', $cni);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    public function update() {}
    public function delete() {}

    public function selectById(int $id)
    {
        $query = "SELECT * FROM personne WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        $data = $stmt->fetch(\PDO::FETCH_ASSOC);
        if (!$data) return null;
        return $this->toObject($data);
    }

    public function selectAll(): array
    {
        $query = "SELECT * FROM personne";
        $stmt = $this->pdo->query($query);
        $result = [];
        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[] = $this->toObject($data);
        }
        return $result;
    }

    public function selectBy(array $filtre): array
    {
        $query = "SELECT * FROM personne";
        $conditions = [];
        foreach ($filtre as $key => $value) {
            $conditions[] = "$key = :$key";
        }
        if ($conditions) {
            $query .= " WHERE " . implode(" AND ", $conditions);
        }
        $stmt = $this->pdo->prepare($query);
        foreach ($filtre as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }
        $stmt->execute();
        $result = [];
        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[] = $this->toObject($data);
        }
        return $result;
    }

     private function toObject(array $data): ?Personne {
        return new Personne(
            $data['id'] ?? 0,
            $data['nom'] ?? '',
            $data['prenom'] ?? '',
            $data['adresse'] ?? '',
            $data['login'] ?? '',
            $data['password'] ?? '',
            $data['numero_telephone'] ?? '',
            $data['photo_recto_carte_identite'] ?? '',
            $data['photo_verso_carte_identite'] ?? '',
            $data['numero_carte_identite'] ?? '',
            $data['type'] ?? 'client'
        );
    }
 }