<?php

namespace App\Domain\User;

use Exception;

class User
{
    private function __construct(
        public string   $firstName,
        public string   $lastName,
        public Document $document,
        public Email    $email,
        public Password $password,
        public UserType $type,
        private float    $balance,
        public ?int     $id = null,
    )
    {
    }

    /**
     * @throws Exception
     */
    public static function create(string $firstName, string $lastName, Document $document, Email $email, Password $password, UserType $type, float $balance): User
    {
        return new User($firstName, $lastName, $document, $email, $password, $type, $balance);
    }

    /**
     * @throws Exception
     */
    public static function restore(string $firstName, string $lastName, Document $document, Email $email, Password $password, UserType $type, float $balance, int $id): User
    {
        return new User($firstName, $lastName, $document, $email, $password, $type, $balance, $id);
    }

    public function getBalance(): float
    {
        return $this->balance;
    }

    public function isUserAllowedToTransfer(): bool
    {
        if($this->type === UserType::Merchant) {
            return false;
        }
        return true;
    }

    public function isBalanceGreaterThenAmountToTransfer(float $amount): bool
    {
        if($this->balance < $amount) {
            return false;
        }
        return true;
    }

    public function increaseBalance(float $amount): void
    {
        $this->balance += $amount;
    }

    public function decreaseBalance(float $amount): void
    {
        $this->balance -= $amount;
    }
}