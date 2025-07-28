<?php
require_once __DIR__ . '/vendor/autoload.php';

use App\Migrations\Migration;

$migration = new Migration();
$migration->run();
echo "Migration terminée avec succès.\n";
