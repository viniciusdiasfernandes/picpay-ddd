<?php

namespace App\Infra\Controller;

use App\Application\UseCases\DTO\CreateUserInput;
use App\Application\UseCases\DTO\CreateUserOutput;
use App\Application\UseCases\DTO\PayUserInput;
use App\Application\UseCases\DTO\PayUserOutput;
use App\Infra\DI\Registry;
use Exception;
use stdClass;

class PaymentController
{
    public function __construct(
    )
    {
    }

    /**
     * @throws Exception
     */
    public function pay(array $params): PayUserOutput
    {
        $input = new PayUserInput(
            amount: $params['amount'],senderId: $params['senderId'],receiverId: $params['receiverId'],timestamp: time()
        );
        return Registry::getInstance()->get('payUser')->execute($input);
    }
}