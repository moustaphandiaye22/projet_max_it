<?php

namespace app\core;

use src\repository\PersonneRepository;
use src\service\PersonneService;
use src\controller\PersonneController;
use src\controller\SecurityController;
use src\service\CompteService;
use src\controller\CompteController;
use src\repository\CompteRepository;
use src\repository\TransactionRepository;
use src\service\TransactionService;
use app\core\Router;
use app\core\Database;
use app\core\Session;

class App{
    private static array $dependencies = [];

    public static function initDependencies(): void {
        // Instanciation séparée pour éviter les dépendances circulaires
        $personneRepository = new PersonneRepository();
        $personneService = new PersonneService($personneRepository);
        $securityService = new \src\service\SecurityService($personneRepository);

        $compteRepository = new \src\repository\CompteRepository();
        $transactionRepository = new \src\repository\TransactionRepository();
        $compteService = new \src\service\CompteService($personneRepository, $compteRepository, $transactionRepository);
        $compteController = new \src\controller\CompteController($compteService);
        $transactionService = new \src\service\TransactionService($transactionRepository, $compteRepository);

        self::$dependencies = [
            "core" => [
                "router" => new Router(),
                "database" => Database::getInstance(),
                "session" => Session::getInstance(),
                
            ],
            "repository" => [
                "personneRepository" => $personneRepository,
                "compteRepository" => $compteRepository,
                "transactionRepository" => $transactionRepository,

            ],
            "service" => [
                "personneService" => $personneService,
                "securityService" => $securityService,
                "compteService" => $compteService,
                "transactionService" => $transactionService,
            ],
            "controller" => [
                "personneController" => new PersonneController($personneService),
                "securityController" => new \src\controller\SecurityController($securityService),
                "compteController" => new \src\controller\CompteController($compteService),
            ]
        ];
    }

    public static function getDependency(string $key){
        foreach (self::$dependencies as $group) {
            if (array_key_exists($key, $group)) {
                return $group[$key];
            }
        }
        throw new \Exception("Dependency not found: " . $key);
    }
}