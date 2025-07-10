<?php

namespace app\core;

use src\repository\PersonneRepository;
use src\service\PersonneService;
use src\controller\PersonneController;
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
        self::$dependencies = [
            "core" => [
                "router" => new Router(),
                "database" => Database::getInstance(),
                "session" => Session::getInstance(),
            ],
            "repository" => [
                "personneRepository" => $personneRepository,
            ],
            "service" => [
                "personneService" => $personneService,
                "securityService" => $securityService,
            ],
            "controller" => [
                "personneController" => new PersonneController(),
                "securityController" => new \src\controller\SecurityController($securityService),
                "compteController" => new \src\controller\CompteController(),
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