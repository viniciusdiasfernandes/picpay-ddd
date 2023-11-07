<?php

namespace Payment\Domain;

use Account\Domain\User;
use Account\Domain\UserType;

class Payment
{
    public Status $status;
    private function __construct(
        readonly float $amount,
        readonly User $sender,
        readonly User $receiver,
        readonly int $timestamp,
        string $status,
        readonly ?int $id = null
    )
    {
        $this->status = StatusFactory::crete($this, StatusEnum::from($status));
    }

    public static function create(float $amount, User $sender, User $receiver): Payment
    {
        $status = StatusEnum::InProgress->value;
        return new Payment($amount, $sender, $receiver, time(), $status);
    }

    public static function restore(float $amount, User $sender, User $receiver, int $timestamp, string $status, int $id): Payment
    {
        return new Payment($amount, $sender, $receiver, $timestamp, $status, $id);
    }
}