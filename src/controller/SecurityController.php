<?php

namespace src\controller;

use app\core\abstract\AbstractController;
use app\core\Validators;                
use PDO;
use app\core\Session;
use src\entity\Personne;
use App\Core\Validator;

class SecurityController extends AbstractController {
    private $securityService;
    protected Session $session;
    public function __construct($securityService = null) {
        parent::__construct();
        $this->layout = 'base.layout';
        if ($securityService) {
            $this->securityService = $securityService;
        } else {
            $this->securityService = \app\core\App::getDependency('securityService');
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
            
            // Utiliser le service pour récupérer le compte et les transactions
            $compteService = \app\core\App::getDependency('compteService');
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
                $errors['login'][] = 'Le login est obligatoire';
            }
            if (empty($password)) {
                $errors['password'][] = 'Le mot de passe est obligatoire';
            }
            $old['login'] = $login;
            if (empty($errors)) {
                $personne = $this->securityService->seConnecter($login, $password);
                if ($personne && in_array($personne->getType(), ['client', 'servicecommercial'])) {
                    $this->session->set('user', $personne->toArray());
                    header('Location: ' . rtrim($_ENV['APP_URL'], '/') . '/accueil');
                    exit;
                } else {
                    $errors['login'][] = 'Identifiants incorrects ou accès non autorisé.';
                }
            }
            return $this->renderHtml('login/login', ['errors' => $errors, 'old' => $old]);
        }
        $this->renderHtml('login/login', ['errors' => $errors, 'old' => $old]);
    }
    public function logout() {
        header('Location: ' . rtrim($_ENV['APP_URL'], '/') . '/');
        exit;
    }
    public function register(){
        $this->renderHtml('login/register');
    }

    public function create() {
        $errors = [];
        $old = $_POST ?? [];
        $success = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            Validator::reset();
            Validator::isEmpty('nom', $_POST['nom'] ?? '', 'Le nom est obligatoire');
            Validator::isEmpty('prenom', $_POST['prenom'] ?? '', 'Le prénom est obligatoire');
            Validator::isEmpty('adresse', $_POST['adresse'] ?? '', 'L\'adresse est obligatoire');
            Validator::isEmpty('login', $_POST['login'] ?? '', 'Le login est obligatoire');
            Validator::isEmpty('password', $_POST['password'] ?? '', 'Le mot de passe est obligatoire');
            Validator::isEmpty('numero_telephone', $_POST['numero_telephone'] ?? '', 'Le numéro de téléphone est obligatoire');
            Validator::isEmpty('numero_carte_identite', $_POST['numero_carte_identite'] ?? '', 'Le numéro de CNI est obligatoire');
            if (empty($_POST['terms'])) {
                Validator::addError('terms', 'Vous devez accepter les termes d\'utilisation');
            }
            Validator::isEmpty('photo_recto_carte_identite', $_FILES['photo_recto_carte_identite']['name'] ?? '', 'La photo recto est obligatoire');
            Validator::isEmpty('photo_verso_carte_identite', $_FILES['photo_verso_carte_identite']['name'] ?? '', 'La photo verso est obligatoire');
            if (!Validator::isValid()) {
                $errors = Validator::getAllErrors();
                return $this->renderHtml('login/register', ['errors' => $errors, 'old' => $old, 'success' => $success]);
            }
            require_once __DIR__ . '/../../public/images/uploads.php';
            list($okRecto, $rectoResult) = uploadImage($_FILES['photo_recto_carte_identite']);
            list($okVerso, $versoResult) = uploadImage($_FILES['photo_verso_carte_identite']);
            if (!$okRecto) {
                $errors['photo_recto_carte_identite'][] = $rectoResult;
            }
            if (!$okVerso) {
                $errors['photo_verso_carte_identite'][] = $versoResult;
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
            $result = $this->securityService->creerCompte($personne);
            if (isset($result['errors'])) {
                $errors = $result['errors'];
                return $this->renderHtml('login/register', ['errors' => $errors, 'old' => $old, 'success' => $success]);
            }
            $success = 'Compte créé avec succès !';
            // On reste sur la page et on affiche le message de succès
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