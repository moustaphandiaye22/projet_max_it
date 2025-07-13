<?php

require_once dirname(__DIR__) . '/app/config/env.php';

$baseUrl = rtrim(APP_URL, '/');

$path = [
    $baseUrl . '/' => [
        'controller' => 'src\\controller\\SecurityController',
        'action' => 'login',
        'middleware' => ['guest'],
    ],
    $baseUrl . '/accueil' => [
        'controller' => 'src\\controller\\SecurityController',
        'action' => 'accueil',
        'middleware' => ['auth'],
    ],
    $baseUrl . '/logout' => [
        'controller' => 'src\\controller\\SecurityController',
        'action' => 'logout',
        'middleware' => ['auth'],
    ],
    $baseUrl . '/login' => [
        'controller' => 'src\\controller\\SecurityController',
        'action' => 'login',
        'middleware' => ['guest'],
    ],
    $baseUrl . '/register' => [
        'controller' => 'src\\controller\\SecurityController',
        'action' => $_SERVER['REQUEST_METHOD'] === 'POST' ? 'create' : 'register',
        'middleware' => ['guest', 'cryptePassword'], 
    ],
    $baseUrl . '/ajouter-personne' => [
        'controller' => 'src\\controller\\PersonneController',
        'action' => 'create',
        'middleware' => ['auth'],
    ],
    $baseUrl . '/add_compte_secondaire' => [
        'controller' => 'src\\controller\\CompteController',
        'action' => $_SERVER['REQUEST_METHOD'] === 'POST' ? 'create' : 'addCompteSecondaire',
        'middleware' => ['auth'],
    ],
    $baseUrl . '/list_transaction' => [
        'controller' => 'src\\controller\\SecurityController',
        'action' => 'listTransactions',
        'middleware' => ['auth'],
    ],
    $baseUrl . '/compte' => [
        'controller' => 'src\\controller\\CompteController',
        'action' => 'index',
        'middleware' => ['auth'],
    ],
    $baseUrl . '/compte/set_principal' => [
        'controller' => 'src\\controller\\CompteController',
        'action' => 'setPrincipal',
        'middleware' => ['auth'],
    ],
    $baseUrl . '/compte/add_secondaire' => [
        'controller' => 'src\\controller\\CompteController',
        'action' => 'addCompteSecondaire',
        'middleware' => ['auth'],
    ],
    $baseUrl . '/compte/store' => [
        'controller' => 'src\\controller\\CompteController',
        'action' => 'store',
        'middleware' => ['auth'],
    ],
    $baseUrl . '/transactions/liste' => [
        'controller' => 'src\\controller\\CompteController',
        'action' => 'listeTransactions',
        'middleware' => ['auth'],
    ],
    $baseUrl . '/servicecommercial/compte' => [
        'controller' => 'src\\controller\\CompteController',
        'action' => 'rechercherCompte',
        'middleware' => ['auth'],
    ],
    $baseUrl . '/servicecommercial/transactions' => [
        'controller' => 'src\\controller\\CompteController',
        'action' => 'listeTransactions',
        'middleware' => ['auth'],
    ],
];