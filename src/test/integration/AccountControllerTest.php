<?php

namespace Tests\integration;

use App\Infra\Controller\AccountController;
use App\Infra\Database\MySqlPromiseAdapter;
use App\Infra\DI\Registry;
use App\Infra\Repository\AccountRepositoryDatabase;
use Exception;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AccountControllerTest extends TestCase
{
    public function testRouteIsWorking()
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_URL, "http://host.docker.internal/signup");
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            "Content-Type:application/json"
        ]);
        $output = curl_exec($curl);
        $this->assertTrue($output);
    }

    /**
     * @throws Exception
     */
    public function testCreateWithSuccess()
    {
        $connection = new MySqlPromiseAdapter();
        $accountRepository = new AccountRepositoryDatabase($connection);
        Registry::getInstance()->set("accountRepository", $accountRepository);
        $accountController = new AccountController();
        $parameters = [
            "name" => "Vinicius",
            "lastName" => "Fernandes",
            "document" => GenerateCpf::cpfRandom(),
            "email" => "vini" . rand(1000, 9999) . "@gmail.com",
            "password" => "Teste@1345667",
            "type" => "common"
        ];
        $request = Request::create(
            uri: "http://host.docker.internal/signup",
            method: "POST",
            parameters: $parameters
        );
        $response = $accountController->create($request);
        $this->assertEquals(Response::HTTP_CREATED, $response->getStatusCode());
    }

    public function testCreateThrowException()
    {
        $connection = new MySqlPromiseAdapter();
        $accountRepository = new AccountRepositoryDatabase($connection);
        Registry::getInstance()->set("accountRepository", $accountRepository);
        $accountController = new AccountController();
        $cpf = GenerateCpf::cpfRandom();
        $parameters = [
            "name" => "Vinicius",
            "lastName" => "Fernandes",
            "document" => $cpf,
            "email" => "vini" . rand(1000, 9999) . "@gmail.com",
            "password" => "Teste@1345667",
            "type" => "common"
        ];
        $request = Request::create(
            uri: "http://host.docker.internal/signup",
            method: "POST",
            parameters: $parameters
        );
        $accountController->create($request);
        $response = $accountController->create($request);
        $this->assertEquals(Response::HTTP_UNPROCESSABLE_ENTITY, $response->getStatusCode());
    }
}