<?php

namespace Account\integration;


use Account\Application\UseCases\CreateUser;
use Account\Application\UseCases\DTO\CreateUserInput;
use Account\Domain\UserType;
use Account\Infra\Database\MySqlPromiseAdapter;
use Account\Infra\Repository\UserRepositoryDatabase;
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
        $randomCpf = $this->cpfRandom();
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
        $randomCpf = $this->cnpjRandom();
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
        $randomCpf = $this->cpfRandom();
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
        $randomCnpj = $this->cnpjRandom();
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

    public static function cnpjRandom($mascara = "1"): string
    {
        $n1 = rand(0, 9);
        $n2 = rand(0, 9);
        $n3 = rand(0, 9);
        $n4 = rand(0, 9);
        $n5 = rand(0, 9);
        $n6 = rand(0, 9);
        $n7 = rand(0, 9);
        $n8 = rand(0, 9);
        $n9 = 0;
        $n10 = 0;
        $n11 = 0;
        $n12 = 1;
        $d1 = $n12 * 2 + $n11 * 3 + $n10 * 4 + $n9 * 5 + $n8 * 6 + $n7 * 7 + $n6 * 8 + $n5 * 9 + $n4 * 2 + $n3 * 3 + $n2 * 4 + $n1 * 5;
        $d1 = 11 - (self::mod($d1, 11));
        if ($d1 >= 10) {
            $d1 = 0;
        }
        $d2 = $d1 * 2 + $n12 * 3 + $n11 * 4 + $n10 * 5 + $n9 * 6 + $n8 * 7 + $n7 * 8 + $n6 * 9 + $n5 * 2 + $n4 * 3 + $n3 * 4 + $n2 * 5 + $n1 * 6;
        $d2 = 11 - (self::mod($d2, 11));
        if ($d2 >= 10) {
            $d2 = 0;
        }
        $retorno = '';
        if ($mascara == 1) {
            $retorno = '' . $n1 . $n2 . "." . $n3 . $n4 . $n5 . "." . $n6 . $n7 . $n8 . "/" . $n9 . $n10 . $n11 . $n12 . "-" . $d1 . $d2;
        } else {
            $retorno = '' . $n1 . $n2 . $n3 . $n4 . $n5 . $n6 . $n7 . $n8 . $n9 . $n10 . $n11 . $n12 . $d1 . $d2;
        }
        return $retorno;
    }

    /**
     * Método para gerar CPF válido, com máscara ou não
     * @param int $mascara
     * @return string
     * @example cpfRandom(0)
     *          para retornar CPF sem máscar
     */
    public static function cpfRandom($mascara = "1"): string
    {
        $n1 = rand(0, 9);
        $n2 = rand(0, 9);
        $n3 = rand(0, 9);
        $n4 = rand(0, 9);
        $n5 = rand(0, 9);
        $n6 = rand(0, 9);
        $n7 = rand(0, 9);
        $n8 = rand(0, 9);
        $n9 = rand(0, 9);
        $d1 = $n9 * 2 + $n8 * 3 + $n7 * 4 + $n6 * 5 + $n5 * 6 + $n4 * 7 + $n3 * 8 + $n2 * 9 + $n1 * 10;
        $d1 = 11 - (self::mod($d1, 11));
        if ($d1 >= 10) {
            $d1 = 0;
        }
        $d2 = $d1 * 2 + $n9 * 3 + $n8 * 4 + $n7 * 5 + $n6 * 6 + $n5 * 7 + $n4 * 8 + $n3 * 9 + $n2 * 10 + $n1 * 11;
        $d2 = 11 - (self::mod($d2, 11));
        if ($d2 >= 10) {
            $d2 = 0;
        }
        if ($mascara == 1) {
            $retorno = '' . $n1 . $n2 . $n3 . "." . $n4 . $n5 . $n6 . "." . $n7 . $n8 . $n9 . "-" . $d1 . $d2;
        } else {
            $retorno = '' . $n1 . $n2 . $n3 . $n4 . $n5 . $n6 . $n7 . $n8 . $n9 . $d1 . $d2;
        }
        return $retorno;
    }

    private static function mod($dividendo, $divisor): float
    {
        return round($dividendo - (floor($dividendo / $divisor) * $divisor));
    }
}