<?php

namespace Tests\integration;


use App\Application\UseCases\DTO\SignupInput;
use App\Application\UseCases\Signup;
use App\Domain\Account\AccountType;
use App\Infra\Database\MySqlPromiseAdapter;
use App\Infra\DI\Registry;
use App\Infra\Repository\AccountRepositoryDatabase;
use Exception;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use ValueError;


class CreateAccountTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testCreateCommonAccountWithSuccess()
    {
        $connection = new MySqlPromiseAdapter();
        $accountRepository = new AccountRepositoryDatabase($connection);
        Registry::getInstance()->set("accountRepository", $accountRepository);
        $signup = new Signup();
        $randomEmail = "vinidiax" . rand(1000, 9999) . "@gmail.com";
        $randomCpf = GenerateCpf::cpfRandom();
        $type = AccountType::Common->value;
        $input = new SignupInput(
            "Vinicius",
            "Fernandes",
            $randomCpf,
            $randomEmail,
            "password",
            $type,
        );
        $output = $signup->execute($input);
        $account = $accountRepository->get($output->accountId);
        $this->assertEquals($input->firstName, $account->firstName);
        $this->assertEquals($input->document, $account->document->getValue());
        $this->assertEquals($input->email, $account->email->getValue());
        $connection->close();
    }

    /**
     * @throws Exception
     */
    public function testCreateMerchantAccountWithSuccess()
    {
        $connection = new MySqlPromiseAdapter();
        $accountRepository = new AccountRepositoryDatabase($connection);
        Registry::getInstance()->set("accountRepository", $accountRepository);
        $signup = new Signup();
        $randomEmail = "vinidiax" . rand(1000, 9999) . "@gmail.com";
        $randomCpf = GenerateCnpj::cnpjRandom();
        $type = AccountType::Merchant->value;
        $input = new SignupInput(
            "Vinicius",
            "Fernandes",
            $randomCpf,
            $randomEmail,
            "password",
            $type,
        );
        $output = $signup->execute($input);
        $account = $accountRepository->get($output->accountId);
        $this->assertEquals($input->firstName, $account->firstName);
        $this->assertEquals($input->document, $account->document->getValue());
        $this->assertEquals($input->email, $account->email->getValue());
        $connection->close();
    }

    /**
     * @throws Exception
     */
    public function testCreateCommonAccountExistentEmail()
    {
        $connection = new MySqlPromiseAdapter();
        $accountRepository = new AccountRepositoryDatabase($connection);
        Registry::getInstance()->set("accountRepository", $accountRepository);
        $signup = new Signup();
        $randomCpf = GenerateCpf::cpfRandom();
        $type = AccountType::Common->value;
        $input = new SignupInput(
            "Vinicius",
            "Fernandes",
            $randomCpf,
            "vinidiax" . rand(1000, 9999) . "@gmail.com",
            "password",
            $type,
        );
        $this->expectException(Exception::class);
        $signup->execute($input);
        $signup->execute($input);
        $connection->close();
    }

    /**
     * @throws Exception
     */
    public function testCreateCommonAccountExistentCpf()
    {
        $connection = new MySqlPromiseAdapter();
        $accountRepository = new AccountRepositoryDatabase($connection);
        Registry::getInstance()->set("accountRepository", $accountRepository);
        $signup = new Signup();
        $type = AccountType::Common->value;
        $input = new SignupInput(
            "Vinicius",
            "Fernandes",
            "565.486.780-60",
            "vinidiax" . rand(1000, 9999) . "@gmail.com",
            "password",
            $type,
        );
        $this->expectException(Exception::class);
        $signup->execute($input);
        $signup->execute($input);
        $connection->close();
    }

    /**
     * @throws Exception
     */
    public function testCreateMerchantAccountExistentEmail()
    {
        $connection = new MySqlPromiseAdapter();
        $accountRepository = new AccountRepositoryDatabase($connection);
        Registry::getInstance()->set("accountRepository", $accountRepository);
        $signup = new Signup();
        $randomCnpj = GenerateCnpj::cnpjRandom();
        $type = AccountType::Merchant->value;
        $input = new SignupInput(
            "Vinicius",
            "Fernandes",
            $randomCnpj,
            "vinidiax" . rand(1000, 9999) . "@gmail.com",
            "password",
            $type,
        );
        $this->expectException(Exception::class);
        $signup->execute($input);
        $signup->execute($input);
        $connection->close();
    }

    /**
     * @throws Exception
     */
    public function testCreateMerchantAccountExistentCnpj()
    {
        $connection = new MySqlPromiseAdapter();
        $accountRepository = new AccountRepositoryDatabase($connection);
        Registry::getInstance()->set("accountRepository", $accountRepository);
        $signup = new Signup();
        $type = AccountType::Merchant->value;
        $input = new SignupInput(
            "Vinicius",
            "Fernandes",
            "55.023.222/0001-11",
            "vinidiax" . rand(1000, 9999) . "@gmail.com",
            "password",
            $type,
        );
        $this->expectException(Exception::class);
        $signup->execute($input);
        $signup->execute($input);
        $connection->close();
    }

    /**
     * @throws Exception
     */
    public function testCreateNonexistentAccountType()
    {
        $connection = new MySqlPromiseAdapter();
        $accountRepository = new AccountRepositoryDatabase($connection);
        Registry::getInstance()->set("accountRepository", $accountRepository);
        $signup = new Signup();
        $input = new SignupInput(
            "Vinicius",
            "Fernandes",
            GenerateCpf::cpfRandom(),
            "vinidiax" . rand(1000, 9999) . "@gmail.com",
            "password",
            "test",
        );
        $this->expectException(BadRequestException::class);
        $signup->execute($input);
        $connection->close();
    }




}