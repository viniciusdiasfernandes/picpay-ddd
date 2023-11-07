<?php

namespace Payment\Domain;

use Exception;

class CancelledStatus extends Status
{
    readonly string $value;
    public function __construct(Payment $payment)
    {
        parent::__construct($payment);
        $this->value = "cancelled";
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