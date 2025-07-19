<?php
namespace Src\Controller;
use App\Core\Session;
use App\Core\Abstract\AbstractController;

class CompteController extends AbstractController {
    private $compteService;

    public function __construct($compteService = null) {
        parent::__construct();
        $this->layout = 'base.layout';
        if ($compteService) {
            $this->compteService = $compteService;
        } else {
            $this->compteService = \App\Core\App::getDependency('compteService');
            
        }
    }
     public function addCompteSecondaire() {
        $this->renderHtml('compte/add_secondaire');
    }

     public function create(){

     }
     public function edit(){

     }
     public function index(){
        $user = $this->session->get('user');
        if ($user && ($user['type'] ?? '') === 'servicecommercial') {
            header('Location: /servicecommercial/compte');
            exit;
        }
        $comptes = [];
        $transactions_principal = [];
        if ($user && isset($user['id'])) {
            $comptes = $this->compteService->getCompteByPersonneId($user['id']);
            // Chercher le compte principal
            $compte_principal = null;
            foreach ($comptes as $c) {
                if (trim(strtolower($c->getType())) === 'principal') {
                    $compte_principal = $c;
                    break;
                }
            }
            if ($compte_principal) {
                $transactions_principal = $this->compteService->getTransactionsByCompteId($compte_principal->getId());
                // Trier par date décroissante
                usort($transactions_principal, function($a, $b) {
                    $dateA = isset($a['datetransaction']) ? strtotime($a['datetransaction']) : 0;
                    $dateB = isset($b['datetransaction']) ? strtotime($b['datetransaction']) : 0;
                    return $dateB - $dateA;
                });
                $transactions_principal = array_slice($transactions_principal, 0, 10);
            }
            
        }
        $this->renderHtml('compte/compte', ['comptes' => $comptes, 'transactions_principal' => $transactions_principal]);
     }

     
     public function store() {
        $user = $this->session->get('user');
        if (!$user || !isset($user['id']) || empty($_POST['numero_telephone'])) {
            header('Location: /compte');
            exit;
        }
        $numero = trim($_POST['numero_telephone']);
        $solde = isset($_POST['solde']) && is_numeric($_POST['solde']) ? floatval($_POST['solde']) : 0;
        $personne = $this->compteService->getPersonneRepository()->selectById($user['id']);
        if (!$personne) {
            header('Location: /compte');
            exit;
        }
        // Créer le compte secondaire
        $compteSecondaire = new \Src\Entity\Compte(0, $solde, $numero);
        $compteSecondaire->setType('secondaire');
        $compteSecondaire->setPersonne($personne);
        // Si solde > 0, retirer du principal
        $inserted = false;
        if ($solde > 0) {
            $comptes = $this->compteService->getCompteByPersonneId($user['id']);
            $principal = null;
            foreach ($comptes as $c) {
                if (trim(strtolower($c->getType())) === 'principal') {
                    $principal = $c;
                    break;
                }
            }
            if ($principal && $principal->getSolde() >= $solde) {
                $inserted = $this->compteService->getCompteRepository()->insertCompte($compteSecondaire);
                $this->compteService->getCompteRepository()->updateSolde($principal->getId(), $principal->getSolde() - $solde);
            } else {
                header('Location: /compte/add_secondaire?error=solde');
                exit;
            }
        } else {
            $inserted = $this->compteService->getCompteRepository()->insertCompte($compteSecondaire);
        }
        if (!$inserted || $inserted <= 0) {
            // Erreur d'insertion
            header('Location: /compte/add_secondaire?error=insertion');
            exit;
        }
        header('Location: /compte');
        exit;
    }
     public function destroy(){

     }
     public function show(){}

     public function setPrincipal() {
        $user = $this->session->get('user');
        if (!$user || !isset($user['id']) || empty($_POST['compte_id'])) {
            header('Location: /compte');
            exit;
        }
        $compteId = (int)$_POST['compte_id'];
        // Récupérer tous les comptes de l'utilisateur
        $comptes = $this->compteService->getCompteByPersonneId($user['id']);
        // Mettre tous les comptes en secondaire
        foreach ($comptes as $compte) {
            if ($compte->getType() === 'principal') {
                $compte->setType('secondaire');
                $this->compteService->updateType($compte->getId(), 'secondaire');
            }
        }
        // Mettre le compte choisi en principal
        $this->compteService->updateType($compteId, 'principal');
        header('Location: /compte');
        exit;
    }
    public function rechercherCompte() {
        $user = $this->session->get('user');
        if (!$user || ($user['type'] ?? '') !== 'servicecommercial') {
            header('Location: /accueil');
            exit;
        }
        $numero = isset($_GET['numero']) ? trim($_GET['numero']) : '';
        $compte = null;
        $transactions = [];
        $comptes = [];
        if ($numero) {
            $comptes = $this->compteService->getCompteRepository()->selectBy(['numero_telephone' => $numero]);
            if (!empty($comptes)) {
                $compte = $comptes[0];
                $transactions = $this->compteService->getTransactionsByCompteId($compte->getId());
                usort($transactions, function($a, $b) {
                    $dateA = isset($a['datetransaction']) ? strtotime($a['datetransaction']) : 0;
                    $dateB = isset($b['datetransaction']) ? strtotime($b['datetransaction']) : 0;
                    return $dateB - $dateA;
                });
                $transactions = array_slice($transactions, 0, 10);
            }
        } else if (isset($_GET['numero'])) { 
            $comptes = $this->compteService->getCompteRepository()->selectBy([]);
        }
        $this->renderHtml('compte/recherche', [
            'compte_recherche' => $compte,
            'transactions_recherche' => $transactions,
            'comptes_recherche' => $comptes
        ]);
    }

    public function listeTransactions() {
        $user = $this->session->get('user');
        if (!$user || ($user['type'] ?? '') !== 'servicecommercial') {
            header('Location: /accueil');
            exit;
        }
        $compteId = isset($_GET['compte_id']) ? intval($_GET['compte_id']) : 0;
        $date = isset($_GET['date']) ? $_GET['date'] : '';
        $type = isset($_GET['type']) ? $_GET['type'] : '';
        $transactions = [];
        if ($compteId) {
            $transactions = $this->compteService->getTransactionsByCompteId($compteId);
            if ($date) {
                $transactions = array_filter($transactions, function($t) use ($date) {
                    return isset($t['datetransaction']) && strpos($t['datetransaction'], $date) === 0;
                });
            }
            if ($type) {
                $transactions = array_filter($transactions, function($t) use ($type) {
                    return strtolower($t['type']) === strtolower($type);
                });
            }
            usort($transactions, function($a, $b) {
                $dateA = isset($a['datetransaction']) ? strtotime($a['datetransaction']) : 0;
                $dateB = isset($b['datetransaction']) ? strtotime($b['datetransaction']) : 0;
                return $dateB - $dateA;
            });
        }
        $this->renderHtml('transactions/liste', [
            'transactions' => $transactions
        ]);
    }
}
