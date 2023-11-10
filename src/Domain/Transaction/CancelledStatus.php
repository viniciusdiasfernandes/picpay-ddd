<?php

namespace App\Domain\Transaction;

use Exception;

class CancelledStatus extends Status
{
    readonly string $value;
    public function __construct(Transaction $transaction)
    {
        parent::__construct($transaction);
        $this->value = StatusEnum::Cancelled->value;
    }

    /**
     * @throws Exception
     */
    public function start(): void
    {
        throw new Exception("Invalid status.");
    }

    /**
     * @throws Exception
     */
    public function finish(): void
    {
        throw new Exception("Invalid status.");
    }

    /**
     * @throws Exception
     */
    public function cancel(): void
    {
        throw new Exception("Invalid status.");
    }
}