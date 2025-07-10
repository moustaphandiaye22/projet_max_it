<?php

namespace App\Core;


class Router {
   
public static function resolvePath(){
    require_once dirname(__DIR__, 2) . '/app/config/env.php';
    require_once dirname(__DIR__, 2) . '/app/config/middlewares.php';
    require dirname(__DIR__, 2) . '/routes/route.web.php';
    require_once __DIR__ . '/App.php';
    \app\core\App::initDependencies();

    $middlewaresMap = getMiddlewares();

    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH); // On ne garde que le chemin
    $uri = rtrim($uri, '/');
    if ($uri === '') $uri = '/';

    // On construit la clé de la même façon que dans Route.web.php
    // Correction : ne pas doubler le port si déjà présent dans APP_URL
    $baseUrl = rtrim(APP_URL, '/');
    $parsedUrl = parse_url($baseUrl);
    $hasPort = isset($parsedUrl['port']);
    $port = (!$hasPort && defined('APP_PORT') && APP_PORT) ? ':' . APP_PORT : '';
    $baseUrlWithPort = $baseUrl . $port;
    $routeKey = $baseUrlWithPort . $uri;

    // Gestion de la résolution de la route
    if (isset($path[$routeKey])) {
        $route = $path[$routeKey];
        $controllerName = $route['controller'];
        $action = $route['action'];
        // Gestion des middlewares
        if (isset($route['middleware']) && is_array($route['middleware'])) {
            foreach ($route['middleware'] as $middlewareKey) {
                if (isset($middlewaresMap[$middlewareKey])) {
                    $callable = $middlewaresMap[$middlewareKey];
                    $callable((object)['getUri' => function() use ($uri) { return $uri; }], function(){});
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
}
}