<?php

namespace App\Infra\Http;

use Exception;
use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use function FastRoute\simpleDispatcher;

class Kernel
{
    /**
     * @throws Exception
     */
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
        $controller = "";
        $method = "";
        switch ($routeInfo[0]) {
            case Dispatcher::NOT_FOUND:
                throw new Exception("Route not found");
            case Dispatcher::METHOD_NOT_ALLOWED:
                throw new Exception("Method not allowed");
            case Dispatcher::FOUND:
                $controller = $routeInfo[1][0];
                $method     = $routeInfo[1][1];
                break;
        }
        return call_user_func_array([new $controller(), $method], ["request" => $request]);
    }
}