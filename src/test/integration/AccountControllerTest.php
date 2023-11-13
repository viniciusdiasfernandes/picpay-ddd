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
//        $input = [
//            "name" => "Vinicius",
//            "lastName" => "Fernandes",
//            "document"=> GenerateCpf::cpfRandom(),
//            "email"=> "vini".rand(1000,9999)."@gmail.com",
//            "password"=> "Teste@1345667",
//            "type"=> "common"
//        ];
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_POST, 1);
//        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($input));
        curl_setopt($curl, CURLOPT_URL, "http://host.docker.internal/signup");
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            "Content-Type:application/json"
        ]);
//        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($curl);
        $this->assertTrue($output);
//        $this->assertEquals($input["name"], $output->firstName);
//        $this->assertEquals($input["lastName"], $output->lastName);
//        $this->assertEquals($input["document"], $output->document);
//        $this->assertEquals($input["email"], $output->email);
//        $this->assertEquals($input["type"], $output->type);
//        $this->assertEquals(0, $output->balance);
//        $this->assertIsInt($output->accountId);
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
}