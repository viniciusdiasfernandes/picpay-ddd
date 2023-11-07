<?php

namespace Tests\integration;


use App\Application\UseCases\CreateUser;
use App\Application\UseCases\DTO\CreateUserInput;
use App\Domain\User\UserType;
use App\Infra\Database\MySqlPromiseAdapter;
use App\Infra\Repository\UserRepositoryDatabase;
use Exception;
use PHPUnit\Framework\TestCase;


class CreateUserTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testCreateCommonUserWithSuccess()
    {
        $connection = new MySqlPromiseAdapter();
        $userRepository = new UserRepositoryDatabase($connection);
        $signup = new CreateUser($userRepository);
        $randomEmail = "vinidiax" . rand(1000, 9999) . "@gmail.com";
        $randomCpf = GenerateCpf::cpfRandom();
        $type = UserType::Common->value;
        $input = new CreateUserInput(
            "Vinicius",
            "Fernandes",
            $randomCpf,
            $randomEmail,
            "password",
            $type,
        );
        $output = $signup->execute($input);
        $user = $userRepository->get($output->userId);
        $this->assertEquals($input->firstName, $user->firstName);
        $this->assertEquals($input->document, $user->document->getValue());
        $this->assertEquals($input->email, $user->email->getValue());
        $connection->close();
    }

    /**
     * @throws Exception
     */
    public function testCreateMerchantUserWithSuccess()
    {
        $connection = new MySqlPromiseAdapter();
        $userRepository = new UserRepositoryDatabase($connection);
        $signup = new CreateUser($userRepository);
        $randomEmail = "vinidiax" . rand(1000, 9999) . "@gmail.com";
        $randomCpf = GenerateCnpj::cnpjRandom();
        $type = UserType::Merchant->value;
        $input = new CreateUserInput(
            "Vinicius",
            "Fernandes",
            $randomCpf,
            $randomEmail,
            "password",
            $type,
        );
        $output = $signup->execute($input);
        $user = $userRepository->get($output->userId);
        $this->assertEquals($input->firstName, $user->firstName);
        $this->assertEquals($input->document, $user->document->getValue());
        $this->assertEquals($input->email, $user->email->getValue());
        $connection->close();
    }

    /**
     * @throws Exception
     */
    public function testCreateCommonUserExistentEmail()
    {
        $connection = new MySqlPromiseAdapter();
        $userRepository = new UserRepositoryDatabase($connection);
        $signup = new CreateUser($userRepository);
        $randomCpf = GenerateCpf::cpfRandom();
        $type = UserType::Common->value;
        $input = new CreateUserInput(
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
    public function testCreateCommonUserExistentCpf()
    {
        $connection = new MySqlPromiseAdapter();
        $userRepository = new UserRepositoryDatabase($connection);
        $signup = new CreateUser($userRepository);
        $type = UserType::Common->value;
        $input = new CreateUserInput(
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
    public function testCreateMerchantUserExistentEmail()
    {
        $connection = new MySqlPromiseAdapter();
        $userRepository = new UserRepositoryDatabase($connection);
        $signup = new CreateUser($userRepository);
        $randomCnpj = GenerateCnpj::cnpjRandom();
        $type = UserType::Merchant->value;
        $input = new CreateUserInput(
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
    public function testCreateMerchantUserExistentCnpj()
    {
        $connection = new MySqlPromiseAdapter();
        $userRepository = new UserRepositoryDatabase($connection);
        $signup = new CreateUser($userRepository);
        $type = UserType::Merchant->value;
        $input = new CreateUserInput(
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




}