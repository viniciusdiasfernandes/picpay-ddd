<?php

use App\Domain\Account\Account;
use App\Domain\Account\AccountType;
use App\Domain\Account\Cpf;
use App\Domain\Account\Email;
use App\Domain\Account\HashPassword;
use App\Infra\Controller\TransactionController;
use App\Infra\Database\MySqlPromiseAdapter;
use App\Infra\DI\Registry;
use App\Infra\Repository\AccountRepositoryDatabase;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Tests\integration\GenerateCpf;

class TransactionControllerTest extends TestCase
{
    public function testRouteIsWorking()
    {

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_URL, "http://host.docker.internal/transaction");
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
        $transactionController = new TransactionController();
        $senderId = $this->createAccount("common");
        $receiverId = $this->createAccount("common");
        $parameters = [
            "amount" => 5,
            "senderId" => $senderId,
            "receiverId" => $receiverId,
        ];
        $request = Request::create(
            uri: "http://host.docker.internal/signup",
            method: "POST",
            parameters: $parameters
        );
        $response = $transactionController->create($request);
        $this->assertEquals(Response::HTTP_CREATED, $response->getStatusCode());
    }

    /**
     * @throws Exception
     */
    private function createAccount(string $type): int
    {
        $randomEmail = "vinidiax" . rand(1000, 9999) . "@gmail.com";
        $randomCpf = GenerateCpf::cpfRandom();
        $user = Account::create(
            "Vinicius",
            "Fernandes",
            new Cpf($randomCpf),
            new Email($randomEmail),
            HashPassword::create("password"),
            AccountType::from($type),
            1500
        );
        $connection = new MySqlPromiseAdapter();
        $accountRepository = new AccountRepositoryDatabase($connection);
        return $accountRepository->save($user);
    }
}