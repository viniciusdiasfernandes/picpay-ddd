<?php

namespace App\Infra\Gateway;

use App\Application\UseCases\DTO\ProcessPaymentInput;
use App\Application\UseCases\DTO\ProcessPaymentOutput;

class PaymentReturnTrueGateway implements PaymentGateway
{
    public function process(ProcessPaymentInput $input): ProcessPaymentOutput
    {
        $urlSuccessTrue = "https://run.mocky.io/v3/2558afe3-d123-4b5a-b1aa-e25b7ed341db";
        $isPaymentApproved = json_decode(file_get_contents($urlSuccessTrue));
        return new ProcessPaymentOutput(success: $isPaymentApproved->success);
    }
}