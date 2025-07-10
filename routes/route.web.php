<?php

require_once dirname(__DIR__) . '/app/config/env.php';

$baseUrl = rtrim(APP_URL, '/');

$path = [
    $baseUrl . '/' => [
        'controller' => 'src\\controller\\SecurityController',
        'action' => 'login',
    ],
    $baseUrl . '/accueil' => [
        'controller' => 'src\\controller\\SecurityController',
        'action' => 'accueil',
    ],
    $baseUrl . '/logout' => [
        'controller' => 'src\\controller\\SecurityController',
        'action' => 'logout',
    ],
    $baseUrl . '/login' => [
        'controller' => 'src\\controller\\SecurityController',
        'action' => 'login',
    ],
    $baseUrl . '/register' => [
        'controller' => 'src\\controller\\SecurityController',
        'action' => $_SERVER['REQUEST_METHOD'] === 'POST' ? 'create' : 'register',
    ],
    $baseUrl . '/ajouter-personne' => [
        'controller' => 'src\\controller\\PersonneController',
        'action' => 'create',
    ],
];