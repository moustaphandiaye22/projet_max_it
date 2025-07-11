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
            // 1. Insérer la personne
            $resultPersonne = $this->personneRepository->insertPersonne($personne);
            if (isset($resultPersonne['errors'])) {
                $this->pdo->rollBack();
                return $resultPersonne;
            }
            // Récupérer la personne insérée
            $personneCree = $resultPersonne['personne'];
            $compte->setPersonne($personneCree);
            $this->compteRepository->insertCompte($compte);


            // $transaction->setCompte($compte);
            // $this->transactionRepository->insertTransaction($transaction);
            // $this->pdo->commit();
            // return [
            //     'personne' => $personne,
            //     'compte' => $compte,
            //     'transaction' => $transaction
            // ];
        } catch (\Exception $e) {
            $this->pdo->rollBack();
            // Affichage détaillé de l'erreur SQL pour le debug
            return ['errors' => ['global' => [$e->getMessage(), $e]]];
        }
    }

    public function getCompteByPersonneId($personneId)
    {
        return $this->compteRepository->selectBy(['personne_id' => $personneId]);
    }

    public function getTransactionsByCompteId($compteId)
    {
        return $this->transactionRepository->selectBy(['compte_id' => $compteId]);
    }
}

