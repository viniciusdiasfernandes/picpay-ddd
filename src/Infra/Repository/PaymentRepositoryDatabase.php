<?php

namespace App\Infra\Repository;

use App\Application\Repository\PaymentRepository;
use App\Domain\Payment\Payment;
use App\Domain\Payment\StatusFactory;
use App\Infra\Database\Connection;

readonly class PaymentRepositoryDatabase implements PaymentRepository
{
    public function __construct(public Connection $connection)
    {
    }

    public function save(Payment $payment): int
    {
        $status = $payment->status->value;
        $this->connection->query("INSERT INTO picpay.payment (amount, sender_id, receiver_id, timestamp, status) VALUES ($payment->amount, $payment->senderId, $payment->receiverId, $payment->timestamp, '{$status}')");
        return $this->connection->getLastInsertedId();
    }

    public function update(Payment $payment): void
    {
        $status = $payment->status->value;
        $this->connection->query("UPDATE picpay.payment SET amount = {$payment->amount}, sender_id = {$payment->senderId}, receiver_id = {$payment->receiverId}, status = '{$status}' WHERE id = {$payment->id}");
    }
}