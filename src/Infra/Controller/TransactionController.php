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
use App\Infra\Http\Response;
use App\Infra\Repository\TransactionRepositoryDatabase;
use App\Infra\Repository\AccountRepositoryDatabase;
use Exception;
use stdClass;

class TransactionController
{
    /**
     * @throws Exception
     */
    public function create(): Response
    {
        $params = (array)json_decode(file_get_contents("php://input"));
        CreateTransactionValidator::validate($params);
        $input = new TransactionInput(
            amount: $params['amount'],senderId: $params['senderId'],receiverId: $params['receiverId'],timestamp: time()
        );
        $connection = new MySqlPromiseAdapter();
        $transactionRepository = new TransactionRepositoryDatabase($connection);
        $transactionGateway = new TransactionReturnTrueGateway();
        $createTransaction = new CreateTransaction($transactionRepository, $transactionGateway);
        $output = $createTransaction->execute($input);
        return new Response(json_encode($output), 201);
    }
}