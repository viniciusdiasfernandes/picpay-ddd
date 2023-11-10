<?php

namespace App\Infra\Controller;

use App\Application\UseCases\DTO\SignupInput;
use App\Application\UseCases\DTO\SignupOutput;
use App\Application\UseCases\DTO\TransactionInput;
use App\Application\UseCases\DTO\TransactionOutput;
use App\Application\UseCases\CreateTransaction;
use App\Infra\Database\MySqlPromiseAdapter;
use App\Infra\DI\Registry;
use App\Infra\Gateway\TransactionReturnTrueGateway;
use App\Infra\Repository\TransactionRepositoryDatabase;
use App\Infra\Repository\AccountRepositoryDatabase;
use Exception;
use stdClass;

class TransactionController
{
    /**
     * @throws Exception
     */
    public function create(array $params): TransactionOutput
    {
        $input = new TransactionInput(
            amount: $params['amount'],senderId: $params['senderId'],receiverId: $params['receiverId'],timestamp: time()
        );
        $connection = new MySqlPromiseAdapter();
        $transactionRepository = new TransactionRepositoryDatabase($connection);
        $transactionGateway = new TransactionReturnTrueGateway();
        $createTransaction = new CreateTransaction($transactionRepository, $transactionGateway);
        return $createTransaction->execute($input);
    }
}