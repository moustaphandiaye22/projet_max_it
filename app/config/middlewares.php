<?php
use App\Core\middlewares\AuthMiddleware;
function getMiddlewares() {
    return [
        'auth' => 'App\\Core\\middlewares\\AuthMiddleware',
    ];
}
