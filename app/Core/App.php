<?php

namespace App\Core;

use Src\Repository\PersonneRepository;
use Src\Service\PersonneService;
use Src\Controller\PersonneController;
use Src\Controller\SecurityController;
use Src\Service\CompteService;
use Src\Controller\CompteController;
use Src\Repository\CompteRepository;
use Src\Repository\TransactionRepository;
use Src\Service\TransactionService;
use App\Core\Router;
use App\Core\Database;
use App\Core\Session;

use Symfony\Component\Yaml\Yaml;

class App{
    private static array $dependencies = [];

    public static function initDependencies(): void {
        
        // $personneRepository = new PersonneRepository();
        // $compteRepository = new CompteRepository();
        // $securityService = new \Src\Service\SecurityService($personneRepository, $compteRepository);
        // $personneService = new PersonneService($personneRepository);

        // $transactionRepository = new \Src\Repository\TransactionRepository();
        // $compteService = new \Src\Service\CompteService($personneRepository, $compteRepository, $transactionRepository);
        // $compteController = new \Src\Controller\CompteController($compteService);
        // $transactionService = new \Src\Service\TransactionService($transactionRepository, $compteRepository);


        // self::$dependencies = [
        //     "core" => [
        //         "router" => new Router(),
        //         "database" => Database::getInstance(),
        //         "session" => Session::getInstance(),
        //         "validator" => new Validator(),

                
        //     ],
        //     "repository" => [
        //         "personneRepository" => $personneRepository,
        //         "compteRepository" => $compteRepository,
        //         "transactionRepository" => $transactionRepository,

        //     ],
        //     "service" => [
        //         "personneService" => $personneService,
        //         "securityService" => $securityService,
        //         "compteService" => $compteService,
        //         "transactionService" => $transactionService,
        //     ],
        //     "controller" => [
        //         "personneController" => new PersonneController($personneService),
        //         "securityController" => new \Src\Controller\SecurityController($securityService),
        //         "compteController" => new \Src\Controller\CompteController($compteService),
        //     ]
        // ];
        $servicesFile = __DIR__ . '/../Config/services.yml';
        if (!file_exists($servicesFile)) {
            throw new \Exception('services.yml introuvable');
        }
        $services = \Symfony\Component\Yaml\Yaml::parseFile($servicesFile);
        $instances = [];
        if (isset($services['services'])) {
            // Première passe : instanciation simple (singletons et sans arguments)
            foreach ($services['services'] as $key => $service) {
                if (isset($service['class'])) {
                    $class = $service['class'];
                    if ($class === 'App\\Core\\Database' || $class === 'App/Core/Database' || $class === 'App/Core/Session' || $class === 'App\\Core\\Session') {
                        if (method_exists($class, 'getInstance')) {
                            $instances[$key] = $class::getInstance();
                        } else {
                            $instances[$key] = new $class();
                        }
                    } else if (empty($service['arguments'])) {
                        $instances[$key] = new $class();
                    }
                }
            }
            // Deuxième passe : instanciation avec arguments (dépendances)
            foreach ($services['services'] as $key => $service) {
                if (isset($service['class'], $service['arguments']) && !isset($instances[$key])) {
                    $class = $service['class'];
                    $args = [];
                    foreach ($service['arguments'] as $argKey) {
                        if (isset($instances[$argKey])) {
                            $args[] = $instances[$argKey];
                        } else {
                            throw new \Exception("Dépendance '$argKey' non trouvée pour le service '$key'");
                        }
                    }
                    $instances[$key] = new $class(...$args);
                }
            }
        }
        self::$dependencies = $instances;
    }

    public static function getDependency(string $key){
        if (array_key_exists($key, self::$dependencies)) {
            return self::$dependencies[$key];
        }
        throw new \Exception("Dependency not found: " . $key);
    }
}