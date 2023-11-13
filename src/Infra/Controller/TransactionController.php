<?php

namespace App\Infra\Controller;

use App\Application\UseCases\CreateTransaction;
use App\Application\UseCases\DTO\TransactionInput;
use App\Infra\Database\MySqlPromiseAdapter;
use App\Infra\Gateway\EmailSystemGateway;
use App\Infra\Gateway\TransactionReturnTrueGateway;
use App\Infra\Repository\TransactionRepositoryDatabase;
use Exception;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TransactionController
{
    public function create(Request $request): JsonResponse
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
        $emailSystemGateway = new EmailSystemGateway();
        $createTransaction = new CreateTransaction($transactionRepository, $transactionGateway, $emailSystemGateway);
        try {
            $output = $createTransaction->execute($input);
        } catch (BadRequestException $e) {
            return new JsonResponse(["Bad Request" => $e->getMessage()], $e->getCode());
        } catch (Exception $e) {
            return new JsonResponse(["Error" => $e->getMessage()], $e->getCode());
        }
        return new JsonResponse($output, Response::HTTP_CREATED);
    }
}