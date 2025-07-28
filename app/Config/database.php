<?php
return [
    'host' => $_ENV['DB_HOST'] ?? 'aws-0-eu-north-1.pooler.supabase.com',
    'dbname' => $_ENV['DB_NAME'] ?? 'postgres',
    'username' => $_ENV['DB_USER'] ?? 'postgres.arlexbtjmppdyadcyepw',
    'password' => $_ENV['DB_PASS'] ?? 'pgpassword',
    'charset' => 'UTF8',
    'options' => [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]
];