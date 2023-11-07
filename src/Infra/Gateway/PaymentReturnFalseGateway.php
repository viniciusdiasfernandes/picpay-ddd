<?php

namespace App\Infra\Gateway;

use App\Application\UseCases\DTO\ProcessPaymentInput;
use App\Application\UseCases\DTO\ProcessPaymentOutput;

class PaymentReturnFalseGateway implements PaymentGateway
{
    public function process(ProcessPaymentInput $input): ProcessPaymentOutput
    {
        $urlSuccessTrue = "https://run.mocky.io/v3/1bcaca9e-0273-45d4-9814-b0390c8317f8";
        $isPaymentApproved = json_decode(file_get_contents($urlSuccessTrue));
        return new ProcessPaymentOutput(success: $isPaymentApproved->success);
    }
}