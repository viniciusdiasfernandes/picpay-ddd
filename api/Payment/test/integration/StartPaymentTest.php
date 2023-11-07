<?php
namespace Payment\integration;

use Account\Infra\Repository\UserRepositoryDatabase;
use Exception;
use Payment\Application\DTO\StartPaymentInput;
use Payment\Application\UserCase\StartPayment;
use Account\Infra\Database\MySqlPromiseAdapter;
use PHPUnit\Framework\TestCase;

class StartPaymentTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testExecuteWithSuccess()
    {
        $connection = new MySqlPromiseAdapter();
        $userRepository = new UserRepositoryDatabase($connection);
        $startPayment = new StartPayment($userRepository);
        $user = $userRepository->get(1);
        $user->addBalance(5000);
        $userRepository->addBalance($user);
        $input = new StartPaymentInput(amount:100,senderId:1,receiverId: 2,timestamp: time());
        $startPayment->execute($input);
        $connection->close();
    }
}