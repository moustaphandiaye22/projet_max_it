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
        'middleware' => ['guest', 'cryptePassword'], // Ajout du middleware de cryptage
    ],
    $baseUrl . '/ajouter-personne' => [
        'controller' => 'src\\controller\\PersonneController',
        'action' => 'create',
        'middleware' => ['auth'],
    ],
];