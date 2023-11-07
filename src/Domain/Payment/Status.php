<?php

namespace App\Domain\Payment;

abstract class Status
{
    public function __construct(public Payment $payment)
    {
    }
    public abstract function start(): void;
    public abstract function finish(): void;
    public abstract function cancel(): void;
}