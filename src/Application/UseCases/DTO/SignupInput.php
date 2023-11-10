<?php

namespace App\Application\UseCases\DTO;

readonly class SignupInput
{
    public function __construct(
        public string $firstName,
        public string $lastName,
        public string $document,
        public string $email,
        public string $password,
        public string $type
    )
    {
    }
}