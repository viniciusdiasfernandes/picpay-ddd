<?php

use App\Application\UseCases\CreateUser;
use App\Application\UseCases\PayUser;
use App\Infra\Controller\MainController;
use App\Infra\Database\MySqlPromiseAdapter;
use App\Infra\DI\Registry;
use App\Infra\Gateway\PaymentReturnTrueGateway;
use App\Infra\Repository\PaymentRepositoryDatabase;
use App\Infra\Repository\UserRepositoryDatabase;

require_once "vendor/autoload.php";
$connection = new MySqlPromiseAdapter();
$userRepository = new UserRepositoryDatabase($connection);
$paymentRepository = new PaymentRepositoryDatabase($connection);
$paymentGateway = new PaymentReturnTrueGateway();
Registry::getInstance()->set("userRepository", $userRepository);
$createUer = new CreateUser($userRepository);
$doPayment = new PayUser($userRepository,$paymentRepository, $paymentGateway);

Registry::getInstance()->set("createUser", $createUer);
Registry::getInstance()->set("payUser", $doPayment);

$controller = new MainController();
//Registry::getInstance()->provide("userRepository", $userRepository);

//$router = new Router();
//
//$router
//    ->register('/', [])
//    ->register('/signup', [])
//    ->register('/pay', []);
//
//echo $router->resolve($_SERVER['REQUEST_URI']);

