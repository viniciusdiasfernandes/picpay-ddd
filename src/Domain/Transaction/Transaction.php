<?php

namespace App\Domain\Transaction;

use Exception;

class Transaction
{
    public Status $status;

    private function __construct(
        readonly float $amount,
        readonly int   $senderId,
        readonly int   $receiverId,
        readonly int   $timestamp,
        string         $status,
        readonly ?int  $id = null
    )
    {
        $this->status = StatusFactory::create($this, StatusEnum::from($status));
    }

    public static function create(float $amount, int $senderId, int $receiverId): Transaction
    {
        $status = StatusEnum::InProgress->value;
        return new Transaction($amount, $senderId, $receiverId, time(), $status);
    }

    public static function restore(float $amount, int $senderId, int $receiverId, int $timestamp, string $status, int $id): Transaction
    {
        return new Transaction($amount, $senderId, $receiverId, $timestamp, $status, $id);
    }

    /**
     * @throws Exception
     */
    public function finish(): void
    {
        $this->status->finish();
    }

    /**
     * @throws Exception
     */
    public function cancel(): void
    {
        $this->status->cancel();
    }
}