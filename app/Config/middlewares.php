<?php

use App\Core\Middlewares\AuthMiddleware;
use App\Core\Session;
use App\Core\Middlewares\Auth;
use App\Core\Middlewares\CryptePassword;

$middlewares = [
    'auth' => Auth::class,
    'cryptePassword' => CryptePassword::class,
    
];



   