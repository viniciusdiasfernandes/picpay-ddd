<?php

namespace Account\Application\UseCases\DTO;

use Account\Domain\Cnpj;
use Account\Domain\Cpf;

readonly class CreateUserOutput
{
    public function __construct(
        public string $firstName,
        public string $lastName,
        public string $document,
        public string $email,
        public string $type,
        public float  $balance,
        public int    $userId
    )
    {
    }
}