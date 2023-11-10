<?php

namespace App\Infra\Repository;

use App\Application\Repository\TransactionRepository;
use App\Domain\Transaction\Transaction;
use App\Domain\Transaction\StatusFactory;
use App\Infra\Database\Connection;

readonly class TransactionRepositoryDatabase implements TransactionRepository
{
    public function __construct(public Connection $connection)
    {
    }

    public function save(Transaction $transaction): int
    {
        $status = $transaction->status->value;
        $this->connection->query("INSERT INTO picpay.transaction (amount, sender_id, receiver_id, timestamp, status) VALUES ($transaction->amount, $transaction->senderId, $transaction->receiverId, $transaction->timestamp, '{$status}')");
        return $this->connection->getLastInsertedId();
    }

    public function update(Transaction $transaction): void
    {
        $status = $transaction->status->value;
        $this->connection->query("UPDATE picpay.transaction SET amount = {$transaction->amount}, sender_id = {$transaction->senderId}, receiver_id = {$transaction->receiverId}, status = '{$status}' WHERE id = {$transaction->id}");
    }
}