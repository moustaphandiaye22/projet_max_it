<?php

use App\Core\middlewares\AuthMiddleware;
use App\Core\Session;
use App\Core\middlewares\Auth;
use App\Core\middlewares\CryptePassword;

$middlewares = [
    'auth' => Auth::class,
    'cryptePassword' => CryptePassword::class,
];



   