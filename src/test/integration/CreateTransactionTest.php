<?php

namespace Tests\integration;

use App\Application\UseCases\CreateTransaction;
use App\Application\UseCases\DTO\TransactionInput;
use App\Domain\Account\Account;
use App\Domain\Account\AccountType;
use App\Domain\Account\Cpf;
use App\Domain\Account\Email;
use App\Domain\Account\HashPassword;
use App\Infra\Database\MySqlPromiseAdapter;
use App\Infra\DI\Registry;
use App\Infra\Gateway\TransactionReturnFalseGateway;
use App\Infra\Gateway\TransactionReturnTrueGateway;
use App\Infra\Repository\AccountRepositoryDatabase;
use App\Infra\Repository\TransactionRepositoryDatabase;
use Exception;
use PHPUnit\Framework\TestCase;

class CreateTransactionTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testExecuteOnSuccessCase()
    {
        $connection = new MySqlPromiseAdapter();
        $accountRepository = new AccountRepositoryDatabase($connection);
        Registry::getInstance()->set("accountRepository", $accountRepository);
        $transactionRepository = new TransactionRepositoryDatabase($connection);
        $transactionGateway = new TransactionReturnTrueGateway();
        $createTransaction = new CreateTransaction($transactionRepository, $transactionGateway);
        $senderAccountId = $this->createAccount(AccountType::Common->value);
        $senderAccountInput = $accountRepository->get($senderAccountId);
        $amount = 100;
        $senderAccountInput->increaseBalance($amount);
        $accountRepository->update($senderAccountInput);
        $receiverAccountId = $this->createAccount(AccountType::Common->value);
        $receiverAccountInput = $accountRepository->get($receiverAccountId);
        $input = new TransactionInput(amount: $amount, senderId: $senderAccountInput->id, receiverId: $receiverAccountId, timestamp: time());
        $createTransaction->execute($input);
        $senderAccountOutput = $accountRepository->get($senderAccountId);
        $receiverAccountOutput = $accountRepository->get($receiverAccountId);
        $this->assertEquals($senderAccountInput->getBalance(), ($senderAccountOutput->getBalance()+$amount));
        $this->assertEquals($receiverAccountInput->getBalance(), $receiverAccountOutput->getBalance()-$amount);
        $connection->close();
    }

    /**
     * @throws Exception
     */
    public function testExecuteWhenTransactionIsNotApproved()
    {
        $connection = new MySqlPromiseAdapter();
        $accountRepository = new AccountRepositoryDatabase($connection);
        Registry::getInstance()->set("accountRepository", $accountRepository);
        $transactionRepository = new TransactionRepositoryDatabase($connection);
        $transactionGateway = new TransactionReturnFalseGateway();
        $createTransaction = new CreateTransaction($transactionRepository, $transactionGateway);
        $senderAccountId = $this->createAccount(AccountType::Common->value);
        $senderAccountInput = $accountRepository->get($senderAccountId);
        $amount = 100;
        $senderAccountInput->increaseBalance($amount);
        $accountRepository->update($senderAccountInput);
        $receiverAccountId = $this->createAccount(AccountType::Common->value);
        $receiverAccountInput = $accountRepository->get($receiverAccountId);
        $input = new TransactionInput(amount: $amount, senderId: $senderAccountInput->id, receiverId: $receiverAccountId, timestamp: time());
        $createTransaction->execute($input);
        $senderAccountOutput = $accountRepository->get($senderAccountId);
        $receiverAccountOutput = $accountRepository->get($receiverAccountId);
        $this->assertEquals($senderAccountInput->getBalance(), ($senderAccountOutput->getBalance()));
        $this->assertEquals($receiverAccountInput->getBalance(), $receiverAccountOutput->getBalance());
        $connection->close();
    }

    /**
     * @throws Exception
     */
    public function testExecuteWithNonexistentAccount()
    {
        $connection = new MySqlPromiseAdapter();
        $accountRepository = new AccountRepositoryDatabase($connection);
        Registry::getInstance()->set("accountRepository", $accountRepository);
        $account = $accountRepository->get(99999999);
        $this->assertNull($account);
        $connection->close();
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
            0
        );
        $connection = new MySqlPromiseAdapter();
        $accountRepository = new AccountRepositoryDatabase($connection);
        return $accountRepository->save($user);
    }
}