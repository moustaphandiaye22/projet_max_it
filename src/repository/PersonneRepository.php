<?php
namespace src\repository;

use src\entity\Personne;
use App\Core\Abstract\AbstractRepository;
use PDO;

 class PersonneRepository extends AbstractRepository{
        
    public function __construct() {
          parent::__construct();
      }
       

    // public function SelectByLoginAndPassword(string $login, string $password): ?Personne {
    //     $errors = [];
    //     if (empty($login)) {
    //         $errors['login'][] = 'Le login est obligatoire';
    //     }
    //     if (empty($password)) {
    //         $errors['password'][] = 'Le mot de passe est obligatoire';
    //     }
    //     if (!empty($errors)) {
            
    //         return null;
    //     }
    //     $query = "SELECT * FROM personne WHERE login = :login AND password = :password";
    //     $stmt = $this->pdo->prepare($query);
    //     $stmt->bindValue(':login', $login);
    //     $stmt->bindValue(':password', $password);
    //     $stmt->execute();
    //     $data = $stmt->fetch(PDO::FETCH_ASSOC);
    //     if (!$data) {
    //         return null; 
    //     }
    //     return $this->toObject($data);
    // }
    public function insert(): void
    {
        // Implementation for inserting a new person
    }


    public function insertPersonne(Personne $personne) {
        // Nettoyage du validateur avant chaque insertion
        \App\Core\Validator::reset();
        // Validation des champs obligatoires
        if (empty($personne->getNom())) {
            \App\Core\Validator::addError('nom', 'Le nom est obligatoire');
        }
        if (empty($personne->getPrenom())) {
            \App\Core\Validator::addError('prenom', 'Le prénom est obligatoire');
        }
        if (empty($personne->getAdresse())) {
            \App\Core\Validator::addError('adresse', "L'adresse est obligatoire");
        }
        if (empty($personne->getLogin())) {
            \App\Core\Validator::addError('login', 'Le login est obligatoire');
        }
        if (empty($personne->getPassword())) {
            \App\Core\Validator::addError('password', 'Le mot de passe est obligatoire');
        }
        if (empty($personne->getNumeroTelephone())) {
            \App\Core\Validator::addError('numero_telephone', 'Le numéro de téléphone est obligatoire');
        }
        if (empty($personne->getNumeroCarteIdentite())) {
            \App\Core\Validator::addError('numero_carte_identite', 'Le numéro de carte identité est obligatoire');
        }
        \App\Core\Validator::isSenegalesePhone('numero_telephone', $personne->getNumeroTelephone());
        // Vérification du format du CNI
        \App\Core\Validator::isSenegaleseCni('numero_carte_identite', $personne->getNumeroCarteIdentite());
        // Vérification unicité numéro de téléphone
        $queryTel = "SELECT COUNT(*) FROM personne WHERE numero_telephone = :numero_telephone";
        $stmtTel = $this->pdo->prepare($queryTel);
        $stmtTel->bindValue(':numero_telephone', $personne->getNumeroTelephone());
        $stmtTel->execute();
        if ($stmtTel->fetchColumn() > 0) {
            \App\Core\Validator::addError('numero_telephone', 'Ce numéro de téléphone existe déjà.');
        }
        // Vérification unicité CNI
        $queryCni = "SELECT COUNT(*) FROM personne WHERE numero_carte_identite = :numero_carte_identite";
        $stmtCni = $this->pdo->prepare($queryCni);
        $stmtCni->bindValue(':numero_carte_identite', $personne->getNumeroCarteIdentite());
        $stmtCni->execute();
        if ($stmtCni->fetchColumn() > 0) {
            \App\Core\Validator::addError('numero_carte_identite', 'Ce numéro CNI existe déjà.');
        }
        if (!\App\Core\Validator::isValid()) {
            return ['errors' => \App\Core\Validator::getAllErrors()];
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

            $smsStatus = null; // Pour suivre l'état d'envoi du SMS
            // Envoi du SMS via Twilio
            $sid = $_ENV['TWILIO_SID'] ?? '';
            $token = $_ENV['TWILIO_TOKEN'] ?? '';
            $from = $_ENV['TWILIO_FROM'] ?? '';
            // Le numéro de téléphone doit être au format international (+221...) pour Twilio
            if ($sid && $token && $from) {
                try {
                    $client = new \Twilio\Rest\Client($sid, $token);
                    $message = sprintf(
                        'Bonjour %s %s, bienvenue sur Max IT ! Votre compte a été créé avec succès.',
                        $personne->getPrenom(),
                        $personne->getNom()
                    );
                    $client->messages->create(
                        $personne->getNumeroTelephone(),
                        [
                            'from' => $from,
                            'body' => $message
                        ]
                    );
                    $smsStatus = 'success';
                } catch (\Exception $e) {
                    $smsStatus = 'failed';
                    // Vous pouvez logger l'erreur ici : $e->getMessage()
                }
            }

            return ['personne' => $personne, 'sms' => $smsStatus];
        } catch (\PDOException $e) {
            return ['errors' => ['sql' => [$e->getMessage()]]];
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

    // Nouvelle méthode pour récupérer par login uniquement
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