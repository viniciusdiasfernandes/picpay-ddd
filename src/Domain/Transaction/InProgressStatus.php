<?php

namespace App\Domain\Transaction;

use Exception;

class InProgressStatus extends Status
{
    readonly string $value;
    public function __construct(Transaction $transaction)
    {
        parent::__construct($transaction);
        $this->value = StatusEnum::InProgress->value;
    }

    /**
     * @throws Exception
     */
    public function start(): void
    {
        throw new Exception("Invalid status");
    }

    /**
     * @throws Exception
     */
    public function finish(): void
    {
        $this->transaction->status = new CompletedStatus($this->transaction);
    }

    /**
     * @throws Exception
     */
    public function cancel(): void
    {
        $this->transaction->status = new CancelledStatus($this->transaction);
    }
}