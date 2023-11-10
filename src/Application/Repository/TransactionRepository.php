<?php

namespace App\Application\Repository;

use App\Domain\Transaction\Transaction;

interface TransactionRepository
{
    public function save(Transaction $transaction): int;
    public function update(Transaction $transaction): void;
}