<?php

use App\Infra\Controller\AccountController;
use App\Infra\Controller\TransactionController;

/**
 * @codeCoverageIgnore
 */
return [
    ['POST','/signup' , [AccountController::class, 'create']],
    ['POST','/transaction' , [TransactionController::class, 'create']]
];