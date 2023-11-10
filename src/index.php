<?php

use App\Application\UseCases\Signup;
use App\Application\UseCases\CreateTransaction;
use App\Infra\Controller\MainController;
use App\Infra\Database\MySqlPromiseAdapter;
use App\Infra\DI\Registry;
use App\Infra\Gateway\TransactionReturnTrueGateway;
use App\Infra\Repository\TransactionRepositoryDatabase;
use App\Infra\Repository\AccountRepositoryDatabase;

require_once "vendor/autoload.php";
$connection = new MySqlPromiseAdapter();
$accountRepository = new AccountRepositoryDatabase($connection);
Registry::getInstance()->set("accountRepository", $accountRepository);
$main = new MainController();


