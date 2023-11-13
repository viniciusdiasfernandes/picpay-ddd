<?php

namespace App\Infra\Http;

use FastRoute\RouteCollector;
use function FastRoute\simpleDispatcher;

class Kernel
{
    public function handle(Request $request): Response
    {
        $dispatcher = simpleDispatcher(function (RouteCollector $routeCollector) {
            $routes = include 'routes/web.php';
            foreach ($routes as $route) {
                $routeCollector->addRoute(...$route);
            }
        });
        $routeInfo = $dispatcher->dispatch(
            $request->getMethod(),
            $request->getPathInfo()
        );
        [$status, [$controller, $method], $vars] = $routeInfo;
        return call_user_func_array([new $controller, $method], $vars);
    }
}