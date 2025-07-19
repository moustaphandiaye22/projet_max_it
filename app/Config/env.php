<?php

use Dotenv\Dotenv;

require_once dirname(__DIR__, 2) . '/vendor/autoload.php';

$dotenv = Dotenv::createImmutable(dirname(__DIR__, 2));
$dotenv->load();

define('DB_HOST', $_ENV['DB_HOST'] ?? 'localhost');
define('DB_NAME', $_ENV['DB_NAME'] ?? 'ges_commercial_auchan');
define('DB_USER', $_ENV['DB_USER'] ?? 'pguser');
define('DB_PASS', $_ENV['DB_PASS'] ?? 'pgpassword');
define('APP_URL', $_ENV['APP_URL'] ?? 'http://localhost');
define('APP_PORT', $_ENV['APP_PORT'] ?? 8000);




