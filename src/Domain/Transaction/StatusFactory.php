<?php

namespace App\Domain\Transaction;

class StatusFactory
{
    public static function create(Transaction $transaction, StatusEnum $status)
    {
        if($status === StatusEnum::InProgress) {
            return new InProgressStatus($transaction);
        }
        if($status === StatusEnum::Cancelled) {
            return new CancelledStatus($transaction);
        }
        if($status === StatusEnum::Completed) {
            return new CompletedStatus($transaction);
        }
    }
}