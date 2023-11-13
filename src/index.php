<?php

use App\Infra\Database\MySqlPromiseAdapter;
use App\Infra\DI\Registry;
use App\Infra\Http\Kernel;
use App\Infra\Repository\AccountRepositoryDatabase;
use Symfony\Component\HttpFoundation\Request;

require_once 'vendor/autoload.php';

$connection = new MySqlPromiseAdapter();
$accountRepository = new AccountRepositoryDatabase($connection);
Registry::getInstance()->set("accountRepository", $accountRepository);
$request = Request::createFromGlobals();
$requestBody = (array)json_decode(file_get_contents("php://input"));
$kernel = new Kernel();
$response = $kernel->handle($request);
$response->send();


