<?php

namespace Src\Service;

use Src\Repository\TransactionRepository;
use Src\Repository\CompteRepository;
use Src\Entity\Transaction;
use Src\Entity\Compte;
use App\Core\Database;

class TransactionService {
    private $transactionRepository;
    private $compteRepository;
    private $pdo;

    public function __construct(TransactionRepository $transactionRepository, CompteRepository $compteRepository) {
        $this->transactionRepository = $transactionRepository;
        $this->compteRepository = $compteRepository;
        $this->pdo = Database::getInstance();
    }

    // Effectuer un dépôt
    public function depot($compteId, $montant, $userId) {
        try {
            $comptes = $this->compteRepository->selectBy(['id' => $compteId]);
            if (empty($comptes)) {
                return ['success' => false, 'error' => 'compte_introuvable'];
            }
            /** @var Compte $compte */
            $compte = $comptes[0];
            if ($montant <= 0) {
                return ['success' => false, 'error' => 'montant_invalide'];
            }
            $this->pdo->beginTransaction();
            $compte->setSolde($compte->getSolde() + $montant);
            $this->compteRepository->updateSolde($compte->getId(), $compte->getSolde());
            $reference = uniqid('DEPOT_');
            $transaction = new Transaction(0, $reference, $montant, 'depot');
            $transaction->setCompte($compte);
            $this->transactionRepository->insertTransaction($transaction);
            $this->pdo->commit();
            return ['success' => true];
        } catch (\Exception $e) {
            $this->pdo->rollBack();
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    // Annuler un dépôt (si non retiré)
    public function annulerDepot($transactionId, $userId) {
        try {
            // 1. Récupérer la transaction
            $transactions = $this->transactionRepository->selectBy(['id' => $transactionId]);
            if (empty($transactions)) {
                return ['success' => false, 'error' => 'transaction_introuvable'];
            }
            $transaction = $transactions[0];
            // Vérifier le type
            if (!isset($transaction['type']) || $transaction['type'] !== 'depot') {
                return ['success' => false, 'error' => 'type_invalide'];
            }
            // Vérifier si le montant n'a pas été retiré (on suppose qu'il n'y a pas de retrait postérieur sur ce montant)
            // Pour simplifier, on vérifie que le solde du compte est suffisant pour annuler
            $compteId = $transaction['compte_id'];
            $comptes = $this->compteRepository->selectBy(['id' => $compteId]);
            if (empty($comptes)) {
                return ['success' => false, 'error' => 'compte_introuvable'];
            }
            $compte = $comptes[0];
            $montant = $transaction['montant'];
            if ($compte->getSolde() < $montant) {
                return ['success' => false, 'error' => 'solde_insuffisant_annulation'];
            }
            $this->pdo->beginTransaction();
            // Débiter le compte
            $compte->setSolde($compte->getSolde() - $montant);
            $this->compteRepository->updateSolde($compte->getId(), $compte->getSolde());
            // Marquer la transaction comme annulée (ou supprimer)
            // Ici, on supprime la transaction
            $sql = "DELETE FROM transaction WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':id', $transactionId, \PDO::PARAM_INT);
            $stmt->execute();
            $this->pdo->commit();
            return ['success' => true];
        } catch (\Exception $e) {
            $this->pdo->rollBack();
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    // Transfert entre comptes
    public function transfert($fromId, $toId, $montant, $userId) {
        try {
            if ($fromId == $toId) {
                return ['success' => false, 'error' => 'comptes_identiques'];
            }
            if ($montant <= 0) {
                return ['success' => false, 'error' => 'montant_invalide'];
            }
            $fromComptes = $this->compteRepository->selectBy(['id' => $fromId]);
            $toComptes = $this->compteRepository->selectBy(['id' => $toId]);
            if (empty($fromComptes) || empty($toComptes)) {
                return ['success' => false, 'error' => 'compte_introuvable'];
            }
            $fromCompte = $fromComptes[0];
            $toCompte = $toComptes[0];
            // Vérifier le solde suffisant
            if ($fromCompte->getSolde() < $montant) {
                return ['success' => false, 'error' => 'solde_insuffisant'];
            }
            // Calcul des frais
            $frais = 0;
            $isPrincipalToPrincipal = (strtolower($fromCompte->getType()) === 'principal' && strtolower($toCompte->getType()) === 'principal');
            if ($isPrincipalToPrincipal) {
                $frais = min($montant * 0.08, 5000);
            }
            $totalDebit = $montant + $frais;
            if ($fromCompte->getSolde() < $totalDebit) {
                return ['success' => false, 'error' => 'solde_insuffisant_frais'];
            }
            $this->pdo->beginTransaction();
            // Débiter le compte source
            $fromCompte->setSolde($fromCompte->getSolde() - $totalDebit);
            $this->compteRepository->updateSolde($fromCompte->getId(), $fromCompte->getSolde());
            // Créditer le compte destinataire
            $toCompte->setSolde($toCompte->getSolde() + $montant);
            $this->compteRepository->updateSolde($toCompte->getId(), $toCompte->getSolde());
            // Créer la transaction de transfert (pour le compte source)
            $referenceFrom = uniqid('TRF_OUT_');
            $transactionFrom = new Transaction(0, $referenceFrom, $montant, 'paiement');
            $transactionFrom->setCompte($fromCompte);
            $this->transactionRepository->insertTransaction($transactionFrom);
            // Créer la transaction de transfert (pour le compte destinataire)
            $referenceTo = uniqid('TRF_IN_');
            $transactionTo = new Transaction(0, $referenceTo, $montant, 'paiement');
            $transactionTo->setCompte($toCompte);
            $this->transactionRepository->insertTransaction($transactionTo);
            // Si frais, enregistrer une transaction de frais
            if ($frais > 0) {
                $referenceFrais = uniqid('FRAIS_');
                $transactionFrais = new Transaction(0, $referenceFrais, $frais, 'paiement');
                $transactionFrais->setCompte($fromCompte);
                $this->transactionRepository->insertTransaction($transactionFrais);
            }
            $this->pdo->commit();
            return ['success' => true];
        } catch (\Exception $e) {
            $this->pdo->rollBack();
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }
}