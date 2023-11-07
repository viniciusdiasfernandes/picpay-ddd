<?php

namespace App\Domain\Payment;

use Exception;

class Payment
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
        $this->status = StatusFactory::crete($this, StatusEnum::from($status));
    }

    public static function create(float $amount, int $senderId, int $receiverId): Payment
    {
        $status = StatusEnum::InProgress->value;
        return new Payment($amount, $senderId, $receiverId, time(), $status);
    }

    public static function restore(float $amount, int $senderId, int $receiverId, int $timestamp, string $status, int $id): Payment
    {
        return new Payment($amount, $senderId, $receiverId, $timestamp, $status, $id);
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