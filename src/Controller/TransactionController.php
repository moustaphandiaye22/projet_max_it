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

    public function depot() {
        $user = $this->session->get('user');
        if (!$user || !isset($_POST['compte_id']) || !isset($_POST['montant'])) {
            header('Location: /transactions/depot?error=missing');
            exit;
        }
        $compteId = (int)$_POST['compte_id'];
        $montant = (float)$_POST['montant'];
        $result = $this->transactionService->depot($compteId, $montant, $user['id']);
        if ($result['success']) {
            header('Location: /transactions/liste?success=depot');
        } else {
            header('Location: /transactions/depot?error=' . $result['error']);
        }
        exit;
    }

    public function annulerDepot() {
        $user = $this->session->get('user');
        if (!$user || !isset($_POST['transaction_id'])) {
            header('Location: /transactions/liste?error=annulation');
            exit;
        }
        $transactionId = (int)$_POST['transaction_id'];
        $result = $this->transactionService->annulerDepot($transactionId, $user['id']);
        if ($result['success']) {
            header('Location: /transactions/liste?success=annulation');
        } else {
            header('Location: /transactions/liste?error=' . urlencode($result['error']));
        }
        exit;
    }

    public function transfert() {
        $user = $this->session->get('user');
        if (!$user || !isset($_POST['from_compte_id']) || !isset($_POST['to_compte_id']) || !isset($_POST['montant'])) {
            header('Location: /compte?error=transfert');
            exit;
        }
        $fromId = (int)$_POST['from_compte_id'];
        $toId = (int)$_POST['to_compte_id'];
        $montant = (float)$_POST['montant'];
        $result = $this->transactionService->transfert($fromId, $toId, $montant, $user['id']);
        if ($result['success']) {
            header('Location: /transactions/liste?success=transfert');
        } else {
            header('Location: /compte?error=' . urlencode($result['error']));
        }
        exit;
    }
}
