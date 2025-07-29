<?php

namespace App\Core;


class Router {
   
public static function resolvePath(){
    try {
        require_once dirname(__DIR__, 2) . '/app/Config/env.php';
        require_once dirname(__DIR__, 2) . '/app/Config/middlewares.php';
        require dirname(__DIR__, 2) . '/routes/route.web.php';
        require_once __DIR__ . '/App.php';
        \App\Core\App::initDependencies();


    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH); // On ne garde que le chemin
    $uri = rtrim($uri, '/');
    if ($uri === '') $uri = '/';
    
    $baseUrl = rtrim(APP_URL, '/');
    $routeKey = $baseUrl . $uri;

    // Gestion de la résolution de la route
    if (isset($path[$routeKey])) {
        $route = $path[$routeKey];
        $controllerName = $route['controller'];
        $action = $route['action'];
        // Gestion des middlewares
        if (isset($route['middleware']) && is_array($route['middleware'])) {
            foreach ($route['middleware'] as $middlewareKey) {
                if (isset($middlewares[$middlewareKey])) {
                    $middlewareClass = $middlewares[$middlewareKey];
                    $middlewareInstance = new $middlewareClass();
                    // On accepte handle OU __invoke
                    if (method_exists($middlewareInstance, 'handle')) {
                        $middlewareInstance->handle((object)['getUri' => function() use ($uri) { return $uri; }], function(){});
                    } elseif (is_callable($middlewareInstance)) {
                        $middlewareInstance((object)['getUri' => function() use ($uri) { return $uri; }], function(){});
                    } else {
                        throw new \Exception("Aucune méthode handle ou __invoke n'existe dans le middleware $middlewareClass");
                    }
                }
            }
        }
        if (class_exists($controllerName) && method_exists($controllerName, $action)) {
            // Correction : résolution de la clé de dépendance
            $controllerKey = lcfirst(basename(str_replace('\\', '/', $controllerName)));
            try {
                $controller = \App\Core\App::getDependency($controllerKey);
            } catch (\Exception $e) {
                $controller = new $controllerName();
            }
            $controller->$action();
            return;
        } else {
            echo "Controller or action not found: '" . htmlspecialchars($controllerName) . "'::'" . htmlspecialchars($action) . "'";
            return;
        }
    } else {
        http_response_code(404);
        echo "Page non trouvée";
        return;
    }
    } catch (\Exception $e) {
        error_log("Router Error: " . $e->getMessage());
        http_response_code(500);
        if (defined('APP_ENV') && APP_ENV === 'production') {
            echo "Une erreur s'est produite.";
        } else {
            echo "Erreur: " . $e->getMessage();
        }
    }
}
}