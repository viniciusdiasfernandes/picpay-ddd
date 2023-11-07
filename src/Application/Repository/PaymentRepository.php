<?php

namespace App\Application\Repository;

use App\Domain\Payment\Payment;

interface PaymentRepository
{
    public function save(Payment $payment): int;
    public function update(Payment $payment): void;
}