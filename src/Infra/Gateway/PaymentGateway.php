<?php

namespace App\Infra\Gateway;

use App\Application\UseCases\DTO\ProcessPaymentInput;
use App\Application\UseCases\DTO\ProcessPaymentOutput;

interface PaymentGateway
{
    public function process(ProcessPaymentInput $input): ProcessPaymentOutput;
}