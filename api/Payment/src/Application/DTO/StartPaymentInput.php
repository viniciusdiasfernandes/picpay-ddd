<?php

namespace Payment\Application\DTO;

readonly class StartPaymentInput
{
    public function __construct(
        public float $amount,
        public int   $senderId,
        public int   $receiverId,
        public int   $timestamp
    )
    {
    }
}