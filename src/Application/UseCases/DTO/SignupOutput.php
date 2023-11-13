<?php

namespace App\Application\UseCases\DTO;

readonly class SignupOutput
{
    public function __construct(
        public string $firstName,
        public string $lastName,
        public string $document,
        public string $email,
        public string $type,
        public float  $balance,
        public int    $accountId
    )
    {
    }
}