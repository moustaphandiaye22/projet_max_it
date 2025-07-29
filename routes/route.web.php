<?php

require_once dirname(__DIR__) . '/app/Config/env.php';

$baseUrl = rtrim(APP_URL, '/');

$path = [
    $baseUrl . '/' => [
        'controller' => 'Src\\Controller\\SecurityController',
        'action' => 'login',
        'middleware' => ['guest'],
    ],
    $baseUrl . '/accueil' => [
        'controller' => 'Src\\Controller\\SecurityController',
        'action' => 'accueil',
        'middleware' => ['auth'],
    ],
    $baseUrl . '/logout' => [
        'controller' => 'Src\\Controller\\SecurityController',
        'action' => 'logout',
        'middleware' => ['auth'],
    ],
    $baseUrl . '/login' => [
        'controller' => 'Src\\Controller\\SecurityController',
        'action' => 'login',
        'middleware' => ['guest'],
    ],
    $baseUrl . '/register' => [
        'controller' => 'Src\\Controller\\SecurityController',
        'action' => $_SERVER['REQUEST_METHOD'] === 'POST' ? 'create' : 'register',
        'middleware' => ['guest', 'cryptePassword'], 
    ],
    $baseUrl . '/ajouter-personne' => [
        'controller' => 'Src\\Controller\\PersonneController',
        'action' => 'create',
        'middleware' => ['auth'],
    ],
    $baseUrl . '/add_compte_secondaire' => [
        'controller' => 'Src\\Controller\\CompteController',
        'action' => $_SERVER['REQUEST_METHOD'] === 'POST' ? 'create' : 'addCompteSecondaire',
        'middleware' => ['auth'],
    ],
    $baseUrl . '/list_transaction' => [
        'controller' => 'Src\\Controller\\SecurityController',
        'action' => 'listTransactions',
        'middleware' => ['auth'],
    ],
    $baseUrl . '/compte' => [
        'controller' => 'Src\\Controller\\CompteController',
        'action' => 'index',
        'middleware' => ['auth'],
    ],
    $baseUrl . '/compte/set_principal' => [
        'controller' => 'Src\\Controller\\CompteController',
        'action' => 'setPrincipal',
        'middleware' => ['auth'],
    ],
    $baseUrl . '/compte/add_secondaire' => [
        'controller' => 'Src\\Controller\\CompteController',
        'action' => 'addCompteSecondaire',
        'middleware' => ['auth'],
    ],
    $baseUrl . '/compte/store' => [
        'controller' => 'Src\\Controller\\CompteController',
        'action' => 'store',
        'middleware' => ['auth'],
    ],
    $baseUrl . '/transactions/liste' => [
        'controller' => 'Src\\Controller\\CompteController',
        'action' => 'listeTransactions',
        'middleware' => ['auth'],
    ],
    $baseUrl . '/servicecommercial/compte' => [
        'controller' => 'Src\\Controller\\CompteController',
        'action' => 'rechercherCompte',
        'middleware' => ['auth'],
    ],
    $baseUrl . '/servicecommercial/transactions' => [
        'controller' => 'Src\\Controller\\CompteController',
        'action' => 'listeTransactions',
        'middleware' => ['auth'],
    ],
    $baseUrl . '/transactions/depot' => [
        'controller' => 'Src\\Controller\\TransactionController',
        'action' => $_SERVER['REQUEST_METHOD'] === 'POST' ? 'depot' : 'depotForm',
        'middleware' => ['auth'],       
    ],
    $baseUrl . '/transactions/transfert' => [
        'controller' => 'Src\\Controller\\TransactionController',
        'action' => $_SERVER['REQUEST_METHOD'] === 'POST' ? 'transfert' : 'transfertForm',
        'middleware' => ['auth'],
    ],
    $baseUrl . '/transactions/annuler' => [
        'controller' => 'Src\\Controller\\TransactionController',
        'action' => 'annulerDepot',
        'middleware' => ['auth'],
    ],
     $baseUrl . '/transactions/achat_woyofal_form' => [
        'controller' => 'Src\\Controller\\TransactionController',
        'action' => 'achatWoyofalForm',
        'middleware' => ['auth'],
    ],
    $baseUrl . '/transactions/achat_woyofal' => [
        'controller' => 'Src\\Controller\\TransactionController',
        'action' => $_SERVER['REQUEST_METHOD'] === 'POST' ? 'achatWoyofal' : 'achatWoyofalForm',
        'middleware' => ['auth'],
    ],
   
];
