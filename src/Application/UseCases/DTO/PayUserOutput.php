<?php

namespace App\Application\UseCases\DTO;

readonly class PayUserOutput
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