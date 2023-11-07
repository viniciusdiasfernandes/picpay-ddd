<?php

namespace Payment\Domain;

use Exception;

class InProgressStatus extends Status
{
    readonly string $value;
    public function __construct(Payment $payment)
    {
        parent::__construct($payment);
        $this->value = "in_progress";
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
        $this->payment->status = new CompletedStatus($this->payment);
    }

    /**
     * @throws Exception
     */
    public function cancel(): void
    {
        $this->payment->status = new CancelledStatus($this->payment);
    }
}