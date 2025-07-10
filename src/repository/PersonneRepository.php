<?php
namespace src\repository;

use src\entity\Personne;
use App\Core\Abstract\AbstractRepository;
use PDO;

 class PersonneRepository extends AbstractRepository{
        
    public function __construct() {
          parent::__construct();
      }
       

    public function SelectByLoginAndPassword(string $login, string $password): ?Personne {
        $errors = [];
        if (empty($login)) {
            $errors['login'][] = 'Le login est obligatoire';
        }
        if (empty($password)) {
            $errors['password'][] = 'Le mot de passe est obligatoire';
        }
        if (!empty($errors)) {
            
            return null;
        }
        $query = "SELECT * FROM personne WHERE login = :login AND password = :password";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':login', $login);
        $stmt->bindValue(':password', $password);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$data) {
            return null; 
        }
        return $this->toObject($data);
    }


    public function insert() {
        $args = func_get_args();
        if (count($args) === 1 && $args[0] instanceof Personne) {
            $personne = $args[0];
            $errors = [];
            if (empty($personne->getNom())) {
                $errors['nom'][] = 'Le nom est obligatoire';
            }
            if (empty($personne->getPrenom())) {
                $errors['prenom'][] = 'Le prénom est obligatoire';
            }
            if (empty($personne->getAdresse())) {
                $errors['adresse'][] = "L'adresse est obligatoire";
            }
            if (empty($personne->getLogin())) {
                $errors['login'][] = 'Le login est obligatoire';
            }
            if (empty($personne->getPassword())) {
                $errors['password'][] = 'Le mot de passe est obligatoire';
            }
            if (empty($personne->getNumeroTelephone())) {
                $errors['numero_telephone'][] = 'Le numéro de téléphone est obligatoire';
            }
            if (empty($personne->getNumeroCarteIdentite())) {
                $errors['numero_carte_identite'][] = 'Le numéro de carte identité est obligatoire';
            }
            if (!empty($errors)) {
                return ['errors' => $errors];
            }
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
                $personne->setId((int)$this->pdo->lastInsertId());
                return ['personne' => $personne];
            } catch (\PDOException $e) {
                return ['errors' => ['sql' => [$e->getMessage()]]];
            }
        } else {
            return ['errors' => ['global' => ['Paramètre attendu : instance de Personne']]];
        }
    }
    public function update() {}
    public function delete() {}

    public function selectById(int $id)
    {
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