<?php

namespace Src\Controller;

use App\Core\Abstract\AbstractController;
use PDO;
use App\Core\Session;
use Src\Entity\Personne;
use App\Core\Validator; 
use App\Config\ErrorMessage;

class SecurityController extends AbstractController {
    private $securityService;
    private $compteService;
    protected Session $session;
    public function __construct($securityService = null, $compteService = null) {
        parent::__construct();
        $this->layout = 'base.layout';
        if ($securityService) {
            $this->securityService = $securityService;
        } else {
            $this->securityService = \App\Core\App::getDependency('securityService');
        }
        if ($compteService) {
            $this->compteService = $compteService;
        } else {
            $this->compteService = \App\Core\App::getDependency('compteService');
        }
    }
    public function index() {
        $this->renderHtml('login/login');
    }
    public function accueil() {
        // Récupérer l'utilisateur connecté
        $user = $this->session->get('user');
        $solde = 0;
        $transactions = [];
        if ($user && isset($user['id'])) {
            
            $compteService = \App\Core\App::getDependency('compteService');
            $comptes = $compteService->getCompteByPersonneId($user['id']);
            if (!empty($comptes) && isset($comptes[0])) {
                $solde = $comptes[0]->getSolde();
                $transactions = $compteService->getTransactionsByCompteId($comptes[0]->getId());
            }
        }
        $this->renderHtml('acceuil', ['solde' => $solde, 'transactions' => $transactions]);
    }

    
    public function login() {
        $errors = [];
        $old = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $login = $_POST['login'] ?? '';
            $password = $_POST['password'] ?? '';
            if (empty($login)) {
                $errors['login'][] = ErrorMessage::required->value;
            }
            if (empty($password)) {
                $errors['password'][] = ErrorMessage::required->value;
            }
            $old['login'] = $login;
            if (empty($errors)) {
                $personne = $this->securityService->seConnecter($login, $password);
                if ($personne && in_array($personne->getType(), ['client', 'servicecommercial'])) {
                $this->session->set('user', $personne->toArray());
                if ($personne->getType() === 'servicecommercial') {
                header('Location: ' . rtrim(APP_URL, '/') . '/servicecommercial/compte');
                exit;
                }
                header('Location: ' . rtrim(APP_URL, '/') . '/accueil');
                exit;
                } else {
                    $errors['login'][] = ErrorMessage::invalidCredentials->value;
                }
            }
            return $this->renderHtml('login/login', ['errors' => $errors, 'old' => $old]);
        }
        $this->renderHtml('login/login', ['errors' => $errors, 'old' => $old]);
    }

    public function logout() {
        session_destroy();
        header('Location: ' . rtrim(APP_URL, '/') . '/');
        
    }


    public function register(){
        $this->renderHtml('login/register');
    }


    public function listTransactions() {
        $user = $this->session->get('user');
        if (!$user || !isset($user['id'])) {
            header('Location: ' . rtrim(APP_URL, '/') . '/list_transaction');
            exit;
        }
        $compteService = \App\Core\App::getDependency('compteService');
        $comptes = $compteService->getCompteByPersonneId($user['id']);
        if (empty($comptes) || !isset($comptes[0])) {
            $this->renderHtml('transactions/list', ['transactions' => []]);
            return;
        }
        $transactions = $compteService->getTransactionsByCompteId($comptes[0]->getId());
        $this->renderHtml('transactions/list', ['transactions' => $transactions]);
    }

    public function create() {
        $errors = [];
        $old = $_POST ?? [];
        $success = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $validator = \App\Core\Validator::getInstance();
            $rules = [
                'nom' => ['required'],
                'prenom' => ['required'],
                'adresse' => ['required'],
                'login' => ['required'],
                'password' => ['required', ['minLength', 8], 'isPassword'],
                'numero_telephone' => ['required', 'isSenegalPhone'],
                'numero_carte_identite' => ['required', 'isCNI'],
                'photo_recto_carte_identite' => ['required'],
                'photo_verso_carte_identite' => ['required'],
            ];
            $data = [
                'nom' => $_POST['nom'] ?? '',
                'prenom' => $_POST['prenom'] ?? '',
                'adresse' => $_POST['adresse'] ?? '',
                'login' => $_POST['login'] ?? '',
                'password' => $_POST['password'] ?? '',
                'numero_telephone' => $_POST['numero_telephone'] ?? '',
                'numero_carte_identite' => $_POST['numero_carte_identite'] ?? '',
                'photo_recto_carte_identite' => $_FILES['photo_recto_carte_identite']['name'] ?? '',
                'photo_verso_carte_identite' => $_FILES['photo_verso_carte_identite']['name'] ?? '',
            ];
            if (empty($_POST['terms'])) {
                Validator::addError('terms', ErrorMessage::termsNotAccepted->value);
            }
            $validator->validate($data, $rules);
            require_once __DIR__ . '/../../public/images/uploads.php';
            list($okRecto, $rectoResult) = uploadImage($_FILES['photo_recto_carte_identite']);
            list($okVerso, $versoResult) = uploadImage($_FILES['photo_verso_carte_identite']);
            if (!$okRecto) {
                $errors['photo_recto_carte_identite'][] = $rectoResult;
            }
            if (!$okVerso) {
                $errors['photo_verso_carte_identite'][] = $versoResult;
            }
            // Fusionner les erreurs du Validator (statique)
            $validatorErrors = Validator::getAllErrors();
            if (!empty($validatorErrors)) {
                foreach ($validatorErrors as $field => $msgs) {
                    foreach ((array)$msgs as $msg) {
                        $errors[$field][] = $msg;
                    }
                }
            }
            // Vérification unicité téléphone et CNI
            $personneRepo = new \Src\Repository\PersonneRepository();
            if (!empty($data['numero_telephone']) && $personneRepo->existsByTelephone($data['numero_telephone'])) {
                $errors['numero_telephone'][] = ErrorMessage::phoneExists->value;
            }
            if (!empty($data['numero_carte_identite']) && $personneRepo->existsByCni($data['numero_carte_identite'])) {
                $errors['numero_carte_identite'][] = ErrorMessage::cniExists->value;
            }
            if (!empty($errors)) {
                return $this->renderHtml('login/register', ['errors' => $errors, 'old' => $old, 'success' => $success]);
            }
            $personne = new Personne(
                0,
                $_POST['nom'] ?? '',
                $_POST['prenom'] ?? '',
                $_POST['adresse'] ?? '',
                $_POST['login'] ?? '',
                $_POST['password'] ?? '',
                $_POST['numero_telephone'] ?? '',
                $rectoResult,
                $versoResult,
                $_POST['numero_carte_identite'] ?? '',
                $_POST['type'] ?? 'client'
            );
            // Création du compte associé
            $compte = new \Src\Entity\Compte(
                0,
                0, // solde initial
                $_POST['numero_telephone'] ?? '',
                new \DateTime(),
                'principal',
                $personne
            );
            $result = $this->compteService->creerCompteAvecTransaction($personne, $compte);
            if (isset($result['errors'])) {
                foreach ($result['errors'] as $field => $msgs) {
                    foreach ((array)$msgs as $msg) {
                        $errors[$field][] = $msg;
                    }
                }
                return $this->renderHtml('login/register', ['errors' => $errors, 'old' => $old, 'success' => $success]);
            }
            if (!$result) {
                $errors['sql'][] = ErrorMessage::accountCreationError->value;
                return $this->renderHtml('login/register', ['errors' => $errors, 'old' => $old, 'success' => $success]);
            }
            $success = ErrorMessage::accountCreationSuccess->value;
            // Envoi du SMS Twilio si numéro valide
            if (!empty($_POST['numero_telephone'])) {
                \App\Core\Message::sendTwilioSms(
                    $_POST['numero_telephone'],
                    ErrorMessage::messageTwillo->value
                );
            }
            return $this->renderHtml('login/register', ['errors' => [], 'old' => [], 'success' => $success]);
        }
        $this->renderHtml('login/register', ['errors' => $errors, 'old' => $old, 'success' => $success]);
    }

   

    public function store() {
        // Logic to store a new security-related resource
    }

    public function edit() {
        // Logic to edit an existing security-related resource
    }

    public function show() {
        // Logic to show a specific security-related resource
    }

    public function destroy() {
        // Logic to delete a security-related resource
    }
}