<?php
namespace src\service;

use src\repository\PersonneRepository;
use src\repository\CompteRepository;
use src\repository\TransactionRepository;
use App\Core\Database;
use src\entity\Personne;
use src\entity\Compte;
use src\entity\Transaction;
use App\Core\App;
use app\config\ErrorMessage;

class CompteService {
    private $personneRepository;
    private $compteRepository;
    private $transactionRepository;
    private $pdo;

    public function __construct(PersonneRepository $personneRepository, CompteRepository $compteRepository, TransactionRepository $transactionRepository) {
        $this->personneRepository = $personneRepository;
        $this->compteRepository = $compteRepository;
        $this->transactionRepository = $transactionRepository;
        $this->pdo = Database::getInstance();
    }


    public function creerCompteAvecTransaction(Personne $personne, Compte $compte) {
        try {
            $this->pdo->beginTransaction();
            $resultPersonne = $this->personneRepository->insertPersonne($personne);
            if (isset($resultPersonne['errors'])) {
                $this->pdo->rollBack();
                return $resultPersonne;
            }
            $personneCree = $resultPersonne['personne'];
            // Vérification de l'ID de la personne
            if (!$personneCree->getId() || $personneCree->getId() <= 0) {
                $this->pdo->rollBack();
                return ['errors' => ['global' => ['Erreur lors de la création de la personne (ID manquant).']]];
            }
            $compte->setPersonne($personneCree);
            $compte->setNumeroTelephone($personneCree->getNumeroTelephone());

            $compteId = $this->compteRepository->insertCompte($compte);
            if ($compteId <= 0) {
                $this->pdo->rollBack();
                return ['errors' => ['global' => [ErrorMessage::accountCreationError->value]]];
            }
            $compte->setId($compteId);
            $personneCree->addCompte($compte); 

            $this->pdo->commit();
            return [
                'personne' => $personneCree,
                'compte' => $compte
            ];
        } catch (\Exception $e) {
            $this->pdo->rollBack();
            return ['errors' => ['global' => [$e->getMessage()]]];
        }
    }

    public function getCompteByPersonneId($personneId)
    {
        return $this->compteRepository->selectBy(['client_id' => $personneId]);
    }

    public function getTransactionsByCompteId($compteId)
    {
        return $this->transactionRepository->selectBy(['compte_id' => $compteId]);
    }
    public function updateType($compteId, $type) {
        $this->compteRepository->updateType($compteId, $type);
    }
    public function getPersonneRepository() {
        return $this->personneRepository;
    }
    public function getCompteRepository() {
        return $this->compteRepository;
    }
}

