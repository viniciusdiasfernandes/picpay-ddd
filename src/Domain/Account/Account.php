<?php

namespace App\Domain\Account;

use Exception;

class Account
{
    private function __construct(
        public string      $firstName,
        public string      $lastName,
        public Document    $document,
        public Email       $email,
        public Password    $password,
        public AccountType $type,
        private float      $balance,
        public ?int        $id = null,
    )
    {
    }

    /**
     * @throws Exception
     */
    public static function create(string $firstName, string $lastName, Document $document, Email $email, Password $password, AccountType $type, float $balance): Account
    {
        return new Account($firstName, $lastName, $document, $email, $password, $type, $balance);
    }

    /**
     * @throws Exception
     */
    public static function restore(string $firstName, string $lastName, Document $document, Email $email, Password $password, AccountType $type, float $balance, int $id): Account
    {
        return new Account($firstName, $lastName, $document, $email, $password, $type, $balance, $id);
    }

    public function getBalance(): float
    {
        return $this->balance;
    }

    public function isUserAllowedToTransfer(): bool
    {
        if($this->type === AccountType::Merchant) {
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