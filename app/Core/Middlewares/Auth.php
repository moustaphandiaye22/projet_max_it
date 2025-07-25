<?php
namespace App\Core\Middlewares;

use App\Core\Session;


class Auth{


    public function __invoke($request, $next): void
    {
        $session = Session::getInstance();
        if (!$session->isAuthenticated()) {
            header('Location: /login');
            exit;
        }
        $next(); 
    }

}