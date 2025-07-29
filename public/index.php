<?php 

// Configuration des erreurs pour la production
if (isset($_ENV['APP_ENV']) && $_ENV['APP_ENV'] === 'production') {
    error_reporting(0);
    ini_set('display_errors', 0);
    ini_set('log_errors', 1);
} else {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
}

require_once '../vendor/autoload.php';

require_once __DIR__ . '/../app/Core/Router.php';

use App\Core\Router;

Router::resolvePath();