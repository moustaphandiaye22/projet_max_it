<?php
require_once __DIR__ . '/vendor/autoload.php';

use App\Seeders\Seeder;

$seeder = new Seeder();
$seeder->run();
echo "Seed terminé avec succès.\n";
