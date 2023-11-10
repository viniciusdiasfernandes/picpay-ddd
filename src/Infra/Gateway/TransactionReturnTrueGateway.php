<?php

namespace App\Infra\Gateway;

use App\Application\UseCases\DTO\ProcessTransactionInput;
use App\Application\UseCases\DTO\ProcessTransactionOutput;

class TransactionReturnTrueGateway implements TransactionGateway
{
    public function process(ProcessTransactionInput $input): ProcessTransactionOutput
    {
        $urlSuccessTrue = "https://run.mocky.io/v3/2558afe3-d123-4b5a-b1aa-e25b7ed341db";
        $isPaymentApproved = json_decode(file_get_contents($urlSuccessTrue));
        return new ProcessTransactionOutput(success: $isPaymentApproved->success);
    }
}