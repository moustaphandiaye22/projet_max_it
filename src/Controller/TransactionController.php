<?php
namespace Src\Controller;

use App\Core\Session;
use App\Core\Abstract\AbstractController;
use Src\Service\TransactionService;

class TransactionController extends AbstractController {
    private $transactionService;

    public function __construct($transactionService = null) {
        parent::__construct();
        $this->layout = 'base.layout';
        if ($transactionService) {
            $this->transactionService = $transactionService;
        } else {
            $this->transactionService = \App\Core\App::getDependency('transactionService');
        }
    }

    public function create() {}
    public function edit() {}
    public function index() {}
    public function store() {}
    public function destroy() {}
    public function show() {}

    public function depotForm() {
        $user = $this->session->get('user');
        $comptes = [];
        if ($user && isset($user['id'])) {
            $compteService = \App\Core\App::getDependency('compteService');
            $comptes = $compteService->getCompteByPersonneId($user['id']);
        }
        $this->renderHtml('transactions/depot_form', ['comptes' => $comptes]);
    }

    public function transfertForm() {
        $user = $this->session->get('user');
        $comptes = [];
        if ($user && isset($user['id'])) {
            $compteService = \App\Core\App::getDependency('compteService');
            $comptes = $compteService->getCompteByPersonneId($user['id']);
        }
        $this->renderHtml('transactions/transfert_form', ['comptes' => $comptes]);
    }

    // Affiche le formulaire d'achat de code Woyofal

    public function depot() {
        $user = $this->session->get('user');
        if (!$user || !isset($_POST['compte_id']) || !isset($_POST['montant'])) {
            header('Location: ' . rtrim(APP_URL, '/') . '/transactions/depot?error=missing');
            exit;
        }
        $compteId = (int)$_POST['compte_id'];
        $montant = (float)$_POST['montant'];
        $result = $this->transactionService->depot($compteId, $montant, $user['id']);
        if ($result['success']) {
            header('Location: ' . rtrim(APP_URL, '/') . '/transactions/liste?success=depot');
        } else {
            header('Location: ' . rtrim(APP_URL, '/') . '/transactions/depot?error=' . $result['error']);
        }
        exit;
    }

    public function annulerDepot() {
        $user = $this->session->get('user');
        if (!$user || !isset($_POST['transaction_id'])) {
            header('Location: ' . rtrim(APP_URL, '/') . '/transactions/liste?error=annulation');
            exit;
        }
        $transactionId = (int)$_POST['transaction_id'];
        $result = $this->transactionService->annulerDepot($transactionId, $user['id']);
        if ($result['success']) {
            header('Location: ' . rtrim(APP_URL, '/') . '/transactions/liste?success=annulation');
        } else {
            header('Location: ' . rtrim(APP_URL, '/') . '/transactions/liste?error=' . urlencode($result['error']));
        }
        exit;
    }

    public function transfert() {
        $user = $this->session->get('user');
        if (!$user || !isset($_POST['from_compte_id']) || !isset($_POST['to_compte_id']) || !isset($_POST['montant'])) {
            header('Location: ' . rtrim(APP_URL, '/') . '/compte?error=transfert');
            exit;
        }
        $fromId = (int)$_POST['from_compte_id'];
        $toId = (int)$_POST['to_compte_id'];
        $montant = (float)$_POST['montant'];
        $result = $this->transactionService->transfert($fromId, $toId, $montant, $user['id']);
        if ($result['success']) {
            header('Location: ' . rtrim(APP_URL, '/') . '/transactions/liste?success=transfert');
        } else {
            header('Location: ' . rtrim(APP_URL, '/') . '/compte?error=' . urlencode($result['error']));
        }
        exit;
    }

    // Affiche le formulaire d'achat de code Woyofal
    public function achatWoyofalForm() {
        $user = $this->session->get('user');
        $comptes = [];
        $error = isset($_GET['error']) ? $_GET['error'] : '';
        if ($user && isset($user['id'])) {
            $compteService = \App\Core\App::getDependency('compteService');
            // On ne propose que les comptes principaux
            $comptes = array_filter($compteService->getCompteByPersonneId($user['id']), function($c) {
                return strtolower($c->getType()) === 'principal';
            });
        }
        $this->renderHtml('transactions/achat_woyofal_form', ['comptes' => $comptes, 'error' => $error]);
    }

    // Traite l'achat de code Woyofal
    public function achatWoyofal() {
        $user = $this->session->get('user');
        if (!$user || empty($_POST['compte_id']) || empty($_POST['numero_compteur']) || empty($_POST['montant'])) {
            header('Location: ' . rtrim(APP_URL, '/') . '/transactions/achat_woyofal_form?error=Champs obligatoires manquants');
            exit;
        }
        $compteId = (int)$_POST['compte_id'];
        $numeroCompteur = trim($_POST['numero_compteur']);
        $montant = (float)$_POST['montant'];
        $result = $this->transactionService->achatWoyofal($compteId, $numeroCompteur, $montant, $user['id']);
        if ($result['success']) {
            // Afficher le reçu avec les infos nécessaires
            $this->renderHtml('transactions/recu_woyofal', $result['recu']);
        } else {
            $error = isset($result['error']) ? $result['error'] : 'Erreur lors de l\'achat';
            header('Location: ' . rtrim(APP_URL, '/') . '/transactions/achat_woyofal_form?error=' . urlencode($error));
        }
        exit;
    }
}
