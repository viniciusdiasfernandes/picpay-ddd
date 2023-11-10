<?php

namespace App\Infra\Gateway;

use App\Application\UseCases\DTO\ProcessTransactionInput;
use App\Application\UseCases\DTO\ProcessTransactionOutput;

interface TransactionGateway
{
    public function process(ProcessTransactionInput $input): ProcessTransactionOutput;
}