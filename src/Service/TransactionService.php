<?php

namespace Src\Service;

use Src\Repository\TransactionRepository;
use Src\Repository\CompteRepository;
use Src\Entity\Transaction;
use Src\Entity\Compte;
use App\Core\Database;

class TransactionService {

    /**
     * Achat de code Woyofal : vérifie le solde, génère le code, enregistre la transaction et prépare le reçu
     */
    public function achatWoyofal($compteId, $numeroCompteur, $montant, $userId) {
        // 1. Vérifier le compte principal
        $comptes = $this->compteRepository->selectBy(['id' => $compteId]);
        if (empty($comptes)) {
            return ['success' => false, 'error' => 'Compte introuvable'];
        }
        /** @var Compte $compte */
        $compte = $comptes[0];
        if (strtolower($compte->getType()) !== 'principal') {
            return ['success' => false, 'error' => 'Seul un compte principal peut acheter un code Woyofal'];
        }
        // 2. Vérifier le montant
        if ($montant <= 0) {
            return ['success' => false, 'error' => 'Montant invalide'];
        }
        if ($compte->getSolde() < $montant) {
            return ['success' => false, 'error' => 'Solde insuffisant'];
        }
        // 3. Débiter le compte et enregistrer la transaction
        try {
            $this->pdo->beginTransaction();
            $compte->setSolde($compte->getSolde() - $montant);
            $this->compteRepository->updateSolde($compte->getId(), $compte->getSolde());
            // Générer un code de recharge simulé (aléatoire)
            $codeRecharge = strtoupper(substr(md5(uniqid((string)mt_rand(), true)), 0, 12));
            // Simuler le nombre de KW, la tranche et le prix unitaire (à adapter selon la vraie logique)
            $prixUnitaire = 120; // FCFA par KW (exemple)
            $nbreKW = floor($montant / $prixUnitaire);
            $tranche = ($montant < 10000) ? 'Social' : 'Normal';
            // Créer la transaction
            $reference = uniqid('WOYOFAL_');
            $transaction = new Transaction(0, $reference, $montant, 'paiement');
            $transaction->setCompte($compte);
            $this->transactionRepository->insertTransaction($transaction);
            $this->pdo->commit();
            // Préparer les infos du reçu
            // Récupérer le client (nom/prénom) via le compte
            $personne = method_exists($compte, 'getPersonne') ? $compte->getPersonne() : null;
            $nom = $personne && method_exists($personne, 'getNom') ? $personne->getNom() : '';
            $prenom = $personne && method_exists($personne, 'getPrenom') ? $personne->getPrenom() : '';
            $dateHeure = (new \DateTime())->format('d/m/Y H:i');
            $recu = [
                'nom' => $nom,
                'prenom' => $prenom,
                'numero_compteur' => $numeroCompteur,
                'code_recharge' => $codeRecharge,
                'date_heure' => $dateHeure,
                'tranche' => $tranche,
                'prix_unitaire' => $prixUnitaire,
                'montant' => $montant,
                'nbre_kw' => $nbreKW
            ];
            return ['success' => true, 'recu' => $recu];
        } catch (\Exception $e) {
            $this->pdo->rollBack();
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }
    private $transactionRepository;
    private $compteRepository;
    private $pdo;

    public function __construct(TransactionRepository $transactionRepository, CompteRepository $compteRepository) {
        $this->transactionRepository = $transactionRepository;
        $this->compteRepository = $compteRepository;
        $this->pdo = Database::getInstance();
    }

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

    public function annulerDepot($transactionId, $userId) {
        try {
            $transactions = $this->transactionRepository->selectBy(['id' => $transactionId]);
            if (empty($transactions)) {
                return ['success' => false, 'error' => 'transaction_introuvable'];
            }
            $transaction = $transactions[0];
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