<?php

use Dotenv\Dotenv;

require_once dirname(__DIR__, 2) . '/vendor/autoload.php';

$dotenv = Dotenv::createImmutable(dirname(__DIR__, 2));
if (file_exists(dirname(__DIR__, 2) . '/.env')) {
    $dotenv->load();
}

define('DB_HOST', $_ENV['DB_HOST'] ?? 'aws-0-eu-north-1.pooler.supabase.com');
define('DB_NAME', $_ENV['DB_NAME'] ?? 'postgres');
define('DB_USER', $_ENV['DB_USER'] ?? 'postgres.arlexbtjmppdyadcyepw');
define('DB_PASS', $_ENV['DB_PASS'] ?? 'pgpassword');
define('APP_URL', $_ENV['APP_URL'] ?? 'http://localhost');
define('APP_PORT', $_ENV['APP_PORT'] ?? 8000);
define('APP_ENV', $_ENV['APP_ENV'] ?? 'development');




