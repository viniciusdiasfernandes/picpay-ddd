<?php

use App\Infra\Database\MySqlPromiseAdapter;
use App\Infra\DI\Registry;
use App\Infra\Http\Kernel;
use App\Infra\Http\Request;
use App\Infra\Repository\AccountRepositoryDatabase;

require_once 'vendor/autoload.php';

$connection = new MySqlPromiseAdapter();
$accountRepository = new AccountRepositoryDatabase($connection);
Registry::getInstance()->set("accountRepository", $accountRepository);
$request = Request::createFromGlobals();
$kernel = new Kernel();
$response = $kernel->handle($request);
$response->send();


