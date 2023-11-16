<?php

namespace App\test\integration\Http;

use App\Infra\Database\MySqlPromiseAdapter;
use App\Infra\DI\Registry;
use App\Infra\Http\Kernel;
use App\Infra\Repository\AccountRepositoryDatabase;
use Exception;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Tests\integration\GenerateCpf;

class KernelTest extends TestCase
{
    public function testHandleWithExistingRoute()
    {
        $connection = new MySqlPromiseAdapter();
        $accountRepository = new AccountRepositoryDatabase($connection);
        Registry::getInstance()->set("accountRepository", $accountRepository);
        $requestBody = [
            "name" => "Vinicius",
            "lastName" => "Fernandes",
            "document"=> GenerateCpf::cpfRandom(),
            "email"=> "vini".rand(1000,9999)."@gmail.com",
            "password"=> "Teste@1345667",
            "type"=> "common"
        ];
        $request = Request::create(
            uri: "http://host.docker.internal/signup",
            method: "POST",
            parameters:$requestBody
        );
        $kernel = new Kernel();
        $response = $kernel->handle($request);
        $this->assertEquals(Response::HTTP_CREATED, $response->getStatusCode());
    }

    public function testHandleWithNonExistingRoute()
    {
        $connection = new MySqlPromiseAdapter();
        $accountRepository = new AccountRepositoryDatabase($connection);
        Registry::getInstance()->set("accountRepository", $accountRepository);
        $requestBody = [
            "name" => "Vinicius",
            "lastName" => "Fernandes",
            "document"=> GenerateCpf::cpfRandom(),
            "email"=> "vini".rand(1000,9999)."@gmail.com",
            "password"=> "Teste@1345667",
            "type"=> "common"
        ];
        $request = Request::create(
            uri: "http://host.docker.internal/signuptest",
            method: "POST",
            parameters:$requestBody
        );
        $kernel = new Kernel();
        $this->expectException(Exception::class);
        $kernel->handle($request);
    }

    public function testHandleWithMethodNotAllowed()
    {
        $connection = new MySqlPromiseAdapter();
        $accountRepository = new AccountRepositoryDatabase($connection);
        Registry::getInstance()->set("accountRepository", $accountRepository);
        $requestBody = [
            "name" => "Vinicius",
            "lastName" => "Fernandes",
            "document"=> GenerateCpf::cpfRandom(),
            "email"=> "vini".rand(1000,9999)."@gmail.com",
            "password"=> "Teste@1345667",
            "type"=> "common"
        ];
        $request = Request::create(
            uri: "http://host.docker.internal/signup",
            method: "DELETE",
            parameters:$requestBody
        );
        $kernel = new Kernel();
        $this->expectException(Exception::class);
        $kernel->handle($request);
    }
}