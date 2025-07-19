<?php
return [
    'host' => $_ENV['DB_HOST'] ?? 'localhost',
    'dbname' => $_ENV['DB_NAME'] ?? 'gestion_max_it',
    'username' => $_ENV['DB_USER'] ?? 'pguser',
    'password' => $_ENV['DB_PASS'] ?? 'pgpassword',
    'charset' => 'UTF8',
    'options' => [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]
];