<?php

namespace App\Infra\Controller;

class MainController
{
    private array $routes;


    public function __construct()
    {
        $this->routes = [
            "POST" => [
                "/signup" => [
                    "class" => AccountController::class,
                    "method" => 'create'
                ],
                "/transfer" => [
                    "class" => TransactionController::class,
                    "method" => 'create'
                ],
            ],
            "GET" => [
                "/"
            ]
        ];
        $this->validateRoute($_SERVER["REQUEST_METHOD"], $_SERVER["REQUEST_URI"]);
        $this->execute($_SERVER["REQUEST_METHOD"], $_SERVER["REQUEST_URI"]);
    }

    public function execute(string $method, string $uri)
    {
        $class = new $this->routes[$method][$uri]["class"]();
        $params = file_get_contents("php://input");

        if ($params) {
            $params = (array)json_decode($params);
        }
        return $class->{$this->routes[$method][$uri]["method"]}($params);
    }

    private function validateRoute(string $method, string $uri): void
    {
        if (!isset($this->routes[$method][$uri])) {
            header("HTTP/1.0 404 Not Found");
            echo "Route not found";
            die();
        }
    }
}