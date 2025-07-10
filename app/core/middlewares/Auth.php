<?php
namespace App\Core\middlewares;

use App\Core\Session;

// Middleware d'authentification générale
function AuthMiddleware($request, $next) {
    $session = Session::getInstance();
    if (!$session->isset('user')) {
        header('Location: /login');
        exit();
    }
    return $next($request);
}