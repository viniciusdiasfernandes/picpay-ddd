<?php

namespace App\Infra\Controller;

use App\Application\UseCases\CreateTransaction;
use App\Application\UseCases\DTO\TransactionInput;
use App\Infra\Database\MySqlPromiseAdapter;
use App\Infra\Gateway\TransactionReturnTrueGateway;
use App\Infra\Repository\TransactionRepositoryDatabase;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TransactionController
{
    /**
     * @throws Exception
     */
    public function create(Request $request): Response
    {
        CreateTransactionValidator::validate($request);
        $payload = $request->getPayload();
        $input = new TransactionInput(
            amount: $payload->get('amount'),
            senderId: $payload->get('senderId'),
            receiverId: $payload->get('receiverId'),
            timestamp: time()
        );
        $connection = new MySqlPromiseAdapter();
        $transactionRepository = new TransactionRepositoryDatabase($connection);
        $transactionGateway = new TransactionReturnTrueGateway();
        $createTransaction = new CreateTransaction($transactionRepository, $transactionGateway);
        $output = $createTransaction->execute($input);
        return new Response(json_encode($output), Response::HTTP_CREATED);
    }
}