<?php

namespace Tests\integration;

use App\Application\UseCases\PayUser;
use App\Application\UseCases\DTO\PayUserInput;
use App\Domain\User\Cpf;
use App\Domain\User\Email;
use App\Domain\User\HashPassword;
use App\Domain\User\User;
use App\Domain\User\UserType;
use App\Infra\Database\MySqlPromiseAdapter;
use App\Infra\Gateway\PaymentReturnFalseGateway;
use App\Infra\Gateway\PaymentReturnTrueGateway;
use App\Infra\Repository\PaymentRepositoryDatabase;
use App\Infra\Repository\UserRepositoryDatabase;
use Exception;
use PHPUnit\Framework\TestCase;

class DoPaymentTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testExecuteWithPaymentApproved()
    {
        $connection = new MySqlPromiseAdapter();
        $userRepository = new UserRepositoryDatabase($connection);;
        $paymentRepository = new PaymentRepositoryDatabase($connection);
        $paymentGateway = new PaymentReturnTrueGateway();
        $startPayment = new PayUser($userRepository, $paymentRepository, $paymentGateway);
        $userId = $this->createUser();
        $sender = $userRepository->get($userId);
        $sender->increaseBalance(100);
        $userRepository->update($sender);
        $receiverId = $this->createUser();
        $input = new PayUserInput(amount: 100, senderId: $sender->id, receiverId: $receiverId, timestamp: time());
        $startPayment->execute($input);
        $connection->close();
    }

    /**
     * @throws Exception
     */
    public function testExecuteWhenPaymentIsNotApproved()
    {
        $connection = new MySqlPromiseAdapter();
        $userRepository = new UserRepositoryDatabase($connection);;
        $paymentRepository = new PaymentRepositoryDatabase($connection);
        $paymentGateway = new PaymentReturnFalseGateway();
        $startPayment = new PayUser($userRepository, $paymentRepository, $paymentGateway);
        $userId = $this->createUser();
        $sender = $userRepository->get($userId);
        $sender->increaseBalance(100);
        $userRepository->update($sender);
        $receiverId = $this->createUser();
        $input = new PayUserInput(amount: 100, senderId: $sender->id, receiverId: $receiverId, timestamp: time());
        $startPayment->execute($input);
        $connection->close();
    }

    /**
     * @throws Exception
     */
    private function createUser(): int
    {
        $randomEmail = "vinidiax" . rand(1000, 9999) . "@gmail.com";
        $randomCpf = GenerateCpf::cpfRandom();
        $type = UserType::Common->value;
        $user = User::create(
            "Vinicius",
            "Fernandes",
            new Cpf($randomCpf),
            new Email($randomEmail),
            HashPassword::create("password"),
            UserType::from(UserType::Common->value),
            0
        );
        $connection = new MySqlPromiseAdapter();
        $userRepository = new UserRepositoryDatabase($connection);
        return $userRepository->save($user);
    }
}